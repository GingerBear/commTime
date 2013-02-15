<?php
require_once('function.php');
$event_list = show_event();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
    <title>Event List</title>
      </head>
  <body>
<h2>Event List</h2>
<p><a href="index.php">Back</a></p>
    <table>
    <tr><th>Event</th></th></th></tr>
<?php
$list = '';
foreach ($event_list as $e) {
  $list .= "<tr><td class='span4'><a href='event_detail.php?eid={$e['eid']}'>{$e['ename']}</a></td><td class='span2'><a href='pick_time.php?e={$e['eid']}'>Pick Time</a></td></tr>";
}
echo $list;
?>
    </table>
  </body>
</html>
