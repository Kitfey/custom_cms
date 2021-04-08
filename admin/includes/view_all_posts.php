<?php

include('delete_modal.php');

if(isset($_POST['checkBoxArray'])) {

  foreach($_POST['checkBoxArray'] as $postValueId){
    
    $bulk_options = $_POST['bulk_options'];
    
    switch($bulk_options) {
      case 'published':
        $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId} ";
        $update_to_published_status = mysqli_query($connection, $query);
        confirm_post($update_to_published_status);
        break;
        
        case 'draft':
        $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId} ";
        $update_to_draft_status = mysqli_query($connection, $query);
        confirm_post($update_to_draft_status);
        break;
        
        case 'delete':
        $query = "DELETE FROM posts WHERE post_id = {$postValueId} ";
        $update_to_delete_status = mysqli_query($connection, $query);
        confirm_post($update_to_delete_status);
        break;
        
        case 'clone':
        
            $query = "SELECT * FROM posts WHERE post_id = '{$postValueId}' ";
            $select_post_query = mysqli_query($connection, $query);
        
            while ($row = mysqli_fetch_array($select_post_query)) {
            $post_title         = $row['post_title'];
            $post_category_id   = $row['post_category_id'];
            $post_date          = $row['post_date']; 
            $post_author        = $row['post_author'];
            $post_user          = $row['post_user'];
            $post_status        = $row['post_status'];
            $post_image         = $row['post_image'] ; 
            $post_tags          = $row['post_tags']; 
            $post_content       = $row['post_content'];

          }
      $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_user, post_date,post_image,post_content,post_tags,post_status) ";
        
      $query .= "VALUES({$post_category_id},'{$post_title}','{$post_author}','{$post_user}',now(),'{$post_image}','{$post_content}','{$post_tags}', '{$post_status}') "; 
                $copy_query = mysqli_query($connection, $query); 
             
               if(!$copy_query ) {

                die("QUERY FAILED" . mysqli_error($connection));
               } 
        
        
        break;
    }
  }
  
}


?>


<form action="" method="post">
 <table class="table table-bordered table-hover">
 
 <div id="bulkOptionsContainer" class="col-xs-4">
  
   <select class="form-control" name="bulk_options" id="">
     <option value="">Select Option</option>
     <option value="published">Publish</option>
     <option value="clone">Clone</option>
     <option value="draft">Draft</option>
     <option value="delete">Delete</option>
   </select>

 </div>
  <div class="col-xs-4">
    <input type="submit" name="submit" class="btn btn-success" value="Apply">
    <a class="btn btn-primary" href="admin_posts.php?source=add_post">Add New</a>
  </div>
  <thead>
    <tr>
      <th><input id="selectAllBoxes" type="checkbox"></th>
      <th>Id</th>
      <th>User</th>
      <th>Post Title</th>
      <th>Category</th>
      <th>Status</th>
      <th>Image</th>
      <th>Tags</th>
      <th>Comments</th>
      <th>Date</th>
      <th>View</th>
      <th>Action</th>
      <th>Action</th>
      <th>View Post</th>

    </tr>
  </thead>

<tbody>

<?php displayPosts(); ?>



</tbody>
</table>
</form>

<?php


//DELETE
if(isset($_GET['delete'])){
  
  $the_post_id = $_GET['delete'];
  
  
   $query = "DELETE FROM posts WHERE post_id = {$the_post_id} ";
   $delete_posts_query = mysqli_query($connection, $query);
   header("Location: admin_posts.php");
  
}

//RESET
if(isset($_GET['reset'])){
  
  $the_post_id = $_GET['reset'];
  
  
   $query = "UPDATE posts SET post_views_count = 0 WHERE post_id =" . mysqli_real_escape_string($connection, $_GET['reset']) . " ";
   $reset_posts_query = mysqli_query($connection, $query);
   header("Location: admin_posts.php");
  
}

?>




<script>
jQuery(document).ready(function() { 

jQuery(".delete-link").on('click', function(){
  
var id = $(this).attr('rel');
var delete_url = "admin_posts.php?delete="+ id +"";
  
  jQuery(".modal_delete_link").attr('href', delete_url);
  
  jQuery("#myModal").modal('show');
  
});


});


</script>