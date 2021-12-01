<?php
include("../config/config.php");



///// Logout
if ($_POST['post']=="clear_system") {

  log_insert("ออกจากระบบสำเร็จ",$_SESSION[$SessionID]);
  setcookie($CookieID, null, time()-3600,'/');
  unset($_COOKIE[$CookieID]);
  unset($_COOKIE[$CookieType]);

  unset($_SESSION[$SessionID]);
  unset($_SESSION[$SessionType]);

  session_unset();
  session_destroy();
  echo fSuccess(4,"ออกจากระบบสำเร็จ",$_POST["linkpath"],2);
}
//// login
if ($_POST['post']=="check-and-login") {
  $SqlSelect = "SELECT cl.lid,cl.l_typeuser
                FROM chon_login cl
                INNER JOIN chon_job_seeker cj ON ( cl.link_id = cj.s_id AND cl.l_typeuser = '2' )
                WHERE (
                        cl.username = '".$_POST['user_login']."' AND
                        cl.password_encode = '".md5(md5($_POST['pass_login']))."' AND
                        cl.l_status_login = '1'
                      )";
  if (select_num($SqlSelect)>0) {
    foreach (select_tb($SqlSelect) as $row) {
      setcookie($CookieID, base64url_encode($row['lid']),  time() + (86400 * 30), "/"); // 86400 = 1 day
      setcookie($CookieType, base64url_encode($row['l_typeuser']),  time() + (86400 * 30), "/"); // 86400 = 1 day
      $_SESSION[$SessionID] = base64url_encode($row['lid']);
      $_SESSION[$SessionType] = base64url_encode($row['l_typeuser']);
      echo fSuccess(5,"ล็อกอินสำเร็จ",$_POST['linkpath'],2);
      log_insert("ล็อกอินเข้าสู่ระบบ",base64url_encode($row['lid']));
    }
  }else {
    $SqlSelect = "SELECT cl.lid,cl.l_typeuser
                  FROM chon_login cl
                  INNER JOIN chon_employer ce ON ( cl.link_id = ce.em_id AND cl.l_typeuser = '3' )
                  WHERE (
                          cl.username = '".$_POST['user_login']."' AND
                          cl.password_encode = '".md5(md5($_POST['pass_login']))."' AND
                          cl.l_status_login = '1'
                        )";
    //echo $SqlSelect;
    if (select_num($SqlSelect)>0) {
      foreach (select_tb($SqlSelect) as $row) {
        setcookie($CookieID, base64url_encode($row['lid']),  time() + (86400 * 30), "/"); // 86400 = 1 day
        setcookie($CookieType, base64url_encode($row['l_typeuser']),  time() + (86400 * 30), "/"); // 86400 = 1 day
        $_SESSION[$SessionID] = base64url_encode($row['lid']);
        $_SESSION[$SessionType] = base64url_encode($row['l_typeuser']);
        echo fSuccess(5,"ล็อกอินสำเร็จ",$_POST['linkpath'],2);
        log_insert("ล็อกอินเข้าสู่ระบบ",base64url_encode($row['lid']));
      }
    }else {
      echo fError(5,"ข้อมูลไม่มีในระบบ","");
    }
  }
}
//// Accept cookie Notice
if ($_POST['post']=="accept-cookie-notice") {
  setcookie($CookieAccept, "Accept-Cookie-Year",  time() + ((86400 * 30)*365), "/"); // 86400 = 1 day
}



