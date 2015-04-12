<?php
include 'header.php'
?>


<h2>Overall Program Progress</h2>
<?=progress_bar($overall_progress, $days_done, $days_total);?>

<h3>Miles</h3>
<?=progress_bar($overall_progress, $miles_done, $miles_total);?>    

<?php if ($miles_done > 100) {
    echo '<h3>Progress Towards 200 Mile Challenge</h3>';
    echo progress_bar($overall_progress, $miles_done, ($miles_total+100));
} ?>

<h3>Workouts</h3>
<?=progress_bar($overall_progress, $workouts_done, $workouts_total);?>

<h3>Team Lead</h3>
<?=progress_bar($overall_progress, $team_lead_done, $team_lead_total);?>

<h3>Challenges</h3>
<?=progress_bar($overall_progress, $challenges_done, $challenges_total);?>

<h3>Raw Logs</h3>
<table class="table">
    <?=$raw_logs;?>
</table>

<?php
include 'footer.php'
?>
