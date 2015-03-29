<?php
require 'vendor/autoload.php';

use PHPHtmlParser\Dom;

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

$dom = new Dom;
$dom->load($body);
$table = $dom->find('table')[0];

$dom_two = new Dom;

$dom_two->load($table->innerHtml);

$rows = $dom_two->find('tr');

$return = [
    'miles'      => 0,
    'workouts'   => 0,
    'team_lead'  => 0,
    'challenges' => 0,
];

foreach ($rows as $row) {
    $columns            = $row->find('td');

    $date               = $columns[0]->innerHtml;
    $start_time         = $columns[1]->innerHtml;
    $duration           = $columns[2]->innerHtml;
    $miles              = $columns[3]->innerHtml;
    $workouts           = $columns[4]->innerHtml;
    $team_lead          = $columns[5]->innerHtml;
    $selection_standard = $columns[6]->innerHtml;
    $challenge          = $columns[7]->innerHtml;
    $notes              = $columns[8]->innerHtml;
    
    $return['miles']      += (is_numeric($miles) ? $miles : 0);
    $return['workouts']   += ($workouts == 'WORKOUT' ? 1 : 0);
    $return['team_lead']  += ($team_lead == 'TEAM LEADER' ? 1 : 0);
    $return['challenges'] += ($challenges != '&nbsp;' ? 1 : 0);
}

echo json_encode($return);
