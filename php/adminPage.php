<?php include('../php/include/header.php')?>
<script src="../javaScript/scriptAdminPage.js" type="text/javascript"></script>
<script src="../javaScript/functionsAdminPage.js" type="text/javascript"></script>
<h3 class="text-left">Admin Page</h3>
<div class="p-3 text-left col-4 "id="listContainer">
        <label for="divList">Dashboard:</label>
        <ul class="list-group" id="divList">
            <li class="list-group-item list-group-item-success" onclick="showDiv($('#newPriorityForm'))">Create new priority</li>
            <li class="list-group-item list-group-item-success" onclick="showDiv($('#newRoleForm'))">Create new role</li>
            <li class="list-group-item list-group-item-success" onclick="showDiv($('#newUserForm'))">Create new user</li>
            <li class="list-group-item list-group-item-danger" onclick="showDiv($('#deleteUserForm'))">Delete user</li>
            <li class="list-group-item list-group-item-danger" onclick="showDiv($('#deletePriorityForm'))">Delete priority</li>
            <li class="list-group-item list-group-item-danger" onclick="showDiv($('#deleteRoleForm'))">Delete role</li>
        </ul>
</div>
<div class="container">
    
    <form>
     <div class="form-group pt-2" id="newPriorityForm">
            <h2 class="text-left pl-5 pt-1">Create new priority</h3>
            <label for="priority">Name for priority</label>
            <input type="text" class="form-control w-50" id="priority" placeholder="Enter a new priority" required>
            <br>
            <button class="btn btn-outline-success" data-toggle="modal" data-target="#exampleModal" onclick="postPriority()">Create priority now</button>
        </div>
    </form>
    <form>
     <div class="form-group pt-2" id="newRoleForm">
            <h2 class="text-left pl-5 pt-1">Create new role</h3>
            <label for="role">Name for role</label>
            <input type="text" class="form-control w-50" id="role" placeholder="Enter a new role" required>
            <br>
            <button class="btn btn-outline-success" type="submit">Create role now</button>
        </div>
    </form>
    <form>
        <div class="form-group pt-2"  id="newUserForm">
            <h2 class="text-left pl-5 pt-2">Create new user</h3>
            <label for="username">Username</label>
            <input type="text" class="form-control w-50" id="username" placeholder="Enter a username" required>
            <label for="firstName">First name</label>
            <input type="text" class="form-control w-50" id="firstName" placeholder="Enter the first Name"required>
            <label for="secondName">Second name</label>
            <input type="text" class="form-control w-50" id="secondName" placeholder="Enter the second Name" required>
            <label for="useremail">Email</label>
            <input type="email" class="form-control w-50" id="useremail" placeholder="Enter an email" required>
            <label for="gender">Please select a gender</label>
            <select type="text" class="form-control w-50" id="gender" required>
                <option value="w">women</option>
                <option value="d">diverse</option>
                <option value="m">men</option>
            </select>   
            <br>
            <button class="btn btn-outline-success" type="submit">Create user now</button>
        </div>
    </form>
    <form>
        <div class="form-group pt-2" id="deleteUserForm">
            <h2 class="text-left pl-5 pt-1">Delete user</h3>
            <label for="delUserSelect">Select user</label>
            <select type="text" class="form-control w-50" id="delUserSelect" required>
            </select> 
            <br>
            <button class="btn btn-outline-danger" type="submit">Delete user now</button>
        </div>
    </form>
    <form>
        <div class="form-group pt-2" id="deletePriorityForm">
            <h2 class="text-left pl-5 pt-1">Delete priority</h3>
            <label for="delPrioritySelect">Select priority</label>
            <select type="text" class="form-control w-50" id="delPrioritySelect" required>
            </select> 
            <br>
            <button class="btn btn-outline-danger" type="submit">Delete priority now</button>
        </div>
    </form>
    <form>
        <div class="form-group pt-2" id="deleteRoleForm">
            <h2 class="text-left pl-5 pt-1">Delete priority</h3>
            <label for="delRoleSelect">Select priority</label>
            <select type="text" class="form-control w-50" id="delRoleSelect" required>
            </select> 
            <br>
            <button class="btn btn-outline-danger" type="submit">Delete role now</button>
        </div>
    </form>
</div>
</body>
</html>