//// compnay  post-job.php
//// change cate
if ($_POST['post']=="select-secondcate") {
  $SqlSelect = "SELECT *
                FROM chon_second_cate
                WHERE ( cate_id = '".$_POST['cateid']."' )
                ORDER BY dcate_name  ASC";
  if (select_num($SqlSelect)>0) {
    ?><option value="">เลือกหมวดหมู่ย่อย</option><?php
    foreach (select_tb($SqlSelect) as $row) {
      ?><option value="<?php echo $row['dcate_id'];?>"><?php echo $row['dcate_name'];?></option><?php
    }
  }else {
    ?><option value="">ไม่มีหมวดหมู่ย่อย</option><?php
  }
}
//// change amphur
if ($_POST['post']=="select-provincetoamphur") {
  $SqlSelect = "SELECT *
                FROM chon_amphur
                WHERE ( PROVINCE_ID = '".$_POST['proid']."' )
                ORDER BY AMPHUR_NAME ASC";
  if (select_num($SqlSelect)>0) {
    ?><option value="">เลือกอำเภอ</option><?php
    foreach (select_tb($SqlSelect) as $row) {
      ?><option value="<?php echo $row['AMPHUR_ID'];?>"><?php echo $row['AMPHUR_NAME'];?></option><?php
    }
  }
}
//// change amphur
if ($_POST['post']=="select-amphur-district") {
  $SqlSelect = "SELECT *
                FROM chon_district
                WHERE (
                        PROVINCE_ID = '".$_POST['proid']."' AND
                        AMPHUR_ID   = '".$_POST['amphurid']."'
                      )
                ORDER BY DISTRICT_NAME ASC";
  if (select_num($SqlSelect)>0) {
    ?><option value="">เลือกตำบล</option><?php
    foreach (select_tb($SqlSelect) as $row) {
      ?><option value="<?php echo $row['DISTRICT_ID'];?>"><?php echo $row['DISTRICT_NAME'];?></option><?php
    }
  }
}
//// view zipcode
if ($_POST['post']=="select-zipcode") {
  $SqlSelect = "SELECT zipcode
                FROM chon_zipcode
                WHERE (
                        PROVINCE_ID = '".$_POST['proid']."' AND
                        AMPHUR_ID   = '".$_POST['amphurid']."' AND
                        DISTRICT_ID   = '".$_POST['districtid']."'
                      );";
  if (select_num($SqlSelect)>0) {
    foreach (select_tb($SqlSelect) as $row) {
      echo $row['zipcode'];
    }
  }
}





/// company dashboard.php
if ($_POST['post']=="status-postjob") {
  $status = 0;
  $status_ = "ปิด";
  if ($_POST['statusid']=='1') {
    $status = 0;
    $status_ = "ปิด";
  }else {
    $status = 1;
    $status_ = "เปิด";
  }
  $SqlUpdate = "UPDATE chon_job
                  SET job_status = '".$status."',
                      job_update = now()
                WHERE ( job_id = '".$_POST['jobid']."' )";
  if (update_tb($SqlUpdate)==true) {
    echo $status;
    log_insert("เปลี่ยนแปลง สถานะประกาศงาน (".$status_.") เลขที่ ".$_POST['jobid']." สำเร็จ",$_COOKIE[$CookieID]);
  }else {
    log_insert("เปลี่ยนแปลง สถานะประกาศงาน (".$status_.") เลขที่ ".$_POST['jobid']." ไม่สำเร็จ",$_COOKIE[$CookieID]);
  }
}
/// company dashboard.php
if ($_POST['post']=="delete-postjob") {
  $SqlSelect = "DELETE FROM chon_job WHERE ( job_id = '".$_POST['jobid']."' )";
  if (delete_tb($SqlSelect)==true) {
    echo fSuccess(3,"ลบประกาศสำเร็จ",$_POST['linkpath'],2);
    log_insert("ลบประกาศ เลขที่ ".$_POST['jobid']." สำเร็จ",$_COOKIE[$CookieID]);
  }else {
    echo fError(3,"ลบประกาศไม่สำเร็จ","");
    log_insert("ลบประกาศ เลขที่ ".$_POST['jobid']." ไม่สำเร็จ",$_COOKIE[$CookieID]);
  }
}

