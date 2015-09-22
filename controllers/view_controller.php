<?php
    class ViewController{
        public function home(){
            $posts = View::latest();
            $content =  'views/view/home.php';
            require_once('views/layout.php');
        }
        public function post(){
            if(isset($_GET['p'])){
                $n=$_GET['p'];
            }else{
                $this::home();
                $n=0;
            }
            $post = View::post($n);
            // convert array to object to match other views;
            $post = json_decode(json_encode($post), FALSE);
            $tags = View::tags($post->id);
            $breadcrumbs = [ "Posts" => "?",
                $post->title => "a"];

            $content =  'views/view/post.php';
            require_once('views/layout.php');
        }

        public function author(){
            if(isset($_GET['p'])){
                $n=$_GET['p'];

                $posts = View::author($n);

                $breadcrumbs = [ "Home" => "?",
                    "Authors" => "?controller=view&action=author",
                    $posts[0]->firstName." ".$posts[0]->lastName => "a"];
                $content =  'views/view/home.php';
            }else{
                $n=0;
                $breadcrumbs = [ "Home" => "?",
                    "Authors" => "?controller=view&action=author"];
                $authors = View::authorList();
                $content =  'views/view/authors.php';
            }
            require_once('views/layout.php');


        }
        public function category(){
            if(isset($_GET['p'])){
                $n=$_GET['p'];
                $posts = View::category($n);
                $breadcrumbs = [ "Home" => "?",
                    "Categories" => "?controller=view&action=category",
                    $posts[0]->cTitle => "a"];

                $content =  'views/view/home.php';
            }else{
                $n=0;
                $breadcrumbs = [ "Home" => "?",
                    "Categories" => "?controller=view&action=category"];
                $categories = View::categoryList();
                $content =  'views/view/categories.php';
            }

            require_once('views/layout.php');

        }


        public function tag(){
            if(isset($_GET['p'])){
                $n=$_GET['p'];
                $posts = View::byTag($n);
                $tag   = View::singleTag($n);
                $breadcrumbs = [ "Home" => "?",
                    "Tags" => "?controller=view&action=tag",
                    $tag['tag'] => $tag['tId']];
                //var_dump($posts);

                $content =  'views/view/home.php';
            }else{
                $breadcrumbs = [ "Home" => "?",
                    "Tags" => ""];
                $tags = View::tagList();
                $content =  'views/view/tags.php';
            }

           require_once('views/layout.php');

        }

        public function error(){
            echo "ERROR!";
        }
    }

?>
