<ul class="list-group">
<?php
foreach($categories as $category){
?>
  <li class="list-group-item">
    <a href='?controller=view&action=category&p=<?php echo $category['id']; ?>'>
<?php echo $category['title']; ?>
</a>
</li>
    <?
}

?>
</ul>
