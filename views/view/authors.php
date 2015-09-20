<ul class="list-group">
<?php
foreach($authors as $author){
?>
  <li class="list-group-item">
    <a href='?controller=view&action=author&p=<?php echo $author['id']; ?>'>
<?php echo $author['firstName']." ".$author['lastName']; ?>
</a>
</li>
    <?
}

?>
</ul>
