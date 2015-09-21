<?php
    class Login{
        public static function validate($username, $password){
            $error = [];
           $db      = db::getinstance();
           $req     = $db->query("SELECT * FROM users ".
                    "WHERE username='$username' ".
                    "AND password='$password' ".
                    "LIMIT 1");
//           $req->bindParam(':name',$username);
//           $req->bindParam(':password',$password);

           $req -> execute();
           $result = $req -> fetch();
           if(!$result)
               $error[] ='Incorrect Login';

            if(count($error)!=0){
                return [0,$error,$username];
            }else{
                return [1,$result];
            }
        }
    }
?>
