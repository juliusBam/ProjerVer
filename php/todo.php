<?php include('../php/include/header.php')?>  
    <script src="../javaScript/scriptToDo.js" type="text/javascript"></script>
    <br>
    <h3 class="text-center">Board</h3>
    <br>
    <div class="container">
        <div class="row bg-light p-4">
            <div class="row">
                <div class="col-md-6">
                    <label for="project">Projekt</label>
                    <input type="text" class="form-control" name="project"  id="inputTitle">
                    <small class="text-danger errorBox" id="noProject">Please insert the name of the project</small>
                </div>
                <div class="col-md-6">
                    <label for="desc">Beschreibung</label>
                    <input class="form-control" type="text" class="form-control" name="desc"  id="inputDesc">
                    <small class="text-danger errorBox" id="noDesc">Please insert a description</small>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                <label for="priority">Priority</label>
            <select class="form-control input-sm" name="priority" id="inputPriority">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
            </select>
            <small class="text-danger errorBox" id="noPriority">Please insert priority 1 (low) - 5 (high)</small>
            </div>
                <div class="col-md text-end">
                    <br>
                    <button class="btn btn-success" id="submitList">Add to List</button>
                </div>
            </div>
        </div>
        <br>
        <div class="row text-center p-3">
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
                <div class="col-2 pt-2">
                    <label for="taskInput">ToDo</label>
                </div>
                <div class="col-5">
                    <input type="text" class="form-control" id="taskInput" aria-describedby="TaskInput" placeholder="Enter a Task">
                </div>
                <div class="col-2">
                    <button class="btn btn-outline-success" id="saveTodo" onclick="createTodo()">Save new Task</button>
                </div>
    
        </div>
        <div class="row bg-light p-4">
            <div class="col">
                <h3>Personal List:</h3>
                <ul class="list-group" id="personalList">
                    <li class="list-group-item">Cras justo odio</li>
                    <li class="list-group-item">Dapibus ac facilisis in</li>
                    <li class="list-group-item">Morbi leo risus</li>
                    <li class="list-group-item">Porta ac consectetur ac</li>
                    <li class="list-group-item">Vestibulum at eros</li>
                </ul>
            </div>
            <div class="col">
                <h3>External List:</h3>
                <ul class="list-group" id="externalList">
                    <li class="list-group-item">Cras justo odio</li>
                    <li class="list-group-item">Dapibus ac facilisis in</li>
                    <li class="list-group-item">Morbi leo risus</li>
                    <li class="list-group-item">Porta ac consectetur ac</li>
                    <li class="list-group-item">Vestibulum at eros</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>