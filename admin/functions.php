<?php

//REDIRECT
function redirect($location) {

  header("Location:" . $location);
  exit;
}

function query($query) {
  global $connection;
  $result = mysqli_query($connection, $query);
  confirm_post($result);
  return $result;
}

function fetchRecords($result) {
   return mysqli_fetch_array($result);
}

//COUNT
function count_records($result){
  return mysqli_num_rows($result);
  
}

//METHOD
function ifItIsMethod($method=null){
  global $connection;
  if($_SERVER['REQUEST_METHOD'] == strtoupper($method)) {
    return true;
    
  }
  return false;
}

function isLoggedIn(){
    if(isset($_SESSION['user_role'])){

        return true;
    }

   return false;

}

function loggedInUserId(){
      if(isLoggedIn()){
        $result = query("SELECT * FROM users WHERE username='" . $_SESSION['username'] ."'");
        confirm_post($result);
        $user = mysqli_fetch_array($result);
        return mysqli_num_rows($result) >= 1 ? $user['user_id'] : false;
    }
  return false;
  
}

//LIKES
function userLikedThisPost($post_id){
    $result = query("SELECT * FROM likes WHERE user_id=' .loggedInUserId() . ' AND post_id={$post_id}");
    confirm_post($result);
    return mysqli_num_rows($result) >= 1 ? true : false;
}

function getPostlikes($post_id){

    $result = query("SELECT * FROM likes WHERE post_id=$post_id");
    confirm_post($result);
    echo mysqli_num_rows($result);

}

function checkIfUserLoggedInAndRedirect($redirectLocation=null){
  global $connection;
  if(isLoggedIn()){
    redirect($redirectLocation);
  }
  
}


function escape($string){
  
  global $connection;
  
  return mysqli_real_escape_string($connection, trim($string));
  
}

//USERS COUNT
function users_online() {
  
  if(isset($_GET['onlineusers'])) {
  
  global $connection;
    
  if(!$connection) {
    session_start();
    include("../includes/db.php");
    
    $session = session_id();
      $time = time();
      $time_out_in_seconds = 05;
      $time_out = $time - $time_out_in_seconds;
      
      $query = "SELECT * FROM users_online WHERE session = '$session' ";
      $send_query= mysqli_query($connection, $query);
      $count = mysqli_num_rows($send_query);
      
      if($count == NULL) {
        mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session', '$time')");
      } else {
        mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session' ");
      }
      
      $user_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out' ");
      echo $count_user = mysqli_num_rows($user_online_query);
    
    
  }
      
      
      
  } // get request isset
   
}
users_online();


