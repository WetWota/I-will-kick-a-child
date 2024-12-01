<?php
// Get the form data
$eventName = $_POST['event_name'];
$eventTime = $_POST['event_time'];
$eventDate = $_POST['event_date'];

// You can store this data in a database or a file.
// Here's a simple example of storing it in a text file:
$file = fopen('schedule.txt', 'a');
fwrite($file, "$eventDate - $eventTime: $eventName\n");
fclose($file);

echo "Event scheduled successfully!";
?>