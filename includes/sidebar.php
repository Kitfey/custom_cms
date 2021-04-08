<?php

        if(ifItIsMethod('post')){


                if(isset($_POST['login'])){


                    if(isset($_POST['username']) && isset($_POST['password'])){

                        login_user($_POST['username'], $_POST['password']);


                    }else {


                        redirect('index');
                    }


                }

        }

?>
                        <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-4">

                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Blog Search</h4>
                    <form action="search.php" method="post">
                    <div class="input-group">
                        <input name="search" type="text" class="form-control">
                        <span class="input-group-btn">
                            <button name="submit" class="btn btn-default" type="submit">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
                    </div>
                    </form><!-- end of search form -->
                    <!-- /.input-group -->
                </div>
                
                
                                <!-- Login Well -->
                <div class="well">
                   
                  <?php if(isset($_SESSION['user_role'])): ?>
                  <h4>Logged in as <?php echo $_SESSION['username'] ?></h4>
                  <a href="/cms/includes/logout.php" class="btn btn-primary">Logout</a>
                  <?php else: ?>
                  
                    <h4>Login</h4>
                    <form method="post">
                    <div class="form-group">
                        <input name="username" type="text" class="form-control" placeholder="Enter Username">
                    </div>    
                    <div class="input-group">
                        <input name="password" type="password" class="form-control" placeholder="Enter Password">
                        <span class="input-group-btn">
                         <button class="btn btn-primary" name="login" type="submit">Submit</button>
                          
                        </span>
                    </div>   
<!--                    FORGOT PASSWORD-->
                     <div class="form-group">
                        <a href="forgot.php?forgot=<?php echo uniqid(true); ?>">Forgot Password</a>
                    </div>  
                    
                    
                    </form>
                   
                  <?php endif; ?>
                   
            
                    <!-- /.input-group -->
                </div>
                
                

                <!-- Blog Categories Well -->
                <div class="well">
                   
                <?php
                  
                  //LIMIT 3 
                  $query = "SELECT * FROM categories";
                  $select_categories_sidebar = mysqli_query($connection, $query);
                  
                  ?>
                   
                    <h4>Blog Categories</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="list-unstyled">
                             <?php
                                 while($row = mysqli_fetch_assoc($select_categories_sidebar )) {
                                    $cat_title = $row['cat_title'];
                                    $cat_id = $row['cat_id'];
                                   
                                   $category_class = '';
                                   $registrasion_class = '';
                                   $registrasion = 'registration';
                                   
                                   
//                                   PHP_SELF is a page where we are atm
                                   $pageName = basename($_SERVER['PHP_SELF']);
                                   
                                   if(isset($_GET['category']) && $_GET['category'] == $cat_id) {
                                     $category_class = 'active';
                                   } else if ($pageName == $registrasion) {
                                     $registrasion_class = 'active';
                                   }
                                     
                                    echo "<li class='$category_class'><a href='/cms/category/$cat_id'>{$cat_title}</a></li>";
                                   

                                   
                           
                                   
                                   
                                 }
                              ?>
                            </ul>
                        </div>
                        <!-- /.col-lg-6 -->
<!--
                        <div class="col-lg-6">
                            <ul class="list-unstyled">
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                            </ul>
                        </div>
-->
                        <!-- /.col-lg-6 -->
                    </div>
                    <!-- /.row -->
                </div>

                <!-- Side Widget Well -->
                <?php include "widget.php"; ?>

            </div>
