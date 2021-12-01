<?php
ob_start() ;
session_start();

header("content-type: text/html; charset=utf-8");
header('Access-Control-Allow-Origin: *');
date_default_timezone_set("utc");


global $Link, $Host, $User, $Pass, $DBname;
global $CookieID,$CookieName,$CookieType,$CookieBranch,$CookieGroup,$CookieEditSystem,$CookieViewReport,$CookieAdminID,$CookieAccept;
global $SessionID,$SessionName,$SessionType,$SessionBranch,$SessionGroup,$SessionEditSystem,$SessionViewReport,$SessionAdminID;
$httplink ;
$linkpath = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']==='on'?"https" : "http")."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
//echo $link;
if(isset($_SERVER['HTTPS']) &&  $_SERVER['HTTPS'] === 'on'){  $httplink = "https"; }else{  $httplink = "http"; }
$LinkWeb 		    = $httplink."://".$_SERVER['HTTP_HOST']."/";
$LinkPath 		  = $linkpath;
$LinkHostWeb 		= $LinkWeb;
$LinkHostLocal 	= $LinkWeb;
$pageadmin      = "admin";
$LinkWebadmin 	= $LinkWeb.$pageadmin."/";

$Linkfile = "file/import/";

$keyAPI = "AIzaSyCvY2IXvJumj6fn0SGhc5WEm_cxKeitMcs";

/// tracking.v4skin.co.th
$Host = "localhost";
$User = "vskincot_tracking";
$Pass = "l&733fzL";
$DBname = "vskincot_tracking";


/// tracking.tamtask.com
//$Host = "localhost";
//$User = "chonjob_tracking";
//$Pass = "t0D41zg&";
//$DBname = "chonjob_tracking";


//// Job step show
$s_start = 0;
$s_limit = 10;

//// Job step show
$s_start = 0;
$s_limit = 5;

//define(SITE_URL,$LinkWeb);

error_reporting(~E_NOTICE);
$Path         = $LinkPath;
$PathExplode  = explode("/",$_SERVER['REQUEST_URI']);
$Url          = $LinkWeb;
$UrlPage      = "";
$UrlId        = "";
$UrlIdSub     = "";
$UrlOther     = "";
$UrlOther2    = "";


if (!empty($PathExplode[1])) {
  $UrlPage = $PathExplode[1];
}
if (!empty($PathExplode[2])) {
  $UrlId = $PathExplode[2];
}
if (!empty($PathExplode[3])) {
  $UrlIdSub = $PathExplode[3];
}
if (!empty($PathExplode[4])) {
  $UrlOther = $PathExplode[4];
}
if (!empty($PathExplode[5])) {
  $UrlOther2 = $PathExplode[5];
}


/*
echo "UrlPage = ".$UrlPage."<br>";
echo "UrlId = ".$UrlId."<br>";
echo "UrlIdSub = ".$UrlIdSub."<br>";
echo "UrlOther = ".$UrlOther."<br>";
echo "UrlOther2 = ".$UrlOther2."<br>";
*/


/// Session and Cookie Admin
$CookieID = 'C_UID'; //ID_admin
$CookieName = 'C_UNAME'; //name_admin
$CookieType = 'C_UTYPEID'; //mem_group_name
$CookieBranch = 'C_UBRANCH'; //mem_group_name
$CookieGroup = 'C_UGROUP'; //mem_group
$CookieCountry = 'C_UCOUNTRY'; //mem_country
$CookieEditSystem = 'C_SYSTEM'; //Edit System
$CookieViewReport = 'C_REPORT'; //View Report
$CookieAdminID = 'C_ADMIN'; //
$CookieAccept = 'C_ACCEPT'; //Cookie

$SessionID = 'S_UID'; // Member_id
$SessionName = 'S_UNAME'; //Company
$SessionType = 'S_UTYPEID'; //member_group
$SessionBranch = 'S_UBRANCH'; //member_branch
$SessionGroup = 'S_UGROUP'; //member_group
$SessionCountry = 'S_UCOUNTRY'; //member_country
$SessionEditSystem = 'S_SYSTEM'; /// Edit System
$SessionViewReport = 'S_REPORT'; /// View Report
$SessionAdminID = 'S_ADMIN'; ///


if (!empty($_SESSION[$SessionID]) ) {
  if ( empty($_COOKIE[$CookieID]) ) {
    setcookie($CookieID, null, time()-3600,'/');
    unset($_COOKIE[$CookieID]);
    unset($_COOKIE[$CookieType]);

    unset($_SESSION[$SessionID]);
    unset($_SESSION[$SessionType]);

    session_unset();
    session_destroy();
    header("Refresh:0; url=$linkpath");
  }
}

function ConnectToDB() {
	global $Link, $Host, $User, $Pass, $DBname;
	$Link = mysqli_connect($Host,$User,$Pass,$DBname);
  if (mysqli_connect_errno()){
		echo "Database Connect Failed : " . mysqli_connect_error();
	}
	mysqli_set_charset($Link,"utf8");
}

function insert_tb($query){
	ConnectToDB();
	global $Link;
	$objQuery = mysqli_query($Link,$query);
	if($objQuery){
		return true;
	}else{
		return false;
	}
  mysqli_close($Link);
}

function delete_tb($query){
	ConnectToDB();
	global $Link;
	$objQuery = mysqli_query($Link,$query);
	if($objQuery){
		return true;
	}else{
		return false;
	}
  mysqli_close($Link);
}

function select_tb($query){
	ConnectToDB();
	global $Link;
	$obj = mysqli_query($Link,$query);
	while($ro = mysqli_fetch_array($obj,MYSQLI_ASSOC)){
		$rows[] = $ro;
	}
	return $rows;
  mysqli_close($Link);
}

function select_num($query){
	ConnectToDB();
	global $Link;
	$obj = mysqli_query($Link,$query);
	$numrow = mysqli_num_rows($obj);
	return $numrow;
  mysqli_close($Link);
}

function update_tb($query){
	ConnectToDB();
	global $Link;
	$objQuery = mysqli_query($Link,$query);
	if($objQuery){
		return true;
	}else{
		return false;
	}
  mysqli_close($Link);
}

function base64url_encode($data) { return base64_encode($data); }

function base64url_decode($data) { return base64_decode($data); }


//// Function
require('function.php');

?>
