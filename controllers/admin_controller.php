<?php
class AdminController{
    public function home(){
        self::sessionCheck();
        $content = "views/admin/home.php";
        require_once('views/admin/layout.php');
    }

    public function posts(){
        self::sessionCheck();
        $content = "views/admin/posts.php";
        require_once('views/admin/layout.php');
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
