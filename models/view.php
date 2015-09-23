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
    public static function latest($n = 10,$s=0, $x=0, $that = self){
        $list  = [];
        $db    = db::getinstance();
        $tags  = [];
        $query = $that::getQuery($s, $n, $x);
        $req   = $db->query($query);

        $rows = $that::getCount($db, $x);
        //$total = $db->query("SELECT count(*) AS 'num' FROM posts ")->fetch(PDO::FETCH_NUM);
//        $rows  = $total[0];
        $i     = 0;

        foreach ($req->fetchall() as $post){
            $tags           = self::tags($post['id']);
            $list[]         = new view($post['id'],$post['categoryId'],$post['authorId'],$post['title'],$post['post'],$post['date'],$post['firstName'],$post['lastName'],$post['cTitle']);
            $list[$i]->tags = $tags;
            $list[$i]->rows = $rows;
            $i++;
        }

        return $list;

    }

    public static function getCount($db, $x=0){
        $total = $db->query("SELECT count(*) AS 'num' FROM posts ")->fetch(PDO::FETCH_NUM);
        $rows  = $total[0];
        return $rows;
    }

    public static function getLatest($per,$s,$n = 0){
        return self::latest($per,$s,$n, View);
    }

    public static function getQuery($s, $n, $x){
        $query     = "select * from posts ".
            "LEFT JOIN authors on posts.authorId = authors.aId".
            " LEFT JOIN categories on posts.categoryId = categories.cId".
            " order by posts.date desc limit $s, $n";
        return $query;
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

class Author extends View{
    public static function getLatest($per,$s,$n){
        return self::latest($per,$s,$n, Author);
    }

    public static function getCount($db,$x){
        $total = $db->query("SELECT count(*) AS 'num' FROM posts ".
            "LEFT JOIN authors on posts.authorId = authors.aId".
            " LEFT JOIN categories on posts.categoryId = categories.cId".
            " WHERE posts.authorId=".$x)->fetch(PDO::FETCH_NUM);
        $rows  = $total[0];
        return $rows;
    }

    public static function getQuery($s, $n, $x){
        $query     = "select * from posts ".
            "LEFT JOIN authors on posts.authorId = authors.aId".
            " LEFT JOIN categories on posts.categoryId = categories.cId".
            " WHERE posts.authorId=".$x.
            " order by posts.date desc limit $s, $n";
        return $query;
    }
}

class Category extends View{
    public static function getLatest($per,$s,$n){
        return self::latest($per,$s,$n, Category);
    }

    public static function getCount($db,$x){
        $total = $db->query("SELECT count(*) AS 'num' FROM posts ".
            "LEFT JOIN authors on posts.authorId = authors.aId".
            " LEFT JOIN categories on posts.categoryId = categories.cId".
            " WHERE posts.categoryId=".$x)->fetch(PDO::FETCH_NUM);
        $rows  = $total[0];
        return $rows;
    }

    public static function getQuery($s, $n, $x){
        $query     = "select * from posts ".
            "LEFT JOIN authors on posts.authorId = authors.aId".
            " LEFT JOIN categories on posts.categoryId = categories.cId".
            " WHERE posts.categoryId=".$x.
            " order by posts.date desc limit $s, $n";
        return $query;
    }
}

class Tag extends View{
    public static function getLatest($per,$s,$n){
        return self::latest($per,$s,$n, Tag);
    }

    public static function getCount($db,$x){
        $total = $db->query("SELECT COUNT(*) AS num FROM postTags".
            " WHERE postTags.tagId=".$x)->fetch(PDO::FETCH_NUM);
        $rows  = $total[0];
        return $rows;
    }

    public static function getQuery($s, $n, $x){
        $query    = "SELECT * FROM postTags".
            " LEFT JOIN posts on postTags.postId = posts.id".
            " LEFT JOIN authors on posts.authorId = authors.aId".
            " LEFT JOIN categories on posts.categoryId = categories.cId".
            " WHERE postTags.tagId=".$x.
            " order by posts.date desc limit $s, $n";
        return $query;
    }
}
?>