//// new contact check-contact.php
if ($_POST['post']=="new-contact") {
  $SqlInsert = "INSERT INTO chon_e_contact
                  VALUES(0,
                    '".$_POST['el_emid']."',
                    '".$_POST['el_company']."',
                    '".$_POST['el_name']."',
                    '".$_POST['el_email']."',
                    '".$_POST['el_phone']."',
                    '".$_POST['el_lineid']."',
                    '".$_POST['el_tel']."',
                    now()
                  );";
  if (insert_tb($SqlInsert)==true) {
    echo fSuccess(1,"เพิ่มข้อมูลการติดต่อสำเร็จ",$_POST['linkpath'],2);
    log_insert("เพิ่มข้อมูลการติดต่อ ใหม่ สำเร็จ",$_COOKIE[$CookieID]);
  }else {
    echo fError(1,"เพิ่มข้อมูลการติดต่อไม่สำเร็จ","");
    log_insert("เพิ่มข้อมูลการติดต่อ ใหม่ ไม่สำเร็จ",$_COOKIE[$CookieID]);
  }
}
//// view contact check-contact.php
if ($_POST['post']=="view-contact") {
  $SqlSelect = "SELECT *
                FROM chon_e_contact
                WHERE ( ec_id = '".$_POST['ec_id']."' )";
  if (select_num($SqlSelect)>0) {
    foreach (select_tb($SqlSelect) as $row) {
      echo $row['ec_company']."|||".
           $row['ec_contact']."|||".
           $row['ec_email']."|||".
           $row['ec_tel']."|||".
           $row['ec_lineid']."|||".
           $row['ec_phone'];
     log_insert("เรียกดู ข้อมูลการติดต่อ เลขที่ ".$_POST['ec_id'],$_COOKIE[$CookieID]);

    }
  }
}
//// update contact check-contact.php
if ($_POST['post']=="update-contact") {
  $SqlUpdate = "UPDATE chon_e_contact
                  SET ec_company = '".$_POST['el_company']."',
                      ec_contact = '".$_POST['el_name']."',
                      ec_email = '".$_POST['el_email']."',
                      ec_tel = '".$_POST['el_tel']."',
                      ec_lineid = '".$_POST['el_lineid']."',
                      ec_phone = '".$_POST['el_phone']."'
                WHERE ( ec_id = '".$_POST['ec_id']."' )";
  if (update_tb($SqlUpdate)==true) {
    echo fSuccess(2,"เปลี่ยนแปลงข้อมูลการติดต่อสำเร็จ",$_POST['linkpath'],2);
    log_insert("เปลี่ยนแปลงข้อมูลการติดต่อ เลขที่ ".$_POST['ec_id']." สำเร็จ",$_COOKIE[$CookieID]);
  }else {
    echo fError(2,"เปลี่ยนแปลงข้อมูลการติดต่อไม่สำเร็จ","");
    log_insert("เปลี่ยนแปลงข้อมูลการติดต่อ ไม่สำเร็จ",$_COOKIE[$CookieID]);
  }
}
//// delete contact check-contact.php
if ($_POST['post']=="delete-contact") {
  $SqlSelect = "SELECT ec_id FROM chon_job WHERE ( ec_id = '".$_POST['ec_id']."' )";
  if (select_num($SqlSelect)>0) {
    echo fError(3,"ลบข้อมูลการติดต่อ ไม่สำเร็จ เนื่องจากมีข้อมูลที่เชื่อมโยงกันอยู่ ","");
  }else {
    $SqlDelete = "DELETE FROM chon_e_contact WHERE ( ec_id = '".$_POST['ec_id']."' )";
    if (delete_tb($SqlDelete)==true) {
      echo fSuccess(3,"ลบข้อมูลการติดต่อ สำเร็จ",$_POST['linkpath'],2);
      log_insert("ลบข้อมูลการติดต่อ เลขที่ ".$_POST['ec_id']." สำเร็จ",$_COOKIE[$CookieID]);
    }else {
      echo fError(3,"ลบข้อมูลการติดต่อ ไม่สำเร็จ","");
    }
  }
}




