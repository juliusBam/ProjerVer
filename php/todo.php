<?php include('../php/include/header.php');?>
<?php
    //logically only admins are allowd to visit the admin page. If the user is not logged, or it is not an admin the loading of the page will be blocked
    //and a message will be shown instead
    if (!isset($_COOKIE["userID"]) || $_COOKIE["userID"] == "" || $_COOKIE["userID"] == "0") {
        include("include/nonAuthorized.inc.php");
        exit();
    }
?>
<?php include('include/modals.inc.php');?>
    <script src="../javaScript/userAlerts.js" type="text/javascript"></script>
    <script src="../javaScript/functionsToDo.js" type="text/javascript"></script>
    <script src="../javaScript/scriptToDo.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../css/myStyle.css">
    <h3 class="text-center pt-5">Board</h3>
    <div class="container">
        <div id="listContainer">
            <div class="row bg-light p-4 customListCont">
                <h2 class="text-center">Active</h2>
                <div class="col">
                    <h3>Personal List:</h3>
                    <ul class="list-group" id="personalList">
                    </ul>
                </div>
                <div class="col">
                    <h3>External List:</h3>
                    <ul class="list-group" id="externalList">
                    </ul>
                </div>
            </div>
            <br>
            <div class="row bg-light p-4 customListCont">
                <div>
                <h2 class="text-center">Overdue</h2>
                </div>
                <div class="col">
                    <ul class="list-group" id="personalListPast">
                    </ul>
                </div>
                <div class="col">
                    <ul class="list-group" id="externalListPast">
                    </ul>
                </div>
            </div>
        </div>
        <div class="row text-center p-2">
            <div class="col">
                <?php
                    //if the user is not an intern he can create new posts
                    if (isset($_COOKIE["userType"]) && $_COOKIE["userType"] != "3") {
                        echo '<button class="btn btn-outline-success" id="createTodo" onclick="showCreateTodo()">Create new ToDo</button>';
                    }
                ?>
                <ol class="list-group" id="listContainer">
                </ol>
            </div>
        </div>
        <?php
        //if the user is not an intern the form is rendered
        if (isset($_COOKIE["userType"]) && $_COOKIE["userType"] != "3") {
        echo '<div class="row p-2 border" id="divCreateTodo">
            <div class="row pt-2">
                <div class="col-2 pt-2 toDoInput">
                    <label for="title">Title:</label>
                </div>
                <div class="col-4">
                    <input type="text" class="form-control" name="title" id="titleInput" aria-describedby="TaskInput" placeholder="Enter a title for the Task">
                    <small id="errorTitle" class="text-danger errorInputs">Please insert a title</small>
                </div>
            </div>
            <div class="row pt-2">
                <div class="col-2 pt-2 toDoInput">
                    <label for="priority">Priority:</label>
                </div>
                <div class="col-4">
                    <select class="form-control" id="priorityInput" name="priority" aria-describedby="TaskInput" placeholder="Select Priority for the Task">
                        <option value="0">Please choose a priority level</option>
                    </select>
                    <small id="errorPriority" class="text-danger errorInputs">Please choose a priority</small>
                </div>
            </div>
            <div class="row pt-2">
                <div class="col-2 pt-2 toDoInput">
                    <label for="assignTo">Assign to:</label>
                </div>
                <div class="col-4">
                    <select type="text" class="form-control" name="assignTo" id="assignInput" aria-describedby="TaskInput">
                        <option value="0">Please choose a user</option>
                    </select>
                    <small id="errorUser" class="text-danger errorInputs">Please choose a user</small>
                </div>
            </div>
            <div class="row pt-2">
                <div class="col-2 pt-2 toDoInput">
                    <label for="description">Description:</label>
                </div>
                <div class="col">
                    <textarea type="text" class="form-control" name="description" rows="3" id="descriptionInput" aria-describedby="TaskInput" placeholder="Enter a describtion for the Task"></textarea>
                    <small id="errorDescr" class="text-danger errorInputs">Please insert a description</small>
                </div>
            </div>
            <div class="row  pt-2">
                <div class="col-2 pt-2 toDoInput">
                    <label for="deadline">Deadline:</label>
                    <small id="errorDeadlinePast" class="text-danger errorInputs">The deadline has to be after the actual date</small>
                </div>
                <div class="col-3">
                    <input type="date" class="form-control" id="deadlineDate" aria-describedby="TaskInput">
                    <small id="errorDeadlineDate" class="text-danger errorInputs">Please pick a day</small>
                </div>
                <div class="col-2">
                    <input type="time" class="form-control" id="deadlineTime" aria-describedby="TaskInput">
                    <small id="errorDeadlineTime" class="text-danger errorInputs">Please choose a time</small>
                </div>
            </div>
            <div class="row text-right p-2">
                <button class="btn btn-outline-success" id="saveTodo" onclick="createTodo()">Save new Task</button>
            </div>
        </div>';
        }
        ?>
    </div>
</body>
</html>