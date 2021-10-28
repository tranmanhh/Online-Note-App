<?php
    $DB = new mysqli("path", "username", "password", "databasename");
    if($DB->errno > 0)
    {
        die("<div class='alert alert-danger'>ERROR: Unable to connect to database " . $DB->error . "</div>");
    }
?>
