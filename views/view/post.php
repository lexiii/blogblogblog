<?php
$string = $post->post;
if($multiple){
    if (strlen($string) > 500) {
        $stringCut = substr($string, 0, 500);
        $string = substr($stringCut, 0, strrpos($stringCut, ' '))."... <a href='?controller=view&action=post&p=".$post->id."'>Read More</a>";
    }
        $editLink = "";
}else{
    if($role==3||$role==1){
        $editLink = "<br/><br/>[<a href='?controller=admin&action=edit&p=".$post->id."'>EDIT</a>]";
    }else{
        $editLink = "";
    }
}
?>

<h3 style='border-bottom:1px dotted grey;padding-bottom:3px'>
    <a href="?controller=view&action=post&p=<?php echo $post->id; ?>">
        <?php echo $post->title; ?>
    </a>
    <small class='pull-right'>
        By <a href='?controller=view&action=author&p=<?php echo $post->authorId; ?>'><?php echo $post->firstName." ".$post->lastName; ?></a>
    </small>
</h3>
<p class='text-justify' style='text-indent:20px;'><?php echo $string; ?></p>
<p class='pull-right'>
    <small>
        Posted in <a href="?controller=view&action=category&p=<?php echo $post->categoryId; ?>"><?php echo $post->cTitle; ?></a>
        on <?php echo $post->date; ?>
         by <a href='?controller=view&action=author&p=<?php echo $post->authorId; ?>'><?php echo $post->firstName." ".$post->lastName; ?></a>
    </small>
</p>
<?php
if($tags){
    foreach($tags as $tag){
        ?>
        <em> <a href='?controller=view&action=tag&p=<?php echo $tag['id']; ?>'>#<?php echo $tag['title'];?></a> </em>
        <?php
    }
}
echo $editLink;
?>
