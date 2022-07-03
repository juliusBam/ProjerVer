function populateDeleteUsers(selectToAppendTo) {
    //AJAX call to get all users from database
    $.ajax({
        'url': '../api/users/getUsers.php',
        'type': 'GET',
        'cache': false,
        'dataType': 'json',
    })
    .done( function (response) {
        //if the ajax is finished go through the response array and create and add one option per existing user
        for(var i=0; i<response.length;i++) {
            if(response[i].status!=0)
            {
                let newOption = $("<option>");
                newOption.val(response[i].uID);
                newOption.html(response[i].uName + " | " + response[i].firstName + " " + response[i].secondName);
                selectToAppendTo.append(newOption);   
            }
            
        }
    })
    .fail( function (errorThrown, response) {
        //If the AJAX wasnt successfull throw an error
        alert(errorThrown + "\n" + response);
    });
}
function populateExistingUsers()
{
    //AJAX call to get all users from database
    $.ajax({
        'url': '../api/users/getUsers.php',
        'type': 'GET',
        'data' : {
            allUsers : 1
        },
        'cache': false,
        'dataType': 'json',
    })
    .done( function (response) {
        //if the ajax is finished go through the response array and add the found users to the corrosponding Textarea
        console.log(response);
        for(var i=0; i<response.length;i++) {
            let userEntry = response[i].uName + " | " + response[i].firstName + " " + response[i].secondName;
            if(response[i].status==1)
            {
                document.getElementById('existingUsers').innerHTML += userEntry+ "\n";
            }
            else{
                document.getElementById('existingUsers').innerHTML += userEntry+ " (currently deactivated)" +"\n";
            }
            
        }
    })
    .fail( function (errorThrown, response) {
        //If the AJAX wasnt successfull throw an error
        alert(errorThrown + "\n" + response);
    });  
}
function populateExistingPriorities()
{
    //AJAX call to get all priorities from the database
    $.ajax({
        'url': '../api/priorities/getPriorities.php',
        'type': 'GET',
        'cache': false,
        'dataType': 'json',
    })
    .done( function (response) {
        //add all found priorities to the corr. Textarea
        for(var i=0; i<response.length;i++) {
            document.getElementById('existingPriorities').innerHTML += response[i].label + "\n";
        }
    })
    .fail( function (errorThrown, response) {
        //If the AJAX wasnt successfull throw an error
        alert(errorThrown + "\n" + response);
    });  
}
function populateExistingRoles()
{
    //get all existing roles from the DB with an AJAX
    $.ajax({
        'url': '../api/roles/getRoles.php',
        'type': 'GET',
        'cache': false,
        'dataType': 'json',
    })
    .done( function (response) {
        //add all roles to the corr. Textarea
        for(var i=0; i<response.length;i++) {
            document.getElementById('existingRoles').innerHTML += response[i].label + "\n";
        }
    })
    .fail( function (errorThrown, response) {
        //If the AJAX wasnt successfull throw an error
        alert(errorThrown + "\n" + response);
    });
}
function populateDeleteProirities(selectToAppendTo) {
    //get all priorities from the db
    $.ajax({
        'url': '../api/priorities/getPriorities.php',
        'type': 'GET',
        'cache': false,
        'dataType': 'json',
    })
    .done( function (response) {
        //create new Options and add to the select
        for(var i=0; i<response.length;i++) {
            let newOption = $("<option>");
            newOption.val(response[i].id);
            newOption.html(response[i].label);
            selectToAppendTo.append(newOption);
        }
    })
    .fail( function (errorThrown, response) {
       //If the AJAX wasnt successfull throw an error
        alert(errorThrown + "\n" + response);
    });
}
function populateDeleteRoles(selectToAppendTo) {
    $.ajax({
        'url': '../api/roles/getRoles.php',
        'type': 'GET',
        'cache': false,
        'dataType': 'json',
    })
    .done( function (response) {
        
        for(var i=0; i<response.length;i++) {
            let newOption = $("<option>");
            newOption.val(response[i].id);
            newOption.html(response[i].label);
            selectToAppendTo.append(newOption);
        }
    })
    .fail( function (errorThrown, response) {
        //TODO add an error reporting
        alert(errorThrown + "\n" + response);
    });
}
function deleteUser()
{
    //get the index of the selected option
    var idInput = $("#delUserSelect").val();
    //make an AJAX call to delete the user - for simpler understanding it is implemented as GET Call
     $.ajax({
        'url': '../api/users/deleteUsers.php',
        'type': 'GET',
        'cache': false,
        data: {
            id: idInput
        },
        //if successfull call the alertUser function which creates an model with the messages provided as parameters
        success: function(result) {
            alertUser("success", "User deleted!", "The user was successfully deleted");
        }
        // the same as above only that it is an error message
    }).fail(function(response){
        alertUser("error", "Error while deleting user!", response);
    });
}
function deletePriority()
{
    //get the index of the selected option
    var idInput = $("#delPrioritySelect").val();
    //make an AJAX call to delete the user - for simpler understanding it is implemented as GET Call
     $.ajax({
        'url': '../api/priorities/deletePriorities.php',
        'type': 'GET',
        'cache': false,
        data: {
            id: idInput
        },
        //if successfull call the alertUser function which creates an model with the messages provided as parameters
        success: function(result) {
            alertUser("success", "Priority deleted!", "The priority was successfully deleted");
        }
        // the same as above only that it is an error message
    }).fail(function(response){
            alertUser("error", "Error while deleting priority!", "The priority is currently assigned to an active Todo");
    });
}
function deleteRole()
{
    //get the index of the selected option
    var idInput = $("#delRoleSelect").val();
    //make an AJAX call to delete the user - for simpler understanding it is implemented as GET Call
     $.ajax({
        'url': '../api/roles/deleteRoles.php',
        'type': 'GET',
        'cache': false,
        data: {
            id: idInput
        },
        //if successfull call the alertUser function which creates an model with the messages provided as parameters
        success: function(result) {
            alertUser("success", "Role deleted!", "The role was successfully deleted");
        }
        // the same as above only that it is an error message
    }).fail(function(response){
            alertUser("error", "Error while deleting role!", "The role is currently assigned to an active user");
    });
}
function hideAllDivs()
{
    $("#newPriorityForm").hide();
    $("#newUserForm").hide();
    $("#newRoleForm").hide();
    $("#deleteUserForm").hide();
    $("#deletePriorityForm").hide();
    $("#deleteRoleForm").hide();
}
//easy to call functions to show one given div
function showDiv(hiddenDiv)
{
    hideAllDivs();
    hiddenDiv.fadeIn();
}
function postPriority()
{
    //get the input
    var labelInput = $('#priority').val();
    //make a POST with ajax, the data comes from the form field
    $.ajax({
        'url': '../api/priorities/postPriorities.php',
        'type': 'POST',
        data: {
            label: labelInput
        }
    }).done(function (response) {
        alertUser("success", "Priority created!", "Your priority was successfully created");
        clearPrioForm();
    }).fail(function (response){
        alertUser("error", "Error while creating priority!", "The entered priority exists already");
    });
}
function postRole()
{
    //get the input
    var labelInput = $('#role').val();
    //make a POST with ajax, the data comes from the form field
    $.ajax({
        'url': '../api/roles/postRoles.php',
        'type': 'POST',
        data: {
            label: labelInput
        }
    }).done(function (response) {
        alertUser("success", "Role created!", "Your role was successfully created");
        clearRoleForm();
    }).fail(function (response){
        alertUser("error", "Error while creating role!", "The entered role exists already");
    });
}
function postUser()
{
    //make a POST with ajax, the data comes from the form fields
    $.ajax({
        'url': '../api/users/postUsers.php',
        'type': 'POST',
        data: {
            username: $("#username").val(),
            firstName: $("#firstName").val(), 
            secondName: $("#secondName").val(),
            email: $("#useremail").val(),
            gender: $("#gender").val(),
            birthDate: $("#birthdate").val(),
            pwd1: $("#pwd1").val(),
            pwd2: $("#pwd2").val(),
            roleID: $("#roleSelect").val(),
        }
    }).done(function (response) {
        alertUser("success", "User created!", "The user was successfully created");
        clearUserForm();
    }).fail(function (response){
        alertUser("error", "Error while creating user!", response.responseJSON);
    });  
}
function clearUserForm()
{
    $("#username").val("");
    $("#firstName").val(""); 
    $("#secondName").val("");
    $("#useremail").val("");
    $("#gender").val("");
    $("#birthdate").val("");
    $("#pwd1").val("");
    $("#pwd2").val("");
    $("#roleSelect").val("");
}
function clearPrioForm()
{
    $('#priority').val("")
}
function clearRoleForm()
{
    $('#role').val("");
}


