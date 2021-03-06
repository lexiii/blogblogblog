<?php
$auth = "";
foreach($authors as $author){
    if(isset($newPost))
        $sel = ($_SESSION['id']==$author['id'])?" selected":"";
    else
        $sel = ($author['id']==$post['authorId'])?" selected":"";
    $auth .=  "<option value='".$author['id']."'".$sel.">".$author['firstName']." ".$author['lastName']."</option> \n";
}
$authorDisabled = $_SESSION['role']==1?"":"disabled";
foreach($categories as $category){
    $sel = ($category['id']==$post['categoryId'])?" selected":"";
    $cats .=  "<option value='".$category['id']."'".$sel.">".$category['title']."</option> \n";
}
$tagg = [];
if($tags){
    foreach($tags as $tag){
        $tagg[] =  $tag['title'];
    }
}
$tagSelector = "";
foreach($tagList as $tag){
    if(!in_array($tag['title'],$tagg))
    $tagSelector .= "<div class='tag makeTag'>#".$tag['title']."</div>";
}
$tagg = json_encode($tagg);
?>
    <form action="<?php echo $formAction; ?>" method="post">
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
            <textarea class="form-control" id='postBox' rows="9" name='post'><?php echo $post['post']; ?></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5">
            <h3><small>User</small></h3>
            <select name='author' class="form-control" <?php echo $authorDisabled; ?>>
                <?php echo $auth; ?>
            </select>
        </div>
        <div class="col-md-5">
            <h3><small>Category</small></h3>
            <select name='category' class="form-control">
                <?php echo $cats; ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <h3><small>Tags</small></h3>
            <input type='text' class='form-control' id='tagEnter' placeholder='Enter tag and press enter'  value='' />
            <input type='hidden' id='tagSend' name='tags' value='<?php echo $tagg; ?>' />
            <div id='tagPlace'>
            </div>
        </div>
        <div id='tagSelector' class="col-md-4 tagSelector">
<h2><small>Existing Tags</small></h2>
            <?php echo $tagSelector; ?>
        </div>
    </div>
<br/>
<input type="submit" value="Save" class='btn btn-default'/>
<?php if(isset($editing)){ ?>
    <a href='?controller=admin&action=delete&p=<?php echo $post['id']; ?>' class='btn btn-danger' id='deleteButton'>Delete</a>
<?php } ?>
</form>
