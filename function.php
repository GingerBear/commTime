<?php
require_once('database.php');

function show_people($pid = FALSE) {
  $db = new Database();
  if ($pid == FALSE) {
    $sql = "SELECT pid, pname FROM people";
  } else {
    $sql = "SELECT pid, pname FROM people WHERE pid = {$pid}";
  }
  $db->query($sql);
  $people = array();
  $i = 0;
  while ($db->nextRecord()) {
    $people[$i++] = $db->Record; 
  }
  return $people;
}
function add_event($ename = FALSE, $enote = ''){
  if ($ename != FALSE) {
    $ecode = rand(1000, 9999);
    $db = new Database();
    $db->connect();
    $sql = "INSERT INTO event (ename, enote, ecode) VALUES ('{$ename}', '{$enote}', {$ecode})";
    if ($db->query($sql)) {
      return $db->lastId();
    } else {
      error('INFA');
      return FALSE;
    }    
  } else {
    error('PAIN');
    return FALSE;
  }
}

function show_event($eid = FALSE){
  $db = new Database();
  if ($eid == FALSE) {
    $sql = "SELECT * FROM event ORDER BY eid DESC";
  } else {
    $sql = "SELECT * FROM event WHERE eid = {$eid}";
  }
  $db->query($sql);
  $events = array();
  $i = 0;
  while ($db->nextRecord()) {
    $events[$i++] = $db->Record; 
  }
  return $events;
}

function pick_time($ecode = FALSE, $pid = FALSE, $eid = FALSE, $time_from = FALSE, $time_to = FALSE){
  if ($ecode != FALSE && $pid != FALSE && $eid != FALSE && $time_from != FALSE && $time_to != FALSE) {
    $db = new Database();
    $db->connect();
    if (!verify_code($eid, $ecode)){
      error('COIV');
      return FALSE;
    }
    $sql = "INSERT INTO time (pid, eid, etime_from, etime_to) VALUES ({$pid}, {$eid}, '{$time_from}', '{$time_to}')";
    if ($db->query($sql)) {
      return TRUE;
    } else {
      error('INFA');
      return FALSE;
    }    
  } else {
    error('PAIN');
    return FALSE;
  }
}

function verify_code($eid = FALSE, $ecode = FALSE){
  if ($eid != FALSE && $ecode != FALSE) {
    $db = new Database();
    $db->connect();
    $sql = "SELECT * FROM event WHERE eid = {$eid} AND ecode = '{$ecode}'";
    $db->query($sql);
    return $db->numRows() == 1 ? TRUE : FALSE;
  } else {
    error('PAIN');
    return FALSE;
  }
}

function show_time($eid = FALSE){
  /* Show time picked for a event. */
  if ($eid != FALSE ) {
    $db = new Database();
    $db->connect();
    $sql = "SELECT pid, etime_from, etime_to FROM time WHERE eid = {$eid} ORDER BY pid";
    $db->query($sql);
    $time_arr = array();
    $i = 0;
    $pid = 0;
    while ($db->nextRecord()) {
      if($pid != $db->Record['pid']) {
        $i = 0;
        $pid = $db->Record['pid'];
      }
      $time_arr[$pid][$i++] = array($db->Record['etime_from'], $db->Record['etime_to']);
    }
    return $time_arr;
  } else {
    error('PAIN');
    return FALSE;
  }
}

function get_common($comm_time = array(), $time){
  /* calculate the commont time by a array of time period, which is a pair from a time to another. */
  /* return common time period(s). */
  if (count($comm_time) < 1) {
    $comm_time = array_shift($time);
  } 
  if (count($time) > 0) {
    $comm = calculate_common($comm_time, array_shift($time)); /* get common time between two people */
    $result = get_common($comm, $time);
    return $result;
  } else {
    return $comm_time;
  }
}

function calculate_common($arr1, $arr2) {
  /* Calculate the common time between two people */
  $comm = array();
  foreach ($arr1 as $a1) {
    foreach ($arr2 as $a2) {
      if (!(dt_comp($a1[0], $a2[1]) > 0 || dt_comp($a1[1], $a2[0]) < 0)){
        $from = dt_comp($a1[0], $a2[0]) >= 0 ? $a1[0] : $a2[0];
        $to = dt_comp($a1[1], $a2[1]) <= 0 ? $a1[1] : $a2[1];
        array_push($comm, array($from, $to));
      }
    }
  }
  return $comm;
}

function dt_comp($dt1, $dt2) {
  if ($dt1 == $dt2) {
    return 0;
  }
  return strtotime($dt1) > strtotime($dt2) ? 1 : -1;
}

function error($eno) {
  switch($eno){
  case('PAIN'):     $msg = "Paramater incomplele"; break;
  case('COIV'):     $msg = "Code Invalid"; break;
  case('INFA'):     $msg = "Insert Faild"; break;
  default:          $msg = "Unknow Error"; break;
  }
  echo "ERROR: " . $msg;
}

//echo "<pre>";
//print_r(show_event(3));
//pick_time(9782, 1, 3, '2013-1-12 12:12:12', '2013-1-12 13:12:12');
//pick_time(9782, 3, 3, '2013-1-12 14:12:12', '2013-1-12 15:12:12');
//print_r(show_time(3));
//print_r(get_common(array(), show_time(3)));
//
//echo strtotime('2013-1-12 12:12:12');
//echo "<br>";
//echo strtotime('2013-1-12 13:12:12');
//echo "<br>";
//echo strtotime('2013-1-12 13:13:59');
//echo "</pre>";
?>
