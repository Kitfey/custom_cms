<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php  include "admin/functions.php"; ?>


 <?php 
//Setting Language
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_GET['lang']) && !empty($_GET['lang'])){
  
  $_SESSION['lang'] = $_GET['lang'];
  
  if(isset($_SESSION['lang']) && $_SESSION['lang'] != $_GET['lang']){
    echo "<script type='text/javascript'> location.reload(); </script>";
  }
  
}
  
  if(isset($_SESSION['lang'])) {
    include "includes/languages/".$_SESSION['lang'].".php";
  } else {
    include "includes/languages/en.php";
  }
  




//AUTHENTICATION
 if($_SERVER['REQUEST_METHOD'] == 'POST') {
   
//   isset($_POST['submit'])
   
  $username = trim($_POST['username']);
  $user_email = trim($_POST['user_email']);
  $user_password = trim($_POST['user_password']);
   
   $error = [
     
     'username' => '',
     'user_email' => '',
     'user_password' => ''
     
    
     
   ];
     
   if(strlen($username) < 4) {
     $error['username'] = 'The username must have more characters';
   }
   
   if ($username == '') {
      $error['username'] = 'The username field is empty';

   }
   
    if (username_exists($username)) {
      $error['username'] = 'This username already exists';

   }
   
   
   if ($user_email == '') {
      $error['user_email'] = 'The email field is empty';

   } 
   
   if (email_exists($user_email)) {
      $error['user_email'] = 'This email already exists, <a href="index.php">Please login</a>';

   }
   
      if ($user_password == '') {
      $error['user_password'] = 'The password field is empty';

   }
   
   foreach($error as $key => $value){
     if(empty($value)) {
       
       unset($error[$key]);
       

     }
   }
   
        if(empty($value)) {
       
       register_user($username, $user_email, $user_password);
       login_user($username, $user_password);

     }
   
 }

?>


    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>
    
 
    <!-- Page Content -->
    <div class="container">
    
    <form method="get" id="language-form" class="navbar-form navbar-right" action="">
      <div class="form-group">
        <select name="lang" class="form-control" onchange="changeLanguage()">
          <option value="en" <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'en') { echo "selected"; }?>>English</option>
          <option value="rus" <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'rus') { echo "selected"; }?>>Русский</option>
        </select>
      </div>

    </form>
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1><?php echo _REGISTER; ?></h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
<!--                       <h6> <?php echo $message; ?> </h6>-->
                       
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="<?php echo _USERNAME; ?>" autocomplete="on" value="<?php echo isset($username) ? $username : '' ?>">
                            
                            <p><?php echo isset($error['username']) ? $error['username'] : '' ?></p>
                            
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="user_email" id="email" class="form-control" placeholder="<?php echo _EMAIL; ?>" autocomplete="on" value="<?php echo isset($user_email) ? $user_email : ''  ?>">
                            <p><?php echo isset($error['user_email']) ? $error['user_email'] : '' ?></p>
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="user_password" id="key" class="form-control" placeholder="<?php echo _PASSWORD; ?>">
                             <p><?php echo isset($error['user_password']) ? $error['user_password'] : '' ?></p>
                        </div>
                
                        <input type="submit" name="register" id="btn-login" class="btn btn-primary btn-lg btn-block" value="<?php echo _REGISTER; ?>">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


<hr>
        
        
<script>

  function changeLanguage(){
    
    document.getElementById('language-form').submit()
  }


</script>



<?php include "includes/footer.php";?>
