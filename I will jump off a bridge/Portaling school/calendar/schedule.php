<!DOCTYPE html>
<html>
<head>
    <title>Schedule Event</title>
</head>
<body>
    <h2>Schedule Event</h2>
    <form method="post" action="process_schedule.php">
        <label for="event_name">Event Name:</label>
        <input type="text" id="event_name" name="event_name"><br><br>
        <label for="event_time">Event Time:</label>
        <input type="time" id="event_time" name="event_time"><br><br>
        <input type="hidden" name="event_date" value="<?php echo $_GET['date']; ?>">
        <input type="submit" value="Schedule">
    </form>
</body>
</html>