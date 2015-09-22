<?php
$i = 0;
$rows = $posts[0]->rows;
if($rows>$per){
    $pages = ceil($rows/$per);
    $pos   = $s+$per;
    $cur   = $s/10+1;

    // PREVIOUS
    if($s>0){
        $prev = '<li><a href="?controller=admin&action=posts&s='.($cur-2).'" aria-label="Previous">';
    }else{
        $prev = '<li class="disabled"><a href="#" aria-label="Previous">';
    }

    // NEXT
    if($postId<$rows){
        $next = '<li><a href="?controller=admin&action=posts&s='.($cur).'" aria-label="Previous">';
    }else{
        $next = '<li class="disabled"><a href="#" aria-label="Previous">';
    }

    // PAGES
    $pag = "";
    for($p=1;$p<$pages+1;$p++){
        if($p==$cur){
            $pag .= '<li class="active"><a href="#">'.$p.'</a></li>';
        }else{
            $pag .= '<li><a href="?controller=admin&action=posts&s='.($p-1).'">'.$p.'</a></li>';
        }
    }
}
foreach($posts as $post){
    $hl = "";
    if(isset($_GET['h'])){
        if($i == 0){
            $hl = "fadeIn";
        }
    }
?>
    <div class="panel panel-default <?php echo $hl; ?>">
  <div class="panel-body">
  <a href='?controller=admin&action=edit&p=<?php echo $post->id; ?>'>
  <?php   echo $post->title; ?>
</a>
</div>
</div>
<?php
    $i++;
}

if($rows>$per){
?>


<nav>
  <ul class="pagination">
  <?php echo $prev; ?>
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    <?php echo $pag; ?>
  <?php echo $next; ?>
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  </ul>
</nav>
<?php
}
?>
