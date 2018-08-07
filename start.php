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
                'amount' => '2.00',
                'email' => 'mk_merchant@gmail.com',
                'primary' => 'false',
            ),
            array(
                'amount' => '3.00',
                'email' => 'buymk@gmail.com',
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
