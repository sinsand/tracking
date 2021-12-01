<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tracking v4skin Management</title>
  <meta name="default" content="<?php echo $LinkHostWeb;?>" />
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="theme-color" content="#ffffff">
  <link rel="icon" href="https://www.v4skin.co.th/wp-content/uploads/2021/05/cropped-icon-32x32.png" sizes="32x32" />
  <link rel="icon" href="https://www.v4skin.co.th/wp-content/uploads/2021/05/cropped-icon-192x192.png" sizes="192x192" />
  <link rel="apple-touch-icon" href="https://www.v4skin.co.th/wp-content/uploads/2021/05/cropped-icon-180x180.png" />
  <meta name="msapplication-TileImage" content="https://www.v4skin.co.th/wp-content/uploads/2021/05/cropped-icon-270x270.png" />

  <link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo $LinkHostWeb;?>plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo $LinkHostWeb;?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <link rel="stylesheet" href="<?php echo $LinkHostWeb;?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $LinkHostWeb;?>plugins/jqvmap/jqvmap.min.css">
  <link rel="stylesheet" href="<?php echo $LinkHostWeb;?>plugins/adminLTE/css/AdminLTE.css">
  <link rel="stylesheet" href="<?php echo $LinkHostWeb;?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="<?php echo $LinkHostWeb;?>plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="<?php echo $LinkHostWeb;?>plugins/summernote/summernote-bs4.css">
  <link rel="stylesheet" href="<?php echo $LinkHostWeb;?>css/font-awesome-animation.min.css">
  <!--<link rel="stylesheet" href="<?php echo $LinkHostWeb;?>css/sheet.css">-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome-animation@1.1.1/css/font-awesome-animation.css">


  <!-- jQuery -->
  <script src="<?php echo $LinkHostWeb;?>plugins/jquery/jquery.min.js"></script>
  <script src="<?php echo $LinkHostWeb;?>plugins/jquery-ui/jquery-ui.min.js"></script>
  <script>  $.widget.bridge('uibutton', $.ui.button)</script>
  <script src="<?php echo $LinkHostWeb;?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo $LinkHostWeb;?>plugins/chart.js/Chart.min.js"></script>
  <script src="<?php echo $LinkHostWeb;?>plugins/sparklines/sparkline.js"></script>
  <script src="<?php echo $LinkHostWeb;?>plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="<?php echo $LinkHostWeb;?>plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <script src="<?php echo $LinkHostWeb;?>plugins/jquery-knob/jquery.knob.min.js"></script>
  <script src="<?php echo $LinkHostWeb;?>plugins/moment/moment.min.js"></script>
  <script src="<?php echo $LinkHostWeb;?>plugins/daterangepicker/daterangepicker.js"></script>
  <script src="<?php echo $LinkHostWeb;?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <script src="<?php echo $LinkHostWeb;?>plugins/summernote/summernote-bs4.min.js"></script>
  <script src="<?php echo $LinkHostWeb;?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <script src="<?php echo $LinkHostWeb;?>plugins/adminLTE/js/adminlte.js"></script>
  <script src="<?php echo $LinkHostWeb;?>plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
