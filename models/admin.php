<?php
class Admin{
    public $id;
    public $categoryId;
    public $authorId;
    public $title;
    public $post;
    public $date;
    public $firstName;
    public $lastName;
    public $cTitle;

    public function __construct($id, $categoryId, $authorId, $title, $post, $date, $firstName, $lastName, $cTitle){
        $this->id           = $id;
        $this->categoryId   = $categoryId;
        $this->authorId     = $authorId;
        $this->title        = $title;
        $this->post         = $post;
        $this->date         = $date;
        $this->firstName    = $firstName;
        $this->lastName     = $lastName;
        $this->cTitle       = $cTitle;
    }

    public static function announce($str){
        //echo "$str <br/>";
        return;
    }
    public static function getAuthors(){
        $list = [];
        $db   = db::getinstance();
        $req  = $db->query("select * from authors ");
        foreach ($req->fetchall() as $authors){
            $list[]=[
                "id" => $authors['aId'],
                "firstName" => $authors['firstName'],
                "lastName"  => $authors['lastName']
            ];
        }
        return $list;
    }

    public static function isTag($tag){
        $db     = db::getinstance();
        $req    = $db->query("select * from tags WHERE tag = '".$tag."' LIMIT 1");
        $result = $req->fetch();
        if($result){
            self::announce("$tag exists");
            return $result['tId'];
        }
        self::announce("$tag does not exist");
        return false;

    }

    public static function getCategory(){
        $list = [];
        $db   = db::getinstance();
        $req  = $db->query("select * from categories ");
        foreach ($req->fetchall() as $categories){
            $list[]=[
                "id"       => $categories['cId'],
                "title"    => $categories['cTitle'],
                "lastName" => $authors['lastName']
            ];
        }
        return $list;
    }

    public static function createTag($tag){
        $db   = db::getinstance();
        $req  = $db->query("insert into tags (tag) values ('".$tag."')");
        self::announce("$tag created");
    }

    // Creates tags that don't exist and returns ones that dont
    public static function sortTags($tags){
        $tag_exists = [];
        $tag_new    = [];
        foreach($tags as $tag){
            if(self::isTag($tag)){
                $tag_exists[] = $tag;
            }else{
                $tag_new[]    = $tag;
            }
        }
        foreach($tag_new as $tag){
            self::createTag($tag);
        }
        return $tag_new;
    }

    public static function hasTag($tagId, $postId){
        $db     = db::getinstance();
        $req    = $db->query("select * from postTags WHERE postId = '".$postId."' AND tagId = '".$tagId."' LIMIT 1");
        $result = $req->fetch();
        if($result){
            self::announce("$postId has $tagId");
            return true;
        }
        self::announce("$postId does not have $tagId");
        return false;
    }

    public static function addTag($tagId,$postId){
        $db   = db::getinstance();
        $req  = $db->query("insert into postTags (postId,tagId) values ('".$postId."','".$tagId."')");
        self::announce("$tag added to $tagid");
    }

    public static function hasTags($tags,$postId){
        $has_tag = [];
        $no_tag  = [];
        foreach($tags as $tag){
            $tagId         = self::isTag($tag);
            if(self::hasTag($tagId,$postId)){
                $has_tag[] = $tagId;
            }else{
                $no_tag[]  = $tagId;
                self::addTag($tagId,$postId);
            }
        }
    }

    public static function removeTag($tag, $postId){
            $tagId = self::isTag($tag);
            $db     = db::getinstance();
            $req    = $db->query("DELETE FROM postTags ".
                                "WHERE postId = '".$postId."' ".
                                "AND TAGID = '".$tagId."' ".
                                "LIMIT 1");

    }

    public static function removeTags($tags, $postId, $tagList){
        $justTags = [];
        foreach($tagList as $tag){
            $justTags[] = $tag['title'];
        }
        if(count($tags)!=0){
            $toDelete = [];
            foreach($justTags as $tag){
                if(in_array($tag,$tags)){
                    self::announce("$tag in taglist");
                }else{
                    self::announce("$tag not in taglist");
                    self::removeTag($tag, $postId);
                    $todelete[] = $tag;
                }
            }
        }
        return $toDelete;
    }

    public static function editPost($id, $title, $post, $tags){
        self::sortTags($tags); // creates tags
        self::hasTags($tags,$id); // adds tags to post
    }

    public static function saveChanges($id, $title, $post, $category, $author){
        $db   = db::getinstance();
        $req  = $db->query("UPDATE posts ".
                "SET authorId = '$author', title = '$title', ".
                "categoryId='$category', post = '$post' ".
                "WHERE id = '".$id."' ".
                "LIMIT 1");

    }

    public static function getRoles(){
        $list = [];
        $db   = db::getinstance();
        $req  = $db->query("SELECT * FROM userRoles");
        foreach ($req->fetchall() as $role){
            $list[]=[
                "id"        => $role['rId'],
                "role"      => $role['uRole']
                ];
        }
        return $list;
    }
    public static function getUsers(){
        $list = [];
        $db   = db::getinstance();
        $req  = $db->query("SELECT * FROM authors LEFT JOIN userRoles on authors.role=userRoles.rId");
        foreach ($req->fetchall() as $user){
            $list[]=[
                "id"        => $user['aId'],
                "firstName" => $user['firstName'],
                "lastName"  => $user['lastName'],
                "userName"  => $user['userName'],
                "role"      => $user['uRole']
                ];
        }
        return $list;
    }

    public static function getUser($id){
        $list = [];
        $db   = db::getinstance();
        $req  = $db->query("SELECT * FROM authors LEFT JOIN userRoles on authors.role=userRoles.rId WHERE aId = ".$id);
        $result = $req->fetch();
        if($result){
            unset($result['password']);
            unset($result[4]);
            return $result;
        }else{
            return NULL;
        }
    }

    public static function updateUser($user){
        if($user['password1']!=""){
            $err = [];
            if($user['password1']!=$user['password2']){
                $err[] = "Passwords must match";
            }
            if(strlen($user['password1'])<6||strlen($user['password1'])>30){
                $err[] = "Password must be between 6 and 30 chars long";
            }

            if(count($err)==0){
                $pass    = password_hash($user['password1'],PASSWORD_DEFAULT);
                $andPass = ", password = '$pass' ";
            }else{
                return [$err,$user['id']];
            }
        }else{
            $andPass = " ";
        }
        $db   = db::getinstance();
        $req  = $db->query("UPDATE authors SET username = '".$user['username']."', ".
                            "firstName = '".$user['firstName']."', ".
                            "lastName = '".$user['lastName']."', ".
                            "role = '".$user['role']."'".
                            $andPass.
                            "WHERE aId = '".$user['id']."'" );
        return [1,$user['id']];
    }
}
?>
