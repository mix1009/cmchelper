<?
  require_once("config.php");

  function registerCmcId($id, $name, $symbol, $website_slug) {
    global $pdo;

    $stm = $pdo->prepare("INSERT INTO cmc_coins (cmcid, name, symbol, website_slug) VALUES (?,?,?,?) ON DUPLICATE KEY UPDATE name=?, symbol=?, website_slug=?");
    $stm->execute(array($id, $name, $symbol, $website_slug, $name, $symbol, $website_slug));
  }

  function update() {
    $json = "https://api.coinmarketcap.com/v2/listings/";
    $jsonfile = file_get_contents($json);
    $jso = json_decode($jsonfile, true);

    foreach ($jso["data"] as $item) { 
      $id = $item["id"];
      $name = $item["name"];
      $symbol = $item["symbol"];
      $website_slug = $item["website_slug"];
      echo("$id $name ($symbol) $website_slug <BR>\n");
      registerCmcId($id, $name, $symbol, $website_slug);
    }
  }

  if (strlen(DB_USERNAME)==0) {
    echo("DB connection not configured in config.php ! <br/>\n");
    return;
  }

  if (strlen($_SERVER["REMOTE_ADDR"]) == 0) {
    // update only when executed from command line.
    update();
  }

?>
