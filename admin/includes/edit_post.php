<?php

if(isset($_GET['p_id'])) {

  $edit_posts_by_id = $_GET['p_id'];
  
   }



$query = "SELECT * FROM posts WHERE post_id = {$edit_posts_by_id} ";
$select_posts_by_id = mysqli_query($connection, $query);                      
  
 while($row = mysqli_fetch_assoc($select_posts_by_id)) {
       $post_id = $row['post_id'];
       $post_user = $row['post_user'];
       $post_title = $row['post_title'];
       $post_category_id = $row['post_category_id'];
       $post_status = $row['post_status'];
       $post_image = $row['post_image'];
       $post_tags = $row['post_tags'];
       $post_comment_count = $row['post_comment_count'];
       $post_date = $row['post_date'];
       $post_content = $row['post_content'];

}

if(isset($_POST['update_posts'])) {
  
  $post_user = $_POST['post_user'];
  $post_title = $_POST['post_title'];
  $post_category_id = $row['post_category_id'];
  $post_status = $_POST['post_status'];
  $post_image = $_FILES['image']['name'];
  $post_image_temp = $_FILES['image']['tmp_name'];
  $post_content = $_POST['post_content'];
  $post_tags = $_POST['post_tags'];
  


  move_uploaded_file($post_image_temp, "../images/$post_image");
  
  if(empty($post_image)) {
    
    $query = "SELECT * FROM posts WHERE post_id = {$edit_posts_by_id} ";
    
    $select_image = mysqli_query($connection, $query);
    while($row = mysqli_fetch_array($select_image)) {
      $post_image = $row['post_image'];
      
    }
    
  }
$post_title = mysqli_real_escape_string($connection, $post_title);
  
  
  $query = "UPDATE posts SET ";
  $query .= "post_title = '{$post_title}', ";
  $query .= "post_category_id = '{$post_category_id}', ";
  $query .= "post_date = now(), ";
  $query .= "post_user = '{$post_user}', ";
  $query .= "post_status = '{$post_status}', ";
  $query .= "post_tags = '{$post_tags}', ";
  $query .= "post_content = '{$post_content}', ";
  $query .= "post_image = '{$post_image}' ";
  $query .= " WHERE post_id = {$edit_posts_by_id} ";
  
  
  $update_posts = mysqli_query($connection, $query);
  
  confirm_post($update_posts);
  
  echo "<p class='bg-success'>Post Updated. <a href='../post.php?p_id={$edit_posts_by_id}'> View Post</a> or <a href='admin_posts.php'>Edit More Posts</a></p>";
   
  
}


?>


<form action="" method="post" enctype="multipart/form-data">
 
<!-- Post Title-->
<div class="form-group">
 <label for="title">Post Title</label>
 <input value='<?php echo $post_title; ?>' type="text" class="form-control" name="post_title">
 </div> 
 
<!-- Post Category ID-->
<div class="form-group">
 <label for="post_category">Post Category ID</label>
 <select name="post_category" id="post_category">
   <?php
    $query = "SELECT * FROM categories ";
    $select_categories = mysqli_query($connection, $query);
   
     confirm_post($select_categories);

     while($row = mysqli_fetch_assoc($select_categories)) {
       $cat_id = $row['cat_id'];
       $cat_title = $row['cat_title'];
       
        if($cat_id == $post_category_id) {

      
        echo "<option selected value='{$cat_id}'>{$cat_title}</option>";


        } else {

          echo "<option value='{$cat_id}'>{$cat_title}</option>";


        }
       
//       echo "<option value='{$cat_id}'>{$cat_title}</option>";
     }
   
   ?>
   
 </select>
 </div>
 
<!--  Post Author-->
<div class="form-group">
 <label for="users">Users</label>
  <select name="post_user" id="users">
  <?php echo "<option value='{$post_user}'>{$post_user}</option>"; ?>
  <?php
    $query = "SELECT * FROM users ";
    $select_users = mysqli_query($connection, $query);
   
     confirm_post($select_users);

     while($row = mysqli_fetch_assoc($select_users)) {
       $user_id = $row['user_id'];
       $username = $row['username'];
       
       echo "<option value='{$username}'>{$username}</option>";
     }
   
   ?>
    
    
  </select>
 </div> 
 
<!-- Post Status-->
<div class="form-group">
<label for="post_image">Post Status</label>
 <select name="post_status" id="post_status">
 <option value='<?php echo $post_status; ?>'><?php echo $post_status; ?></option>
    <?php
  if($post_status == 'published') {
    echo "<option value='draft'>Draft</option>";
  } else {
    echo "<option value='published'>Published</option>";
  }
   ?>
 
 </select>
  </div>

<!-- Post Image-->
<div class="form-group">
 <label for="post_image">Image</label>

<input type="file" name="image">
<br>
<img class="img-thumbnail" width="104" height="76" src="../images/<?php echo $post_image; ?>" alt="">
 </div> 
 
<!-- Post Tags-->
<div class="form-group">
 <label for="post_tags">Post Tags</label>
 <input value='<?php echo $post_tags; ?>' type="text" class="form-control" name="post_tags">
 </div> 
 
<!-- Post Content-->
<div class="form-group">
 <label for="post_content">Post Content</label>
 <textarea class="form-control" name="post_content" id="body" cols="30" rows="10"><?php echo str_replace('<p></p>', '', $post_content); ?></textarea>
 </div> 
  
  <div class="form-group">
  <input class="btn btn-primary" type="submit" name="update_posts" value="Update Post">
  </div>
  
  
</form>


