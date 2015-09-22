<?php
$auth = "";
foreach($authors as $author){
    $sel = ($author['id']==$post['authorId'])?" selected":"";
    $auth .=  "<option value='".$author['id']."'".$sel.">".$author['firstName']." ".$author['lastName']."</option> \n";
}
foreach($categories as $category){
    $sel = ($category['id']==$post['categoryId'])?" selected":"";
    $cats .=  "<option value='".$category['id']."'".$sel.">".$category['title']."</option> \n";
}
$tagg = "";
foreach($tags as $tag){
    $tagg .= "#".$tag['title'];
    if($tag != end($tags))
        $tagg.=", ";
}
?>
<form action="?controller=admin&action=edit" method="pos">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <h3><small>Title</small></h3>
                <input type='text' class='form-control' name='title' value='<?php echo $post['title']; ?>' />
                <input type='hidden'  name='id' value='<?php echo $post['id']; ?>' />
            </div>
        </div>
    </div>
    <h3><small>Post</small></h3>
    <div class="row">
        <div class="col-md-10">
            <textarea class="form-control" rows="9" name='post'><?php echo $post['post']; ?></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5">
            <h3><small>User</small></h3>
            <select class="form-control">
                <?php echo $auth; ?>
            </select>
        </div>
        <div class="col-md-5">
            <h3><small>Category</small></h3>
            <select class="form-control">
                <?php echo $cats; ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <h3><small>Tags</small></h3>
            <input type='text' class='form-control' name='tags' value='<?php echo $tagg; ?>' />
        </div>
    </div>
<br/>
<input type="submit" value="edit" class='btn btn-default'/>
</form>
