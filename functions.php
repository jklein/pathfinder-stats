<?php

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
