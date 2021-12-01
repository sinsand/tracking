<?php
require_once("../config/config.php");

if(isset($_GET['view'])) {
  $SqlSelect = "SELECT type_icon FROM tracking_type WHERE type_id = '".$_GET['view']."' ";
  foreach (select_tb($SqlSelect) as $row) {
    header("Content-type:");
    echo $row["type_icon"];
  }
}
?>
