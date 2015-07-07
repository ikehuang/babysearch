<?php

// Put your device token here (without spaces):

$deviceToken = 'fdb07e39865749f0e08a6af59bd6b4e9b9d9a5dcca73ae71344ede73723f4aad';
$deviceToken = 'ce4ca8dbe185a2e2bc0b5c71af427c5407a2b892c7e888ca6bc002f4de974383';
$arg_list = $argv;
var_dump($arg_list);

$deviceToken = $arg_list[1];
$serial_number = $arg_list[2];
$message = $arg_list[3];
// Put your private key's passphrase here:
$passphrase = '1234';
$imei = (string)"P1Q000000005";
// Put your alert message here:

////////////////////////////////////////////////////////////////////////////////

$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

// Open a connection to the APNS server
$fp = stream_socket_client(
	'ssl://gateway.push.apple.com:2195', $err,
	$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

if (!$fp)
	exit("Failed to connect: $err $errstr" . PHP_EOL);

echo 'Connected to APNS' . PHP_EOL;

// Create the payload body
$body['aps'] = array(
	'alert' => $message,
	'sound' => 'default',
	'sn' => $serial_number
	);
 

// Encode the payload as JSON
$payload = json_encode($body);

// Build the binary notification
$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

// Send it to the server
$result = fwrite($fp, $msg, strlen($msg));
var_dump($result);

if (!$result)
	echo 'Message not delivered' . PHP_EOL;
else
	echo 'Message successfully delivered' . PHP_EOL;

// Close the connection to the server
fclose($fp);
