<?php
include 'header.php';

foreach ($roster_data as $class => $rosters) {
    echo '<form action="/stats" method="GET" class="form-inline">';
    echo "<h3>Rosters for Class $class</h3>";
    echo '<div class="form-group">' . PHP_EOL;
    echo '<input type="hidden" name="class" value="' . $class . '" />';
    echo '<select class="form-control" name="roster" onChange="this.form.submit();">' . PHP_EOL;
    foreach ($rosters as $roster) {
        $roster_name = str_replace('"', '', $roster);
        $roster_number = explode(' ', $roster_name)[0];
        echo '<option value="' . $roster_number . '">' . $roster_name . '</option>' . PHP_EOL;
    }
    echo '</select>' . PHP_EOL;
    echo '</div>' . PHP_EOL;
    echo '</form>';
}

include 'footer.php';