//POSTS
function displayPosts() {
    global $connection;
  
  
//     $query = "SELECT * FROM posts ORDER BY post_id DESC ";
  $query = "SELECT posts.post_id, posts.post_author,  posts.post_user, posts.post_title, posts.post_category_id, posts.post_status, posts.post_image, ";
  $query .= "posts.post_tags, posts.post_comment_count, posts.post_date, posts.post_views_count, categories.cat_id, categories.cat_title ";
  $query .= "FROM posts ";
  $query .= "LEFT JOIN categories ON posts.post_category_id = categories.cat_id ORDER BY posts.post_id DESC";
  
     $select_posts = mysqli_query($connection, $query);
  
                                
  
       while($row = mysqli_fetch_assoc($select_posts)) {
             $post_id = $row['post_id'];
             $post_author = $row['post_author'];
             $post_user = $row['post_user'];
             $post_title = $row['post_title'];
             $post_category_id = $row['post_category_id'];
             $post_status = $row['post_status'];
             $post_image = $row['post_image'];
             $post_tags = $row['post_tags'];
             $post_comment_count = $row['post_comment_count'];
             $post_date = $row['post_date'];
             $post_views_count = $row['post_views_count'];
             $cat_title = $row['cat_title'];
             $cat_id = $row['cat_id'];
                                   
              echo "<tr>";
         ?>
              <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $post_id; ?>'></td>;
             <?php
              echo "<td>$post_id</td>";
              
         if(!empty($post_author)) {
           echo "<td>$post_author</td>";
         } elseif(!empty($post_user)) {
           echo "<td>$post_user</td>";
         }
         

              echo "<td><a href='../post.php?p_id={$post_id}'>$post_title</a></td>";

              echo "<td><a href='detail_cat.php?category=$cat_id'>{$cat_title}</a></td>";

              echo "<td>$post_status</td>";
              echo "<td><img class='img-thumbnail' width='104' height='76' src='../images/$post_image' alt='image'></td>"; 
              echo "<td>$post_tags</td>";
         
         
              $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
              $send_comment_query = mysqli_query($connection, $query);
              
              $row = mysqli_fetch_array($send_comment_query);
              $comment_id = $row['comment_id'];
              $count_comments = mysqli_num_rows($send_comment_query);
              echo "<td><a href='post_comments.php?id=$post_id'>$count_comments</a></td>";
              echo "<td>$post_date</td>";
              echo "<td><a href='../post.php?p_id={$post_id}'>View Post</a></td>";
              echo "<td><a href='admin_posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
//              echo "<td><a onClick=\"javascript: return confirm('Confirm your action'); \" href='admin_posts.php?delete={$post_id}'>Delete</a></td>";
         
              echo "<td><a rel='$post_id' href='javascript:void(0)' class='delete-link'>Delete</a></td>";
              echo "<td><a href='admin_posts.php?reset={$post_id}'>$post_views_count</a></td>";
              
              echo "</tr>";
       } 



}

function confirm_post($result) {
  
  global $connection;
  
    if(!$result) {
    die("QUERY FAILED" . mysqli_error($connection));
  } 
  
}

//Categories

function insert_categories() {
  
  global $connection;
  
      if(isset($_POST['submit'])) {
          $cat_title = $_POST['cat_title'];
                        
           if($cat_title == "" || empty($cat_title)) {
               echo "This field should not be empty";
           } else {
               $stmt = mysqli_prepare($connection ,"INSERT INTO categories(cat_title) VALUES(?) ");
             
               mysqli_stmt_bind_param($stmt, 's', $cat_title);
               mysqli_stmt_execute($stmt);

                          
                   if(!$stmt) {
                      die('QUERY FAILED' . mysqli_error($connection));
                    }
                    }
        mysqli_stmt_close($stmt);
                        
         }
  
  
}

function findAllCategories() {
    global $connection;
  
     $query = "SELECT * FROM categories";
     $select_categories = mysqli_query($connection, $query);
  
                                
//<!--                            DELETE QUERY                     -->
                           
     if(isset($_GET['delete'])) {
          $the_cat_id = $_GET['delete'];
          $query = "DELETE FROM categories WHERE cat_id = {$the_cat_id} ";
          $delete_category_query = mysqli_query($connection, $query);
          header("Location: categories.php");
     }
  
       while($row = mysqli_fetch_assoc($select_categories)) {
             $cat_id = $row['cat_id'];
             $cat_title = $row['cat_title'];
                                   
              echo "<tr>";
              echo "<td>{$cat_id}</td>";
              echo "<td>{$cat_title}</td>";
              echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
              echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
              echo "</tr>";
       }  
}


