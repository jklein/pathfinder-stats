<?php
include 'header.php'
?>


<h2>Program Progress (Days Complete / Total Days)</h2>
<?=progress_bar($overall_progress, $days_done, $days_total);?>

<h3>Miles</h3>
<?=progress_bar($overall_progress, $miles_done, $miles_total);?>    

<?php if ($miles_done > MILES_TOTAL) {
    echo '<h3>Progress Towards ' . MILES_CHALLENGE_TOTAL . ' Mile Challenge</h3>';
    echo progress_bar($overall_progress, $miles_done, MILES_CHALLENGE_TOTAL);
} ?>

<h3>Workouts</h3>
<?=progress_bar($overall_progress, $workouts_done, $workouts_total);?>

<h3>Team Lead</h3>
<?=progress_bar($overall_progress, $team_lead_done, $team_lead_total);?>

<h3>Challenges</h3>
<?=progress_bar($overall_progress, $challenges_done, $challenges_total);?>

<h3>Raw Logs</h3>
<table class="table table-striped table-condensed table-bordered">
    <tr>
        <th>Date</th>
        <th>Start Time</th>
        <th>Duration</th>
        <th>Ruck Mileage Logged</th>
        <th>Ruck Workout?</th>
        <th>Team Leader</th>
        <th>Selection Standard Attempt</th>
        <th>Challenge Completed?</th>
        <th>Notes</th>
    </tr>
    <?=$log_html;?>
</table>

<?php
include 'footer.php'
?>
