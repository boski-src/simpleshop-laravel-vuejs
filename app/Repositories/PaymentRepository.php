<?php

namespace App\Repositories;

use App\Models\Payments;

class PaymentRepository
{
    public function getPayments(int $limit) {
        return Payments::orderBy('id', 'DESC')
            ->limit($limit)
            ->get();
    }

    public function addPayment(array $data) {
        return Payments::create($data);
    }

    public function getPayment(int $id) {
        return Payments::where('id', $id)->firstOrFail();
    }

    public function deletePayment(int $id) {
        $payment = Payments::where('id', $id)->firstOrFail();
        $payment->delete();

        return $payment;
    }
}