<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>v4skin Tracking</title>
    <meta name="robots" content="nofollow, index, max-snippet:-1, max-video-preview:-1, max-image-preview:large"/>
    <link rel="canonical" href="<?php echo $LinkWeb;?>" />
    <meta property="og:locale" content="th_TH" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Tracking Order - v4skin Sole Beauty Distributor" />
    <link rel="icon" href="https://www.v4skin.co.th/wp-content/uploads/2021/05/cropped-icon-32x32.png" sizes="32x32" />
    <link rel="icon" href="https://www.v4skin.co.th/wp-content/uploads/2021/05/cropped-icon-192x192.png" sizes="192x192" />
    <link rel="apple-touch-icon" href="https://www.v4skin.co.th/wp-content/uploads/2021/05/cropped-icon-180x180.png" />
    <meta name="msapplication-TileImage" content="https://www.v4skin.co.th/wp-content/uploads/2021/05/cropped-icon-270x270.png" />
    <meta name=“keywords” content="tracking v4skin,เลขติดตามพัสดุ,tracking" />
    <meta name="description" content="ติดตามหมายเลขพัสดุ V4SKIN เป็นบริษัทนำเข้าผลิตภัณฑ์ Dermastir ที่ดูแลผิวหน้าและร่างกายอย่างครบวงจร เราสรรหาผลิตภัณฑ์เพื่อดูแลผิวหน้า และร่างกายจากทั่วโลก เพื่อให้ทุกคนได้ใช้ผลิตภัณฑ์ที่มีคุณภาพ"/>
    <!--<link rel="stylesheet" href="<?php echo $LinkHostWeb;?>plugins/bootstrap/dist/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="<?php echo $LinkHostWeb;?>plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo $LinkHostWeb;?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="<?php echo $LinkHostWeb;?>plugins/adminLTE/css/AdminLTE.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Kanit&family=Open+Sans&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome-animation@1.1.1/css/font-awesome-animation.css">
    <style>
      body{
        padding: 0px;
        margin: 0px;
        background: #f4f6f9;
        background: url('https://tracking.v4skin.co.th/images/subtle-prism.svg');
      }
    </style>
  </head>
  <body>
    <div class="row" style="margin:0px;border-bottom: 1px solid #e1e1e1;">
      <div class="col-12 text-center" style="background:#fff;">
        <img src="https://www.v4skin.co.th/wp-content/uploads/2021/08/logo-font-Final03.jpeg" style="width:90px;height:auto;" />
      </div>
    </div>

    <div class="row" style="margin:0px;">
      <div class="container">
        <div class="col-xs-12 col-sm-8 offset-sm-2">

          <div class="card card-default" style="margin-top:10%;">
              <div class="card-header text-center" style="border-bottom:0px;">
                <h1 style="font-family: 'Kanit';">ตรวจสอบหมายเลขพัสดุ</h1>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <input type="search" class="form-control text-center" id="CheckTrackingMain" placeholder="กรุณา ระบุชื่อ/เบอร์โทรศัพท์/email" autocomplete="off">
                    </div>
                    <div class="form-group text-center">
                      <button type="button" class="btn btn-info btn-md" id="ClickCheckTrackingMain">ค้นหาข้อมูล</button>
                    </div>
                    <div class="row" style="margin:0px;">
                      <div class="col-12 text-center" id="ViewTrackingMain">

                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer text-center" style="font-size: 14px;color: #999797;">
                หากไม่พบข้อมูล ติดต่อ <a href="https://m.me/v4skin/">คลิก</a>
              </div>
          </div>

          <div class="row" style="margin:0px;">
            <div class="col-12" style="font-family: 'Kanit';font-size:13px;">
              <h4 style="font-family: 'Kanit';font-size:15px;">ตัวอย่าง</h4>
              <p style="margin-bottom:0px;">- กรุณาระบุชื่อและนามสกุล <b>ตัวอย่าง:</b> เอมใจ มากา</p>
              <p style="margin-bottom:0px;">- กรุณาระบุเบอร์โทรศัพท์ 10 หลัก <b>ตัวอย่าง:</b> 0812345678</p>
              <p style="margin-bottom:0px;">- กรุณาระบุ Email <b>ตัวอย่าง:</b> v4skin_tracking@gmail.com</p>
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="wrapper" style="display:none;">
      <section class="content">
        <div class="error-page">
          <h2 class="headline text-success"><i class="fas fa-search text-success"></i></h2>
          <div class="error-content">
            <h3>ตรวจสอบหมายเลขพัสดุ</h3>
            <p>หากไม่พบข้อมูล กรุณาติดต่อคลิก <a href="https://m.me/v4skin/" target="_blank">ที่นี่</a><br>
              <span style="font-size:14px;color: #939393;">ตัวอย่างชื่อ เอมิกา มาใจลา ,ตัวอย่างเบอร์ 0987654321 ,ตัวอย่างเมล v4@gmail.com</span>
            </p>
            <form class="search-form" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
              <div class="input-group">
                <input type="text" name="search" value="<?php echo $_POST['search'];?>" class="form-control" placeholder="กรุณา ระบุชื่อ/เบอร์โทรศัพท์/email" autocomplete="off">
                <div class="input-group-append">
                  <button type="submit" name="submit" class="btn btn-info"><i class="fas fa-search"></i> ค้นหาข้อมูล
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </section>
    </div>


    <script src="<?php echo $LinkHostWeb;?>plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo $LinkHostWeb;?>plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="<?php echo $LinkHostWeb;?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
          $("#CheckTrackingMain").focus();

          $("#CheckTrackingMain").keypress(function(e) {
              if(e.which==13){
                if ($(this).val()!="") {
                  $("#ViewTrackingMain").html("กำลังโหลดข้อมูล... <i class='fa fa-spinner faa-spin animated'></i>");
                  setTimeout(function(){
                    $.post("<?php echo $LinkWeb;?>query/admin-query.php",
                    {
                        trvalue  :$(this).val(),
                        post :"CheckTrackingMain"
                    },
                    function(data){
                      $("#ViewTrackingMain").html(data);
                    });
                  },1000);
                }
              }
          });
          $("#ClickCheckTrackingMain").click(function(e) {
              if ($("#CheckTrackingMain").val()!="") {
                $("#ViewTrackingMain").html("กำลังโหลดข้อมูล... <i class='fa fa-spinner faa-spin animated'></i>");
                setTimeout(function(){
                  $.post("<?php echo $LinkWeb;?>query/admin-query.php",
                  {
                      trvalue  :$("#CheckTrackingMain").val(),
                      post :"CheckTrackingMain"
                  },
                  function(data){
                    $("#ViewTrackingMain").html(data);
                  });
                },2000);
              }
          });

      });
    </script>
  </body>
</html>
