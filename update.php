<?
  require_once("config.php");

  function registerCmcId($id, $name, $symbol, $website_slug) {
    global $pdo;

    $stm = $pdo->prepare("INSERT INTO cmc_coins (cmcid, name, symbol, website_slug) VALUES (?,?,?,?) ON DUPLICATE KEY UPDATE name=?, symbol=?, website_slug=?");
    $stm->execute(array($id, $name, $symbol, $website_slug, $name, $symbol, $website_slug));
  }

  function update() {
    global $cmc_pro_api_key;

    $url = "https://pro-api.coinmarketcap.com/v1/cryptocurrency/map?CMC_PRO_API_KEY=$cmc_pro_api_key";
    $jsonfile = file_get_contents($url);
    $jso = json_decode($jsonfile, true);

    foreach ($jso["data"] as $item) { 
      $id = $item["id"];
      $name = $item["name"];
      $symbol = $item["symbol"];
      $website_slug = $item["slug"];
      //echo("$id $name ($symbol) $website_slug <BR>\n");
      registerCmcId($id, $name, $symbol, $website_slug);
    }
  }

  if (strlen(DB_USERNAME)==0) {
    echo("DB connection not configured in config.php ! <br/>\n");
    return;
  }

  if (strlen($cmc_pro_api_key)==0) {
    echo("Coinmarketcap API key not configured in config.php ! <br/>\n");
    return;
  }

  if (strlen($_SERVER["REMOTE_ADDR"]) == 0) {
    // update only when executed from command line.
    update();
  } else {
    echo("execute update.php from command line preferably from crontab ! <br/>\n");
  }

?>
