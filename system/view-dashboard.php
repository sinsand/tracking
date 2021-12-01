<?php
if (isset($_POST['SubmitdConfirm'])) {
  if (check_tracking(htmlentities($_POST['dName']))===true) {
    $Dmail = "NULL";
    if (!empty($_POST['dMail'])) {
      $Dmail = htmlentities($_POST['dMail']);
    }
    $SqlInsert = "INSERT INTO tracking_all
                    VALUES(0,
                      '".htmlentities($_POST['dName'])."',
                      '".htmlentities($_POST['dPhone'])."',
                      '".$Dmail."',
                      '".htmlentities($_POST['dTracking'])."',
                      '".$_POST['dType']."',
                      '".base64url_decode($_SESSION[$SessionID])."',
                      now(),'0',
                      '".$_POST['dStatus']."'
                    );";
    if (insert_tb($SqlInsert)==true) {
      echo fSuccess(2,"เพิ่มข้อมูลสำเร็จ",$LinkPath,2);
      log_insert("เพิ่มข้อมูลสำเร็จ",$_SESSION[$SessionID]);
    }else {
      echo fError(2,"เพิ่มข้อมูลไม่สำเร็จ","","");
      log_insert("เพิ่มข้อมูลไม่สำเร็จ",$_SESSION[$SessionID]);
    }
  }else {
    echo fError(2,"มีเลข Tracking ซ้ำแล้ว","","");
  }
}
?>
<div class="row">
  <div class="col-md-6 col-sm-12">
    <div class="card card-default">
      <div class="card-header">
        <h3 class="card-title">เพิ่มข้อมูล Tracking</h3>
      </div>
      <form role="form" class="" action="<?php echo $LinkPath;?>" method="post">
        <div class="card-body">
          <div class="form-group">
            <label for="">ชื่อลูกค้า<font color="#f00">*</font></label>
            <input type="text" class="form-control" name="dName" value="<?php echo $_POST['dName'];?>" placeholder="ตัวอย่าง เอมิกา พาใจ" required autocomplete="off">
          </div>
          <div class="form-group">
            <label for="">เบอร์ติดต่อ<font color="#f00">*</font></label>
            <input type="text" class="form-control" name="dPhone" value="<?php echo $_POST['dPhone'];?>" placeholder="ตัวอย่าง 0987654321" required autocomplete="off" max-maxlength="10" max="10">
          </div>
          <div class="form-group">
            <label for="">อีเมล</label>
            <input type="text" class="form-control" name="dMail" value="<?php echo $_POST['dMail'];?>" placeholder="ตัวอย่าง v4skin_tracking@gmail.com" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="">เลขติดตามพัสดุ<font color="#f00">*</font></label>
            <input type="text" class="form-control" id="CheckValueTracking" value="<?php echo $_POST['dTracking'];?>" name="dTracking" placeholder="ตัวอย่าง JTE10102345" required autocomplete="off">
            <span class="label idlabel" style="font-size:12px;color:#f00;"></span>
          </div>
          <div class="form-group">
            <label for="">สถานะ<font color="#f00">*</font></label>
            <select class="form-control" name="dStatus" required>
              <option value="0">สถานะเปิด</option>
              <option value="1">สถานะปิด</option>
            </select>
          </div>
          <div class="form-group">
            <label for="">ประเภทการขนส่ง<font color="#f00">*</font></label>
            <select class="form-control" name="dType" required>
              <option value="">เลือกประเภท</option>
              <?php
                $SqlSelect = "SELECT type_id,type_delivery
                              FROM tracking_type
                              ORDER BY type_delivery;";
                if (select_num($SqlSelect)>0) {
                  foreach (select_tb($SqlSelect) as $value) {
                    ?><option value="<?php echo $value['type_id'];?>"><?php echo $value['type_delivery'];?></option><?php
                  }
                }
              ?>
            </select>
          </div>
          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="dConfirm" name"dConfirm" required>
            <label class="form-check-label" for="dConfirm">ยืนยันข้อมูล</label>
          </div>
        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-info" name="SubmitdConfirm">บันทึกข้อมูล</button>
        </div>
      </form>
    </div>
  </div>
  <div class="col-md-6 col-sm-12">
    <div class="row">
      <div class="col-sm-12 col-md-6">
        <div class="info-box">
          <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-user-md"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Tracking ทั้งหมด</span>
            <span class="info-box-number">
              <?php
                $SqlSelect = "SELECT tra_id
                              FROM tracking_all ;";
                echo select_num($SqlSelect);
              ?>
            </span>
          </div>
        </div>
      </div>
      <div class="col-sm-12 col-md-6">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-success elevation-1"><i class="fas fa-user-md"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">การค้นหา (ครั้ง)</span>
            <span class="info-box-number">
              <?php
                $SqlSelect = "SELECT SUM(tra_search) as tra_search
                              FROM tracking_all
                              WHERE tra_search > '0';";
                if (select_num($SqlSelect)>0) {
                  foreach (select_tb($SqlSelect) as $value) {
                    echo $value['tra_search'];
                  }
                }else {
                  echo '0';
                }
              ?>
            </span>
          </div>
        </div>
      </div>
      <div class="clearfix hidden-md-up"></div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="input-group input-group-md">
              <input type="search" class="form-control" id="value-search" placeholder="ค้นหาข้อมูล ชื่อ/เบอร์ติดต่อ/email" autocomplete="off">
              <span class="input-group-append">
                <button type="button" class="btn btn-info btn-flat" id="btn-search-quick">ค้นหาด่วน!</button>
              </span>
            </div>
            <div class="col-12" id="ShowTracking">

            </div>
          </div>
        </div>
      </div>
      <script type="text/javascript">
        $(document).ready(function(e) {
          $("#value-search").keypress(function(e) {
              if(e.which==13){
                if ($("#value-search").val()!="") {
                  $.post("<?php echo $LinkWeb;?>query/admin-query.php",
                  {
                      trvalue  :$("#value-search").val(),
                      post :"CheckTracking"
                  },
                  function(data){
                    $("#ShowTracking").html(data);
                  });
                }
              }
          });
          $("#btn-search-quick").click(function(e) {
              if ($("#value-search").val()!="") {
                $.post("<?php echo $LinkWeb;?>query/admin-query.php",
                {
                    trvalue  :$("#value-search").val(),
                    post :"CheckTracking"
                },
                function(data){
                  $("#ShowTracking").html(data);
                });
              }
          });
        });
      </script>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(e) {
    $("#CheckValueTracking").keyup(function(e) {
        $("#ViewTrackingMain").html("กำลังโหลดข้อมูล... <i class='fa fa-spinner faa-spin animated'></i>");
        setTimeout(function(){
          $.post("<?php echo $LinkWeb;?>query/admin-query.php",
          {
              trvalue :$(this).val(),
              post :"CheckKeyPress"
          },
          function(data){
            $(".idlabel").html(data);
          });
        },2000);
    });
  });
</script>
