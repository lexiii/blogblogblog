<?php
class LoginController{
    public function login(){
        session_start();
        if(isset($_SESSION["id"])){
            //ALREADY LOGGED IN
            echo "Already logged in";
        }else{
            if(isset($_POST['username'])){
                //VALIDATION
                $username = $_POST['username'];
                $password = $_POST['password'];
                $validated = Login::validate($username,$password);
                //if error
                if($validated[0]==0){
                    $error = $validated[1];
                    $username = $validated[2];
                    $content = "views/login/login.php";
                    require_once('views/login/layout.php');
                }else{
                    $details = $validated[1]; // id->1
                    $_SESSION["id"]         = $details["uId"];
                    $_SESSION["username"]   = $details["username"];
                    $_SESSION["role"]       = $details["role"];
                    $redirect = "?controller=admin&action=home";
                    require_once('views/redirect.php');
                }
            }else{
                // LOGIN FORM
                $content = "views/login/login.php";
                require_once('views/login/layout.php');
            }
        }
    }
    public function logout(){
        session_start();
        session_destroy();
        $redirect = "?controller=login&action=login";
        require_once('views/redirect.php');
    }
    public function error(){
        echo "ERROR";
    }
}
?>
