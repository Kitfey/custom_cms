<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>Id</th>
      <th>Username</th>
<!--      <th>Password</th>-->
      <th>Firstname</th>
      <th>Lastname</th>
      <th>Email</th>
<!--      <th>Image</th>-->
      <th>Role</th>
      <th>Image</th>
      <th>Date</th>
      <th>Change role</th>
      <th>Change role</th>
      <th>Delete</th>
      <th>Edit</th>
      


    </tr>
  </thead>

<tbody>

<?php displayUsers(); ?>

</tbody>
</table>


<?php

//Change to admin
if(isset($_GET['change_to_admin'])){
  
  $the_user_id = $_GET['change_to_admin'];
  
  
   $query = "UPDATE users SET user_role = 'admin' WHERE user_id = {$the_user_id} ";
   $admin_role_query = mysqli_query($connection, $query);
   header("Location: users.php");
  
}


//Change to subscriber
if(isset($_GET['change_to_subscriber'])){
  
  $the_user_id = $_GET['change_to_subscriber'];
  
  
   $query = "UPDATE users SET user_role = 'subscriber' WHERE user_id = {$the_user_id} ";
   $subscriber_role_query = mysqli_query($connection, $query);
   header("Location: users.php");
  
}

//DELETE
if(isset($_GET['delete'])){
  
  if(isset($_SESSION['user_role'])) {
    
    if($_SESSION['user_role'] == 'admin') {
  
  $the_user_id = mysqli_real_escape_string($connection, $_GET['delete']);
  
  
   $query = "DELETE FROM users WHERE user_id = {$the_user_id} ";
   $delete_query = mysqli_query($connection, $query);
   header("Location: users.php");
      
    }
  }
}

?>