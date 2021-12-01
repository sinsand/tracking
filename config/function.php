<?php
//// alert success
function fSuccess($type,$value,$link,$time){
  ?>
  <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <?php echo FType($type);?>
    <?php echo $value;?> ....<i class="fas fa-spinner faa-spin animated"></i>
  </div>
  <?php
    if ($time>0) {
      ?><meta http-equiv="refresh" content="<?php echo $time;?>;url=<?php echo $link;?>"><?php
    }
}
//// alert error
function fError($type,$value,$sql=""){
  ?>
  <div class="alert alert-warning alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <?php echo FType($type);?>
    <?php echo $value;?> ....<?php echo $sql;?>
  </div>
  <?php
}
//// check alert type
function FType($type){
  if ($type==1) { /// add
    return "<h4><i class='far fa-check-circle'></i> ADD !</h4>";
  }else if ($type==2){ /// update
    return "<h4><i class='far fa-check-circle'></i> UPDATE !</h4>";
  }else if ($type==3){ // delete
    return "<h4><i class='far fa-check-circle'></i> DELETE !</h4>";
  }else if ($type==4){ // sign out
    return "<h4><i class='fas fa-lock-open'></i> Exit !</h4>";
  }else if ($type==5){ // sign in
    return "<h4><i class='fas fa-lock'></i> Sign In !</h4>";
  }else if ($type==6){ // register
    return "<h4><i class='far fa-check-circle'></i> Register !</h4>";
  }
}







//// insert to table log
function log_insert($value,$eid){
  $SqlInsert  = "INSERT INTO tracking_log VALUES(0,'".htmlentities($value)."',".base64url_decode($eid).",now());";
  if(insert_tb($SqlInsert)==true){
    return true;
  }else {
    return false;
  }
}
//// convert day
function day_format_month($value){
  $a_month = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
  //return substr($value,8,2)."-".(substr($value,5,2)-1)."-".substr($value,0,4)." ".(substr($value,11,20));
  return substr($value,8,2)."-".$a_month[(substr($value,5,2)-1)]."-".substr($value,0,4)." ".(substr($value,11,20));
}
////* onvert day
function day_format_month_thai($value){
  $a_monthth = array("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
  return substr($value,8,2)." ".$a_monthth[(substr($value,5,2)-1)]." ".(substr($value,0,4)+543)." ".(substr($value,11,20));
}
//// convert time
function show_time($value){
  return substr($value,11,8);
}

/// Date diff
function DateDiff($strDate2,$strDate1){
		return (strtotime($strDate2) - strtotime($strDate1))/  ( 60 * 60 * 24 );  // 1 day = 60*60*24
}


function check_tracking($value){
  $SqlSelect = "SELECT tra_tracking FROM tracking_all WHERE ( tra_tracking = '$value')";
  if (select_num($SqlSelect)>0) {
    return false;
  }else {
    return true;
  }
}

function check_username($value){
  $SqlSelect = "SELECT user_name FROM tracking_user WHERE ( user_name = '$value')";
  if (select_num($SqlSelect)>0) {
    return false;
  }else {
    return true;
  }
}

function check_user_in_tracking($user){
  $SqlSelect = "SELECT tra_id FROM tracking_all WHERE ( user_id = '$user')";
  if (select_num($SqlSelect)>0) {
    return false;
  }else {
    return true;
  }
}

function check_type_in_tracking($typeid){
  $SqlSelect = "SELECT type_id FROM tracking_all WHERE ( type_id = '$typeid')";
  if (select_num($SqlSelect)>0) {
    return false;
  }else {
    return true;
  }
}

function check_tracking_value($value){
  $SqlSelect = "SELECT tra_id FROM tracking_all WHERE ( tra_tracking = '$value')";
  if (select_num($SqlSelect)>0) {
    foreach (select_tb($SqlSelect) as $value) {
      return $value['tra_id'];
    }
  }
}

function check_tracking_number($value){
  $SqlSelect = "SELECT tra_tracking FROM tracking_all WHERE ( tra_tracking = '$value')";
  if (select_num($SqlSelect)>0) {
    foreach (select_tb($SqlSelect) as $value) {
      return $value['tra_tracking'];
    }
  }
}

function day15_tracking(){
  $SqlSelect = "SELECT tra_id from tracking_all where ( tra_updatedate NOT BETWEEN adddate(now(),-15) AND now());";
  if (select_num($SqlSelect)>0) {
    foreach (select_tb($SqlSelect) as $value) {
      $SqlUpdate = "UPDATE tracking_all SET tra_status = '1' WHERE ( tra_id = '".$value['tra_id']."') ";
      update_tb($SqlUpdate);
    }
  }
}
?>
