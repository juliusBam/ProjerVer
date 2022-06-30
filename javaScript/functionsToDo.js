//TODO add error message
//TODO add success message
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
        postPostIt(inputArray);
    } else {
        $("#errorForm").fadeIn();
    }
    
}

function loadInitialData()
{
    //First we populate the part with the active deadline
    $("#personaList").empty();
    //We Get the TO DO assigned to us
    $.ajax({
          'url': '../api/todo/getPostIt.php?assignedID=1&onlyFuture=1',
          'type': 'GET',
          'cache': false,
          'dataType': 'json',
          success : function (response) {
            if (response != "Empty") {
                for(var i=0; i<response.length;i++)
                {
                    appendListElToEl("personalList", response[i]);
    
                }
            }
          },
          error : function () {
            alertUser("error", "Error in data loading", "An error occourred while loading the post-it");
          }
      });
    //Than we get the TO DO created by us
        $.ajax({
            'url': '../api/todo/getPostIt.php?creatorID=1&onlyFuture=1',
            'type': 'GET',
            'cache': false,
            'dataType': 'json',
            success: function (response) {
                if (response != "Empty") {
                    for(var i=0; i<response.length;i++)
                    {
                        appendListElToEl("externalList", response[i]);
                    }
                }
            },
            error : function () {
                alertUser("error", "Error in data loading", "An error occourred while loading the post-it");
            }
        });
    //Now we fill the part with the past deadline:
        //We get the TO DO assigned to us
        $.ajax({
            'url': '../api/todo/getPostIt.php?assignedID=1&onlyPast=1',
            'type': 'GET',
            'cache': false,
            'dataType': 'json',
            success : function (response) {
                if (response != "Empty") {
                    for(var i=0; i<response.length;i++)
                    {
                        appendListElToEl("personalListPast", response[i]);
    /*                   var listItem = document.createElement("li");
                      listItem.setAttribute("class", "list-group-item");
                      listItem.innerHTML = response[i].title;
                      document.getElementById("personalListPast").appendChild(listItem); */
                    }
                }
            },
            error : function () {
                alertUser("error", "Error in data loading", "An error occourred while loading the post-it");
            }
        });
        //And now we get the TO DO created by us
        $.ajax({
            'url': '../api/todo/getPostIt.php?creatorID=1&onlyPast=1',
            'type': 'GET',
            'cache': false,
            'dataType': 'json',
            success : function (response) {
                if (response != "Empty") {
                    for(var i=0; i<response.length;i++)
                    {
                        appendListElToEl("externalListPast", response[i]);
                      /*var listItem = document.createElement("li");
                      listItem.setAttribute("class", "list-group-item");
                      listItem.innerHTML = response[i].title;
                      document.getElementById("externalListPast").appendChild(listItem);*/
                    }
                }
            },
            error : function () {
                alertUser("error", "Error in data loading", "An error occourred while loading the post-it");
            }
        });
}

/*function deleteEl() {
    $(this).parents("li").fadeOut("slow");
    $(this).parents("li").hide();
}*/

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

/*function appendToList(arrayInputs, newClass) {
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
}*/

function purgeList() {
    $("#personalList > .list-group-item").remove();
    $("#externalList > .list-group-item").remove();
    $("#personalListPast > .list-group-item").remove();
    $("#externalListPast > .list-group-item").remove();
}

function postPostIt(dataToSend) {
    //data to send is the array
    $.ajax({
        'url': '../api/todo/postPostIt.php',
        'type': 'POST',
        data: {
            //createdBy: session["uID"],
            createdBy: 1,
            title: dataToSend[0],
            priority: dataToSend[1],
            assignedTo: dataToSend[2],
            descr: dataToSend[3],
            deadline: dataToSend[4]
        },
        success : function (response) {
            //purge lists
            purgeList();
            //loads the data from db
            loadInitialData();
            alertUser("success", "Data saved!", "Your data was successfully saved");
        },
        error : function (response){
            alertUser("error", "Error in data upload", "An error occourred while saving your data");
        }
    });
}

function populateUsers(selectToAppendTo) {
    $.ajax({
        'url': '../api/users/getUsers.php',
        'type': 'GET',
        'cache': false,
        'dataType': 'json',
        success : function (response) {
            for(var i=0; i<response.length;i++) {
                let newOption = $("<option>");
                newOption.val(response[i].uID);
                newOption.html(response[i].uName + " | " + response[i].firstName + " " + response[i].secondName);
                selectToAppendTo.append(newOption);
            }
        },
        error : function (errorThrown, response) {
            alertUser("error", "Error in data loading", "An error occoured while loading the users' list");
        }
    });
}