//Comments
function displayComments() {
    global $connection;
  
     $query = "SELECT * FROM comments";
     $select_comments = mysqli_query($connection, $query);
  
                                
  
       while($row = mysqli_fetch_assoc($select_comments)) {
             $comment_id = $row['comment_id'];
             $comment_post_id = $row['comment_post_id'];
             $comment_author = $row['comment_author'];
             $comment_content = $row['comment_content'];
             $comment_email = $row['comment_email'];
             $comment_status = $row['comment_status'];
             $comment_date = $row['comment_date'];
        
                                   
              echo "<tr>";
              echo "<td>{$comment_id}</td>";
              echo "<td>{$comment_author}</td>";
              echo "<td>{$comment_content}</td>";
              echo "<td>{$comment_email}</td>";
              echo "<td>{$comment_status}</td>";
         
              $query = "SELECT * FROM posts WHERE post_id = $comment_post_id";
              $select_post_id_query = mysqli_query($connection, $query);
         
              while($row = mysqli_fetch_assoc($select_post_id_query)) {
                
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                
                echo "<td><a href='../post.php?p_id={$post_id}'>$post_title</a></td>";
              }
         
         
//              echo "<td>$post_title</td>";
         
         
              echo "<td>{$comment_date}</td>";
              echo "<td><a href='comments.php?approved={$comment_id}'>Approved</a></td>";
              echo "<td><a href='comments.php?unapproved={$comment_id}'>Unapproved</a></td>";
              echo "<td><a href='comments.php?delete={$comment_id}'>Delete</a></td>";
         

              
              
//              $query = "SELECT * FROM categories WHERE cat_id = {$post_category_id} ";
//              $select_categories_id = mysqli_query($connection, $query);
//
//              while($row = mysqli_fetch_assoc($select_categories_id)) {
//                   $cat_id = $row['cat_id'];
//                   $cat_title = $row['cat_title'];
//         
//              echo "<td>{$cat_title}</td>";
//              }
         
              
              echo "</tr>";
       }  
}



//Users
function displayUsers() {
    global $connection;
  
     $query = "SELECT * FROM users";
     $select_users = mysqli_query($connection, $query);
     
  
       while($row = mysqli_fetch_assoc($select_users)) {
             $user_id = $row['user_id'];
             $username = $row['username'];
             $user_password = $row['user_password'];
             $user_firstname = $row['user_firstname'];
             $user_lastname = $row['user_lastname'];
             $user_email = $row['user_email'];
             $user_role = $row['user_role'];
             $user_image = $row['user_image'];
             $user_date = date('d-m-y');
        
                                   
              echo "<tr>";
              echo "<td>{$user_id}</td>";
              echo "<td>{$username}</td>";
              echo "<td>{$user_firstname}</td>";
              echo "<td>{$user_lastname}</td>";
              echo "<td>{$user_email}</td>";
              echo "<td>{$user_role}</td>";
              echo "<td>{$user_image}</td>";
              echo "<td>{$user_date}</td>";
         
//              $query = "SELECT * FROM posts WHERE post_id = $comment_post_id";
//              $select_post_id_query = mysqli_query($connection, $query);
//         
//              while($row = mysqli_fetch_assoc($select_post_id_query)) {
//                
//                $post_id = $row['post_id'];
//                $post_title = $row['post_title'];
//                
//                echo "<td><a href='../post.php?p_id={$post_id}'>$post_title</a></td>";
//              }
  
              echo "<td><a href='users.php?change_to_admin={$user_id}'>Admin</a></td>";
              echo "<td><a href='users.php?change_to_subscriber={$user_id}'>Subscriber</a></td>";
              echo "<td><a href='users.php?source=edit_user&edit_user={$user_id}'>Edit</a></td>";
              echo "<td><a href='users.php?delete={$user_id}'>Delete</a></td>";
         
         

              
         
              
              echo "</tr>";
       }  
}

function currentUser() {
  global $connection;
  if(isset($_SESSION['username'])) {
    return $_SESSION['username'];
  }
  return false;
}

//PERSONAL USERS DASHBOARD

function get_all_user_posts() {

    return query("SELECT * FROM posts WHERE user_id=".loggedInUserId()."");
}

function get_all_user_comments() {

    return query("SELECT * FROM comments WHERE user_id=".loggedInUserId()."");
}

function get_all_user_categories() {

    return query("SELECT * FROM categories WHERE user_id=".loggedInUserId()."");
}

function get_all_user_published_posts(){
    return query("SELECT * FROM posts WHERE user_id=".loggedInUserId()." AND post_status='published'");
}

function get_all_user_draft_posts(){
    return query("SELECT * FROM posts WHERE user_id=".loggedInUserId()." AND post_status='draft'");
}

function get_all_user_approved_posts_comments(){
  return query("SELECT * FROM comments WHERE user_id=".loggedInUserId()." AND comment_status='approved'");
}


