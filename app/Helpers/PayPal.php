<?php
namespace App\Helpers;

use Illuminate\Http\Request;

class PayPal
{
    private function sendRequest($params = []) {
        $client = new \GuzzleHttp\Client();
        return $client->request('POST', (config('payment.paypal.ipn').'?cmd=_notify-validate'), [
            'json' => $params
        ]);
    }

    public function checkPayment($data) {
        if (is_string($data)) $data = explode('&', $data);

        $req = $this->sendRequest($data);

        if ($req->getStatusCode() !== 200) return false;

        return $req->getBody();
    }
}