function populatePrios(selectToAppendTo) {
    $.ajax({
        'url': '../api/priorities/getPriorities.php',
        'type': 'GET',
        'cache': false,
        'dataType': 'json',
        success : function (response) {
            //console.log(response.length);
            for(var i=0; i<response.length;i++) {
                let newOption = $("<option>");
                newOption.val(response[i].id);
                newOption.html(response[i].label);
                selectToAppendTo.append(newOption);
            }
        },
        error : function (errorThrown, response) {
            alertUser("error", "Error in data loading", "An error occoured loading the priority's list");
        }
    });
}

function appendListElToEl(elID, response) {
    var listItem = document.createElement("li");

    listItem.setAttribute("class", "list-group-item");
    let itemContainer = document.createElement("div");
    $(itemContainer).addClass("infoContainer");
    $(itemContainer).hide();

    //####BEGIN title creation
    let title = document.createElement("h5");
    title.innerHTML = response.title;
    listItem.appendChild(title);

    $(title).css("cursor", "pointer");
    title.onclick = function() {
        let elToToggle = $(this).next(".infoContainer");
        if ($(elToToggle).is(":visible")) {
            elToToggle.hide();
        } else {
            elToToggle.show();
        }
    }

    let priority = document.createElement("div");
    $(priority).addClass("text-bold");
    $(priority).html(response.priorityLabel);
    itemContainer.appendChild(priority);

    //#####BEGIN descr creation
    let descrContainer = document.createElement("div");
    $(descrContainer).addClass("text");
    $(descrContainer).text(response.description);
    itemContainer.appendChild(descrContainer);

    //####BEGIN date creation 
    let dateRow = document.createElement("div");
    $(dateRow).addClass("row");
    let creationCol = document.createElement("div");
    $(creationCol).addClass("col-md-6");
    //we want only the first part of the timestamp aka the date
    $(creationCol).html("<small>Created on:</small>" + "<br>" + response.createdOn.split(" ")[0]);
    let deadlineCol = document.createElement("div");
    $(deadlineCol).addClass("col-md-6");
    $(deadlineCol).addClass("text-end")
    $(deadlineCol).html("<small>Deadline</small>"+ "<br>"  + response.deadline);
    dateRow.appendChild(creationCol);
    dateRow.appendChild(deadlineCol);
    itemContainer.appendChild(dateRow);

    //#####BEGIN Users creation
    let userRow = document.createElement("div");
    $(userRow).addClass("row");
    let creatorCol = document.createElement("div");
    $(creatorCol).addClass("col-md-6");
    //we want only the first part of the timestamp aka the date
    $(creatorCol).html("<small>Created by:</small>" + "<br>" + response.createdByName);
    let assignedCol = document.createElement("div");
    $(assignedCol).addClass("col-md-6");
    $(assignedCol).addClass("text-end")
    $(assignedCol).html("<small>Assigned to</small>"+ "<br>"  + response.assignedToName);
    dateRow.appendChild(creatorCol);
    dateRow.appendChild(assignedCol);
    itemContainer.appendChild(userRow);

    //If tickets are still open
    if (response.postStatus == 0) {
        $(title).addClass("text-success");
        $(title).addClass("text-bold");
        console.log(title);
        let buttonChange = document.createElement("button");
        $(buttonChange).addClass("btn btn-success");
        $(buttonChange).text("Close ticket!");
        $(buttonChange).attr("postID", response.id);
        buttonChange.onclick = function () {
            $.ajax({
                type: "POST",
                url: "../api/todo/updatePostIt.php",
                data: {
                    postID: $(this).attr("postID"),
                    newStatus: 1
                },
                success: function (response) {
                    alertUser("success","Post closed", "The post was successfully closed");
                    purgeList();
                    loadInitialData();
                },
                error: function (response) {
                    alertUser("error", "An error occourred", response.statusText);
                }
            });
        }
        itemContainer.appendChild(buttonChange);
    } else {
        $(title).addClass("text-danger");
        $(title).css("text-decoration", "Line-Through");
    }

    listItem.appendChild(itemContainer);
    //listItem.innerHTML = response.title;
    document.getElementById(elID).appendChild(listItem);
}