</head>

  <body class=" <?php  if( empty($_COOKIE[$CookieID]) && empty($_SESSION[$SessionID])  ) {
                      echo "hold-transition login-page";
                    }elseif( !empty($_COOKIE[$CookieID]) && empty($_SESSION[$SessionID]) ) {
                      echo "hold-transition lockscreen";
                    }elseif( !empty($_COOKIE[$CookieID]) && !empty($_SESSION[$SessionID]) ){
                      echo "hold-transition sidebar-mini layout-fixed"; } ?>">
  <?php if( empty($_COOKIE[$CookieID]) && empty($_SESSION[$SessionID]) ){ ?>
    <div class="login-box">
      <div class="login-logo">
        <a href="<?php echo $LinkWeb;?>"><b>Tracking</b> Management</a>
      </div>
      <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg">Sign in to start your session</p>
          <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post" autocomplete="off">
            <div class="input-group mb-3">
              <input type="text" class="form-control" placeholder="Username" id="u_username" autocomplete="off">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="password" class="form-control" placeholder="Password" id="u_password" autocomplete="off">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-8">
                <div class="icheck-primary">
                  <input type="checkbox" id="u_remember" name="u_remember" value="1" checked>
                  <label for="u_remember">Remember Me</label>
                </div>
              </div>
              <div class="col-4">
                <button type="button" class="btn btn-primary btn-block" id="u_submit_login">Sign In</button>
              </div>
            </div>
            <div class="row">
              <div class="col modal-signin-show" style="padding:5px 0;">

              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <script>
      $(document).ready(function(e) {
          $("#u_username").focus();
          $("#u_username").keypress(function(e) {
              if(e.which==13){
                  $("#u_password").focus();
              }
          });
          $("#u_password").keypress(function(e) {
              if(e.which==13){
                $.post("<?php echo $LinkHostWeb;?>query/admin-query.php",
                {
                    u_name  :$("#u_username").val(),
                    u_pass  :$("#u_password").val(),
                    u_check :$("#u_remember:checked").val(),
                    linkpath : "<?php echo $LinkPath;?>",
                    post :"sign-in"
                },
                function(data){
                  $(".modal-signin-show").html(data);
                });
              }
          });
          $("#u_submit_login").click(function(e) {
            $.post("<?php echo $LinkHostWeb;?>query/admin-query.php",
            {
                u_name  :$("#u_username").val(),
                u_pass  :$("#u_password").val(),
                u_check :$("#u_remember:checked").val(),
                linkpath : "<?php echo $LinkPath;?>",
                post :"sign-in"
            },
            function(data){
              $(".modal-signin-show").html(data);
            });
          });
      });
    </script>
  <?php }elseif( !empty($_COOKIE[$CookieID]) && empty($_SESSION[$SessionID]) ){ ?>
        <div class="lockscreen-wrapper">
          <div class="lockscreen-logo">
            <a><b>Tracking</b> Management</a>
          </div>
          <div class="lockscreen-name"><?php echo base64url_decode($_COOKIE[$CookieName]);?></div>
          <div class="lockscreen-item">
            <div class="lockscreen-image">
              <img src="<?php echo $LinkHostWeb;?>images/avatar.png" alt="User Image">
            </div>
            <form class="lockscreen-credentials" name="pForm">
              <div class="input-group">
                <input type="password" class="form-control" id="u_password" placeholder="password">
                <div class="input-group-btn">
                  <button type="button" class="btn click-check-signin"><i class="fa fa-arrow-right text-muted"></i></button>
                </div>
              </div>
            </form>


            <script>
              $(document).ready(function(e) {
                  $('form[name=pForm]').submit(function(){
                    return false;
                  });
                  $("#u_password").focus();
                  $(".click-check-signin").click(function(e) {
                    $.post("<?php echo $LinkHostWeb;?>query/admin-query.php",
                    {
                        u_pass :$("#u_password").val(),
                        linkpath : "<?php echo $LinkPath;?>",
                        post :"check-signin"
                    },
                    function(data){
                      $(".modal-check-signin-show").html(data);
                    });
                  });
                  $("#u_password").keypress(function(e) {
                      if(e.which==13){
                        $.post("<?php echo $LinkHostWeb;?>query/admin-query.php",
                        {
                            u_pass :$("#u_password").val(),
                            linkpath : "<?php echo $LinkPath;?>",
                            post :"check-signin"
                        },
                        function(data){
                          $(".modal-check-signin-show").html(data);
                        });
                      }
                  });
              });
            </script>

          </div>
          <div class="help-block text-center"> Please insert Password.</div>
          <div class="text-center">
            <a style="cursor:pointer;" class="signout_system">Or New Login</a>
            <script>
              $(document).ready(function() {
                $(".signout_system").click(function(e) {
                  $.post("<?php echo $LinkHostWeb;?>query/check-query.php", { post :"clear-system" }, function(d){  $(".modal-signout-show").html(d); });
                });
              });
            </script>
          </div>
          <div class="modal-signout-show  modal-check-signin-show" style="margin:10px 0;"> </div>

        </div>
  <?php }elseif( !empty($_SESSION[$SessionID]) && !empty($_COOKIE[$CookieID])   ){ ?>
    <div class="wrapper">

      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
        </ul>
        <!-- SEARCH FORM -->
        <form class="form-inline ml-3">
          <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-navbar" type="submit">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        </form>
      </nav>


      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="<?php echo $LinkHostWeb;?>" class="brand-link">
          <img src="<?php echo $LinkHostWeb;?>images/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light">Management</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img src="<?php echo $LinkHostWeb;?>images/avatar.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
              <a href="<?php echo $LinkWebadmin;?>profile" class="d-block">
                <?php
                  $SqlSelect = "SELECT user_showname
                                FROM tracking_user
                                WHERE ( user_id = '".base64url_decode($_COOKIE[$CookieID])."' )";
                  if (select_num($SqlSelect)>0) {
                    foreach (select_tb($SqlSelect) as $row) {
                      echo  $row['user_showname'];
                    }
                  }
                ?>
              </a>
            </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <li class="nav-header">MENU</li>
              <li class="nav-item">
                <a href="<?php echo $LinkWeb;?>" target="_blank" class="nav-link" style="color:#f00;">
                  <i class="nav-icon fas fa-external-link-alt"></i> <p>Go to Mainpage</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $LinkWebadmin;?>dashboard" class="nav-link <?php echo $UrlId=="dashboard"||$UrlId==""?"active":"";?>">
                  <i class="nav-icon fas fa-tachometer-alt"></i> <p>Dashboard</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $LinkWebadmin;?>view-tracking" class="nav-link <?php echo $UrlId=="view-tracking"?"active":"";?>">
                  <i class="nav-icon fas fa-comment"></i> <p>ข้อมูล Tracking</p>
                </a>
              </li>




              <li class="nav-header">System</li>
              <li class="nav-item has-treeview <?php echo $UrlId=="manage-user"||$UrlId=="manage-type-delivery"?"menu-open":"";?>">
                <a href="#" class="nav-link <?php echo $UrlId=="manage-user"||$UrlId=="manage-type-delivery"?"active":"";?>">
                  <i class="nav-icon fas fa-cogs"></i><p>Manage <i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?php echo $LinkWebadmin;?>manage-type-delivery" class="nav-link <?php echo $UrlId=="manage-type-delivery"?"active":"";?>">
                      <i class="nav-icon far fa-circle"></i> <p>ข้อมูลบริษัทขนส่ง</p>
                    </a>
                  </li>
                  <?php if (base64url_decode($_COOKIE[$CookieType])==1) {?>
                  <li class="nav-item">
                    <a href="<?php echo $LinkWebadmin;?>manage-user" class="nav-link <?php echo $UrlId=="manage-user"?"active":"";?>">
                      <i class="nav-icon far fa-circle"></i> <p>ผู้ใช้งานระบบ</p>
                    </a>
                  </li>
                 <?php } ?>
                </ul>
              </li>
              <li class="nav-item">
                <a style="cursor: pointer;" class="nav-link modal-signout" data-toggle="modal" data-target="#modal-signout">
                  <i class="nav-icon fas fa-lock"></i> <p>Lock Out</p>
                </a>
              </li>
            </ul>
          </nav>
        </div>
      </aside>




      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">
                  <?php
                    echo $UrlId!=""?ucwords(str_replace("-"," ",$UrlId)):"Dashboard";
                  ?>
                </h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <?php
                    $PathEx = $PathExplode;
                    for ($i=2; $i < count($PathEx); $i++) {
                      if ($PathEx[$i]!="") {
                        ////// แสดงต่อเมื่อ ไม่ใช่หน้า Dashboard
                        $var = "";
                        $varlast = "";
                        if ($i==2 && $PathEx[2]!="dashboard") {
                          $var = "dashboard";
                          $varlast = "dashboard";
                          ?>
                          <li class="breadcrumb-item"><a href="<?php echo $LinkHostWeb.$var;?>"><?php echo ucwords(str_replace("-"," ",$varlast));?></a></li>
                          <?php
                        }
                        ////// แสดงค่าปกติ
                        $var = "";
                        $varlast = "";
                        for ($a=1; $a <= ($i); $a++) {
                          if ($a==1) {
                            $var .= $PathEx[$a];
                            $varlast = $PathEx[$a];
                          }else {
                            $var .= "/".$PathEx[$a];
                            $varlast = $PathEx[$a];
                          }
                        }
                        ?>
                        <li class="breadcrumb-item <?php echo end($PathEx)==$PathEx[$i]?"active":"";?>"><?php echo end($PathEx)==$PathEx[$i]?ucwords(str_replace("-"," ",$varlast)):"<a href=".$LinkHostWeb.$var.">".ucwords(str_replace("-"," ",$varlast))."</a>";?></li>
                        <?php
                      }
                    }
                  ?>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <?php
            switch (trim($UrlId)) {

              /// All
              case 'profile'            	 :   include("view-profile.php");  			break;
              case 'dashboard'          	 :   include("view-dashboard.php"); 	 	break;
              case 'view-tracking'         :   include("view-tracking.php"); 	break;


              /// Manange
              case 'manage-user'           :   include("manage-user.php"); 	 		break;
              case 'manage-type-delivery'  :   include("manage-type-delivery.php"); break;

              default                    	 :  include("view-dashboard.php"); 			break;
            }
          ?>
        </section>
      </div>


      <footer class="main-footer hidden-xs">
        <strong><a href="<?php echo $LinkHostWeb;?>">v4skin.co.th</a> Management &copy; 2021</strong>
        <div class="float-right d-none d-sm-inline-block">
          <b>Version</b> 1.0.0
        </div>
      </footer>


      <div class="control-sidebar-bg"></div>
    </div>

    <!-- SignOut   -->
    <script>
      $(document).ready(function() {
        $(".modal-signout-confirm").click(function(e) {
          $.post("<?php echo $LinkHostWeb;?>query/admin-query.php", { post :"clear-system" }, function(d){  $("#show_logout").html(d); });
        });
      });
    </script>
    <div class="modal fade" id="modal-signout" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-body confirm-popup">
            <form>
              <div class="form-group">
                <div class="text-center" id="show_logout" style="padding:25px 0;">Are you Logout ?</div>
              </div>
            </form>
          </div>
          <div class="modal-footer" style="background-color: white; text-align: center;">
            <button type="button" style="width: 48%;float:left;margin: 0px;" class="btn btn-default" data-dismiss="modal" id="">Cancel</button>
            <button type="button" style="width: 48%;float:right;" class="btn btn-danger modal-signout-confirm" id="">Confirm</button>
          </div>
        </div>
      </div>
    </div>
    <!-- end  SignOut  -->

  <?php } ?>
  </body>
</html>
