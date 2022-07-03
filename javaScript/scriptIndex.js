function getDailyStats(elID) {
    //we create today's date
    let today = new Date();

    //the date for the API has to be as a string in format YYYY-M-D
    let month = ((today.getMonth() + 1) < 10) ? "0" + (today.getMonth() + 1) : today.getMonth() + 1;
    let day = (today.getDate() < 10) ? "0" + today.getDate() : today.getDate();
    //merges the parts together
    let dateForRequest = today.getFullYear() + "-" + month + "-" + day;
    //starts asynch data request to API to fetch daily stats
    $.ajax({
        type: "get",
        url: "../api/stats/getDailyStats.php",
        data: {
            day: dateForRequest
        },
        dataType: "json",
        success: function (response) {
            //once we have the data we append it to the passed container whose id is the param elID
            let container = $("#"+elID+"");
            let title = document.createElement("h3");
            $(title).html("What happened today?");
            container.append(title);
            let listContainer = document.createElement("ul");
            let numbLogs = document.createElement("li");
            $(numbLogs).html("Logins: " + response.numbLogins);
            let numbCreatedPosts = document.createElement("li");
            $(numbCreatedPosts).html("Created posts: " + response.numbCreatedPosts);
            let numbClosedPosts = document.createElement("li");
            $(numbClosedPosts).html("Closed posts: " + response.numbClosedPosts);            
            let numbSignUps = document.createElement("li");
            $(numbSignUps).html("Signups: " + response.numbCreatedUsers);        
            listContainer.append(numbLogs);
            listContainer.append(numbCreatedPosts);
            listContainer.append(numbClosedPosts);
            listContainer.append(numbSignUps);
            container.append(listContainer);
        },
        error: function () {
            alertUser("error","Error while loading the data", "An error occourred while loading the daily statistics");
        }
    });
}

function getTimeStats(elID) {
    //end date of the time frame
    let frameEnd = new Date();
    //increments it by 1, cause between would exclude today's date
    frameEnd.setDate(frameEnd.getDate() + 1);
    //creates a date in format YYYY-M-D
    let monthEnd = ((frameEnd.getMonth() + 1) < 10) ? "0" + (frameEnd.getMonth() + 1) : frameEnd.getMonth() + 1;
    let dayEnd = (frameEnd.getDate() < 10) ? "0" + frameEnd.getDate() : frameEnd.getDate();
    let frameEndReq = frameEnd.getFullYear() + "-" + monthEnd + "-" + dayEnd;
    //start date of the time frame
    let frameBegin = new Date();
    //decrements it by 14 to get the date of 14 days before
    frameBegin.setDate(frameBegin.getDate() - 14);
    //creates a date in format YYYY-M-D for the API
    let monthBegin = ((frameBegin.getMonth() + 1) < 10) ? "0" + (frameBegin.getMonth() + 1) : frameBegin.getMonth() + 1;
    let dayBegin = (frameBegin.getDate() < 10) ? "0" + frameBegin.getDate() : frameBegin.getDate();
    let frameBeginReq = frameBegin.getFullYear() + "-" + monthBegin + "-" + dayBegin;
    //asynch data request to the API to fetch the statistic of the specified timeframe (from frameBeginReq to frameEndReq) 
    $.ajax({
        type: "get",
        url: "../api/stats/getTimeFrameStats.php",
        data: {
            date1: frameBeginReq,
            date2: frameEndReq
        },
        dataType: "json",
        success: function (response) {
            //appends the results to the container, whose ID was specified as parameter
            let container = $("#"+elID+"");
            let title = document.createElement("h3");
            $(title).html("What happened from the "+ response.dateBegin + " until today?");
            container.append(title);
            let listContainer = document.createElement("ul");
            let numbLogs = document.createElement("li");
            $(numbLogs).html("Logins: " + response.numbLogins);
            let numbCreatedPosts = document.createElement("li");
            $(numbCreatedPosts).html("Created posts: " + response.numbCreatedPosts);
            let numbClosedPosts = document.createElement("li");
            $(numbClosedPosts).html("Closed posts: " + response.numbClosedPosts);            
            let numbSignUps = document.createElement("li");
            $(numbSignUps).html("Signups: " + response.numbCreatedUsers);        
            listContainer.append(numbLogs);
            listContainer.append(numbCreatedPosts);
            listContainer.append(numbClosedPosts);
            listContainer.append(numbSignUps);
            container.append(listContainer);
        },
        error: function() {
            alertUser("error","Error while loading the data", "An error occourred while loading the daily statistics");
        }
    });
}

$(document).ready(function(){
    //hides the class for the title message first so that it can have an animated appearance
    $(".pt-6").hide();
    $(".pt-6").fadeIn(2000);
    //$(".text").hide();
    //effects when the mouse hovers
    /*$(".content").mouseover(function(){
        $(this).children().fadeIn(1000);
    });
    //if the mouse moves out of range the just shown information gets hidden again
    $(".content").mouseout(function(){
        $(this).children().hide();
    });*/
    //populates the container with the stats
    getDailyStats("dailyStats");
    getTimeStats("timeStats");
});
