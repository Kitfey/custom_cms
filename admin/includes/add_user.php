<?php
if(isset($_POST['create_user'])) {

  
  $user_firstname = $_POST['user_firstname'];
  $user_lastname = $_POST['user_lastname'];
  $username = $_POST['username'];
  $user_role = $_POST['user_role'];
  $user_email = $_POST['user_email'];
  $user_password = $_POST['user_password'];

  $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10) );
  
  $query = "INSERT INTO users(user_firstname, user_lastname, username, user_role, user_email, user_password) ";
  
$query .= "VALUES('{$user_firstname}','{$user_lastname}','{$username}','{$user_role}', '{$user_email}', '{$user_password}')";
  
  
  $create_users_query = mysqli_query($connection, $query);
  
confirm_post($create_users_query);
  
  echo "User has been created /" . " " . "<a href='users.php'>View all Users</a> ";
  
}


?>


<form action="" method="post" enctype="multipart/form-data">
 
 <div class="form-group">
 <label for="user_firstname">Firstname</label>
 <input type="text" class="form-control" name="user_firstname">
 </div> 
 
 <div class="form-group">
 <label for="user_lastname">Lastname</label>
 <input type="text" class="form-control" name="user_lastname">
 </div> 

 
<!--
 <div class="form-group">
 <label for="post_image">Post Image</label>
 <input type="file" name="image">
 </div> 
-->
  
 
 <div class="form-group">
 <label for="username">Username</label>
 <input type="text" class="form-control" name="username">
 </div> 
 
  <div class="form-group">
  <label for="user_role">Role</label>
  <select name="user_role" id="">
 
  <option value="subscriber">Select Options</option>
  <option value="admin">Admin</option>
  <option value="subscriber">Subscriber</option>
  
</select>
 </div> 
 
 
   <div class="form-group">
 <label for="user_email">Email</label>
 <input type="email" class="form-control" name="user_email">
 </div> 
 
   <div class="form-group">
 <label for="user_password">Password</label>
 <input type="text" class="form-control" name="user_password">
 </div> 
 
<!--
    <div class="form-group">
 <label for="post_content">Post Content</label>
 <textarea type="text" class="form-control" name="post_content" id="" cols="30" rows="10">
 </textarea>
 </div> 
-->
  
  <div class="form-group">
  <input class="btn btn-primary" type="submit" name="create_user" value="Create User">
  </div>
  
  
</form>
































