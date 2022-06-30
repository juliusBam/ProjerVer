$(document).ready(function(){
    //hides the class for the title message first so that it can have an animated appearance
    $(".pt-6").hide();
    $(".pt-6").fadeIn(2000);
    $(".text").hide();
    //effects when the mouse hovers
    $(".content").mouseover(function(){
        $(this).children().fadeIn(1000);
    });
    //if the mouse moves out of range the just shown information gets hidden again
    $(".content").mouseout(function(){
        $(this).children().hide();
    });
});