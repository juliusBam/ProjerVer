$(document).ready(function(){
    $( "#personalList" ).sortable();
    $( "#externalList" ).sortable();
    $("#divCreateTodo").hide();
    $("#listContainer").sortable();
    $("#btnHide").removeClass("hiddenBtn");
    $(document).on("click", "#submitList", addList);
    $(document).on("click", ".delete", deleteEl);
    $(document).on("click", "#inputTitle", hideErrorsTit);
    $(document).on("click", "#inputDesc", hideErrorsDesc);
    $(document).on("click", "#inputPriority", hideErrorsPriority);
    $(document).on("click", "button#btnHide", hideList);
    $(document).on("click", "#loadList", loadList);
    $(document).on("click", "#saveList", saveList);
});

function showCreateTodo()
{
    $("#divCreateTodo").fadeIn();
}
function createTodo()
{
    let task = $("#taskInput").val();
    if(task!="")
    {
        var listItem = document.createElement("li");
        listItem.setAttribute("class", "list-group-item");
        listItem.innerHTML = task;
        document.getElementById("personalList").appendChild(listItem);
        $("#divCreateTodo").fadeOut();
    }
}
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

/*
function loadList() {
    //ajax call to get the data
    $.get("php/getList.php", function(result){
        purgeList();//has to be before the loop
        $(result).each(function(index, element){
            appendToList(element, "phpAdded");
            hideList();
        });
    })
}
*/


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