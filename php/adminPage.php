<?php include('../php/include/header.php')?>
<?php include('include/modals.inc.php');?>
<script src="../javaScript/userAlerts.js" type="text/javascript"></script>
<script src="../javaScript/scriptAdminPage.js" type="text/javascript"></script>
<script src="../javaScript/functionsAdminPage.js" type="text/javascript"></script>
<h2 class="text-left">Admin Page</h2>
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
    
    <form onsubmit="postPriority();return false">
        <div class="form-group pt-2" id="newPriorityForm">
            <div class="container">
                    <div class="row">
                        <div class="col">
                            <h2 class="text-left pl-5 pt-1">Create new priority</h2>
                            <label for="priority">Name for priority</label>
                            <input type="text" class="form-control w-75" id="priority" placeholder="Enter a new priority" required>
                            <br>
                            <button class="btn btn-outline-success" type="submit">Create priority now</button>
                        </div>
                        <div class="col">
                            <h2 class="text-left pl-5 pt-2">All existing priorities</h2>
                            <label for="existingPriorities">The following priorities do already exist:</label>
                            <textarea class="form-control" id="existingPriorities" rows="5" readonly></textarea> 
                        </div>
                    </div>
            </div>
        </div>
    </form>
    <form onsubmit="postRole();return false">
        <div class="form-group pt-2" id="newRoleForm">
            <div class="container">
                        <div class="row">
                            <div class="col">
                                <h2 class="text-left pl-5 pt-1">Create new role</h2>
                                <label for="role">Name for role</label>
                                <input type="text" class="form-control w-75" id="role" placeholder="Enter a new role" required>
                                <br>
                                <button class="btn btn-outline-success" type="submit">Create role now</button>
                            </div>
                            <div class="col">
                                <h2 class="text-left pl-5 pt-2">All existing roles</h2>
                                <label for="existingRoles">The following roles do already exist:</label>
                                <textarea class="form-control" id="existingRoles" rows="5" readonly></textarea> 
                            </div>
                        </div>
                </div>
            
        </div>
    </form>
    <form onsubmit="postUser();return false">
        <div class="form-group pt-2"  id="newUserForm">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <h2 class="text-left pl-5 pt-2">Create new user</h2>
                        <label for="username">Username</label>
                        <input type="text" class="form-control w-75" id="username" placeholder="Enter a username" required>
                        <label for="firstName">First name</label>
                        <input type="text" class="form-control w-75" id="firstName" placeholder="Enter the first Name"required>
                        <label for="secondName">Second name</label>
                        <input type="text" class="form-control w-75" id="secondName" placeholder="Enter the second Name" required>
                        <label for="useremail">Email</label>
                        <input type="email" class="form-control w-75" id="useremail" placeholder="Enter an email" required>
                        <label for="gender">Please select a gender</label>
                        <select type="text" class="form-control w-75" id="gender" required>
                            <option value="w">women</option>
                            <option value="d">diverse</option>
                            <option value="m">men</option>
                        </select>
                        <label for="pwd1">Birthdate</label>
                        <input type="date" class="form-control w-75" id="birthdate" required>
                        <label for="pwd1">Password</label>
                        <input type="password" class="form-control w-75" id="pwd1" placeholder="Enter the a password" required>
                        <label for="pwd2">Repeat password</label>
                        <input type="password" class="form-control w-75" id="pwd2" placeholder="Repeat your password" required>
                        <label for="roleSelect">Select role</label>
                        <select type="text" class="form-control w-75" id="roleSelect" required>
                        </select>    
                        <br>
                        <button class="btn btn-outline-success" type="submit">Create user now</button>
                    </div>
                    <div class="col">
                        <h2 class="text-left pl-5 pt-2">All existing users</h2>
                        <label for="existingUsers">The following useres do already exist:</label>
                        <textarea class="form-control" id="existingUsers" rows="5" readonly></textarea>
                    </div>
                </div>
            </div>           
        </div>
    </from>
    <div class="form-group pt-2" id="deleteUserForm">
            <h2 class="text-left pl-5 pt-1">Delete user</h2>
            <label for="delUserSelect">Select user</label>
            <select type="text" class="form-control w-50" id="delUserSelect">
            </select> 
            <br>
            <button class="btn btn-outline-danger" type="button" onclick="deleteUser()">Delete user now</button>
    </div>
    <div class="form-group pt-2" id="deletePriorityForm">
        <h2 class="text-left pl-5 pt-1">Delete priority</h2>
        <label for="delPrioritySelect">Select priority</label>
        <select type="text" class="form-control w-50" id="delPrioritySelect">
        </select> 
        <br>
        <button class="btn btn-outline-danger"type="button"  onclick="deletePriority()">Delete priority now</button>
    </div> 
    <div class="form-group pt-2" id="deleteRoleForm">
        <h2 class="text-left pl-5 pt-1">Delete role</h2>
        <label for="delRoleSelect">Select role</label>
        <select type="text" class="form-control w-50" id="delRoleSelect">
        </select> 
        <br>
        <button class="btn btn-outline-danger" type="button" onclick="deleteRole()">Delete role now</button>
    </div>
</div>
</body>
</html>