function get_all_user_unapproved_posts_comments(){
  
  return query("SELECT * FROM comments WHERE user_id=".loggedInUserId()." AND comment_status='unapproved'");
}




//ALL USERS DASHBOARD
function recordCount($table) {
  global $connection;
  
    $query = "SELECT * FROM " . $table;
    $select_all_post = mysqli_query($connection, $query);  
  
    $result = mysqli_num_rows($select_all_post); 
    confirm_post($result);
    return $result;
}

//ADMIN INDEX SELECT FUNCTION
function checkStatus($table, $column, $status) {
   global $connection;
  
  $query = "SELECT * FROM $table WHERE $column = '$status' ";
  $result = mysqli_query($connection, $query);  
  return mysqli_num_rows($result); 
//  return $result;
  
  
}

//ADMIN. Restricts subscribers to see the user page
function get_user_name() {

  return isset($_SESSION['username']) ? $_SESSION['username'] : null;
  
}

function is_admin() {
  
  if(isLoggedIn()) {
  
  $result = query("SELECT user_role FROM users WHERE user_id = " .$_SESSION['user_id']. "");
  $row = fetchRecords($result);
  if($row['user_role'] == 'admin') {
      return true;
    }else {
      return false;
    }
    
   }
  return false;
}

//Check the dubicates in username
function username_exists($username) {
  global $connection;
  
  $query = "SELECT username FROM users WHERE username = '$username' ";
    $result = mysqli_query($connection, $query);
    confirm_post($result);
  
  if(mysqli_num_rows($result) > 0) {
    return true;
  }else {
    return false;
  }
}

//Check the dubicates in email
function email_exists($user_email) {
  global $connection;
  
  $query = "SELECT user_email FROM users WHERE user_email = '$user_email' ";
    $result = mysqli_query($connection, $query);
    confirm_post($result);
  
  if(mysqli_num_rows($result) > 0) {
    return true;
  }else {
    return false;
  }
}

//
function register_user($username, $user_email, $password) {
    global $connection;

      $username = mysqli_real_escape_string($connection, $username);
      $user_email = mysqli_real_escape_string($connection, $user_email);
      $password = mysqli_real_escape_string($connection, $password);

       $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 10) );


       $query = "INSERT INTO users(username, user_email, user_password, user_role) ";   
       $query .= "VALUES('{$username}', '{$user_email}', '{$password}', 'subscriber' )";

       $register_user_query = mysqli_query($connection, $query);

       confirm_post($register_user_query);
    
    
}

//LOGIN
function login_user($username, $password) {
  
  global $connection;

  $username = trim($username);
  $password = trim($password);
  
  $username = mysqli_real_escape_string($connection, $username);
  $password = mysqli_real_escape_string($connection, $password);
  
  
  $query = "SELECT * FROM users WHERE username = '{$username}' ";
  $select_user_query = mysqli_query($connection, $query);
  
  if(!$select_user_query) {
    die("Not working" . mysqli_error($connection));
  }
  
  
  while($row = mysqli_fetch_assoc($select_user_query)) {
    
    $db_user_id = $row['user_id'];
    $db_username = $row['username'];
    $db_user_password = $row['user_password'];
    $db_user_firstname = $row['user_firstname'];
    $db_user_lastname = $row['user_lastname'];
    $db_user_role = $row['user_role'];
    
    if(password_verify($password,$db_user_password)) {
    
    $_SESSION['user_id'] = $db_user_id;
    $_SESSION['username'] = $db_username;
    $_SESSION['user_firstname'] = $db_user_firstname;
    $_SESSION['user_lastname'] = $db_user_lastname;
    $_SESSION['user_role'] = $db_user_role;
    
    redirect("/cms/admin");
    
  } else {
    return false;
  }
    
  }
  
  return true;

}

//IMAGES
function imagePlaceholder($image=null){
  
  if(!$image){
    
    return 'd2.jpg';
    
  } else {
    return $image;
  }
  
}




?>