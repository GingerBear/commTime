<?php
require_once('function.php');
$pname = '';
$ename = '';
$enote = '';
$code = '';
$pid = 0;
$eid = 0;
$p;
$e;
if (isset($_POST['pid']) && isset($_POST['eid']) && isset($_POST['time_fd']) && isset($_POST['time_td']) && isset($_POST['time_ft']) && isset($_POST['time_tt']) && isset($_POST['ecode'])) {
  $pid = $_POST['pid'];
  $eid = $_POST['eid'];
  $time_fd = $_POST['time_fd'];
  $time_ft = $_POST['time_ft'];
  $time_td = $_POST['time_td'];
  $time_tt = $_POST['time_tt'];
  $ecode = $_POST['ecode'];
  if (verify_code($eid, $ecode)) {
    for ($i = 0; $i < count($time_fd); $i++) {
      if ($time_fd[$i] == ""){continue;}
    pick_time($ecode, $pid, $eid, date("Y-m-d H:i:s", strtotime($time_fd[$i]." ".$time_ft[$i])), date("Y-m-d H:i:s", strtotime($time_td[$i]." ".$time_tt[$i])));
      //echo $i . ": From ". date("Y-m-d H:i:s", strtotime($time_fd[$i]." ".$time_ft[$i])) . " To " . date("Y-m-d H:i:s", strtotime($time_td[$i]." ".$time_tt[$i])) . "<br>";
    }
    Header('Location: event_detail.php?eid='.$eid.'&msg=done');
  } else {
    Header('Location: index.php?err=COIV');
  }
} else if (isset($_GET['e'])) {
  $eid = $_GET['e'];
  if (isset($_GET['code'])){
    $code = $_GET['code'];
  }
  $e = show_event($eid);
  if (count($e) > 0) {
    $ename = $e[0]['ename'];
    $enote = $e[0]['enote'];
  } else {
    Header('Location: index.php?err=WREV');
  }
} else {
  Header('Location: index.php?err=NOEV');
}
?>
<!DOCTYPE html> 
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" type="text/css" href="js/jquery.timepicker.css" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="js/lib/base.css" />
    <style type="text/css" media="screen">
      .datepair input {
        margin: 0;
      }
      .wrapper {
        margin: 0 auto;
        width: 600px;
      }
    .holder {
        padding: 20px;
        width: 550px;
}
      .sub-p {
        text-align: right;
      }   
      .banner {
        margin: 0;
        background: #eee;
        padding: 10px;
        }
    .title {
        margin-top: 0;
        }
    </style>
    <title>Pick a Time</title>
  </head>
  <body>
    <div class="wrapper img-polaroid">
    <p class='banner'>Pick Time for</p>
<div class='holder'>
    <h3 class='title'><b><?=$ename?></b></h3>
    <p class='alert alert-info'><?=$enote?></p>
    <form action="pick_time.php" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
    <p>Name: <select name="pid">
      <?php 
        $people_list = show_people();
        $people = '';
        foreach ($people_list as $e) {
          $people .= "<option";
          if (isset($_GET['p'])){
            if ($e['pid'] == $_GET['p']) {
              $people .= " selected";
            }
          }
          
          $people .= " value='{$e['pid']}'>{$e['pname']}</a></option>";
        }
        echo $people;
      ?>
    </select></p>
    <input type="hidden" name="eid" value="<?=$eid?>"/>
    <div class='time-holder'>
      <p class="datepair alert" data-language="javascript">
        <button type="button" class="close" data-dismiss="alert">&times;</button>From 
		  	<input type="text" name="time_fd[]" class="date start" />
		  	<input type="text" name="time_ft[]" class="time start" /> to
        <input type="text" name="time_td[]" class="time end" />
		  	<input type="text" name="time_tt[]" class="date end" />
      </p>
      <p class="datepair alert" data-language="javascript">
        <button type="button" class="close" data-dismiss="alert">&times;</button>From 
		  	<input type="text" name="time_fd[]" class="date start" />
		  	<input type="text" name="time_ft[]" class="time start" /> to
        <input type="text" name="time_td[]" class="time end" />
		  	<input type="text" name="time_tt[]" class="date end" />
      </p>
    </div>
    
    <p><button class="more-time btn">More Time</button></p>
    <p>Event Code: <input type="text" rel="popover" data-placement="right" data-content="Please Input Code" data-title="Error" name="ecode" value="<?=$code?>"/></p>
      <p class='sub-p'><input type="submit" class="submit btn btn-primary" value="Submit"/></p>

    </form>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery.timepicker.min.js"></script>
    <script type="text/javascript" src="js/lib/base.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <script language="javascript" type="text/javascript">
        var rebind = function() {          
          $(".script-holder").empty();
          $(".script-holder").append("<script src='js\/lib\/datepair.js'><\/script>");
        }
        var timeInput = $(".datepair:first")[0].outerHTML;
        $(".more-time").click(function(e){
          e.preventDefault();
          $(timeInput).appendTo('.time-holder');
          rebind();
          return false;
        });

        $('html').click(function() {
          $("input[name='ecode']").popover('hide');
         });
        
        $(".alert").alert()

          $("input[name='ecode']").click(function(event){
            event.stopPropagation();
          });

        $(".submit").click(function(event){
          event.stopPropagation();
          if($("input[name='ecode']").val().length == 0) {
            //alert("Please Input Event Code");
            $("input[name='ecode']").focus();
            $("input[name='ecode']").popover('show');
            return false;
          }
          return confirm("Are you sure?");
        });
        
  </script>


    <div class="script-holder">
      <script src="js/lib/datepair.js"></script>
    </div>
    </div>
</div>
  </body>
</html>
