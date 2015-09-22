<?php
class AdminController{
    public function home(){
        self::sessionCheck();
        $content = "views/admin/home.php";
        require_once('views/admin/layout.php');
    }

    public function posts(){
        self::sessionCheck();
        $s = isset($_GET['s'])?$_GET['s']:0;
        $s = $s*10;
        $per = 10;
        $posts = View::latest($per,$s);
        $content = "views/admin/posts.php";
        require_once('views/admin/layout.php');
    }

    public function newPost(){
        self::sessionCheck();
        if(isset($_POST['title'])){
            $title    = $_POST['title'];
            $post     = $_POST['post'];
            $category = $_POST['category'];
            $author   = $_POST['author'];
            $tags     = $_POST['tags'];
            $tags     = str_replace("#","",$tags);
            $tags     = json_decode($tags);

            $id = Admin::newPost($title, $post, $category, $author);

            foreach($tags as $tag){
                $tagId = Admin::isTag($tag);
                Admin::addTag($tagId,$id);
            }
            $redirect = "?controller=admin&action=posts&h=1";
            require_once('views/redirect.php');
        }else{
            $authors    = Admin::getAuthors();
            $categories = Admin::getCategory();
            $tagList    = View::tagList();
            $formAction = "?controller=admin&action=newPost";
            $content    = "views/admin/edit.php";
            require_once('views/admin/layout.php');
        }
    }
    public function edit(){
        self::sessionCheck();
        if(isset($_POST['title'])){
            $title    = $_POST['title'];
            $id       = $_POST['id'];
            $post     = $_POST['post'];
            $category = $_POST['category'];
            $author   = $_POST['author'];
            $tags     = $_POST['tags'];
            $tags     = str_replace("#","",$tags);
            $tags     = json_decode($tags);

            $tagList = View::tags($id);
            if(count($tags)!=0){
                Admin::sortTags($tags);
                Admin::hasTags($tags,$id);
            }
            Admin::removeTags($tags,$id,$tagList);

            Admin::saveChanges($id,$title,$post,$category,$author);

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
                $formAction = "?controller=admin&action=edit";
                require_once('views/admin/layout.php');
            }
        }
    }

    public function users($res = [0]){
        self::sessionCheck();
        if(isset($_POST['username'])){
            $update = Admin::updateUser($_POST);
                unset($_POST);
                $_GET['p']=$update[1];
            if($update[0]==1){
                $success = TRUE;
                $res = [1];
            }else{
                $err = $update[0];
                $res = [2,$err];
            }
                self::users($res);
        }else{
            if(isset($_GET['p'])){
                // SINGLE USER
                $id      = $_GET['p'];
                $user    = Admin::getUser($id);
                $roles   = Admin::getRoles();
                $content = "views/admin/edituser.php";
                switch($res[0]){
                case 1:
                    $success = TRUE;
                    break;
                case 2:
                    $err = $res[1];
                    break;
                }
                require_once('views/admin/layout.php');
                //var_dump($user);
            }else{
                // ALL USERS
                $users   = Admin::getUsers();
                $content = "views/admin/users.php";
                require_once('views/admin/layout.php');
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
