<?php include "includes/admin_header.php"; ?>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include "includes/admin_navigation.php"; ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to the admin page
                            <small>Author</small>
                        </h1>
<!--                    FORM    -->
                    <div class="col-xs-6">
                       
                    <?php insert_categories(); ?>
                         
<!--                         ADD-->
                        <form action="" method="post">
                          <div class="form-groups">
                           <label for="cat-title">Category Title</label>
                            <input class="form-control" type="text" name="cat_title">
                            
                          </div>
                           <div class="form-groups">
                            <input class="btn btn-primary" type="submit" name="submit" value="Add Category">
                            
                          </div>
                        </form>
                        
                      <?php 
                      
                      if(isset($_GET['edit'])) {
                        
                        $cat_id = $_GET['edit'];
                        
                        include "includes/edit_category.php";
                        
                      }
                      
                      
                      ?>
                        
                    </div>  
                    
<!--                      Table  -->
                      <div class="col-xs-6">
                        <table class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>Id</th>
                              <th>Category Title</th>
                              <th>Action</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php findAllCategories(); ?>

                              
                          </tbody>
                        </table>
                        
                        
                        
                      </div>

                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

        
<?php include "includes/admin_footer.php"; ?>