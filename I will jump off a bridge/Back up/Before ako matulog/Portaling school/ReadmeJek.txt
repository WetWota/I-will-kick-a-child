<?php
ob_start();
?>
        //put this at the start
<?php
ob_end_flush();
?>
        //this at the end

        //you need these two incase you get a header thingy error I forgor

session_start();
        //use this at the start of a php class
        //it utilizes the data shared from the other files that uses $_Session
        //it's required for sharing temporary data across the project
        //don't forgor to put this on every php file that needs session data

session_destroy();
        //it deletes the temporary data
        //dw about it, we only need it for logging out rn

Sa calendar, it writes a file, plain file. Do convert it to utilizing another csv file instead when you can.
If not, that's fine.

just need more data to insert pero I'll leave you for designing muna
