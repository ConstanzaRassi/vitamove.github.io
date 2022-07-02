<?php
    require_once 'vendor/autoload.php';

    MercadoPago\SDK::setAccessToken("TEST-2411074096576364-031414-30e4cf6d4eca8ff009c3bb6f4a168f08-130151352");

    $payment = new MercadoPago\Payment();
    $requestBody = file_get_contents('php://input');
    $requestBody = json_decode($requestBody, true) or die("Could not decode JSON");
    $payment->transaction_amount = $requestBody['transaction_amount'];
    $payment->token = $requestBody['token'];
 /*   $payment->description = $_POST['description'];*/
    $payment->installments = (int)$requestBody['installments'];
    $payment->payment_method_id = $requestBody['payment_method_id'];
    $payment->issuer_id = (int)$requestBody['issuer_id'];

    $payer = new MercadoPago\Payer();
    $payer->email = $requestBody['payer']['email'];
    $payer->identification = array(
        "type" => $requestBody['payer']['identification']['type'],
        "number" => $requestBody['payer']['identification']['number']
    );
   /* $payer->first_name = $_POST['cardholderName'];*/
    $payment->payer = $payer;

    $payment->save();

    $response = array(
        'status' => $payment->status,
        'status_detail' => $payment->status_detail,
        'id' => $payment->id
    );
    echo json_encode($response);
?>