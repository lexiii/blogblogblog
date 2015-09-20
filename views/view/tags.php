<ul class="list-group">
<?php
foreach($tags as $tag){
?>
  <li class="list-group-item">
    <a href='?controller=view&action=tag&p=<?php echo $tag['id']; ?>'>
<?php echo $tag['title']?>
</a>
</li>
    <?
}

?>
</ul>
