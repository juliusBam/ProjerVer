$(document).ready(function() {
    //hides the Form to create new Todos
    $("#divCreateTodo").hide();
    //get the initial Data from the DB
    loadInitialData();
});