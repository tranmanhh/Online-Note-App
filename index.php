<?php
    session_start();
    include "connection.php";
    //logout
    include "logout.php";
    //remember me
    include "rememberme.php";
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Online Notes</title>
        <link rel="stylesheet" href="styling/style.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
        <!--include header-->
        <?php
            include "layouts/header.php";
        ?>
        <!--jumbotron-->
        <div class="jumbotron bg-transparent" id="landingPage">
            <h1>Online Notes App</h1>
            <p>Your Notes with you wherever you go.</p>
            <p>Easy to use, protects all your notes!</p>
            <button class="btn btn-success btn-lg" data-target="#signupModal" data-toggle="modal">Sign up-It's free</button>
        </div>
        <!--login form-->
        <form method="post" id="loginForm">
            <div class="modal" id="loginModal" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 id="loginModalLabel">Login:</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <!--Login message from php file-->
                            <div id="loginMsg"></div>
                            <div class="form-group">
                                <label for="loginEmail" class="sr-only">Login Email:</label>
                                <input type="email" class="form-control" name="loginEmail" id="loginEmail" placeholder="Email" maxlength="30">
                                <label for="loginPassword" class="sr-only">Login Password:</label>
                                <input type="password" class="form-control" name="loginPassword" id="loginPassword" placeholder="Password" maxlength="40">
                            </div>
                            <!--Remember me checkbox and forgot password link-->
                            <div class="checkbox">
                                <label><input type="checkbox" name="rememberme" id="rememberme"> Remember me</label>
                                <a href="#" class="float-right" style="cursor: pointer" data-target="#passwordModal" data-toggle="modal" data-dismiss="modal">Forgot Password?</a>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn border register-left" name="register" data-target="#signupModal" data-toggle="modal" data-dismiss="modal">Register</button>
                            <input type="submit" class="btn btn-success" name="login" value="Login">
                            <button type="button" class="btn btn-default border" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!--signup form-->
        <form method="post" id="signupForm">
            <div class="modal" id="signupModal" role="dialog" aria-labelledby="signupModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 id="signupModalLabel">Sign up today and Start using our Online Notes App!</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <!--Sign up message from php file-->
                            <div id="signupMsg"></div>
                            <div class="form-group">
                                <label for="username" class="sr-only">Username:</label>
                                <input type="text" class="form-control" name="username" id="username" placeholder="Username" maxlength="30">
                                <label for="email" class="sr-only">Email:</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email Address" maxlength="30">
                                <label for="password" class="sr-only">Password:</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Choose a password" maxlength="40">
                                <label for="cfPassword" class="sr-only">Confirm Password:</label>
                                <input type="password" class="form-control" name="cfPassword" id="cfPassword" placeholder="Confirm password" maxlength="40">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-success" name="signup" value="Sign up">
                            <button type="button" class="btn btn-default border" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!--Forgot password form-->
        <form method="post" id="passwordForm">
            <div class="modal" id="passwordModal" role="dialog" aria-labelledby="passwordModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 id="passwordModalLabel">Enter your email:</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div id="passwordMsg"></div>
                            <label for="forgotemail" class="sr-only">Forgot Password Email:</label>
                            <input type="email" class="form-control" name="forgotemail" id="forgotemail" placeholder="Email" maxlength="30">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn border register-left" name="register" data-target="#signupModal" data-toggle="modal" data-dismiss="modal">Register</button>
                            <input type="submit" class="btn btn-success" name="submit" value="Submit">
                            <button type="button" class="btn btn-default border" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!--include footer-->
        <?php
            include "layouts/footer.php";
        ?>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="index.js"></script>
    </body>
</html>