<?
  define('DB_SERVER', 'localhost');
  define('DB_USERNAME', '');
  define('DB_PASSWORD', '');
  define('DB_DATABASE', '');
  define('MEMCACHED_PORT', 11211);

  $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
  mysqli_query($db, "SET NAMES utf8;");

  $pdo = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_DATABASE, DB_USERNAME, DB_PASSWORD);

  $memcached = new Memcached();
  $memcached->addServer("127.0.0.1", MEMCACHED_PORT);

?>
