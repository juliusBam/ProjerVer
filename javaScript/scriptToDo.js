
//
$(document).ready(function(){
    $( "#personalList" ).sortable();
    $( "#externalList" ).sortable();
    $("#divCreateTodo").hide();
    loadInitialData();
    //alertUser("success", "Cool you did it", "Your operation was successful");
    //------- alex's old Code ??

    $("#listContainer").sortable();
    $("#btnHide").removeClass("hiddenBtn");
    $(document).on("click", ".delete", deleteEl);
    $(document).on("click", "#inputTitle", hideErrorsTit);
    $(document).on("click", "#inputDesc", hideErrorsDesc);
    $(document).on("click", "#inputPriority", hideErrorsPriority);
    $(document).on("click", "#btnHide", hideList);
});