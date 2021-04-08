<?php include "includes/admin_header.php"; ?>
<?php 
$post_counts = count_records(get_all_user_posts());
$comments_counts = count_records(get_all_user_comments());
$categories_counts = count_records(get_all_user_categories());
?>   
     

    <div id="wrapper">
    
<?php users_online(); ?>


        <!-- Navigation -->
        <?php include "includes/admin_navigation.php"; ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to the admin page
                            <small><?php echo strtoupper(get_user_name()); ?></small>
                        </h1>
                        

                    </div>
                </div>
                <!-- /.row -->
                       
                <!-- /.row -->
                
<div class="row">
<!--   Posts-->
    <div class="col-lg-4 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-file-text fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                      <div class='huge'>
                       <?php echo $post_counts;?>
                        </div>
                        <div>Posts</div>
                    </div>
                </div>
            </div>
            <a href="admin_posts.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
<!--    Comments-->
    <div class="col-lg-4 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                    <div class='huge'>
                     <?php echo $comments_counts;?>
                     </div>
                      <div>Comments</div>
                    </div>
                </div>
            </div>
            <a href="comments.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>

<!--    Categories-->
    <div class="col-lg-4 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-list fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                    
                    <div class='huge'><?php echo $categories_counts;?></div>

                       
                         <div>Categories</div>
                    </div>
                </div>
            </div>
            <a href="categories.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>
                <!-- /.row -->
                
<?php 
$post_published_counts = count_records(get_all_user_published_posts());
$post_draft_counts = count_records(get_all_user_draft_posts());            

$com_app_counts = count_records(get_all_user_approved_posts_comments());
$com_un_counts = count_records(get_all_user_unapproved_posts_comments());     
?>              
                
                
                
<div class="row">
  <script type="text/javascript">
  google.charts.load('current', {'packages':['bar']});
  google.charts.setOnLoadCallback(drawStuff);

  function drawStuff() {
    var data = new google.visualization.arrayToDataTable([
      ['Data', 'Count'],
      
      <?php
      $element_text = ['All Posts', 'Published Posts', 'Draft Posts', 'Comments', 'Approved Comments', 'Unapproved Comments', 'Categories'];
      $element_count = [$post_counts, $post_published_counts, $post_draft_counts, $comments_counts, $com_app_counts, $com_un_counts, $categories_counts];
      
      for($i = 0; $i < 7; $i++) {
        echo "['{$element_text[$i]}'" . "," . "{$element_count[$i]}],";
      }
      
      ?>
      
      
//      ["Posts", 44],

    ]);

    var options = {
      width: '100%',
      legend: { position: 'none' },
      chart: {
        title: '',
        subtitle: '' },
      axes: {
        x: {
          0: { side: 'top', label: ''} // Top x-axis.
        }
      },
      bar: { groupWidth: "60%" }
    };

    var chart = new google.charts.Bar(document.getElementById('top_x_div'));
    // Convert the Classic options to Material options.
    chart.draw(data, google.charts.Bar.convertOptions(options));
  };
</script>
<div id="top_x_div" style="width: 100%; height: 600px;"></div>  
  
</div>                

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
        
        <?php include "includes/admin_footer.php"; ?>


