<?php

$rows = $posts[0]->rows;
if($rows>$per){
    $pages = ceil($rows/$per);
    $pos   = $s+$per;
    $cur   = $s/10+1;
    if(!isset($link2))
        $link2  = "?controller=view&action=home&s=";
    $link = $link2;

    // PREVIOUS
    if($s>0){
        $prev = '<li><a href="'.$link.($cur-2).'" aria-label="Previous">';
    }else{
        $prev = '<li class="disabled"><a href="#" aria-label="Previous">';
    }

    // NEXT
    if($postId<$rows){
        $next = '<li><a href="'.$link.($cur).'" aria-label="Previous">';
    }else{
        $next = '<li class="disabled"><a href="#" aria-label="Previous">';
    }

    // PAGES
    $pag = "";
    for($p=1;$p<$pages+1;$p++){
        if($p==$cur){
            $pag .= '<li class="active"><a href="#">'.$p.'</a></li>';
        }else{
            $pag .= '<li><a href="'.$link.($p-1).'">'.$p.'</a></li>';
        }
    }
}
$multiple = true;
foreach ($posts as $post){
    $tags = $post->tags;
    include('post.php');
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