//// check check-job-register.php
if ($_POST['post']=="check-register") {
  $status_ = "";
  if ($_POST['js_status']=='1') {
    $status_ = "ผ่านการสมัคร";
  }else {
    $status_ = "ไม่ผ่าน";
  }
  $SqlUpdate = "UPDATE chon_job_register
                  SET jr_check_indate = now(),
                      jr_check_status = '".$_POST['js_status']."'
                WHERE ( jr_id = '".$_POST['js_id']."' )";
  if (update_tb($SqlUpdate)==true) {
    echo fSuccess(2,"เปลี่ยนสถานะผู้สมัครสำเร็จ",$_POST['linkpath'],2);
    log_insert("เปลี่ยนแปลง สถานะผู้สมัคร (".$status_.") เลขที่ ".$_POST['js_id']." สำเร็จ",$_COOKIE[$CookieID]);
  }else {
    echo fError(2,"เปลี่ยนสถานะผู้สมัครไม่สำเร็จ","");
    log_insert("เปลี่ยนแปลง สถานะผู้สมัคร (".$status_.") เลขที่ ".$_POST['js_id']." ไม่สำเร็จ",$_COOKIE[$CookieID]);
  }
}


//// load-view-job
if ($_POST['post']=="load-view-job"){
  $s_str     = $_POST['s_str'];
  $s_limit   = $_POST['s_limit'];
  $s_job     = $_POST['s_job'] + $_POST['s_str'];
  $SqlSelect = "SELECT *
                FROM chon_job cj
                LEFT OUTER JOIN chon_employer ce ON ( cj.em_id = ce.em_id )
                LEFT OUTER JOIN chon_e_location cel ON ( cj.el_id = cel.el_id )
                LEFT OUTER JOIN chon_typework  ctw ON ( cj.ctw_id = ctw.ctw_id )
                WHERE (
                        cj.job_status = '1' AND
                        cj.type_approve = '2'
                      )
                GROUP BY cj.job_id
                ORDER BY cj.job_update DESC
                LIMIT ".$s_str.", ".$s_limit.";";
  $select_num = select_num($SqlSelect);
  if ($select_num>0) {
    if ($select_num<$s_limit) {
      $s_str = $s_str + $select_num;
      $s_job = $_POST['s_job'] + $select_num;
    }else {
      $s_str = $s_str + $s_limit;
      $s_job = $_POST['s_job'] + $s_limit;
    }
    echo $s_str."|||".$s_limit."|||".$s_job."|||";
    foreach (select_tb($SqlSelect) as $row) {
      ?>
      <div class="single-post d-flex flex-row">
        <div class="row" style="width:100%;margin: 0px;">
          <div class="col-sm-12 col-md-3 thumb" style="padding-right: 15px;">
            <div class="row" style="width:100%;margin: 0px;">
              <a href="<?php echo $LinkHostWeb;?>job/<?php echo $row['job_id'];?>" class="col-xs-4 col-sm-4 col-md-12" style="padding:0px;">
                <img src="<?php echo $LinkHostWeb;?>query/viewlogo.php?view=<?php echo $row['em_id'];?>" style="width:100%;height:auto;">
                <div class="col-12 text-left" style="padding:0px;">
                  <span style="font-size: 12px;color: #676767;">ล่าสุด : <?php echo day_format_month($row['job_update']);?></span>
                </div>
              </a>
              <?php
                if (!empty($_COOKIE[$CookieID]) && base64url_decode($_COOKIE[$CookieType])=='2' ) {
                  ?>
                  <ul class="btns hidden-md hidden-lg hidden-xl col-sm-8 col-xs-8 text-right " style="padding:0px;">
                    <li><a href="<?php echo $LinkHostWeb;?>job/<?php echo $row['job_id'];?>"><span class="lnr lnr-magnifier"></span></a></li>
                    <li><a href="#" data-toggle="modal" data-target="#modal-favorite-job" class="modal-favorite-job" id="<?php echo $row['job_id'];?>"><span class="lnr lnr-heart"></span></a></li>
                    <li><a href="#" data-toggle="modal" data-target="#modal-register-job" class="modal-register-job" id="<?php echo $row['job_id'];?>">สมัครงานนี้</a></li>
                  </ul>
                  <?php
                }
              ?>
            </div>
          </div>
          <div class="col-sm-12 col-md-9 details text-detail-job" style="width:100%;">
            <div class="title d-flex flex-row justify-content-between" style="width:100%;">
              <div class="titles">
                <a href="<?php echo $LinkHostWeb;?>job/<?php echo $row['job_id'];?>"><h4><?php echo $row['job_position'];?></h4></a>
                <a href="<?php echo $LinkHostWeb;?>company/<?php echo $row['em_id'];?>"><h6><?php echo $row['em_companyname'];?></h6></a>
              </div>
              <?php
                if (!empty($_COOKIE[$CookieID]) && base64url_decode($_COOKIE[$CookieType])=='2' ) {
                  ?>
                  <ul class="btns hidden-xs hidden-sm ">
                    <li><a href="#" data-toggle="modal" data-target="#modal-favorite-job" class="modal-favorite-job" id="<?php echo $row['job_id'];?>"><span class="lnr lnr-heart"></span></a></li>
                    <li><a href="#" data-toggle="modal" data-target="#modal-register-job" class="modal-register-job" id="<?php echo $row['job_id'];?>">สมัครงานนี้</a></li>
                  </ul>
                  <?php
                }
              ?>
            </div>
            <p style="white-space: pre-line;display:none;"><?php echo $row['job_description'];?></p>
            <h5>ลักษณะงาน :<?php 	echo $row['ctw_name']; ?>
            </h5>
            <div class="row">
              <div class="col-sm-7" style="margin-bottom:15px;">
                <span class="lnr lnr-map-marker"></span> <?php echo $row['el_namelocation'];?>
              </div>
              <div class="col-sm-5" style="margin-bottom:15px;">
                <span class="lnr lnr-user"></span> <?php echo $row['job_rate'];?>
              </div>
            </div>
            <p class="address">
              <span class="lnr lnr-database"></span> <?php echo $row['job_salary'];?>
            </p>
          </div>

        </div>
      </div>
      <?php
    }
  }else {
    echo $_POST['view']."|||";
  }
}

