<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="css/main.css">

</head>
<body>
<?php
$settings = $GLOBALS['settings'];
require('views/view/header.php');
?>
<div class='container' id='mainContent'>
<div class="row">
  <div class="col-md-9" style='overflow:hidden;'>
<?php
if(!isset($breadcrumbs)){
    $breadcrumbs = ["Home"=>"?"];
}
$last = end($breadcrumbs);
?>
<ol class="breadcrumb">
<?php
foreach($breadcrumbs as $name => $link ){
if($link == $last){
    echo  "<li class='active'>$name</li>";
}else{
    echo  "<li><a href='$link'>$name</a></li>";
}


}

?>
</ol>
<?php

require($content);
?></div>
  <div class="col-md-3">
  <?php require('sidebar.php'); ?>
</div>
</div>
</div>

<div id='footer'>
<div class='container'>
<div class="row">
  <div class="col-md-6" style='overflow:hidden;'>
<p>footer</p>
</div>
  <div class="col-md-3" style='overflow:hidden;'>
<p class='pull-right'><a href="?controller=login&action=login">Login</a></p>
</div>
</div>
</div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>
