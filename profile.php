<?php
    session_start();
    if(!isset($_SESSION["user_id"]))
    {
        header("location: index.php");
    }
?>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Profile</title>
        <link rel="stylesheet" href="styling/style.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
        <?php
            include "layouts/headerprofile.php"
        ?>
        <!--create general profile information container-->
        <div class="container">
            <div class="row">
                <div class="offset-md-3 col-md-6">
                    <h2>General Account Settings:</h2>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <tr data-target="#updateUsernameModal" data-toggle="modal">
                                <td>Username</td>
                                <td><?php echo $_SESSION["username"];?></td>
                            </tr>
                            <tr data-target="#updateEmailModal" data-toggle="modal">
                                <td>Email</td>
                                <td><?php echo $_SESSION["email"];?></td>
                            </tr>
                            <tr data-target="#updatePasswordModal" data-toggle="modal">
                                <td>Password</td>
                                <td>
                                    <?php
                                        for($i = 0; $i < 10; $i++)
                                        {
                                            echo "&bull;";
                                        }
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--Update username form-->
        <form method="post" id="updateUsernameForm">
            <div class="modal" id="updateUsernameModal" role="dialog" aria-labelledby="updateUsernameLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 id="updateUsernameLabel">Edit Username:</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div id="updateUsernameMsg"></div>
                            <label for="updateUsername">Username:</label>
                            <input type="text" name="updateUsername" class="form-control" id="updateUsername" placeholder="Username" maxlength="30">
                        </div>
                        <div class="modal-footer">
                            <input type="submit" name="submit" class="btn btn-success" value="Submit">
                            <button type="button" class="btn btn-default border" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!--Update email form-->
        <form method="post" id="updateEmailForm">
            <div class="modal" id="updateEmailModal" role="dialog" aria-labelledby="updateEmailLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 id="updateEmailLabel">Edit Email:</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div id="updateEmailMsg"></div>
                            <label for="updateEmail">Email:</label>
                            <input type="email" name="updateEmail" class="form-control" id="updateEmail" placeholder="Email" maxlength="30">
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-success" value="Submit">
                            <button type="button" class="btn btn-default border" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!--Update password form-->
        <form method="post" id="updatePasswordForm">
            <div class="modal" id="updatePasswordModal" role="dialog" aria-labelledby="updatePasswordLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 id="updatePasswordLabel">Enter current and new password:</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div id="updatePasswordMsg"></div>
                            <label for="currentPassword" class="sr-only">Current password:</label>
                            <input type="password" name="currentPassword" class="form-control" id="currentPassword" placeholder="Your current password" maxlength="40">
                            <label for="updatePassword" class="sr-only">Choose a password:</label>
                            <input type="password" name="updatePassword" class="form-control" id="updatePassword" placeholder="Choose a password" maxlength="40">
                            <label for="cfUpdatePassword" class="sr-only">Confirm password:</label>
                            <input type="password" name="cfUpdatePassword" class="form-control" id="cfUpdatePassword" placeholder="Confirm password" maxlength="40">
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-success" value="Submit">
                            <button type="button" class="btn btn-default border" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <?php
            include "layouts/footer.php";
        ?>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="profile.js"></script>
    </body>
</html>