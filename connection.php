<?php
    class Db {
        private static $instance = NULL;

        private function __construct() {}

        private function __clone() {}

        public static function getInstance() {
            if(!isset(self::$instance)) {
                try {
                    $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;

                    self::$instance = new PDO('mysql:host=localhost;dbname=blogthing',root,root, $pdo_options);
                } catch (PDOException $e) {
                    echo 'Connection failed: ' . $e->getMessage();
                    die();
                }
            }
            return self::$instance;
        }

    }
?>
