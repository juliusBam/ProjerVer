
//
$(document).ready(function(){

    $( "#personalList" ).sortable();
    $( "#externalList" ).sortable();
    $("#divCreateTodo").hide();
    loadInitialData();

    //------- alex's old Code ??

    $("#listContainer").sortable();
    $("#btnHide").removeClass("hiddenBtn");
    $(document).on("click", ".delete", deleteEl);
    $(document).on("click", "#inputTitle", hideErrorsTit);
    $(document).on("click", "#inputDesc", hideErrorsDesc);
    $(document).on("click", "#inputPriority", hideErrorsPriority);
    $(document).on("click", "#btnHide", hideList);
    //$(document).on("click", "#loadList", loadList);
    //$(document).on("click", "#saveList", saveList);
});