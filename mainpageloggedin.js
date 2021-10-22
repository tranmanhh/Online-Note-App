$(function(){
    //define variables
    var activeNoteID = 0;
    var editMode = false;
    //load notes on page load: Ajax call to loadnotes.php
    $.ajax({
        url: "loadnotes.php",
        success: function(message){
            $("#notes").html(message);
            clickOnNote();
            deleteNote();
        },
        error: function(){
            $("#notes").html("<div class='alert alert-danger'>There was an error with Ajax call. Please try again later!</div>");
        }
    });
    //add a new notes: Ajax call to createnotes.php
    $("#addNote").click(function(){
        $.ajax({
            url: "createnotes.php",
            success: function(message){
                if(message == "error"){
                    $("#alertMsg").text("There was an issue inserting the new note to the database.");
                    $("#alert").fadeIn();
                }
                else
                {
                    //update activeNoteID to the id of the new note
                    activeNoteID = message;
                    //show hide elements
                    $("#notePad textarea").val("");
                    $("#notePad textarea").focus();
                    showHide(["#notePad", "#allNotes"], ["#edit", "#addNote", "#done", "#notes"]);
                }
            },
            error: function(){
                $("#alertMsg").text("There was an error with Ajax call. Please try again later!");
                $("#alert").fadeIn();
            }
        });
    });
    //type note: Ajax call to updatenotes.php
    $("#notePad textarea").keyup(function(){
        //Ajax call to update the task of id active note
        $.ajax({
            url: "updatenotes.php",
            type: "POST",
            data: {note: $(this).val(), id: activeNoteID},
            success: function(message){
                if(message == "error")
                {
                    $("#alertMsg").text("There was issue updating the notes. Please try again later!");
                    $("#alert").fadeIn();
                }
            },
            error: function(){
                $("#alertMsg").text("There was issue updating the notes. Please try again later!");
                $("#alert").fadeIn();
            }
        })
    });
    //click on "All Note" button
    $("#allNotes").click(function(){
        $.ajax({
            url: "loadnotes.php",
            success: function(message){
                $("#notes").html(message);
                showHide(["#addNote", "#edit", "#notes"], ["#allNotes", "#notePad"]);
                clickOnNote();
                deleteNote();
            },
            error: function(){
                $("#notes").html("<div class='alert alert-danger'>There was an error with Ajax call. Please try again later!</div>");
            }
        });
    });
    //click on "Done" button after editing: load notes again
    $("#done").click(function(){
        editMode = false;
        $(".noteBackground").removeClass("col-7 col-sm-9");
        $.ajax({
            url: "loadnotes.php",
            success: function(message){
                $("#notes").html(message);
                showHide(["#edit"], ["#done", ".delete"]);
                clickOnNote();
                deleteNote();
            },
            error: function(){
                $("#alertMsg").text("There was an error with Ajax call. Please try again later!");
                $("#alert").fadeIn();
            }
        });
    });
    //click on "Edit": go to edit mode (show delete buttons and reduce width of notes)
    $("#edit").click(function(){
        //switch editMode
        editMode = true;
        //reduce the width of notes
        $(".noteBackground").addClass("col-7 col-sm-9");
        showHide(["#done", ".delete"], ["#edit"]);
    });

    //functions:
        //click on "Delete" button
    function deleteNote(){
        $(".delete").click(function(){
            var deleteButton = $(this);
            $.ajax({
                url: "deletenotes.php",
                type: "POST",
                data: {id: deleteButton.next().attr("id")},
                success: function(message){
                    if(message == "error")
                    {
                        $("#alertMsg").text("There was an issue deleting the note. Please try again later!");
                        $("#alert").fadeIn();
                    }
                    else
                    {
                        //remove containing div
                        deleteButton.parent().remove();
                    }
                },
                error: function(){
                    $("#alertMsg").text("There was an error with Ajax call. Please try again later!");
                    $("#alert").fadeIn();
                }
            })
        });
    }
        //click on a note
    function clickOnNote(){
        $(".noteBackground").click(function(){
            if(!editMode)
            {
                //update activeNoteID variable
                activeNoteID = $(this).attr("id");
                //fill text area
                $("#notePad textarea").val($(this).find(".noteText").text());
                //show hide elements
                showHide(["#notePad", "#allNotes"], ["#edit", "#addNote", "#done", "#notes"]);
                $("#notePad textarea").focus();
            }
        });
    }
        //show/hide function
    function showHide(arrayToShow, arrayToHide){
        arrayToShow.forEach(element => {
            $(element).show();
        });
        arrayToHide.forEach(element => {
            $(element).hide();
        });
    }
}); //function executed when page is fully loaded