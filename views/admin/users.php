<?php
$userList = "";
foreach($users as $user){
    $userList .= "<li class='list-group-item'>".
        "<a href='?controller=admin&action=users&p=".$user['id']."'>".
        $user['firstName']." ".$user['lastName'].
        "</a><span class='label label-default pull-right'>".$user['role']."</span></li>";
}
?>
<div class="row">
    <div class="col-md-4">
        <ul class="list-group">
            <?php echo $userList; ?>
<br/>
<a class='btn btn-default' href='?controller=admin&action=newUser'>New User</a>
        </ul>
    </div>
</div>

