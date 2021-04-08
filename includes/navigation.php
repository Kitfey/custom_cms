<?php  require_once ('admin/functions.php'); ?>
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/cms">CMS Front</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">

               
               <?php if (isLoggedIn()): ?>
               
               <a class="navbar-brand" href="/cms/admin.php">Admin</a>
               
               <a class="navbar-brand" href="/cms/includes/logout.php">Logout</a>
               
               <?php else: ?>
               
               <a class="navbar-brand" href="/cms/login.php">Login</a>   
               
               <?php endif; ?>
<!--                <a class="navbar-brand" href="/cms/login">Login</a>   -->

  
<!--        check who's logged in            -->
<?php
if (session_status() === PHP_SESSION_NONE) session_start(); 

                  
    if(isset($_SESSION['user_role'])) {
    
        if(isset($_GET['p_id'])) {
            
          $the_post_id = $_GET['p_id'];
        
        echo "<li><a href='/cms/admin/admin_posts.php?source=edit_post&p_id={$the_post_id}'>Edit Post</a></li>";
          
//          admin_posts.php?source=edit_post&p_id={$post_id}
        
        }
    
    
    
    }                
                  
?>
                    
                    
                </ul>
              <ul class="nav navbar-right navbar-nav">
               
<!--                  <a class="navbar-brand" href="/cms/admin">Admin</a>-->
               
                  <li class='<?php echo $registrasion_class?>'>
                  <a class="active navbar-brand" href="/cms/registration">Registration</a>
                </li>
              
                  <a class="active navbar-brand" href="/cms/contact">Contact</a>
            
                
              </ul>

            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    
  
  
  
</nav>
    
   