<?php
    session_start();
    include "connection.php";
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        //get the id of the note sent through Ajax call
        $noteID = $_POST["id"];
        //run a query to delete a note
        $sql = "DELETE FROM notes WHERE id='$noteID'";
        if(!mysqli_query($DB, $sql))
        {
            echo "error";
        }
    }
?>