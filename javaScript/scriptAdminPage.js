$(document).ready(function(){
    //hides all forms so that they can be opened individiually
    hideAllDivs();
    //call of functions so that all Selects and Textareas are immediatly available when the site is ready
    populateDeleteUsers($("#delUserSelect"));
    populateDeleteProirities($("#delPrioritySelect"));
    populateDeleteRoles($("#roleSelect"));
    populateDeleteRoles($("#delRoleSelect"));
    populateExistingUsers();
    populateExistingPriorities();
    populateExistingRoles();
});
