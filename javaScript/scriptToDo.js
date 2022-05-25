$(document).ready(function(){
    $( "#personalList" ).sortable();
    $( "#externalList" ).sortable();
    $("#divCreateTodo").hide();
    loadInitialData();

    //------- alex's old Code ??
    $("#listContainer").sortable();
    $("#btnHide").removeClass("hiddenBtn");
    $(document).on("click", "#submitList", addList);
    $(document).on("click", ".delete", deleteEl);
    $(document).on("click", "#inputTitle", hideErrorsTit);
    $(document).on("click", "#inputDesc", hideErrorsDesc);
    $(document).on("click", "#inputPriority", hideErrorsPriority);
    //$(document).on("click", "button#btnHide", hideList);
    //$(document).on("click", "#loadList", loadList);
    //$(document).on("click", "#saveList", saveList);
});
//
function showCreateTodo()
{
    $(".errorInputs").hide();
    $("#divCreateTodo").fadeIn();
}
function createTodo()
{
    let inputVal = [false, false, false, false, false];

    $(".errorInputs").fadeOut();

    let title = $("#titleInput").val();
    let priority = $("#priorityInput option:selected").val();
    let assignedTo = $("#assignInput option:selected").val();
    let descr = $("#descriptionInput").val();
    let deadlineDate = $("#deadlineDate").val();
    let deadlineTime = $("#deadlineTime").val();
    let dateToSend;
    if (title == "" || title == null) {
        $("#errorTitle").fadeIn();
    } else {
        inputVal[0] = true;
    }
    if (priority == 0 || priority == "" || priority == null) {
        $("#errorPriority").fadeIn();
    } else {
        inputVal[1] = true;
    }
    if (assignedTo == "" || assignedTo == null || assignedTo == 0) {
        $("#errorUser").fadeIn();
    } else {
        inputVal[2] = true;
    }
    if (descr == "" || descr == null) {
        $("#errorDescr").fadeIn();
    } else {
        inputVal[3] = true;
    }
    if (deadlineDate == "" || deadlineDate == null) {
        $("#errorDeadlineDate").fadeIn();
    } else {
        if (deadlineTime == "" || deadlineTime == null) {
            $("#errorDeadlineTime").fadeIn();
        } else {
            if (new Date() < new Date(deadlineDate)) {
                deadlineTime += ":00";
                dateToSend = deadlineDate + deadlineTime;
                inputVal[4] = true;
            } else {
                $("#errorDeadlinePast").fadeIn();
            }
            //let dateToCheck = new DateTim();
        }
    }
    let goOn = true;
    for (var i = 0; i < inputVal.length; ++i) {
        if (inputVal[i] == false) {
            goOn = false;
            break;
        }
    }
    if (goOn) {
        alert("Sending to server");
    } else {
        $("#errorForm").fadeIn();
    }
}

function loadInitialData()
{
    $.ajax({
          'url': '../api/todo/postIt.php',
          'type': 'GET',
          'cache': false,
          'dataType': 'json',
      })
      .done( function (response) {
          console.log(response);

            for(var i=0; i<response.length;i++)
            {
                var listItem = document.createElement("li");
                listItem.setAttribute("class", "list-group-item");
                listItem.innerHTML = response[i].title;
                if(response[i].createdBy == response[i].assignedTo)
                {
                    document.getElementById("personalList").appendChild(listItem);
                }
                else{
                    document.getElementById("externalList").appendChild(listItem);
                }

            }
      })
}


//------- alex's old Code ??
function addList() {
    let inputs = [];
    let inputsVal = true;
    inputs[0] = $("#inputTitle").val();
    inputs[1] = $("#inputDesc").val();
    inputs[2] = $("#inputPriority").val();
    if (inputs[0] == '') {
        inputsVal = false;
        $("#noProject").show();
    }   
    if (inputs[1] == '') {
        inputsVal = false;
        $("#noDesc").show();
    }
    if (isNaN(inputs[2]) || inputs[2] == '') {
        inputsVal = false;
        $("#noPriority").show();
    }
    if (inputsVal) {
        appendToList(inputs, "userAdded");
        //Before we append the element to the dom the inputs are cleared
        $("#inputTitle").val("");
        $("#inputDesc").val("");
        $("#inputPriority").val("");
        //checks if the hide/show button is visible
        if (!($("#btnHide").is(':visible'))) {
            $("#btnHide").show();
        }
    }
}

function deleteEl() {
    $(this).parents("li").fadeOut("slow");
    $(this).parents("li").hide();
}

function hideErrorsTit() {
    $("#noProject").hide();
}

function hideErrorsDesc() {
    $("#noDesc").hide();
}

function hideErrorsPriority() {
    $("#noPriority").hide();
}

function hideList() {
    if ($("#listContainer").is(':visible')) {
        $("#listContainer").fadeOut();
        $(this).text("Show list");
    } else {
        $("#listContainer").fadeIn();
        //$(".hiddenBtn")
        $(this).text("Hide list");
    }
}


function appendToList(arrayInputs, newClass) {
    let listEl = document.createElement('li'); //creates the container for the list
    listEl.className = "list-group-item text-left " + newClass;
    //creates the html items to append to the list
    let container1 = document.createElement('div');
    container1.className = "card-header row";
    let col1 = document.createElement('div');
    col1.className = "col-md-7";
    let col2 = document.createElement('div');
    col2.className = "col-md-5 text-end";
    let par1col1 = document.createElement('h5');
    par1col1.className = "card-header pCourse";
    let par2col1 = document.createElement('p');
    par2col1.className = "card-body pList";
    let par1col2 = document.createElement('p');
    let par2col2 = document.createElement('p');
    let deleteBtn = document.createElement('button');
    deleteBtn.append("Delete");
    deleteBtn.className = "btn btn-outline-danger delete";
    par1col2.append(arrayInputs[2]);
    par1col1.append(arrayInputs[0]);
    par2col1.append(arrayInputs[1]);
    par1col2.className = "badge bg-info rounded-pill";
    par2col2.append(deleteBtn);
    col1.appendChild(par1col1);
    col1.appendChild(par2col1);
    col2.appendChild(par1col2);
    col2.appendChild(par2col2);
    container1.appendChild(col1);
    container1.appendChild(col2);
    listEl.appendChild(container1);
    $("#listContainer").append(listEl);
}

function purgeList() {
    $("#listContainer > .phpAdded").remove();
}
/*
function saveList() {
    let arrayToSend = new Array();
    $("#listContainer > li").each(function (i, el) { 
        arrayToSend[i] = new Array();
        arrayToSend[i][0] = $(el).find("p.pCourse").text();
        arrayToSend[i][1] = $(el).find("p.pList").text();
        arrayToSend[i][2] = $(el).find("p.badge").text();
    });
    $.ajax({
        method: "POST",
        url: 'php/saveList.php',
        data: {newList : arrayToSend},
        success: function(response){
            console.log(response);
        },
        error: function(xhr, status, error){
            console.error(xhr);
        }
    });
}*/