////
if ($_POST['post']=="load-view-job-spec"){
  $s_str     = $_POST['s_str'];
  $s_limit   = $_POST['s_limit'];
  $s_job     = $_POST['s_job'] + $_POST['s_str'];

  /*$SqlSelect = "SELECT *
                FROM chon_job cj
                LEFT OUTER JOIN chon_employer ce ON ( cj.em_id = ce.em_id )
                LEFT OUTER JOIN chon_e_location cel ON ( cj.el_id = cel.el_id )
                WHERE (
                        cj.job_status = '1'  AND
                        cj.type_approve = '2'
                        ".$_POST['s_search']."
                      )
                GROUP BY cj.job_id
                ORDER BY cj.job_indate DESC
                LIMIT ".$s_str.", ".$s_limit.";";
  */

  $SqlSelect = $_POST['s_sql'];
  $SqlSelect = "LIMIT ".$s_str.", ".$s_limit;

  $select_num = select_num($SqlSelect);
  if ($select_num>0) {
    if ($select_num<$s_limit) {
      $s_str = $s_str + $select_num;
      $s_job = $_POST['s_job'] + $select_num;
    }else {
      $s_str = $s_str + $s_limit;
      $s_job = $_POST['s_job'] + $s_limit;
    }
    echo $s_str."|||".$s_limit."|||".$s_job."|||";
    foreach (select_tb($SqlSelect) as $row) {
      ?>
      <div class="col-lg-12 single-post">
        <div class="row" style="width:100%;margin: 0px;">
          <div class="col-sm-12 col-md-3 thumb" style="padding-right: 15px;">
            <div class="row" style="width:100%;margin: 0px;">
              <a href="<?php echo $LinkHostWeb;?>job/<?php echo $row['job_id'];?>" class="col-xs-4 col-sm-4 col-md-12" style="padding:0px;">
                <img src="<?php echo $LinkHostWeb;?>query/viewlogo.php?view=<?php echo $row['em_id'];?>" style="width:100%;height:auto;">
                <div class="col-12 text-left" style="padding:0px;">
                  <span style="font-size: 12px;color: #676767;">ล่าสุด : <?php echo day_format_month($row['job_update']);?></span>
                </div>
              </a>
              <?php
                if (!empty($_COOKIE[$CookieID]) && base64url_decode($_COOKIE[$CookieType])=='2' ) {
                  ?>
                  <ul class="btns hidden-md hidden-lg hidden-xl col-sm-8 col-xs-8 text-right " style="padding:0px;">
                    <li><a href="<?php echo $LinkHostWeb;?>job/<?php echo $row['job_id'];?>"><span class="lnr lnr-magnifier"></span></a></li>
                    <li><a href="#" data-toggle="modal" data-target="#modal-favorite-job" class="modal-favorite-job" id="<?php echo $row['job_id'];?>"><span class="lnr lnr-heart"></span></a></li>
                    <li><a href="#" data-toggle="modal" data-target="#modal-register-job" class="modal-register-job" id="<?php echo $row['job_id'];?>">สมัครงานนี้</a></li>
                  </ul>
                  <?php
                }
              ?>
            </div>
          </div>
          <div class="col-sm-12 col-md-9 details text-detail-job" style="width:100%;">
            <div class="title d-flex flex-row justify-content-between" style="width:100%;">
              <div class="titles">
                <a href="<?php echo $LinkHostWeb;?>job/<?php echo $row['job_id'];?>"><h4><?php echo $row['job_position'];?></h4></a>
                <a href="<?php echo $LinkHostWeb;?>company/<?php echo $row['em_id'];?>"><h6><?php echo $row['em_companyname'];?></h6></a>
              </div>
              <?php
                if (!empty($_COOKIE[$CookieID]) && base64url_decode($_COOKIE[$CookieType])=='2' ) {
                  ?>
                  <ul class="btns hidden-xs hidden-sm ">
                    <li><a href="#" data-toggle="modal" data-target="#modal-favorite-job" class="modal-favorite-job" id="<?php echo $row['job_id'];?>"><span class="lnr lnr-heart"></span></a></li>
                    <li><a href="#" data-toggle="modal" data-target="#modal-register-job" class="modal-register-job" id="<?php echo $row['job_id'];?>">สมัครงานนี้</a></li>
                  </ul>
                  <?php
                }
              ?>
            </div>
            <p style="white-space: pre-line;display:none;"><?php echo $row['job_description'];?></p>
            <h5>ลักษณะงาน :<?php 	echo $row['job_work']=='1'?"งานประจำ":"Part-Time";  	?>
            </h5>
            <div class="row">
              <div class="col-sm-7" style="margin-bottom:15px;">
                <span class="lnr lnr-map-marker"></span> <?php echo $row['el_namelocation'];?>
              </div>
              <div class="col-sm-5" style="margin-bottom:15px;">
                <span class="lnr lnr-user"></span> <?php echo $row['job_rate'];?>
              </div>
            </div>
            <p class="address">
              <span class="lnr lnr-database"></span> <?php echo $row['job_salary'];?>
            </p>
          </div>

        </div>
      </div>
      <?php
    }
  }else {
    echo $_POST['view']."|||";
  }
}

