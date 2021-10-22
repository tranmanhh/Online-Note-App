<?php
    session_start();
    include "connection.php";
?>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Reset Password</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <h1>Reset Password</h1>
            <div id="resetPasswordMsg"></div>
            <div>
                <?php
                    //if user_id or validation_key is missing
                    if(!isset($_GET["user_id"]) || !isset($_GET["validation_key"]))
                    {
                        echo "<div class=alert alert-danger>There was an error. Please click on the correct link.</div>";
                    }
                    else
                    {
                        //store them in two variables
                        $userID = $_GET["user_id"];
                        $validationKey = $_GET["validation_key"];
                        $time = time() - 24*60*60;
                        //prepare varaibles for the query
                        $userID = mysqli_real_escape_string($DB, $userID);
                        $validationKey = mysqli_real_escape_string($DB, $validationKey);
                        $sql = "SELECT * FROM forgotpassword WHERE user_id='$userID' AND validation_key='$validationKey' AND time > '$time' AND status='pending'";
                        $result = mysqli_query($DB, $sql);
                        if(!$result)
                        {
                            echo "<div class='alert alert-danger'>Unable to execute query. ERROR " . $DB->error . "</div>";
                        }
                        else
                        {
                            $numRows = mysqli_num_rows($result);
                            if($numRows != 1)
                            {
                                echo "<div class='alert alert-danger'>Link expired.</div>";
                            }
                            else
                            {
                                //print reset password form with hidden user_id and key fields
                                echo "<form id='resetPasswordForm'>
                                        <input type='hidden' name='validationKey' value='$validationKey'>
                                        <input type='hidden' name='userID' value='$userID'>
                                        <div class='form-group'>
                                            <label for='newPassword' class='sr-only'>Enter your new password:</label>
                                            <input type='password' name='newPassword' class='form-control' id='newPassword' placeholder='Enter your new password' maxlength='50'>
                                        </div>
                                        <div class='form-group'>
                                            <label for='cfNewPassword' class='sr-only'>Confirm your new password:</label>
                                            <input type='password' name='cfNewPassword' class='form-control' id='cfNewPassword' placeholder='Confirm your new password' maxlength='50'>
                                        </div>
                                        <input type='submit' name='resetPassword' class='btn btn-success btn-lg' id='resetPassword' value='Reset Password'>
                                    </form>";
                                //script for Ajax call to storeresetpassword.php which will process the reset password form
                            }
                        }
                    }
                ?>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script>
            $("#resetPasswordForm").submit(function(event){
                event.preventDefault();
                var userInputs = $(this).serializeArray();
                $.ajax({
                    url: "storeresetpassword.php",
                    type: "POST",
                    data: userInputs,
                    success: function(message){
                        $("#resetPasswordMsg").html(message);
                    },
                    error: function(){
                        $("#resetPasswordMsg").html("<div class='alert alert-danger'>There was an error with the Ajax call. Please try again later!</div>");
                    }
                })
            });
        </script>
    </body>
</html>