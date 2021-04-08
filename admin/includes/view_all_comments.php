<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>Id</th>
      <th>Author</th>
      <th>Comment</th>
      <th>Email</th>
      <th>Status</th>
      <th>In Response to</th>
      <th>Date</th>
      <th>Approved</th>
      <th>Unapproved</th>
      <th>Delete</th>

    </tr>
  </thead>

<tbody>

<?php displayComments(); ?>

</tbody>
</table>


<?php

//Approve
if(isset($_GET['approved'])){
  
  $the_comment_id = $_GET['approved'];
  
  
   $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = {$the_comment_id} ";
   $approve_comment_query = mysqli_query($connection, $query);
   header("Location: comments.php");
  
}


//Unapprove
if(isset($_GET['unapproved'])){
  
  $the_comment_id = $_GET['unapproved'];
  
  
   $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = {$the_comment_id} ";
   $unapprove_comment_query = mysqli_query($connection, $query);
   header("Location: comments.php");
  
}

//DELETE
if(isset($_GET['delete'])){
  
  $the_comment_id = $_GET['delete'];
  
  
   $query = "DELETE FROM comments WHERE comment_id = {$the_comment_id} ";
   $delete_query = mysqli_query($connection, $query);
   header("Location: comments.php");
  
}

?>