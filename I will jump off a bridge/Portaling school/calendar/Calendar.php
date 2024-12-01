<?php
/*function generate_calendar($month, $year) {
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

*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Calendar Embed</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .calendar-container {
            max-width: 800px; /* Maximum width for the container */
            margin: 0 auto; /* Center the container */
            padding: 20px; /* Padding around the container */
            background-color: white; /* Background color for the container */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        iframe {
            width: 100%; /* Full width */
            height: 600px; /* Set height */
            border: 0; /* No border */
        }
    </style>
</head>
<body>
    <div class="calendar-container">
        <iframe src="https://calendar.google.com/calendar/embed?src=aics.group1ge%40gmail.com&ctz=UTC" 
                frameborder="0" 
                scrolling="no"></iframe>
    </div>
</body>
</html>