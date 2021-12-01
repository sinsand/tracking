<?php
if ($UrlIdSub=="edit") {
  if (isset($_POST['UpdateDConfirm'])) {
      $Set = "";
      if ($_FILES["NPhoto"]["tmp_name"]!="") {
        //*** Read file BINARY *** upload replace
        $fp = fopen($_FILES["NPhoto"]["tmp_name"],"r");
        $ReadBinary = fread($fp,filesize($_FILES["NPhoto"]["tmp_name"]));
        fclose($fp);
        $FileData = addslashes($ReadBinary);
        $Set = " , type_icon = '".$FileData."' ";
      }

      $SqlUpdate = "UPDATE tracking_type
                      SET
                        type_delivery = '".htmlentities($_POST['NDelivery'], ENT_QUOTES)."',
                        type_link = '".htmlentities($_POST['NLink'], ENT_QUOTES)."',
                        type_updatedate = now()
                        ".$Set."
                      WHERE ( type_id = '".$UrlOther."' );";
      if (insert_tb($SqlUpdate)==true) {
        echo fSuccess(2,"บันทึกข้อมูลบริษัทขนส่ง : ".$_POST['NDelivery']." สำเร็จ",$LinkWebadmin."manage-type-delivery",2);
        log_insert("บันทึกข้อมูลบริษัทขนส่ง : ".$_POST['NDelivery']." สำเร็จ",$_SESSION[$SessionID]);
      }else {
        echo fError(2,"บันทึกข้อมูลไม่สำเร็จ","","");
        log_insert("บันทึกข้อมูลไม่สำเร็จ",$_SESSION[$SessionID]);
      }
  }

  $SqlSelect = "SELECT *
                FROM tracking_type
                WHERE ( type_id = '".$UrlOther."')";
  if (select_num($SqlSelect)>0) {
    foreach (select_tb($SqlSelect) as $value) {
      ?>
      <div class="row">
        <div class="col-md-6 col-sm-12">
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">เปลี่ยนแปลงข้อมูลบริษัทขนส่ง</h3>
            </div>
            <form  class="form-horizontal" action="<?php echo $LinkPath;?>" method="post" enctype="multipart/form-data">
              <div class="card-body">
                <div class="form-group row">
                  <label for="" class="col-sm-3 col-form-label">ชื่อขนส่ง<font color="#f00">*</font></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="NDelivery" name="NDelivery" value="<?php echo $value['type_delivery'];?>"  placeholder="ตัวอย่าง Kerry Express" required autocomplete="off">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="NPhoto" class="col-sm-3 ">รูปไอคอน</label>
                  <div class="col-sm-9">
                    <img src="<?php echo $LinkWeb."query/view-image-type.php?view=".$value['type_id'];?>" style="width:auto;height:30px;" alt="">
                  </div>
                </div>


                <div class="form-group row">
                  <label for="NPhoto" class="col-sm-3 ">รูปไอคอน ใหม่</label>
                  <div class="input-group col-sm-9">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="NPhoto" name="NPhoto">
                      <label class="custom-file-label" for="NPhoto">เลือกไฟล์</label>
                    </div>
                  </div>
                  <span class="col-sm-3"></span>
                  <span class="label idlabel col-sm-9" style="font-size:12px;color:#878585;">แนะนำ ขนาดรูปความสูงไม่เกิน 50px (.png หรือ .jpg)</span>
                </div>
                <div class="form-group row">
                  <label for="" class="col-sm-3 col-form-label">ลิ้งค์<font color="#f00">*</font></label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="NLink" name="NLink" value="<?php echo $value['type_link'];?>" placeholder="ตัวอย่าง https://www.jtexpress.co.th/index/query/gzquery.html" required autocomplete="off">
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
                <button type="submit" class="btn btn-primary" name="UpdateDConfirm">บันทึกข้อมูล</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <?php
    }
  }


}else {
  if (isset($_POST['SubmitDConfirm'])) {
      //*** Read file BINARY *** upload replace
      $fp = fopen($_FILES["NPhoto"]["tmp_name"],"r");
      $ReadBinary = fread($fp,filesize($_FILES["NPhoto"]["tmp_name"]));
      fclose($fp);
      $FileData = addslashes($ReadBinary);
      $SqlInsert = "INSERT INTO tracking_type
                      VALUES(0,
                        '".htmlentities($_POST['NDelivery'], ENT_QUOTES)."',
                        '".$FileData."',
                        '".htmlentities($_POST['NLink'], ENT_QUOTES)."',
                        now())";
      if (insert_tb($SqlInsert)==true) {
        echo fSuccess(2,"เพิ่มข้อมูลบริษัทขนส่งสำเร็จ",$LinkPath,2);
        log_insert("เพิ่มข้อมูลบริษัทขนส่งสำเร็จ",$_SESSION[$SessionID]);
      }else {
        echo fError(2,"เพิ่มข้อมูลบริษัทขนส่งไม่สำเร็จ","","");
        log_insert("เพิ่มข้อมูลบริษัทขนส่งไม่สำเร็จ",$_SESSION[$SessionID]);
      }
  }
  ?>
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
      <div class="card">
        <div class="card-header p-2">
          <ul class="nav nav-pills">
            <li class="nav-item"><a class="nav-link active" href="#viewtype" data-toggle="tab">ข้อมูลบริษัทขนส่ง</a></li>
            <li class="nav-item"><a class="nav-link" href="#newtype" data-toggle="tab">เพิ่มข้อมูลบริษัทขนส่ง</a></li>
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content">
            <div class="active tab-pane" id="viewtype">
              <div class="table-responsive">
                <table class="table table-hover table-striped">
                  <thead>
                    <tr>
                      <th>ลำดับ</th>
                      <th>รายการ</th>
                      <th class="text-center">รูป</th>
                      <th>Link</th>
                      <th>วันที่ดำเนินการ</th>
                      <th class="text-center">จัดการ</th>
                    </tr>
                    <tbody>
                    <?php
                      $SqlSelect = "SELECT *
                                    FROM tracking_type
                                    ORDER BY type_id ASC";
                      if (select_num($SqlSelect)>0) { $i=1;
                        foreach (select_tb($SqlSelect) as $row) {
                          ?>
                            <tr>
                              <td><?php echo ($i++);?></td>
                              <td><?php echo $row['type_delivery'];?></td>
                              <td class="text-center"><img src="<?php echo $LinkWeb."query/view-image-type.php?view=".$row['type_id'];?>" style="height:30px;width:auto;" /></td>
                              <td><a href="<?php echo $row['type_link'];?>" target="_blank">คลิกดูลิ้งค์</a></td>
                              <td><?php echo $row['type_updatedate'];?></td>
                              <td class="text-center">
                                <div class="btn-group btn-xs">
                                  <a href="<?php echo $LinkPath."/edit/".$row['type_id'];?>" class="btn btn-sm btn-default modal-edit"><i class="fa fa-edit"></i></a>
                                  <button id="<?php echo $row['type_id'];?>" data-toggle="modal" class="btn btn-sm btn-default modal-trash <?php echo check_type_in_tracking($row['type_id'])==false?"disabled":"";?>" data-target="#modal-trash" <?php echo check_type_in_tracking($row['type_id'])==false?"disabled":"";?>><i class="fa fa-trash"></i></button>
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
            <div class="tab-pane" id="newtype">
              <div class="row">
                <div class="col-sm-12">

                    <form  class="form-horizontal" action="<?php echo $LinkPath;?>" method="post" enctype="multipart/form-data">
                      <div class="card-body">
                        <div class="form-group row">
                          <label for="" class="col-sm-3 col-form-label">ชื่อขนส่ง<font color="#f00">*</font></label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="NDelivery" name="NDelivery"  placeholder="ตัวอย่าง Kerry Express" required autocomplete="off">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="NPhoto" class="col-sm-3 ">รูปไอคอน<font color="#f00">*</font></label>
                          <div class="input-group col-sm-9">
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="NPhoto" name="NPhoto">
                              <label class="custom-file-label" for="NPhoto">เลือกไฟล์</label>
                            </div>
                          </div>
                          <span class="col-sm-3"></span>
                          <span class="label idlabel col-sm-9" style="font-size:12px;color:#878585;">แนะนำ ขนาดรูปความสูงไม่เกิน 50px (.png หรือ .jpg)</span>
                        </div>
                        <div class="form-group row">
                          <label for="" class="col-sm-3 col-form-label">ลิ้งค์<font color="#f00">*</font></label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="NLink" name="NLink"  placeholder="ตัวอย่าง https://www.jtexpress.co.th/index/query/gzquery.html" required autocomplete="off">
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
                        <button type="submit" class="btn btn-primary" name="SubmitDConfirm">บันทึกข้อมูล</button>
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
    $(document).ready(function () {
      bsCustomFileInput.init();
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
           tratype :$(this).attr("id"),
           linkpath : "<?php echo $LinkPath;?>",
           post :"delete-type-delivery"
        },
        function(d){
          $("#ShowDeleteType").html(d);
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
              <div class="text-center" id="ShowDeleteType" style="padding:25px 0;">Are you Delete ?</div>
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
