<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
    
<?php

    if(!isset($_GET['email']) && !isset($_GET['token'])){

        redirect('/cms/index.php');

    }


//$email = 'zarov@gmail.com';
//
//$token = '7c4dff6724e40cc8335b3091bfef9d5d7542a73d1a0f23d4490aae98eedd8f0bb613aa6c41fb8449d50ac690b40c1d46d86b';

if($stmt = mysqli_prepare($connection, 'SELECT username, user_email, token FROM users WHERE token=?')) {
  
          mysqli_stmt_bind_param($stmt, "s", $_GET['token']);
          mysqli_stmt_execute($stmt);
          mysqli_stmt_bind_result($stmt, $username, $user_email, $token);
          mysqli_stmt_fetch($stmt);
          mysqli_stmt_close($stmt);
  
//if($_GET['token'] !== $token || $_GET['email'] !== $email) {
//  redirect('index');
//}
  
  if(isset($_POST['password']) && isset($_POST['confirmPassword'])){
    
    if($_POST['password'] === $_POST['confirmPassword']){
      
      $user_password = $_POST['password'];
      $hashedPassword = password_hash($user_password, PASSWORD_BCRYPT, array('cost'=>12));
      
      if($stmt = mysqli_prepare($connection, "UPDATE users SET token='', user_passsword='{$hashedPassword}' WHERE user_email=? ")) {
        
          mysqli_stmt_bind_param($stmt, "s", $_GET['email']);
          mysqli_stmt_execute($stmt);
        
                if(mysqli_stmt_affected_rows($stmt) >= 1){

                  redirect('/cms/login');
                }
        mysqli_stmt_close($stmt);

      }
    }
    
  }
  
  
}

?>

    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>

<!-- Page Content -->
<div class="container">


    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">

                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Forgot Password?</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">

                                <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>
                                            <input id="password" name="password" placeholder="Enter password" class="form-control"  type="password">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-ok color-blue"></i></span>
                                            <input id="confirmPassword" name="confirmPassword" placeholder="Confirm password" class="form-control"  type="password">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <input name="resetPassword" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                    </div>

                                    <input type="hidden" class="hide" name="token" id="token" value="">
                                </form>

                                </div><!-- Body-->


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <hr>

    <?php include "includes/footer.php";?>

</div> <!-- /.container -->

