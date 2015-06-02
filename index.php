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

define('NUM_PARTICIPANTS', 121);
define('START_DATE', '2015-03-01 00:00:00');
define('END_DATE', '2015-06-01 00:00:00');


$app->get('/', function () use ($app) {
    $app->render('home.php');
});

$app->get('/stats?roster=:roster', function ($roster) use ($app) {
    $roster_data = gather_data($roster);

    $start_date = Carbon::parse(START_DATE);
    $end_date = Carbon::parse(END_DATE);
    $total_days = $end_date->diffInDays($start_date);
    $days_done = $start_date->diffInDays(Carbon::now());

    $data = [
        'miles_done'       => $roster_data['miles'],
        'miles_total'      => MILES_TOTAL,
        'workouts_done'    => $roster_data['workouts'],
        'workouts_total'   => WORKOUTS_TOTAL,
        'team_lead_done'   => $roster_data['team_lead'],
        'team_lead_total'  => TEAM_LEAD_TOTAL,
        'challenges_done'  => $roster_data['challenges'],
        'challenges_total' => CHALLENGES_TOTAL,
        'days_done'        => $days_done,
        'days_total'       => $total_days,
        'overall_progress' => $days_done/$total_days,
        'person'           => $roster,
        'log_html'         => $roster_data['log_html'],
    ];

    $app->render('stats.php', $data);
});

$app->run();
