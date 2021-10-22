//Ajax call for the sign up form
//Once the form is submitted
$("#signupForm").submit(function(event){
    //prevent default php processing(if not automatically process in the form it is placed)
    event.preventDefault();
    //collect user inputs
    var userInputs = $(this).serializeArray();
    //send them to signup.php using Ajax
    //can also use post func or get func: $.post({}).done().fail()
    $.ajax({
        url: "signup.php",
        type: "POST",
        data: userInputs,
        //Ajax call successful: show error or success message
        success: function(message){
            if(message)
            {
                $("#signupMsg").html(message);
            }
        },
        //Ajax call fails: show Ajax call error
        error: function(){
            $("#signupMsg").html("<div class='alert alert-danger'>There was an error with the Ajax call. Please try again later!</div>");
        }
    });
});

$("#loginForm").submit(function(event){
    event.preventDefault();
    var userInputs = $(this).serializeArray();
    $.ajax({
        url: "login.php",
        type: "POST",
        data: userInputs,
        success: function(message){
            if(message == "success")
            {
                window.location = "mainpageloggedin.php";
            }
            else
            {
                $("#loginMsg").html(message);
            }
        },
        error: function(){
            $("#loginMsg").html("<div class='alert alert-danger'>There was an error with the Ajax call. Please try again later!</div>")
        }
    })
});

$("#passwordForm").submit(function(event){
    event.preventDefault();
    var userInputs = $(this).serializeArray();
    $.ajax({
        url: "forgotpassword.php",
        type: "POST",
        data: userInputs,
        success: function(message){
            if(message)
            {
                $("#passwordMsg").html(message);
            }
        },
        error: function(){
            $("#passwordMsg").html("<div class='alert alert-danger'>There was an error with the Ajax call. Please try again later!</div>");
        }
    })
});