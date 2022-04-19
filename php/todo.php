<?php include('../php/include/header.php')?>  

    <br>
    <h3 class="text-center">Board</h3>
    <br>
    <div class="row">
        <div class="col-md-2">

        </div>
        <div class="col-md-6 bg-light p-4">
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
    </div>
    <br>
    <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-7">
            <button class="btn btn-outline-secondary hiddenBtn" id="btnHide">Hide list</button>
            <button class="btn btn-outline-info" id="loadList">Load list from file</button>
            <button class="btn btn-outline-success" id="saveList">Save list into file</button>
            <br>
            <br>
            <ol class="list-group" id="listContainer">
            </ol>
        </div>
        <div class="col-md">
        </div>
    </div>
    <script src="../javaScript/scriptToDo.js" type="text/javascript"></script>
</body>
</html>