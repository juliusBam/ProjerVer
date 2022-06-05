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
function DeleteUser()
{

}