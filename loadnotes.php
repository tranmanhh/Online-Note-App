<?php
    session_start();
    include "connection.php";
    //get user_id
    $userID = $_SESSION["user_id"];
    //run a query to delete empty notes
    $sql = "DELETE FROM notes WHERE user_id='$userID' AND note=''";
    if(!mysqli_query($DB, $sql))
    {
        echo "<div>Unable to execute query. ERROR " . $DB->error . "</div>";
    }
    //run a query to look for notes corresponding to user_id
    $sql = "SELECT * FROM notes WHERE user_id='$userID' ORDER BY time DESC";
    $result = mysqli_query($DB, $sql);
    $noteDisplay = "";
    if(!$result)
    {
        echo "<div>Unable to execute query. ERROR " . $DB->error . "</div>";
    }
    else
    {
        $numRows = mysqli_num_rows($result);
        if($numRows == 0)
        {
            echo "<div class='alert alert-warning'>You have not created any notes!</div>";
        }
        else
        {
            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
            {
                $note = $row['note'];
                $noteID = $row['id'];
                $time = date("M j, Y, h:i:s A", $row["time"]);
                $noteDisplay .= "<div class='row'>
                                    <div class='col-5 col-sm-3 delete'><button type='button' class='btn btn-danger btn-lg form-control'>Delete</button></div>
                                    <div class='noteBackground' id='$noteID'>
                                        <div class='noteText'>$note</div>
                                        <div class='noteTime'>$time</div>
                                    </div>
                                </div>";
            }
        }
    }
    //show notes or alert message if no notes were created
    echo $noteDisplay;
?>