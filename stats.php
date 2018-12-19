<?

if (!isset($_GET['id'])) $_GET['id'] = 0;
$_GET["id"] = (int)($_GET["id"]);

if ($_GET["id"] === 0) {
    header('Location: http://top.oldbk.com/rate');
} else {
    header('Location: http://top.oldbk.com/rate/site/' . $_GET["id"]);
}

die();