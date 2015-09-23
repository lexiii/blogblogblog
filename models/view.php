<?php

// VIEW MODEL          -       /models/view.php

class View{
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

    // Gets posts where $n is how many posts to fetch and $s is what post to start from (for pagination)
    public static function latest($n = 10,$s=0){
        $list    = [];
        $db      = db::getinstance();
        $tags    = [];
        $req     = $db->query("select * from posts ".
            "LEFT JOIN authors on posts.authorId = authors.aId".
            " LEFT JOIN categories on posts.categoryId = categories.cId".
            " order by posts.date desc limit $s, $n");
        $total     = $db->query("SELECT count(*) AS 'num' FROM posts ")->fetch(PDO::FETCH_NUM);
        $rows = $total[0];
        $i = 0;
        foreach ($req->fetchall() as $post){
            $tags           = self::tags($post['id']);
            $list[]         = new view($post['id'],$post['categoryId'],$post['authorId'],$post['title'],$post['post'],$post['date'],$post['firstName'],$post['lastName'],$post['cTitle']);
            $list[$i]->tags = $tags;
            $list[$i]->rows = $rows;
            $i++;
        }

        return $list;

    }

    // Grab a single post
    public static function post($n){
        $db      = db::getinstance();
        $req     = $db->query("select * from posts".
            " LEFT JOIN authors on posts.authorId = authors.aId".
            " LEFT JOIN categories on posts.categoryId = categories.cId".
            " WHERE posts.id=".$n);

        $req -> execute();
        $result  = $req->fetch();
        if($result)
            return $result;
        return NULL;
    }

    public static function author($n){
        $list   = [];
        $db     = db::getinstance();
        $req    = $db->query("select * from posts".
            " LEFT JOIN authors on posts.authorId = authors.aId".
            " LEFT JOIN categories on posts.categoryId = categories.cId".
            " WHERE posts.authorId=".$n);

        foreach ($req->fetchall() as $post){
            $list[] = new view($post['id'],$post['categoryId'],$post['authorId'],$post['title'],$post['post'],$post['date'],$post['firstName'],$post['lastName'],$post['cTitle']);
        }
        return $list;
    }

    public static function category($n){
        $list   = [];
        $db     = db::getinstance();
        $req    = $db->query("select * from posts".
            " LEFT JOIN authors on posts.authorId = authors.aId".
            " LEFT JOIN categories on posts.categoryId = categories.cId".
            " WHERE posts.categoryId=".$n);

        foreach ($req->fetchall() as $post){
            $list[] = new view($post['id'],$post['categoryId'],$post['authorId'],$post['title'],$post['post'],$post['date'],$post['firstName'],$post['lastName'],$post['cTitle']);
        }
        return $list;
    }

    public static function byTag($n){
        $list   = [];
        $db     = db::getinstance();
        $req    = $db->query("select * from postTags".
            " LEFT JOIN posts on postTags.postId = posts.id".
            " LEFT JOIN authors on posts.authorId = authors.aId".
            " LEFT JOIN categories on posts.categoryId = categories.cId".
            " WHERE postTags.tagId=".$n);

        foreach ($req->fetchall() as $post){
            $list[] = new view($post['id'],$post['categoryId'],$post['authorId'],$post['title'],$post['post'],$post['date'],$post['firstName'],$post['lastName'],$post['cTitle']);
        }
        return $list;
    }

    public static function tags($n){
        $list   =[];
        $db     = db::getinstance();
        $req    = $db->query("select * from postTags ".
            " LEFT JOIN tags on postTags.tagId = tags.tId".
            " where postTags.postId = ".$n);

        foreach ($req->fetchall() as $tags){
            $list[]=[
                "id" => $tags['tagId'],
                "title" => $tags['tag']
            ];
        }
        return $list;
    }

    public static function singleTag($n){
        $db     = db::getinstance();
        $req    = $db->query("select * from tags ".
            " where tId = ".$n);

        $req -> execute();
        $result  = $req->fetch();
        return $result;
    }

    public static function tagList(){
        $list   = [];
        $db     = db::getinstance();
        $req    = $db->query("select * from tags ");

        foreach ($req->fetchall() as $tags){
            $list[]=[
                "id" => $tags['tId'],
                "title" => $tags['tag']
            ];
        }
        return $list;
    }

    public static function authorList(){
        $list   = [];
        $db     = db::getinstance();
        $req    = $db->query("select * from authors ORDER BY firstName asc");
        foreach ($req->fetchall() as $author){
            $list[]=[
                "id" => $author['aId'],
                "firstName" => $author['firstName'],
                "lastName" => $author['lastName']
            ];
        }
        return $list;
    }


    public static function categoryList(){
        $list   = [];
        $db     = db::getinstance();
        $req    = $db->query("select * from categories ORDER BY cTitle asc");
        foreach ($req->fetchall() as $category){
            $list[]=[
                "id" => $category['cId'],
                "title" => $category['cTitle']
            ];
        }
        return $list;
    }
}
?>
