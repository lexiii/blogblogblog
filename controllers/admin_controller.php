<?php
class AdminController{
    public function home(){
        self::sessionCheck();
        $content = "views/admin/home.php";
        require_once('views/admin/layout.php');
    }

    public function posts(){
        self::sessionCheck();
        $posts = View::latest(10);
        $content = "views/admin/posts.php";
        require_once('views/admin/layout.php');
    }

    public function edit(){
        self::sessionCheck();
        if(isset($_POST['title'])){
            $title      = $_POST['title'];
            $id         = $_POST['id'];
            $post       = $_POST['post'];
            $tags       = $_POST['tags'];
            $tags       = str_replace("#","",$tags);
            $tags = json_decode($tags);

            $tagList = View::tags($id);
            Admin::sortTags($tags);
            Admin::hasTags($tags,$id);
            Admin::removeTags($tags,$id,$tagList);

            $redirect = "?controller=admin&action=edit&p=".$id;
            require_once('views/redirect.php');
        }else{
            if(!isset($_GET['p'])){
                $redirect   = "?controller=admin&action=posts";
                require_once('views/redirect.php');
            }else{
                $n          = $_GET['p'];
                $post       = View::post($n);
                $authors    = Admin::getAuthors();
                $categories = Admin::getCategory();
                $tagList    = View::tagList();
                $tags       = View::tags($n);
                $content    = "views/admin/edit.php";
                require_once('views/admin/layout.php');
                //echo $n;
            }
        }
    }

    public function error(){
        echo "error";
    }

    public function sessionCheck(){
        session_start();
        if(isset($_SESSION["id"])){
            return 1;
        }else{
            $redirect = "?controller=login&action=login";
            require_once('views/redirect.php');
            die();
        }
    }
}

?>
