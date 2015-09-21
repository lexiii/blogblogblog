<?php
if(isset($error)){
$errorMsg = "<div class='alert alert-danger' role='alert'><strong>";
    foreach($error as $er){
        $errorMsg .= $er."<br/>";
    }
$uname = "value='$username'";
$errorMsg .= "</strong></div>";
}else{
    $uname = "";
    $errorMsg = "";
}
?>
<div class="container" style="margin-top:30px">
<div class="col-md-4">
</div>
<div class="col-md-4">
<?php echo $errorMsg; ?>
    <div class="panel panel-default">
  <div class="panel-heading"><h3 class="panel-title"><strong>Sign In </strong></h3></div>
  <div class="panel-body">
   <form role="form" action="?controller=login&action=login" method='post'>
  <div class="form-group">
    <label for="exampleInputEm">Username</label>
    <input type="text" class="form-control" name='username' id="username" placeholder="Username" <?php echo $uname; ?>>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password <a href="/sessions/forgot_password">(forgot password)</a></label>
    <input type="password" class="form-control" id="password" name='password' placeholder="Password">
  </div>
  <button type="submit" class="btn btn-sm btn-default">Sign in</button>
<a href='?' class='pull-right'>Back</a>
</form>
  </div>
</div>
</div>
</div>
