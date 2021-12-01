<?php
if (base64url_decode($_COOKIE[$CookieType])==2) {
  ?><meta http-equiv="refresh" content="0;url=<?php echo $$LinkWebadmin;?>"><?php
}
if ($UrlIdSub=="edit") {
  if (isset($_POST['UpdatedConfirm'])) {
      if (htmlentities($_POST['Upassword'])==htmlentities($_POST['Upassword2'])) {
        $SqlInsert = "UPDATE tracking_user
                        SET
                          user_pass = '".md5(md5($_POST['Upassword2']))."',
                          user_type = '".$_POST['UPermiss']."',
                          user_showname = '".htmlentities($_POST['UNameShow'], ENT_QUOTES)."',
                          user_updatedate = now()
                        WHERE ( user_id = '".$UrlOther."' );";
        if (insert_tb($SqlInsert)==true) {
          echo fSuccess(2,"บันทึกข้อมูล User : ".$_POST['UNameShow']." สำเร็จ",$LinkWebadmin."manage-user",2);
          log_insert("บันทึกข้อมูล User : ".$_POST['UNameShow']." สำเร็จ",$_SESSION[$SessionID]);
        }else {
          echo fError(2,"บันทึกข้อมูลไม่สำเร็จ","","");
          log_insert("บันทึกข้อมูลไม่สำเร็จ",$_SESSION[$SessionID]);
        }// code...
     }else {
       echo fError(2,"รหัสผ่านไม่ตรงกัน","","");
     }
  }

  $SqlSelect = "SELECT *
                FROM tracking_user
                WHERE ( user_id = '".$UrlOther."');";
  if (select_num($SqlSelect)>0) {
    foreach (select_tb($SqlSelect) as $value) {
      ?>
      <div class="row">
        <div class="col-md-6 col-sm-12">
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">เปลี่ยนแปลงข้อมูล USer</h3>
            </div>
            <form  class="form-horizontal" action="<?php echo $LinkPath;?>" method="post">
              <div class="card-body">
                <div class="form-group row">
                  <label for="" class="col-sm-3 col-form-label">ชื่อผู้เข้าใช้งาน<font color="#f00">*</font></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="UNameShow" name="UNameShow" value="<?php echo $value['user_showname'];?>" placeholder="ตัวอย่าง เอมิกา พาใจ" required autocomplete="off">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-3 col-form-label">Username<font color="#f00">*</font></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="UUsername" name="UUsername" readonly value="<?php echo $value['user_name'];?>" placeholder="ตัวอย่าง Admin002" required autocomplete="off">
                    <span class="label idlabel" style="font-size:12px;color:#f00;"></span>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-3 col-form-label">รหัสผ่าน<font color="#f00">*</font></label>
                  <div class="col-sm-9">
                    <input type="password" class="form-control" id="Upassword" name="Upassword" placeholder="ตัวอย่าง 10102345" required autocomplete="off">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-3 col-form-label">ยืนยัน รหัสผ่าน<font color="#f00">*</font></label>
                  <div class="col-sm-9">
                    <input type="password" class="form-control" id="Upassword2" name="Upassword2" placeholder="ตัวอย่าง 10102345" required autocomplete="off">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-3 col-form-label">สิทธิ์การเข้าถึง<font color="#f00">*</font></label>
                  <div class="col-sm-9">
                    <select class="form-control" name="UPermiss" required>
                      <option value="">เลือกสิทธิ์</option>
                      <option value="1" <?php echo $value['user_type']=="1"?"selected":"";?>>เข้าถึงทั้งหมด</option>
                      <option value="2" <?php echo $value['user_type']=="2"?"selected":"";?>>เข้าถึงบางส่วน</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label" for="cjeck_confirm">ยืนยัน</label>
                  <div class="col-sm-9">
                    <input type="checkbox"  id="cjeck_confirm"  name="cjeck_confirm" required>
                  </div>
                </div>
              </div>
              <div class="form-group text-right col-12">
                <button type="submit" class="btn btn-primary" name="UpdatedConfirm" id="UpdatedConfirm">เปลี่ยนแปลงข้อมูล</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <?php
    }
  }
}else {
  if (isset($_POST['SubmitConfirm'])) {
      if (htmlentities($_POST['Upassword']) == htmlentities($_POST['Upassword2'])) {
        $SqlInsert = "INSERT INTO tracking_user
                        VALUES(0,
                          '".htmlentities($_POST['UUsername'])."',
                          '".md5(md5($_POST['Upassword']))."',
                          '".$_POST['UPermiss']."',
                          now(),
                          '".htmlentities($_POST['UNameShow'])."');";
        if (insert_tb($SqlInsert)==true) {
          echo fSuccess(2,"เพิ่มข้อมูลผู้ใช้งานสำเร็จ",$LinkPath,2);
          log_insert("เพิ่มข้อมูลผู้ใช้งานสำเร็จ",$_SESSION[$SessionID]);
        }else {
          echo fError(2,"เพิ่มข้อมูลผู้ใช้งานไม่สำเร็จ","","");
          log_insert("เพิ่มข้อมูลผู้ใช้งานไม่สำเร็จ",$_SESSION[$SessionID]);
        }
    }else {
      echo fError(2,"รหัสผ่าน ไม่ตรงกัน","","");
    }
  }
  ?>
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
      <div class="card">
        <div class="card-header p-2">
          <ul class="nav nav-pills">
            <li class="nav-item"><a class="nav-link active" href="#viewuser" data-toggle="tab">ข้อมูลผู้ใช้งาน</a></li>
            <li class="nav-item"><a class="nav-link" href="#newuser" data-toggle="tab">เพิ่มข้อมูลผู้ใช้งาน</a></li>
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content">
            <div class="active tab-pane" id="viewuser">
              <div class="table-responsive">
                <table class="table table-hover table-striped">
                  <thead>
                    <tr>
                      <th>ลำดับ</th>
                      <th>ชื่อแสดง</th>
                      <th>Username</th>
                      <th>สิทธิ์การจัดการ ผู้ใช้งาน</th>
                      <th class="text-center">จัดการ</th>
                    </tr>
                    <tbody>
                    <?php
                      $SqlSelect = "SELECT *
                                    FROM tracking_user
                                    ORDER BY user_id ASC";
                      if (select_num($SqlSelect)>0) { $i=1;
                        foreach (select_tb($SqlSelect) as $row) {
                          ?>
                            <tr>
                              <td><?php echo ($i++);?></td>
                              <td><?php echo $row['user_showname'];?></td>
                              <td><?php echo $row['user_name'];?></td>
                              <td class="text-center">
                                <?php
                                  if ($row['user_type']=='1') {
                                    ?>เข้าถึงผู้ใช้งาน<?php
                                  }else {
                                    ?>ทั่วไป<?php
                                  }
                                ?>
                              </td>
                              <td class="text-center">
                                <div class="btn-group btn-xs">
                                  <a href="<?php echo $linkpath."/edit/".$row['user_id'];?>"  class="btn btn-sm btn-default modal-edit"><i class="fa fa-edit"></i></a>
                                  <button id="<?php echo $row['user_id'];?>" data-toggle="modal" class="btn btn-sm btn-default modal-trash <?php echo check_user_in_tracking($row['user_id'])==false?"disabled":"";?>" <?php echo check_user_in_tracking($row['user_id'])==false?"disabled":"";?> data-target="#modal-trash"><i class="fa fa-trash"></i></button>
                                </div>
                              </td>
                            </tr>
                          <?php
                        }
                      }
                      ?>
                    </tbody>
                  </thead>
                </table>
              </div>
            </div>
            <div class="tab-pane" id="newuser">
              <div class="row">
                <div class="col-12">

                  <form  class="form-horizontal" action="<?php echo $LinkPath;?>" method="post">
                    <div class="card-body">
                      <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">ชื่อผู้เข้าใช้งาน<font color="#f00">*</font></label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="UNameShow" name="UNameShow" value="<?php echo $_POST['UNameShow'];?>" placeholder="ตัวอย่าง เอมิกา พาใจ" required autocomplete="off">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Username<font color="#f00">*</font></label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="UUsername" name="UUsername" value="<?php echo $_POST['UUsername'];?>" placeholder="ตัวอย่าง Admin002" required autocomplete="off">
                          <span class="label idlabel" style="font-size:12px;color:#f00;"></span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">รหัสผ่าน<font color="#f00">*</font></label>
                        <div class="col-sm-9">
                          <input type="password" class="form-control" id="Upassword" name="Upassword" placeholder="ตัวอย่าง JTE10102345" required autocomplete="off">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">ยืนยัน รหัสผ่าน<font color="#f00">*</font></label>
                        <div class="col-sm-9">
                          <input type="password" class="form-control" id="Upassword2" name="Upassword2" placeholder="ตัวอย่าง JTE10102345" required autocomplete="off">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">สิทธิ์การเข้าถึง<font color="#f00">*</font></label>
                        <div class="col-sm-9">
                          <select class="form-control" name="UPermiss" required>
                            <option value="">เลือกสิทธิ์</option>
                            <option value="1">เข้าถึงทั้งหมด</option>
                            <option value="2">เข้าถึงบางส่วน</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="cjeck_confirm">ยืนยัน</label>
                        <div class="col-sm-9">
                          <input type="checkbox"  id="cjeck_confirm"  name="cjeck_confirm" required>
                        </div>
                      </div>
                    </div>
                    <div class="text-right">
                      <button type="submit" class="btn btn-primary" name="SubmitConfirm" id="SubmitConfirm">บันทึกข้อมูล</button>
                    </div>
                  </form>

                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    $(document).ready(function(e) {
      $("#UUsername").keyup(function(e) {
          $.post("<?php echo $LinkWeb;?>query/admin-query.php",
          {
              truser :$(this).val(),
              post :"CheckKeyPress-User"
          },
          function(data){
            console.log(data);
            if (data=='1') {
              $(".idlabel").html("มี Username นี้แล้ว");
              $("#SubmitConfirm").attr("disabled","disabled");
              $("#SubmitConfirm").addClass("disabled");
            }else {
              $(".idlabel").html("");
              $("#SubmitConfirm").removeAttr("disabled","disabled");
              $("#SubmitConfirm").removeClass("disabled","disabled");
            }

          });
      });
    });
  </script>

  <!-- Delete   -->
  <script>
    $(document).ready(function() {

      $(".modal-trash").click(function(e) {
        $(".modal-trash-confirm").attr("id",$(this).attr("id"));
      });

      $(".modal-trash-confirm").click(function(e) {

        $.post("<?php echo $LinkHostWeb;?>query/admin-query.php",
        {
           trauser :$(this).attr("id"),
           linkpath : "<?php echo $LinkPath;?>",
           post :"delete-user"
        },
        function(d){
          $("#ShowDeleteUser").html(d);
        });
      });
    });
  </script>
  <div class="modal fade" id="modal-trash" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-body confirm-popup">
          <form>
            <div class="form-group">
              <div class="text-center" id="ShowDeleteUser" style="padding:25px 0;">Are you Delete ?</div>
            </div>
          </form>
        </div>
        <div class="modal-footer" style="background-color: white; text-align: center;">
          <button type="button" style="width: 48%;float:left;margin: 0px;" class="btn btn-default" data-dismiss="modal" id="">Cancel</button>
          <button type="button" style="width: 48%;float:right;" class="btn btn-danger modal-trash-confirm" id="">Confirm</button>
        </div>
      </div>
    </div>
  </div>
  <!-- end  Delete  -->


  <?php
}
?>