////  save favorite
if ($_POST['post']=="save-favorite") {
  if (!empty($_COOKIE[$CookieID]) && base64url_decode($_COOKIE[$CookieType]) =="2" ) {

    $SqlInsert = "INSERT INTO chon_job_favorite
                   VALUES(0,
                     '".$_POST['jobid']."',
                     '".js_id($_COOKIE[$CookieID])."',
                     now()
                   );";
    if (insert_tb($SqlInsert)==true) {
      echo fSuccess(1,"เก็บความสนใจตำแหน่งงานสำเร็จ",$_POST['linkpath'],2);
      log_insert("เก็บความสนใจตำแหน่งงานสำเร็จ",$_COOKIE[$CookieID]);
    }else {
      echo fError(1,"เก็บความสนใจตำแหน่งงานไม่สำเร็จ","");
      log_insert("เก็บความสนใจตำแหน่งงานไม่สำเร็จ",$_COOKIE[$CookieID]);
    }

  }else {
    echo fError(1,"กรุณา เข้าสู่ระบบก่อนทำรายการด้วยค่ะ","");
  }
}
////  save register
if ($_POST['post']=="save-register") {
  if (!empty($_COOKIE[$CookieID]) && base64url_decode($_COOKIE[$CookieType]) =="2" ) {

    $SqlInsert = "INSERT INTO chon_job_register
                   VALUES(0,
                     '".$_POST['jobid']."',
                     '".js_id($_COOKIE[$CookieID])."',
                     null,
                     null,
                     now()
                   );";
    if (insert_tb($SqlInsert)==true) {
      echo fSuccess(1,"ได้ทำการสมัครตำแหน่งงานนี้สำเร็จ",$_POST['linkpath'],2);
      log_insert("ได้ทำการสมัครตำแหน่งงานนี้สำเร็จ",$_COOKIE[$CookieID]);
    }else {
      echo fError(1,"ไม่สามารถสมัครตำแหน่งงานนี้ได้","");
      log_insert("ไม่สามารถสมัครตำแหน่งงานนี้ได้",$_COOKIE[$CookieID]);
    }

  }else {
    echo fError(1,"กรุณา เข้าสู่ระบบก่อนทำรายการด้วยค่ะ","");
  }
}



