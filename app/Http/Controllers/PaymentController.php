<?php

namespace App\Http\Controllers;

use App\Helpers\PayPal;
use App\Repositories\OrdersRepository;
use App\Repositories\PaymentRepository;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    const ORDERS_PATH = '/account/orders';

    public function __construct(OrdersRepository $ordersRepository, PaymentRepository $paymentRepository)
    {
        $this->ordersRepository = $ordersRepository;
        $this->paymentRepository = $paymentRepository;
    }

    /**
     * Create new payment
     *
     * @param  string $hash
     * @return \Illuminate\Http\Response
     */
    public function create($hash)
    {
        $order = $this->ordersRepository->getOrder($hash, false);
        if (! $order['hash']) {
            return redirect(self::ORDERS_PATH);
        }

        $data = [
            'cmd' => '_xclick',
            'business' => config('payment.paypal.account'),
            'item_name' => 'Order: '.$order['hash'],
            'item_number' => 1,
            'custom' => $hash,
            'notify_url' => url('api/payment/ipn'),
            'return' => url('account/orders'),
            'cancel_return' => url('api/payment/cancel'),
            'charset' => 'utf-8',
            'amount' => $order['price'],
            'quantity' => 1,
            'currency_code' => 'USD',
        ];

        $link = config('payment.paypal.link').'?'.http_build_query($data);

        echo 'Redirecting to PayPal.com. Please wait, loading...';

        return redirect($link);
    }

    /**
     * Redirect with positive message
     */
    public function complete()
    {
        return redirect(self::ORDERS_PATH)->with(['msg' => 'Order has been paid.']);
    }

    /**
     * Redirect with negative message
     */
    public function cancel()
    {
        return redirect(self::ORDERS_PATH);
    }

    /**
     * Check payment
     */
    public function ipn(Request $request)
    {
        $data = $request->all();

        $paypalHelper = new PayPal();
        if (! $payment = $paypalHelper->checkPayment($data)) {
            return response()->json(['status' => false], 403);
        }

        $order = $this->ordersRepository->getOrder($data['custom'], false);
        $payment = $this->paymentRepository->addPayment($data);
        $this->ordersRepository->updateOrder($order['id'], [
            'status' => $order['status'],
            'paid' => 1,
            'payment_status' => $payment['payment_status'],
            'payment_id' => $payment['id']
        ]);

        return response()->json(['status' => true], 200);
    }
}
