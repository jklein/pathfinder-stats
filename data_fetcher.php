<?php

class DataFetcher {

    public static $class_data = [
        "005" => [
            "START_DATE"   => '2015-03-01 00:00:00',
            "END_DATE"     => '2015-06-01 00:00:00',
            "KEY"          => '1lAi2-TQPduWoqA7MqyFCpP8ZLaRXzaxq5qbcXAffnvk',
            'ROSTER_QUERY' => "select+B",
        ],
        "006" => [
            "START_DATE"   => '2015-06-01 00:00:00',
            "END_DATE"     => '2015-09-01 00:00:00',
            "KEY"          => '1F3LgSum81KLFkd2a36356c-6jN-gb3C5-wlkKigXDkg',
            'ROSTER_QUERY' => "select+M",
        ],
    ];

    private static $url = "https://docs.google.com/spreadsheets/d/{{key}}/gviz/tq?tqx=out:csv&tq={{query}}";

    private static $client;
    private static $check_mark = '<span class="glyphicon glyphicon-ok"></span>';

    private static function getClient() {
        if (empty(self::$client)) {
            self::$client = new GuzzleHttp\Client();
        }

        return self::$client;
    }

    private static function buildUrl($class, $query) {
        $key = self::$class_data[$class]['KEY'];

        return str_replace(["{{query}}", "{{key}}"], [$query, $key], self::$url);
    }

    public static function getRosters($class) {
        $client = self::getClient();

        $url = self::buildUrl($class, self::$class_data[$class]['ROSTER_QUERY']);

        $response = $client->get($url);
        $body = $response->getBody();

        $body_string = $body->getContents();

        $unique_rosters = array_slice(array_unique(explode("\n", $body_string)), 1);
        sort($unique_rosters);

        return $unique_rosters;
    }


    public static function getDataForRoster($class, $roster) {
        $client = self::getClient();

        $query = "select+D,+E,+F,+G,+H,+I,+J,+K,+L+where+B+starts+with+%27" . $roster . "%27";
        $url = self::buildUrl($class, $query);

        $response = $client->get($url);
        $body = $response->getBody();

        $body_string = $body->getContents();

        $csv = new parseCSV();
        $csv->auto($body_string);

        $results = $csv->data;


        $return = [
            'miles'      => 0,
            'workouts'   => 0,
            'team_lead'  => 0,
            'challenges' => 0,
            'log_html'   => '',
        ];

        foreach ($results as $row) {
            // Skip the first row
            if ($row["ENTRY DATE"] == 'ENTRY DATE' || count($row) < 9) {
                continue;
            }

            $date               = $row["ENTRY DATE"];
            $start_time         = $row["ENTRY START TIME "];
            $duration           = str_replace(" AM", "", $row["ENTRY DURATION"]);
            $miles              = $row["RUCK MILEAGE LOGGED"];
            $workouts           = $row["RUCK WORKOUT/WOD?"] == 'WORKOUT' ? self::$check_mark : '';
            $team_lead          = $row["WORKOUT TEAM LEADER"] == 'TEAM LEADER' ? self::$check_mark : '';
            $selection_standard = $row["SELECTION STANDARD ATTEMPT"];
            $challenge          = $row["REQUIRED CHALLENGE COMPLETED?"];
            $notes              = str_replace("\n", "<br/>", $row["YOUR NAME and ENTRY NOTES"]);
            
            $return['miles']      += (is_numeric($miles) ? $miles : 0);
            $return['workouts']   += (!empty($workouts) ? 1 : 0);
            $return['team_lead']  += (!empty($team_lead) ? 1 : 0);
            $return['challenges'] += (!empty($challenge) ? 1 : 0);

            $return['log_html'] .= "<tr>
                                        <td>$date</td>
                                        <td>$start_time</td>
                                        <td>$duration</td>
                                        <td>$miles</td>
                                        <td>$workouts</td>
                                        <td>$team_lead</td>
                                        <td>$selection_standard</td>
                                        <td class='wrap'>$challenge</td>
                                        <td class='wrap notes'>$notes</td>
                                    </tr>";
        }

        return $return;
    }
}
