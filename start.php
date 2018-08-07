<?php

session_start();
require('includes/config.php');
require('includes/paypal/adaptive-payments.php');

$paypal = new PayPal($config);

$result = $paypal->call(
        array(
    'actionType' => 'PAY',
    'currencyCode' => 'USD',
    'feesPayer' => 'EACHRECEIVER',
    'memo' => 'Order number #123',
    'cancelUrl' => 'cancel.php',
    'returnUrl' => 'success.php',
    'receiverList' => array(
        'receiver' => array(
            array(
                'amount' => '12.00',
                'email' => 'your_paypal_accountn@here.com',
                'primary' => 'false',
            ),
            array(
                'amount' => '13.00',
                'email' => 'here@yourpaypal.com',
            ),
        ),
    ),
        ), 'Pay'
);

if ($result['responseEnvelope']['ack'] == 'Success') {
    $_SESSION['payKey'] = $result["payKey"];
    $paypal->redirect($result);
} else {
    echo 'Handle the payment creation failure';
}
