<?php
use PHPHtmlParser\Dom;

function progress_bar($progress, $num_done, $num_total) {
    $overall_percent = $progress > 1 ? 100 : $progress * 100;
    $this_percent = ($num_done / $num_total) * 100;

    if ($this_percent >= 100) {
        $this_percent = 100;
        $text = 'Complete! (' . $num_done . ' / ' . $num_total . ')';
    } else {
        $text = floor($this_percent) . '% (' . $num_done . ' / ' . $num_total . ')';
    }

    if ($overall_percent === $this_percent) {
        $class = 'info';
    } elseif ($this_percent > $overall_percent) {
        $class = 'success';
    } elseif ($this_percent < $overall_percent) {
        $class = 'danger';
    }

    return '
    <div class="progress">
        <div class="progress-bar progress-bar-'.$class.'" role="progressbar" 
        aria-valuenow="' . $this_percent . '" aria-valuemin="0" aria-valuemax="100" 
        style="width: ' . $this_percent . '%;">
        ' . $text . '
        </div>
    </div>';
}


function options() {
    for ($i = 0; $i <= NUM_PARTICIPANTS; $i++) {
        $roster = '5-' . substr(1000 + $i, 1);

        echo '<option value="' . $roster . '">' . $roster . '</option>';
    }
}

function gather_data($roster) {
    $client = new GuzzleHttp\Client();
    $jar = new GuzzleHttp\Cookie\CookieJar();

    $query = "select+D,+E,+F,+G,+H,+I,+J,+K,+L+where+B+starts+with+%27" . $roster . "%27";
    $key = "1lAi2-TQPduWoqA7MqyFCpP8ZLaRXzaxq5qbcXAffnvk";

    $url = "https://docs.google.com/spreadsheets/d/" . $key . "/gviz/tq?tqx=out:csv&tq=" . $query;

    $response = $client->get($url);
    $body = $response->getBody();

    $body_string = $body->getContents();

    $results = array_map('str_getcsv', str_getcsv($body_string, "\n"));

    $return = [
        'miles'      => 0,
        'workouts'   => 0,
        'team_lead'  => 0,
        'challenges' => 0,
        'log_html'   => '',
    ];

    foreach ($results as $row) {
        // Skip the first row
        if ($row[0] == 'ENTRY DATE' || count($row) < 9) {
            continue;
        }

        $date               = $row[0];
        $start_time         = $row[1];
        $duration           = $row[2];
        $miles              = $row[3];
        $workouts           = $row[4] == 'WORKOUT' ? '<span class="glyphicon glyphicon-ok"></span>' : '';
        $team_lead          = $row[5] == 'TEAM LEADER' ? '<span class="glyphicon glyphicon-ok"></span>' : '';
        $selection_standard = $row[6];
        $challenge          = $row[7];
        $notes              = $row[8];
        
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
                                    <td class='wrap'>$notes</td>
                                </tr>";
    }

    return $return;
}
