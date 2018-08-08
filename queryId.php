<?
  require_once("config.php");

  $arr = array();

  $names = explode(",", $_GET["q"]);

  function getCmcId($name) {
    global $pdo, $memcached;
    $name = strtolower($name);
    $name = str_replace(" ", "-", $name);

    $val = $memcached->get("cmc_".$name);
    if ($val) {
       return 0+$val;
    }

    $stm = $pdo->prepare("SELECT cmcid FROM cmc_coins WHERE website_slug=?");
    $stm->execute(array($name));
    $data = $stm->fetchAll();
    if ($data) {
      $val = 0+$data[0]['cmcid'];
      $memcached->set("cmc_".$name, $val);
      return $val;
    }
    return null;
  }

  foreach ($names as $name) { 
    $id = getCmcId($name);

    $item = array();
    if ($id) {
      $item["name"] = $name;
      $item["id"] = $id;
    } else {
      $item["name"] = $name;
      $item["error"] = "not found";
    }
    array_push($arr, $item);

  }

  header('Content-Type: text/json; charset=utf8');
  echo json_encode($arr);
?>
