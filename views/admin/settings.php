<?php
$form = "";
foreach($settings as $setting){
    $form .=  '<div class="form-group">'.
        '<label for="'.$setting['setting'].'">'.$setting['human'].'</label>'.
        '<input type="text" class="form-control" id="'.$setting['setting'].'" placeholder="" value="'.$setting['value'].'">'.
        '</div>';
}
$nav = "";
foreach($categories as $cat){
    $current = $cat['id']==$category?"class='active'":"";
    $nav .= ' <li role="presentation" '.$current.'><a href="?controller=admin&action=settings&p='.$cat['id'].'">'.ucfirst($cat['category']).'</a></li> ';
}
?>
<ul class="nav nav-pills">
        <?php
            echo  $nav;
        ?>
</ul>
<br/>
<div class="row">
    <div class="col-md-5">
    <form>
        <?php
            echo  $form;
        ?>
<input type='submit' class='btn btn-default pull-right' value='UPDATE' />
    </form>
    </div>
</div>
