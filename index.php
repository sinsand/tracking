<?php
include("config/config.php");
/// check update status last 15 day
day15_tracking();
if ($UrlPage=="admin") {
  include("system/index.php");
}else {
  include("main-tracking.php");
}
?>
