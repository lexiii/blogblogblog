<?php
foreach($posts as $post){
?>
<div class="panel panel-default">
  <div class="panel-body">
  <a href='?controller=admin&action=edit&p=<?php echo $post->id; ?>'>
  <?php   echo $post->title; ?>
</a>
</div>
</div>
<?php
}

?>
