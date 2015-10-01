<?php

// SETTINGS MODEL       -       /models/settings.php

class Settings{
    public static function getSettings(){
        $list = [];
        $db   = db::getinstance();
        $req  = $db->query("select id, settings, value, category from settings");

        foreach ($req->fetchall() as $settings){
            $list[ $settings["setting"]] = [
                "id"       => $settings['id'],
                "value"    => $settings['value'],
                "category" => $settings['category']
            ];
        }

        return $list;
    }

    public static function getByCategory($category){
        $list = [];
        $db   = db::getinstance();
        $req  = $db->query("select * from settings ".
            "LEFT JOIN settingsCategories ".
            "ON settings.categoryId = settingsCategories.sId ".
            "WHERE settings.categoryId = '".$category."'");


        foreach ($req->fetchall() as $settings){
            $list[] = [
                "id"       => $settings['id'],
                "setting"  => $settings['setting'],
                "value"    => $settings['value'],
                "category" => $settings['category'],
                "categoryId" => $settings['categoryId'],
                "human"    => $settings['humanName']
            ];
        }

        return $list;
    }

    public static function getCategories(){
        $list = [];
        $db   = db::getinstance();
        $req  = $db->query("select * from settingsCategories ");


        foreach ($req->fetchall() as $cats){
            $list[] = [
                "id"       => $cats['sId'],
                "category"  => $cats['category']
            ];
        }

        return $list;
    }
}
?>
