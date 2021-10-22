<?php
    $DB = new mysqli("remotemysql.com", "ntxgCa0F76", "hwbZiF5uqP", "ntxgCa0F76");
    if($DB->errno > 0)
    {
        die("<div class='alert alert-danger'>ERROR: Unable to connect to database " . $DB->error . "</div>");
    }
?>