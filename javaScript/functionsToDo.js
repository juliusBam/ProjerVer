//alert("script");

function showCreateTodo() {
    $(".errorInputs").hide();
    //fetches the users and populates the select with them
    populateUsers($("#assignInput"));
    //fetches the different priorities from the db and adds them to the dropdown
    populatePrios($("#priorityInput"));
    $("#divCreateTodo").fadeIn();
}
function createTodo() {

    //InputVal will be used to check if every input is considered as valid, if yes
    //the data will be sent to the server
    let inputVal = [false, false, false, false, false];

    $(".errorInputs").fadeOut();
    let inputArray = new Array();
    //inputArray contains the inputs incapsulated, in order to send them to the postPostIt API
    inputArray[0] = $("#titleInput").val();
    inputArray[1] = $("#priorityInput option:selected").val();
    inputArray[2] = $("#assignInput option:selected").val();
    inputArray[3] = $("#descriptionInput").val();
    //Deadline date and deadline time are separated inputs in order to check the 
    //picked date more easily
    let deadlineDate = $("#deadlineDate").val();
    let deadlineTime = $("#deadlineTime").val();

    //Validations of all user's input
    if (inputArray[0] == "" || inputArray[0] == null) {
        $("#errorTitle").fadeIn();
    } else {
        inputVal[0] = true;
    }
    if (inputArray[1] == 0 || inputArray[1] == "" || inputArray[1] == null) {
        $("#errorPriority").fadeIn();
    } else {
        inputVal[1] = true;
    }
    if (inputArray[2] == "" || inputArray[2] == null || inputArray[2] == 0) {
        $("#errorUser").fadeIn();
    } else {
        inputVal[2] = true;
    }
    if (inputArray[3] == "" || inputArray[3] == null) {
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
                inputArray[4] = deadlineDate + " " + deadlineTime;
                inputVal[4] = true;
            } else {
                $("#errorDeadlinePast").fadeIn();
            }
            //let dateToCheck = new DateTim();
        }
    }

    //goOn is used as check
    let goOn = true;
    for (var i = 0; i < inputVal.length; ++i) {
        if (inputVal[i] == false) {
            goOn = false;
            break;
        }
    }

    //if inputs are okkey, send to server
    if (goOn) {
        //alert("Sending to server");
        console.log(inputArray);
    } else {
        $("#errorForm").fadeIn();
    }
    
}

function loadInitialData()
{
    $.ajax({
          'url': '../api/todo/getPostIt.php',
          'type': 'GET',
          'cache': false,
          'dataType': 'json',
      })
      .done( function (response) {
          //console.log(response);

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

function postPostIt(dataToSend) {

}

function populateUsers(selectToAppendTo) {
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
    })
}

function populatePrios(selectToAppendTo) {
    $.ajax({
        'url': '../api/priorities/getPriorities.php',
        'type': 'GET',
        'cache': false,
        'dataType': 'json',
    })
    .done( function (response) {
        console.log(response.length);
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
    })
}