<?php
include 'header.php'
?>


<h2>Overall Program Progress</h2>
<?=progress_bar($overall_progress, $days_done, $days_total);?>

<h3>Miles</h3>
<?=progress_bar($overall_progress, $miles_done, $miles_total);?>        

<h3>Workouts</h3>
<?=progress_bar($overall_progress, $workouts_done, $workouts_total);?>

<h3>Team Lead</h3>
<?=progress_bar($overall_progress, $team_lead_done, $team_lead_total);?>

<h3>Challenges</h3>
<?=progress_bar($overall_progress, $challenges_done, $challenges_total);?>


<?php
include 'footer.php'
?>
