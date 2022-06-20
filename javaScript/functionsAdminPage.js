function populateDeleteUsers(selectToAppendTo) {
    $.ajax({
        'url': '../api/users/getUsers.php',
        'type': 'GET',
        'cache': false,
        'dataType': 'json',
    })
    .done( function (response) {
        
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
        //TODO add an error reporting
        alert(errorThrown + "\n" + response);
    });
}
function populateDeleteProirities(selectToAppendTo) {
    $.ajax({
        'url': '../api/priorities/getPriorities.php',
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
    var idInput = $("#delUserSelect").val();
     $.ajax({
        'url': '../api/users/deleteUsers.php',
        'type': 'GET',
        'cache': false,
        data: {
            id: idInput
        },
        success: function(result) {
            alertUser("success", "User deleted!", "The user was successfully deleted");
        }
    }).fail(function(response){
        alertUser("error", "Error while deleting user!", response);
    });
}
function deletePriority()
{
    var idInput = $("#delPrioritySelect").val();
     $.ajax({
        'url': '../api/priorities/deletePriorities.php',
        'type': 'GET',
        'cache': false,
        data: {
            id: idInput
        },
        success: function(result) {
            alertUser("success", "Priority deleted!", "The priority was successfully deleted");
        }
    }).fail(function(response){
            alertUser("error", "Error while deleting priority!", "The priority is currently assigned to an active Todo");
    });
}
function deleteRole()
{
    var idInput = $("#delRoleSelect").val();
     $.ajax({
        'url': '../api/roles/deleteRoles.php',
        'type': 'GET',
        'cache': false,
        data: {
            id: idInput
        },
        success: function(result) {
            alertUser("success", "Role deleted!", "The role was successfully deleted");
        }
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
function showDiv(hiddenDiv)
{
    hideAllDivs();
    hiddenDiv.fadeIn();
}
function postPriority()
{
    var labelInput = $('#priority').val();
    $.ajax({
        'url': '../api/priorities/postPriorities.php',
        'type': 'POST',
        data: {
            label: labelInput
        }
    }).done(function (response) {
        alertUser("success", "Priority created!", "Your priority was successfully created");
    }).fail(function (response){
        alertUser("error", "Error while creating priority!", "The entered priority exists already");
    });
}
function postRole()
{
    var labelInput = $('#role').val();
    console.log(labelInput);
    $.ajax({
        'url': '../api/roles/postRoles.php',
        'type': 'POST',
        data: {
            label: labelInput
        }
    }).done(function (response) {
        alertUser("success", "Role created!", "Your role was successfully created");
    }).fail(function (response){
        alertUser("error", "Error while creating role!", "The entered role exists already");
    });
}
function postUser()
{
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
    }).fail(function (response){
        alertUser("error", "Error while creating user!", response.responseJSON);
    });  
}

