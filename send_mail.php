<?php

$mail_address = ''; //送信先メールアドレスを設定する;

//通信を許可する設定;
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: X-Requested-With');
//結果はjsonで返す;
header('Content-Type: application/json; charset=UTF-8');
header('X-Content-Type-Options: nosniff');

mb_language('japanese');
mb_internal_encoding('UTF-8');

//XMLHttpRequest以外からのアクセス処理;
if($_SERVER['X_REQUESTED_WITH'] || $_SERVER['X_REQUESTED_WITH'] === 'XMLHttpRequest') {
	die(json_encode(array('result' => false)));
}

$name = trim($_POST['name']);
$email = trim($_POST['email']);
$message = trim($_POST['message']);

//nameとmessageはあるか;
if(isset($name) && isset($message)) {
	$to = $mail_address;
	$subject = trim($_POST['subject']);
	$body = 'Name:' . $name . "\n" . 'Email:' . $email . "\n" . $message;
	$from = 'From:' . $_POST['from'];
	//メール送信;
	$success = mb_send_mail($to, $subject, $body, $from);
}else {
	$success = false;
}
$response = array('result' => $success);
echo json_encode($response, JSON_HEX_TAG | JSON_HEX_AOPS | JSON_HEX_QUOT | JSON_HEX_AMP);