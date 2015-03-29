<?php
use PHPHtmlParser\Dom;

function progress_bar($progress, $num_done, $num_total) {
    $overall_percent = $progress * 100;
    $this_percent = ($num_done / $num_total) * 100;

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
        ' . floor($this_percent) . '% (' . $num_done . ' / ' . $num_total . ')
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

    $response = $client->post('http://www.teamspearhead.com/wp-login.php?action=postpass', [
        'body' => [
            'post_password' => 'PF005',
            'Submit' => 'submit',
        ],
        'cookies' => $jar
    ]);


    $reponse_two = $client->post('http://www.teamspearhead.com/pathfinder-005-log-viewer/', [
        'body' => [
            'roster' => $roster,
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
        'raw_logs'   => $table->innerHtml,
    ];

    foreach ($rows as $row) {
        $columns = $row->find('td');

        // Skip the first row
        if ($columns[0]->innerHtml == 'ENTRY DATE') {
            continue;
        }


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
        $return['challenges'] += ($challenge != '&nbsp;' ? 1 : 0);
    }

    return $return;

}
