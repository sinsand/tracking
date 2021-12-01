<?php
include("../config/config.php");
///// Logout
if ($_POST['post']=="clear-system") {

  log_insert("ออกจากระบบสำเร็จ",$_SESSION[$SessionID]);
  setcookie($CookieID, null, time()-3600,'/');
  setcookie($CookieAdminID, null, time()-3600,'/');
  setcookie($CookieType, null, time()-3600,'/');
  unset($_COOKIE[$CookieID]);
  unset($_COOKIE[$CookieAdminID]);
  unset($_COOKIE[$CookieType]);

  unset($_SESSION[$SessionID]);
  unset($_SESSION[$SessionAdminID]);
  unset($_SESSION[$SessionType]);

  session_unset();
  session_destroy();
  echo fSuccess(4,"ออกจากระบบสำเร็จ",$_POST["linkpath"],2);
}
//// login
if ($_POST['post']=="sign-in") {
  $SqlSelect = "SELECT user_id,user_type
                FROM tracking_user
                WHERE (
                        user_name = '".$_POST['u_name']."' AND
                        user_pass = '".md5(md5($_POST['u_pass']))."'
                      )";
  if (select_num($SqlSelect)>0) {
    foreach (select_tb($SqlSelect) as $row) {
      setcookie($CookieID, base64url_encode($row['user_id']), time()+86400, "/"); // 86400 = 1 day
      setcookie($CookieType, base64url_encode($row['user_type']),  time()+86400, "/"); // 86400 = 1 day
      $_SESSION[$SessionID] = base64url_encode($row['user_id']);
      $_SESSION[$SessionType] = base64url_encode($row['user_type']);
      echo fSuccess(5,"ล็อกอินสำเร็จ",$_POST['linkpath'],2);
    }
  }else {
    echo fError(5,"ข้อมูลไม่ถูกต้อง","");
    //echo $SqlSelect;
  }
}
/// Check signin
if ($_POST['post']=="check-signin") {
  $SqlSelect = "SELECT user_id,user_type
                FROM tracking_user
                WHERE (
                        user_pass = '".md5(md5($_POST['u_pass']))."'
                      )";
  if (select_num($SqlSelect)>0) {
    foreach (select_tb($SqlSelect) as $row) {
      setcookie($CookieID, base64url_encode($row['user_id']), time()+86400, "/"); // 86400 = 1 day
      setcookie($CookieType, base64url_encode($row['user_type']),  time()+86400, "/"); // 86400 = 1 day
      $_SESSION[$SessionID] = base64url_encode($row['user_id']);
      $_SESSION[$SessionType] = base64url_encode($row['user_type']);
      echo fSuccess(5,"เข้าใช้งานสำเร็จ",$_POST['linkpath'],2);
      log_insert("เข้าสู่ระบบผ่าน Cookie สำเร็จ",base64url_encode($row['user_id']));
    }
  }else {
    echo fError(5,"รหัสผ่านไม่ถูกต้อง","กรุณากรอกข้อมูลให้ถูกต้อง ","");
    log_insert("เข้าสู่ระบบผ่าน Cookie ไม่สำเร็จ",$_COOKIE[$CookieID]);
  }
}
/// Search Tracking Dashboard
if ($_POST['post']=="CheckTracking") {
  $SqlSelect = "SELECT ta.*,tt.type_delivery,tt.type_link
                FROM tracking_all ta
                INNER JOIN tracking_type tt ON (ta.type_id = tt.type_id)
                WHERE (
                        ta.tra_customer LIKE '%".htmlentities($_POST['trvalue'], ENT_QUOTES)."%' OR
                        ta.tra_phone LIKE '%".htmlentities($_POST['trvalue'], ENT_QUOTES)."%' OR
                        ta.tra_email LIKE '%".htmlentities($_POST['trvalue'], ENT_QUOTES)."%' OR
                        ta.tra_tracking LIKE '%".htmlentities($_POST['trvalue'], ENT_QUOTES)."%'
                      ) ;";
  if (select_num($SqlSelect)>0) { $i =1;
    foreach (select_tb($SqlSelect) as $row) {
      $SqlUpdate = "UPDATE tracking_all SET tra_search = tra_search+1 WHERE (tra_id = '".$row['tra_id']."') ";
      update_tb($SqlUpdate);
      ?>
        <div class="col-xs-12" style="padding: 15px 0;">
          <form class="form-horizontal">
            <div class="form-group row" style="margin-bottom:0px;">
              <div class="col-3 col-form-label"><b>ชื่อ :</b></div>
              <div class="col-9 col-form-label"><?php echo $row['tra_customer'];?></div>
            </div>
            <div class="form-group row" style="margin-bottom:0px;">
              <div class="col-3 col-form-label"><b>เบอร์ติดต่อ :</b></div>
              <div class="col-9 col-form-label"><?php echo $row['tra_phone'];?></div>
            </div>
            <div class="form-group row" style="margin-bottom:0px;">
              <div class="col-3 col-form-label"><b>Email :</b></div>
              <div class="col-9 col-form-label"><?php echo $row['tra_email'];?></div>
            </div>
            <div class="form-group row" style="margin-bottom:0px;">
              <div class="col-3 col-form-label"><b>เลข Tracking :</b></div>
              <div class="col-9 col-form-label">
                <div class="row" style="margin:0px;">
                  <div class="col-xs-7"><?php echo $row['tra_tracking'];?>
                    <input type="hidden" id="idcopyvalues<?php echo $i;?>" value="<?php echo $row['tra_tracking'];?>"/>
                  </div>
                  <div class="col-xs-2">&nbsp;&nbsp;</div><button class="btn btn-success col-xs-3 btn-xs" type="button" onclick="myFunction<?php echo $i;?>()">Copy</button>
                </div>
              </div>
            </div>
            <div class="form-group row" style="margin-bottom:0px;">
              <div class="col-3 col-form-label"><b>ขนส่ง :</b></div>
              <div class="col-9 col-form-label"><?php echo $row['type_delivery'];?></div>
            </div>
            <div class="form-group row" style="margin-bottom:0px;">
              <div class="col-3 col-form-label"><b>อัพเดตวันที่ :</b></div>
              <div class="col-9 col-form-label"><?php echo day_format_month_thai($row['tra_updatedate']);?></div>
            </div>
            <div class="form-group row" style="margin-bottom:0px;">
              <div class="col-3 col-form-label"><b>ลิ้งค์ :</b></div>
              <div class="col-9 col-form-label">
                <a  class="btn btn-danger col-xs-3 btn-xs" href="<?php echo $row['type_link'];?>" target="_blank">คลิกดูลิ้งค์</a>
              </div>
            </div>
            <div class="form-group row" style="margin-bottom:0px;">
              <div class="col-12 col-form-label"><b><a href="<?php echo $LinkWeb."view-tracking/edit/".$row['tra_id'];?>" class="btn btn-sm btn-default modal-edit"><i class="fa fa-edit"></i> แก้ไขข้อมูล</a></b></div>
            </div>



          </form>
        </div>
        <script type="text/javascript">
          function copyToClipboard(text) {
            var sampleTextarea = document.createElement("textarea");
            document.body.appendChild(sampleTextarea);
            sampleTextarea.value = text; //save main text in it
            sampleTextarea.select(); //select textarea contenrs
            document.execCommand("copy");
            document.body.removeChild(sampleTextarea);
          }

          function myFunction<?php echo $i;?>(){
            var copyText = document.getElementById("idcopyvalues<?php echo $i;?>");
            copyToClipboard(copyText.value);
            return false;
          }
        </script>
      <?php $i++;
    }
  }else {
    ?><div class="col-xs-12" style="padding: 15px 0;color:#f00;">ไม่มีข้อมูล หรือข้อมูลไม่ถูกต้อง!</div><?php
  }
}
/// Check Tracking
if ($_POST['post']=="CheckKeyPress") {
  $SqlSelect = "SELECT tra_tracking
                FROM tracking_all
                WHERE ( tra_tracking = '".$_POST['trvalue']."'  ) ;";
  if (select_num($SqlSelect)>0) {
    echo "มีข้อมูลเลข Tracking แล้ว";
  }else {
    return true;
  }
}
/// Delete Tracking
if ($_POST['post']=="delete-tracking") {
  $SqlSelect = "SELECT tra_tracking FROM tracking_all WHERE (tra_id = '".$_POST['travlue']."')";
  foreach (select_tb($SqlSelect) as $value) {
    $SqlDelete = "DELETE FROM tracking_all WHERE (tra_id ='".$_POST['travlue']."');";
    if (delete_tb($SqlDelete)==true) {
     echo fSuccess(2,"ลบข้อมูลเลข Tracking : ".$value['tra_tracking']." สำเร็จ ",$_POST['linkpath'],2);
     log_insert("ลบข้อมูลเลข Tracking : ".$value['tra_tracking']." สำเร็จ ",$_COOKIE[$CookieID]);
   }else {
     echo fError(2,"ลบข้อมูลเลข Tracking : ".$value['tra_tracking']." ไม่สำเร็จ ","");
     log_insert("ลบข้อมูลเลข Tracking : ".$value['tra_tracking']." ไม่สำเร็จ ",$_COOKIE[$CookieID]);
   }
  }

}
/// Check Username
if ($_POST['post']=="CheckKeyPress-User") {
  $SqlSelect = "SELECT user_name
                FROM tracking_user
                WHERE ( user_name = '".$_POST['truser']."'  ) ;";
  if (select_num($SqlSelect)>0) {
    echo "1";
  }else {
    echo "0";
  }
}
/// Delete User
if ($_POST['post']=="delete-user") {
  $SqlSelect = "SELECT user_name FROM tracking_user WHERE (user_id = '".$_POST['trauser']."')";
  foreach (select_tb($SqlSelect) as $value) {
    $SqlDelete = "DELETE FROM tracking_user WHERE (user_id ='".$_POST['trauser']."');";
    if (delete_tb($SqlDelete)==true) {
     echo fSuccess(2,"ลบข้อมูล User : ".$value['user_name']." สำเร็จ ",$_POST['linkpath'],2);
     log_insert("ลบข้อมูล User : ".$value['user_name']." สำเร็จ ",$_COOKIE[$CookieID]);
   }else {
     echo fError(2,"ลบข้อมูล User : ".$value['user_name']." ไม่สำเร็จ ","");
     log_insert("ลบข้อมูล User : ".$value['user_name']." ไม่สำเร็จ ",$_COOKIE[$CookieID]);
   }
  }

}
/// Delete Delivery
if ($_POST['post']=="delete-type-delivery") {
  $SqlSelect = "SELECT type_delivery FROM tracking_type WHERE (type_id = '".$_POST['tratype']."')";
  foreach (select_tb($SqlSelect) as $value) {
    $SqlDelete = "DELETE FROM tracking_type WHERE (type_id ='".$_POST['tratype']."');";
    if (delete_tb($SqlDelete)==true) {
     echo fSuccess(2,"ลบข้อมูลบริษัทขนส่ง : ".$value['type_delivery']." สำเร็จ ",$_POST['linkpath'],2);
     log_insert("ลบข้อมูลบริษัทขนส่ง : ".$value['type_delivery']." สำเร็จ ",$_COOKIE[$CookieID]);
   }else {
     echo fError(2,"ลบข้อมูลบริษัทขนส่ง : ".$value['type_delivery']." ไม่สำเร็จ ","");
     log_insert("ลบข้อมูลบริษัทขนส่ง : ".$value['type_delivery']." ไม่สำเร็จ ",$_COOKIE[$CookieID]);
   }
  }

}
/// Search Tracking Dashboard
if ($_POST['post']=="CheckTrackingMain") {
  $SqlSelect = "SELECT ta.*,tt.type_delivery,tt.type_link
                FROM tracking_all ta
                INNER JOIN tracking_type tt ON (ta.type_id = tt.type_id)
                WHERE (
                        (
                          ta.tra_customer = '".htmlentities($_POST['trvalue'], ENT_QUOTES)."' OR
                          ta.tra_phone = '".htmlentities($_POST['trvalue'], ENT_QUOTES)."' OR
                          ta.tra_email = '".htmlentities($_POST['trvalue'], ENT_QUOTES)."'
                        ) AND ta.tra_status = '0'
                      ) ;";
  if (select_num($SqlSelect)>0) { $i =1;
    foreach (select_tb($SqlSelect) as $row) {
      $SqlUpdate = "UPDATE tracking_all SET tra_search = tra_search+1 WHERE (tra_id = '".$row['tra_id']."') ";
      update_tb($SqlUpdate);
      ?>
        <div class="col-xs-12" style="padding: 15px 0;">
          <!--
          <form class="form-horizontal" style="display:none;">
            <div class="form-group row" style="margin-bottom:0px;">
              <div class="col-3 col-form-label"><b>เลข Tracking :</b></div>
              <div class="col-9 col-form-label">
                <div class="row" style="margin:0px;">
                  <div class="col-xs-7"><?php echo $row['tra_tracking'];?>
                    <input type="hidden" id="idcopyvalues<?php echo $i;?>" value="<?php echo $row['tra_tracking'];?>"/>
                  </div>
                  <div class="col-xs-2">&nbsp;&nbsp;</div><button class="btn btn-success col-xs-3 btn-xs" type="button" onclick="myFunction<?php echo $i;?>()">Copy</button>
                </div>
              </div>
            </div>
            <div class="form-group row" style="margin-bottom:0px;">
              <div class="col-3 col-form-label"><b>ขนส่ง :</b></div>
              <div class="col-9 col-form-label"><?php echo $row['type_delivery'];?></div>
            </div>
            <div class="form-group row" style="margin-bottom:0px;">
              <div class="col-3 col-form-label"><b>ลิ้งค์ :</b></div>
              <div class="col-9 col-form-label">
                <a  class="btn btn-danger col-xs-3 btn-xs" href="<?php echo $row['type_link'];?>" target="_blank">คลิกดูลิ้งค์</a>
              </div>
            </div>
            <div class="form-group row" style="margin-bottom:0px;">
              <div class="col-12 col-form-label"><b><a href="<?php echo $LinkWeb."view-tracking/edit/".$row['tra_id'];?>" class="btn btn-sm btn-default modal-edit"><i class="fa fa-edit"></i> แก้ไขข้อมูล</a></b></div>
            </div>



          </form>
          -->
          <p><b>เลขติดตามพัสดุ : </b><?php echo $row['tra_tracking'];?>
            <input type="hidden" id="idcopyvalues<?php echo $i;?>" value="<?php echo $row['tra_tracking'];?>"/>
            <button class="btn btn-success col-xs-3 btn-xs" type="button" onclick="myFunction<?php echo $i;?>()">คัดลอก</button>
          </p>
          <p>
            <img src="<?php echo $LinkWeb."query/view-image-type.php?view=".$row['type_id'];?>" style="width:auto;height:30px;" />
          </p>
          <p>
            <a class="btn btn-danger col-xs-3 btn-xs" href="<?php echo $row['type_link'];?>" target="_blank">เว็บไซต์ <?php echo $row['type_delivery'];?> <i class="far fa-hand-point-up"></i></a>
          </p>

        </div>
        <script type="text/javascript">
          function copyToClipboard(text) {
            var sampleTextarea = document.createElement("textarea");
            document.body.appendChild(sampleTextarea);
            sampleTextarea.value = text; //save main text in it
            sampleTextarea.select(); //select textarea contenrs
            document.execCommand("copy");
            document.body.removeChild(sampleTextarea);
          }

          function myFunction<?php echo $i;?>(){
            var copyText = document.getElementById("idcopyvalues<?php echo $i;?>");
            copyToClipboard(copyText.value);
            return false;
          }
        </script>
      <?php $i++;
    }
  }else {
    ?><div class="col-xs-12" style="padding: 15px 0;color:#f00;">ไม่มีข้อมูล หรือข้อมูลไม่ถูกต้อง!</div><?php
  }
}










?>
