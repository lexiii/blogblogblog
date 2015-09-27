<?php
$roleSelect = "";

foreach($roles as $role){

    if($role['id']==$user['role'])
        $sel = "selected";
    else
        $sel = "";

    $roleSelect .= "<option value='".$role['id']."' ".$sel.">".$role['role']."</option>";
}

$backCancel = isset($new)?"Cancel":"Back";
$saveCreate = isset($new)?"Create":"Save";
$formAction = isset($new)?"?controller=admin&action=newUser":"?controller=admin&action=users";
if(!isset($new)){
    $delete = "<a href='?controller=admin&action=deleteUser'>";
}

if(isset($success)){
    $updateCreate = isset($new)?"created":"updated";
    $msg = '<div class="alert alert-success" role="alert">Successfully ".$updateCreate." user!</div>';
}else if(isset($err)){
    $msg = '<div class="alert alert-danger" role="alert"><ul>';

    foreach($err as $error){
            $msg .= "<li>".$error."</li>";
    }

    $msg .= "</ul></div>";
}else{
    $msg = "";
}
?>

<div class="row">
  <div class="col-md-4">
  <?php echo $msg; ?>
<form action="<?php echo $formAction; ?>" method="post">
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
            <input type='submit' class='btn btn-primary' value='<?php echo $saveCreate; ?>' />
                <a class='btn btn-warning pull-right' href='?controller=admin&action=users'><?php echo $backCancel; ?></a>
            </div>
        </div>
    </form>
</div>
</div>