//// submit approve job
if ($_POST['post']=="job-sent-approve") {
  $SqlUpdate = "UPDATE chon_job
                  SET type_approve = '1',
                      type_approve_date = now()
                WHERE ( job_id = '".$_POST['jobid']."' )";
  if (update_tb($SqlUpdate)==true) {
    echo fSuccess(2,"ยื่นขออนุมัติ ตำแหน่งงานเรียบร้อย รอการอนุมัติ",$_POST['linkpath'],2);
    log_insert("ยื่นขออนุมัติ ตำแหน่งงานเรียบร้อย รอการอนุมัติ เลขที่ ".$_POST['jobid'],$_COOKIE[$CookieID]);
  }else {
    echo fError(2,"ไม่สามารถยื่นขออนุมัติ ตำแหน่งงานได้","");
    log_insert("ไม่สามารถยื่นขออนุมัติ ตำแหน่งงานได้",$_COOKIE[$CookieID]);
  }
}
/// delete job
if ($_POST['post']=="delete-job-confirm") {
  $SqlDelete = "DELETE FROM chon_job WHERE ( job_id = '".$_POST['jobid']."' )";
  if (delete_tb($SqlDelete)==true) {
    echo fSuccess(3,"ลบตำแหน่งงานสำเร็จ",$_POST['linkpath'],2);
    log_insert("ลบตำแหน่งงาน งานเลขที่ ".$_POST['jobid']." สำเร็จ",$_COOKIE[$CookieID]);
  }else {
    echo fError(3,"ลบตำแหน่งงานไม่สำเร็จ","");
  }
}

?>
