<?php

if ($UrlIdSub=="edit") {

  if (isset($_POST['UpdatedConfirm'])) {

    //if (check_tracking_number(htmlentities($_POST['dTracking'])) == ) {
      $SqlUpdate = "UPDATE tracking_all
                      SET
                        tra_customer = '".htmlentities($_POST['dName'], ENT_QUOTES)."',
                        tra_email = '".htmlentities($_POST['dMail'], ENT_QUOTES)."',
                        tra_phone = '".htmlentities($_POST['dPhone'], ENT_QUOTES)."',
                        tra_tracking = '".htmlentities($_POST['dTracking'], ENT_QUOTES)."',
                        type_id = '".htmlentities($_POST['dType'])."',
                        tra_status = '".$_POST['dStatus']."',
                        user_id = '".base64url_decode($_SESSION[$SessionID])."'
                      WHERE ( tra_id = '".$UrlOther."' );";
      if (insert_tb($SqlUpdate)==true) {
        echo fSuccess(2,"บันทึกข้อมูล Tracking:".$_POST['dTracking']." สำเร็จ",$LinkWebadmin."view-tracking",2);
        log_insert("บันทึกข้อมูล Tracking:".$_POST['dTracking']." สำเร็จ",$_SESSION[$SessionID]);
      }else {
        echo fError(2,"บันทึกข้อมูลไม่สำเร็จ","","");
        log_insert("บันทึกข้อมูลไม่สำเร็จ",$_SESSION[$SessionID]);
      }
    //}else {
    //  echo fError(2,"มีเลข Tracking ซ้ำแล้ว ดูข้อมูล > <a target='_blank' href='".$LinkWebadmin."view-tracking/edit/".check_tracking_value(htmlentities($_POST['dTracking']))."'>คลิกดูข้อมูล</a> <","","");
    //}
  }

  $SqlSelect = "SELECT *
                FROM tracking_all
                WHERE ( tra_id = '".$UrlOther."');";
  if (select_num($SqlSelect)>0) {
    foreach (select_tb($SqlSelect) as $value) {
      ?>
      <div class="row">
        <div class="col-md-6 col-sm-12">
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">เปลี่ยนแปลงข้อมูล Tracking</h3>
            </div>
            <form role="form" class="" action="<?php echo $LinkPath;?>" method="post">
              <div class="card-body">
                <div class="form-group">
                  <label for="">ชื่อลูกค้า<font color="#f00">*</font></label>
                  <input type="hidden" name="dId" value="<?php echo $value['tra_id'];?>">
                  <input type="text" class="form-control" name="dName" value="<?php echo $value['tra_customer'];?>" placeholder="ตัวอย่าง เอมิกา พาใจ" required autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="">เบอร์ติดต่อ<font color="#f00">*</font></label>
                  <input type="text" class="form-control" name="dPhone" value="<?php echo $value['tra_phone'];?>" placeholder="ตัวอย่าง 0987654321" required autocomplete="off" max-maxlength="10" max="10">
                </div>
                <div class="form-group">
                  <label for="">อีเมล</label>
                  <input type="email" class="form-control" name="dMail" value="<?php echo $value['tra_email'];?>" placeholder="ตัวอย่าง v4skin_tracking@gmail.com" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="">เลขติดตามพัสดุ<font color="#f00">*</font></label>
                  <input type="text" class="form-control" name="dTracking" value="<?php echo $value['tra_tracking'];?>" placeholder="ตัวอย่าง JTE10102345" required autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="">สถานะ<font color="#f00">*</font></label>
                  <select class="form-control" name="dStatus" required>
                    <option value="0" <?php echo $value['tra_status']=='0'?"selected":"";?> >สถานะเปิด</option>
                    <option value="1" <?php echo $value['tra_status']=='1'?"selected":"";?> >สถานะปิด</option>
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
                        foreach (select_tb($SqlSelect) as $row) {
                          ?><option value="<?php echo $row['type_id'];?>" <?php echo $value['type_id']==$row['type_id']?"selected":"";?> ><?php echo $row['type_delivery'];?></option><?php
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
                <button type="submit" class="btn btn-info" name="UpdatedConfirm">เปลี่ยนแปลงข้อมูล</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <?php
    }
  }
}else {
  ?>
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="card">
        <div class="card-header p-2">
          <ul class="nav nav-pills">
            <li class="nav-item"><a class="nav-link active" href="#viewtracking" data-toggle="tab">ข้อมูลเลข Tracking</a></li>
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content">
            <div class="active tab-pane" id="viewtracking">
              <div class="col-12">

                <form class="" action="<?php echo $linkpath;?>" method="post">
                  <div class="input-group input-group-md">
                      <input type="search" class="form-control" name="value-search-full" value="<?php echo $_POST['value-search-full'];?>" placeholder="ค้นหาข้อมูล ชื่อ/เบอร์ติดต่อ/email" autocomplete="off">
                      <span class="input-group-append">
                        <button type="submit" class="btn btn-info btn-flat" name="btn-search-full">ค้นหา!</button>
                        <?php if (isset($_POST['value-search-full'])) {
                          ?><a href="<?php echo $linkpath;?>" class="btn btn-default btn-flat" >ยกเลิก</a><?php
                        } ?>
                      </span>
                  </div>
                </form>
                <span style="font-size:12px;color:#f00;">*ข้อมูล Tracking ที่เกินระยะ 15 วัน ระบบจะทำการปรับสถานะให้ไม่แสดงอัตโนมัติ (สำหรับลูกค้าค้นหาเท่านั้น)</span>
              </div>
              <div class="table-responsive">
                <table class="table table-hover table-striped">
                  <thead>
                    <tr>
                      <th>ลำดับ</th>
                      <th>ชื่อ นามสกุล</th>
                      <th>เบอร์โทรศัพท์</th>
                      <th>อีเมล</th>
                      <th>ขนส่ง</th>
                      <th class="text-right">เลข Tacking</th>
                      <th class="text-center">การค้นหา</th>
                      <th class="text-center">สถานะ</th>
                      <th class="text-center">วันที่ดำเนินการ</th>
                      <th class="text-center">จัดการ</th>
                    </tr>
                    <tbody>
                    <?php
                      $Where = "";
                      if (isset($_POST['btn-search-full'])) {
                        $Where = " WHERE (
                                            ta.tra_customer LIKE '%".$_POST['value-search-full']."%' OR
                                            ta.tra_phone LIKE '%".$_POST['value-search-full']."%' OR
                                            ta.tra_email LIKE '%".$_POST['value-search-full']."%' OR
                                            ta.tra_tracking LIKE '%".$_POST['value-search-full']."%'
                                          ) ";
                      }

                      $SqlSelect = "SELECT ta.*,tt.type_delivery
                                    FROM tracking_all ta
                                    INNER JOIN tracking_type tt ON (ta.type_id = tt.type_id)
                                    $Where ";

                      $SqlSelect .= " ORDER BY ta.tra_id DESC ";
                      if (select_num($SqlSelect)>0) { $i=1;
                        foreach (select_tb($SqlSelect) as $row) {
                          ?>
                            <tr>
                              <td><?php echo ($i++);?></td>
                              <td><?php echo $row['tra_customer'];?></td>
                              <td><?php echo $row['tra_phone'];?></td>
                              <td><?php echo $row['tra_email'];?></td>
                              <td><?php echo $row['type_delivery'];?></td>
                              <td class="text-right"><?php echo $row['tra_tracking'];?></td>
                              <td class="text-center"><?php echo $row['tra_search'];?></td>
                              <td class="text-center">
                                <?php
                                  if ($row['tra_status']=='1') {
                                    ?><i class="fas fa-toggle-off fa-2x" style="color:#d1d1d1;"></i><?php
                                  }else {
                                    ?><i class="fas fa-toggle-on fa-2x" style="color:#000;"></i><?php
                                  }
                                ?>
                              </td>
                              <td class="text-center"><?php echo day_format_month_thai($row['tra_updatedate']);?></td>
                              <td class="text-center">
                                <div class="btn-group btn-xs">
                                  <a href="<?php echo $LinkPath."/edit/".$row['tra_id'];?>" class="btn btn-sm btn-default modal-edit"><i class="fa fa-edit"></i></a>
                                  <button id="<?php echo $row['tra_id'];?>" data-toggle="modal" class="btn btn-sm btn-default modal-trash" data-target="#modal-trash"><i class="fa fa-trash"></i></button>
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
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Delete   -->
  <script>
    $(document).ready(function() {

      $(".modal-trash").click(function(e) {
        $(".modal-trash-confirm").attr("id",$(this).attr("id"));
      });

      $(".modal-trash-confirm").click(function(e) {

        $.post("<?php echo $LinkHostWeb;?>query/admin-query.php",
        {
           travlue :$(this).attr("id"),
           linkpath : "<?php echo $LinkPath;?>",
           post :"delete-tracking"
        },
        function(d){
          $("#ShowDeleteTracking").html(d);
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
              <div class="text-center" id="ShowDeleteTracking" style="padding:25px 0;">Are you Delete ?</div>
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
