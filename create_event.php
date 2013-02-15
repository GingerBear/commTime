<?php
require_once('function.php');
define("C_CODE", 'commtime');

$ename = '';
$ecode = 0;
if (isset($_POST['ename']) && isset($_POST['enote']) && isset($_POST['c_code'])){
  if ($_POST['c_code'] == C_CODE) {
    $ename = $_POST['ename'];
    $enote = $_POST['enote'];
    $eid = add_event($ename, $enote);
    header('Location: event_detail.php?eid='.$eid);

    // generate a link that will link to picking time page whick will to use for send email.

  } else {
    header('Location: index.php?msg=COIV');
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
    <title>create_event</title>
  </head>
  <body>
<h2>Create Event</h2>
<p><a href="index.php">Back</a></p>
<form action="create_event.php" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
  <p><label>Event Name:</label><input type="text" name="ename" value=""/></p>
  <p><label>Message(optional):</label><textarea type="text" name="enote" value="" cols=50 rows=10></textarea></p>
  <p><label>Code For Create Event:</label><input type="text" name="c_code" value=""/></p></p>
  <p><input class="btn btn-primary" type="submit" value="Submit"/></p>
</form>
  </body>
</html>
