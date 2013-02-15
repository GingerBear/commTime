<?php
require_once('function.php');
$eid = 0;
$event = array();
$time = array();
$comm_time = array();
if (isset($_GET['eid'])) {
  $eid = $_GET['eid'];
  $event = show_event($eid);
  if (count($event) > 0) {
    $time = show_time($eid);
    if (count($time) > 0) {
      $comm_time = get_common(array(), $time);
    }
  } else {
    header('Location: index.php');
  }
} else {
  header('Location: index.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
    <title>Event Detail</title>
  </head>
  <body>
  <p><a href="event_list.php">Back</a></p>
<?php
if(isset($_GET['msg'])){
    if($_GET['msg'] == 'done'){
        echo "<p class='alert alert-success'>Time Picked.</p>";
    }
}
?>
  <h2>Event: <?=$event[0]['ename']?></h2>
  <p><?=$event[0]['enote']?></p>
  <h3>Code</h3>
  <p><?=$event[0]['ecode']?></p>
  <h3>Common Time:</h3>
  <ul>
<?php 
$list = '';
if (count($comm_time) > 0 ){
  foreach ($comm_time as $c) {
    $list .= "<li>{$c[0]} ~ {$c[1]}</li>";
  }
} else {
  $list = "<p>No Common Time...</p>";
}
echo $list;
?>
  </ul>
  <h3>Time Picked:</h3>
    <ul>
<?php
$list = '';
if (count($time) > 0 ){
  foreach ($time as $key => $p) {
    $p_detail = show_people($key);
    $list .= "<li><h4>{$p_detail[0]['pname']}</h4><ul>";
    foreach ($p as $t) {
      $list .= "<li>{$t[0]} ~ {$t[1]}</li>";
    }
    $list .= "</ul></li>";
  }
} else {
  $list = "<p>No Time Picked Yet</p>";
}
echo $list;
?>
    </ul>
<h3>Address of picking time for this event:</h3>
<p class='alert alert-info'><?php echo "http://".$_SERVER['SERVER_NAME']."/comm_time/pick_time.php?e=".$event[0]['eid']."&code=".$event[0]['ecode']?></p>
  </body>
</html>

