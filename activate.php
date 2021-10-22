<?php
    //The user is re-directed to this file after clicking the activation link
    //Signup link contains two Get parameters: email and activation key
    session_start();
    include "connection.php";
?>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Account Activation</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
        <div class="container-fluid">
            <h1>Account Activation</h1>
            <div>
                <?php
                    //if email or activation key is missing: show an error
                    if(!isset($_GET["email"]) || !isset($_GET["key"]))
                    {
                        echo "<div class='alert alert-danger'>There was an error. Please click on the activation link you received via your registered email.</div>";
                        exit;
                    }
                    //else
                        //store them in two variables
                    $email = $_GET["email"];
                    $key = $_GET["key"];
                        //prepare variables for the query
                    $email = mysqli_real_escape_string($DB, $email);
                    $key = mysqli_real_escape_string($DB, $key);
                        //run query: set activation field to 'activated' for the provided email
                    $sql = "UPDATE users SET activation='activated' WHERE email='$email' AND activation='$key' LIMIT 1";
                    if(!mysqli_query($DB, $sql))
                    {
                        echo "<div class='alert alert-danger'>Cannot execute query. Error: " . $DB->error . "</div>";
                    }
                    else
                    {
                        //if query is successful, show success message and invite user to login
                        if(mysqli_affected_rows($DB) == 1)
                        {
                            echo "<div class='alert alert-success'>Account activated successfully!</div>";
                            echo "<a href='index.php' class='btn btn-primary btn-lg'>Return</a>";
                        }
                        else
                        {
                            echo "<div class='alert alert-danger'>Cannot activate your account. Please make sure you click on the correct link.</div>";
                        }
                    }
                ?>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    </body>
</html>