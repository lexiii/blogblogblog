<?php
$roleSelect = "";
foreach($roles as $role){
    if($role['id']==$user['role'])
        $sel = "selected";
    else
        $sel = "";
//    $sel = ($roles['id']==$user['role'])?"selected":"";

    $roleSelect .= "<option value='".$role['id']."' ".$sel.">".$role['role']."</option>";

}
if(isset($success)){
    $msg = '<div class="alert alert-success" role="alert">Successfully updated user!</div>';
}else if(isset($err)){
    $msg = '<div class="alert alert-danger" role="alert">';
    foreach($err as $error){
        $msg .= $error."<br/>";
    }
    $msg .= "</div>";
}else{
    $msg = "";
}
?>
<div class="row">
  <div class="col-md-4">
  <?php echo $msg; ?>
    <form action="?controller=admin&action=users" method="post">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" name='username' id="username" value="<?php echo $user['username']; ?>">
            <input type="hidden" name='id' value="<?php echo $user['aId']; ?>">
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label for="firstName">First Name</label>
                    <input type="text" class="form-control" name='firstName' id="firstName" value="<?php echo $user['firstName']; ?>">
                </div>
                <div class="col-md-6">
                    <label for="lastName">Last Name</label>
                    <input type="text" class="form-control" name='lastName' id="lastName" value="<?php echo $user['lastName']; ?>">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="role">Role</label>
            <select id='role' name='role' class="form-control">
                <?php echo $roleSelect; ?>
            </select>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-8">
                    <label for="password">Password (optional)</label>
                    <input type="password" class="form-control" name='password1' id="password" value="">
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <label for="password">Password (again)</label>
                    <input type="password" class="form-control" name='password2' id="password" value="">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <input type='submit' class='btn btn-primary' value='save' />
                <a class='btn btn-warning pull-right' href='?controller=admin&action=users'>Back</a>
            </div>
        </div>
    </form>
</div>
</div>

