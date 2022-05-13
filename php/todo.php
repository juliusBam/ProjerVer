<?php include('../php/include/header.php')?>  
    <script src="../javaScript/scriptToDo.js" type="text/javascript"></script>
    <h3 class="text-center pt-5">Board</h3>
    <div class="container">
        <div class="row bg-light p-4">
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
        <div class="row text-center p-2">
            <div class="col">
                <button class="btn btn-outline-secondary hiddenBtn" id="btnHide">Hide list</button>
                <button class="btn btn-outline-info" id="loadList">Load list from file</button>
                <button class="btn btn-outline-success" id="saveList">Save list into file</button>
                <button class="btn btn-outline-success" id="createTodo" onclick="showCreateTodo()">Create new ToDo</button>
                <ol class="list-group" id="listContainer">
                </ol>
            </div>
        </div>
        <div class="row text-center p-2 border" id="divCreateTodo">
            <div class="row text-center pt-2">
                <div class="col-2 pt-2">
                    <label for="taskInput">Title:</label>
                </div>
                <div class="col">
                    <input type="text" class="form-control" id="taskInput" aria-describedby="TaskInput" placeholder="Enter a title for the Task">
                </div>
            </div>
            <div class="row text-center pt-2">
                <div class="col-2 pt-2">
                    <label for="taskInput">Priority:</label>
                </div>
                <div class="col">
                    <input type="text" class="form-control" id="taskInput" aria-describedby="TaskInput" placeholder="Select Priority for the Task">
                </div>
            </div>
            <div class="row text-center pt-2">
                <div class="col-4 pt-2">
                    <label for="taskInput">Select assignment for User:</label>
                </div>
                <div class="col">
                    <input type="text" class="form-control" id="taskInput" aria-describedby="TaskInput" placeholder="Select an User to assign the Task">
                </div>
            </div>
            <div class="row text-center pt-2">
                <div class="col-2 pt-2">
                    <label for="taskInput">Description:</label>
                </div>
                <div class="col">
                    <input type="text" class="form-control" id="taskInput" aria-describedby="TaskInput" placeholder="Enter a describtion for the Task">
                </div>
            </div>
            <div class="row text-center pt-2">
                <div class="col-2 pt-2">
                    <label for="taskInput">Deadline:</label>
                </div>
                <div class="col">
                    <input type="date" class="form-control" id="taskInput" aria-describedby="TaskInput">
                    <input type="time" class="form-control" id="taskInput" aria-describedby="TaskInput">
                </div>
            </div>
            <div class="row text-center p-2">
                <button class="btn btn-outline-success" id="saveTodo" onclick="createTodo()">Save new Task</button>
            </div>
        </div>
    </div>
</body>
</html>