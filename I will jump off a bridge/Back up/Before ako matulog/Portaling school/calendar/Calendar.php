<?php
function generate_calendar($month, $year) {
    // Array of days in a week
    $daysOfWeek = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');

    // Get the number of days in the current month
    $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);

    // Get the first day of the month
    $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
    $firstDayOfWeek = date('w', $firstDayOfMonth);

    // Create the calendar table
    echo "<table border='1'>";
    echo "<tr>";
    foreach ($daysOfWeek as $day) {
        echo "<th>$day</th>";
    }
    echo "</tr><tr>";

    // Fill the first row with blank cells
    for ($i = 0; $i < $firstDayOfWeek; $i++) {
        echo "<td></td>";
    }

    // Fill the rest of the calendar
    $dayCount = 1;
    while ($dayCount <= $numberOfDays) {
        echo "<td><a href='schedule.php?date=".date('Y-m-d', mktime(0, 0, 0, $month, $dayCount, $year))."'>$dayCount</a></td>";
        if ($dayCount % 7 == 6) {
            echo "</tr><tr>";
        }
        $dayCount++;
    }

    // Fill the last row with blank cells
    while (date('w', mktime(0, 0, 0, $month, $dayCount, $year)) != 0) {
        echo "<td></td>";
        $dayCount++;
    }

    echo "</tr></table>";
}

// Get the current month and year
$month = date('m');
$year = date('Y');

// Generate the calendar
generate_calendar($month, $year);
?>