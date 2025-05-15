<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require __DIR__ . '/../../vendor/autoload.php';
Midtrans\Config::$serverKey = getenv('MidtransKey');
// Midtrans\Config::$isProduction = getenv('MidtransProduction');



class Midtrans_model extends CI_Model {
    public function generate_link_checkout($params){
        try {
            $paymentUrl = Midtrans\Snap::createTransaction($params)->redirect_url;
            header('Location: ' . $paymentUrl);
        }
        catch (\Exception $e) {
            echo $e->getMessage();
        }
   }

   public function check_payment_status(){
        try {
            $notif = new Notification();
        }
        catch (\Exception $e) {
            exit($e->getMessage());
        }

        $notif = $notif->getResponse();

        $data = [
            'transaction_time' => $notif->transaction_time,
            'transaction_status' => $notif->transaction_status,
            'payment_type' => $notif->payment_type,
            'fraud' => $notif->fraud_status,
            'currency' => $notif->currency,
            'order_id' => $notif->order_id,
        ];

        return $data;
   }
}