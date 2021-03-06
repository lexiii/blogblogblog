<?php
    class ViewController{
        public function home(){
            $s       = isset($_GET['s'])?$_GET['s']:0;
            $s       = $s*10;
            $per     = 10;
            $posts   = View::getLatest($per,$s);
            $content = 'views/view/home.php';
            require_once('views/layout.php');
        }
        public function post(){
            $role    = $this->getRole();
            if(isset($_GET['p'])){
                $n=$_GET['p'];
            }else{
                $this->home();
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
                $s       = isset($_GET['s'])?$_GET['s']:0;
                $s       = $s*10;
                $per     = 10;
                $posts = Author::getLatest($per,$s,$n);
                $link2  = "?controller=view&action=author&p=".$n."&s=";

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
                $s       = isset($_GET['s'])?$_GET['s']:0;
                $s       = $s*10;
                $per     = 10;
                $posts = Category::getLatest($per,$s,$n);
                $link2  = "?controller=view&action=category&p=".$n."&s=";

                //$posts = View::category($n);
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
                $s       = isset($_GET['s'])?$_GET['s']:0;
                $s       = $s*10;
                $per     = 10;
                $posts = Tag::getLatest($per,$s,$n);
                $link2  = "?controller=view&action=tag&p=".$n."&s=";

                $tag   = View::singleTag($n);
                $breadcrumbs = [ "Home" => "?",
                    "Tags" => "?controller=view&action=tag",
                    $tag['tag'] => $tag['tId']];

                $content =  'views/view/home.php';
            }else{
                $breadcrumbs = [ "Home" => "?",
                    "Tags" => ""];
                $tags = View::tagList();
                $content =  'views/view/tags.php';
            }

           require_once('views/layout.php');

        }

        public function getRole(){
            session_start();
            if(isset($_SESSION["role"])){
                return $_SESSION['role'];
            }
            return -1;
        }

        public function error(){
            echo "ERROR!";
        }
    }

?>
