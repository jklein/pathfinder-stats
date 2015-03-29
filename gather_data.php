<?php
require 'vendor/autoload.php';

$client = new GuzzleHttp\Client();
$jar = new GuzzleHttp\Cookie\CookieJar();

$response = $client->post('http://www.teamspearhead.com/wp-login.php?action=postpass', [
    'body' => [
        'post_password' => 'PF005',
        'Submit' => 'submit',
    ],
    'cookies' => $jar
]);


$reponse_two = $client->post('http://www.teamspearhead.com/pathfinder-005-log-viewer/', [
    'body' => [
        'roster' => '5-068',
    ],
    'cookies' => $jar
]);

$code = $reponse_two->getStatusCode();
$body = $reponse_two->getBody();

echo $code . PHP_EOL . PHP_EOL;
echo $body;
