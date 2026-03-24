<?php
function progress_bar_circle($week1 = 0, $week2 = 0, $week3 = 0, $week4 = 0, $week5 = 0, $week6 = 0, $week7 = 0) {
    $values = [$week1, $week2, $week3, $week4, $week5, $week6, $week7];

    foreach ($values as $index => $value) {
        $circleIndex = $index + 1;
        echo '<div data-preset="circle" class="progress_bar" id="circle_' . $circleIndex . '" data-value="' . intval($value) . '"></div>';
    }
}
?>