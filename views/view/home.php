<?php
$multiple = true;
foreach ($posts as $post){
    $tags = $post->tags;
    include('post.php');
}
?>
