<?php

require 'vendor/autoload.php';
require 'functions.php';
require 'data_fetcher.php';

use Carbon\Carbon;

error_reporting(-1);

$app = new \Slim\Slim();

$app->config([
    'debug' => true,
    'templates.path' => './templates'
]);

define('MILES_TOTAL', 75);
define('MILES_CHALLENGE_TOTAL', 150);
define('WORKOUTS_TOTAL', 20);
define('TEAM_LEAD_TOTAL', 3);
define('CHALLENGES_TOTAL', 4);

$app->get('/', function () use ($app) {
    $data['roster_data'] = [];
    foreach (DataFetcher::$class_data as $key => $value) {
        $data['roster_data'][$key] = DataFetcher::getRosters($key);
    }
    
    $app->render('home.php', $data);
});

$app->get('/stats?class=:class&roster=:roster', function ($class, $roster) use ($app) {
    $roster_data = DataFetcher::getDataForRoster($class, $roster);

    $start_date = Carbon::parse(DataFetcher::$class_data[$class]['START_DATE']);
    $end_date = Carbon::parse(DataFetcher::$class_data[$class]['END_DATE']);
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
