function populateDeleteUsers(selectToAppendTo) {
    $.ajax({
        'url': '../api/users/getUsers.php',
        'type': 'GET',
        'cache': false,
        'dataType': 'json',
    })
    .done( function (response) {
        
        for(var i=0; i<response.length;i++) {
            let newOption = $("<option>");
            newOption.val(response[i].uID);
            newOption.html(response[i].uName + " | " + response[i].firstName + " " + response[i].secondName);
            selectToAppendTo.append(newOption);
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
            console.log(result);
        }
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
            console.log(result);
        }
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
            console.log(result);
        }
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
        alert(response);
    }).fail(function (response){
        console.log(response);
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
        alert(response);
    }).fail(function (response){
        console.log(response);
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
        alert(response);
    }).fail(function (response){
        console.log(response.responseJSON);
    });  
}

