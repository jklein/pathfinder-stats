<?php

require 'vendor/autoload.php';
require 'functions.php';

use Carbon\Carbon;

error_reporting(-1);

$app = new \Slim\Slim();

$app->config([
    'debug' => true,
    'templates.path' => './templates'
]);

define('MILES_TOTAL', 100);
define('WORKOUTS_TOTAL', 20);
define('TEAM_LEAD_TOTAL', 3);
define('CHALLENGES_TOTAL', 5);
define('START_DATE', '2015-03-01 00:00:00');
define('END_DATE', '2015-06-01 00:00:00');


$app->get('/', function () use ($app) {
    $start_date = Carbon::parse(START_DATE);
    $end_date = Carbon::parse(END_DATE);
    $total_days = $end_date->diffInDays($start_date);
    $days_done = $start_date->diffInDays(Carbon::now());

    $data = [
        'miles_done'       => 32,
        'miles_total'      => MILES_TOTAL,
        'workouts_done'    => 5,
        'workouts_total'   => WORKOUTS_TOTAL,
        'team_lead_done'   => 1,
        'team_lead_total'  => TEAM_LEAD_TOTAL,
        'challenges_done'  => 3,
        'challenges_total' => CHALLENGES_TOTAL,
        'days_done'        => $days_done,
        'days_total'       => $total_days,
        'overall_progress' => $days_done/$total_days,
        'person'           => 'Jonathan Klein',
    ];

    $app->render('stats.php', $data);
});

$app->get('/hello/:name', function ($name) {
    echo "Hello, $name";
});
$app->run();
