<?php
    function call($controller, $action) {
        require_once('controllers/'. $controller . '_controller.php');

        switch($controller){
        case 'view':
            require_once('models/view.php');
            $controller = new ViewController();
            break;
        case 'login':
            require_once('models/login.php');
            $controller = new LoginController();
            break;
        case 'admin':
//            require_once('models/login.php');
            $controller = new AdminController();
            break;
        }
        $controller->{ $action }();

    }
$controllers = array(   'view'=>['home','post','author','category','tag','error'],
                        'login'=>['login','submit','register','forgot','logout','error'],
                        'admin'=>['home','posts','new','edit','error']);

if(array_key_exists($controller,$controllers)){
    if(in_array($action,$controllers[$controller])){
        call($controller,$action);
    }else{
        call($controller,'error');

    }
}else{
    call('view','error');
}

?>
