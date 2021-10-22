//Ajax call to update username.php
$("#updateUsernameForm").submit(function(event){
    event.preventDefault();
    var userInputs = $(this).serializeArray();
    $.ajax({
        url: "updateusername.php",
        type: "POST",
        data: userInputs,
        success: function(message){
            if(message)
            {
                $("#updateUsernameMsg").html(message);
            }
            else
            {
                location.reload();
            }
        },
        error: function(){
            $("#updateUsernameMsg").html("<div class='alert alert-danger'>There was an error with Ajax call. Please try again later!</div>");
        }
    });
});

//Ajax call to updatepassword.php
$("#updatePasswordForm").submit(function(event){
    event.preventDefault();
    userInputs = $(this).serializeArray();
    $.ajax({
        url: "updatepassword.php",
        type: "POST",
        data: userInputs,
        success: function(message){
            if(message)
            {
                $("#updatePasswordMsg").html(message);
            }
            else
            {
                location.reload();
                window.alert("Password updated successfully! Please log in again.");
            }
        },
        error: function(){
            $("#updatePasswordMsg").html("<div class='alert alert-danger'>There was an error with Ajax call. Please try again later!</div>");
        }
    });
});

//Ajax call to updateemail.php
$("#updateEmailForm").submit(function(event){
    event.preventDefault();
    userInputs = $(this).serializeArray();
    $.ajax({
        url: "updateemail.php",
        type: "POST",
        data: userInputs,
        success: function(message){
            if(message)
            {
                $("#updateEmailMsg").html(message);
            }
        },
        error: function(){
            $("#updateEmailMsg").html("<div class='alert alert-danger'>There was an error with Ajax call. Please try again later!</div>")
        }
    });
})