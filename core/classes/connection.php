<?php

// try for connect with class

class Connect {
    protected static $servername = "localhost";
    protected static $db_name="tweetphp";
    protected static $username = "root";
    protected static $password = "";
    protected static $pdo;
    public function __construct() { }


    public static function connect() {
      if (!self::$pdo) {
          $servername = self::$servername;
          $db_name = self::$db_name;
          try {
              self::$pdo = new PDO("mysql:host=$servername;dbname=$db_name", self::$username, self::$password);
              self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          } catch (PDOException $e) {
              echo "Connection failed: " . $e->getMessage();
          }
      }
      return self::$pdo;
  }
  

}


