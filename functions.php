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
