<?
ini_set('error_reporting', E_ALL);
if (isset($_GET['id'])) {
    $_GET['id'] = (int)($_GET['id']);
} else {
    die();
}
require("config.php");

$hosts = './visits/oldbk' . $_GET['id'] . '.cnt';

function getip()
{

    if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
        $_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_CF_CONNECTING_IP'];
    }

    return $_SERVER["REMOTE_ADDR"];
}

function dohits()
{
    global $a, $b, $c, $date, $daytoday;
    mysql_query($a) or die("������ �����������");
    mysql_query($b) or die("������ �����������");

    if ($date != "$daytoday") {
        mysql_query($c) or die("������ �����������");
    }
}


//���� ������ �� �����
function testhost($ip)
{
    global $hosts;

    if (!file_exists($hosts)) {
        $f = fopen($hosts, "w");
        fwrite($f, date("d/m/Y H:i:s") . ":[" . $ip . "]:" . $_SERVER["HTTP_REFERER"] . ":\r\n");
        fclose($f);
        return 1;
    } else {
        $f = fopen($hosts, "r");
        $buf = fread($f, filesize($hosts));
        fclose($f);

        if (!strpos($buf, "[" . $ip . "]")) {
            $f = fopen($hosts, "a");
            if (flock($f, LOCK_EX)) {
                fwrite($f, date("d/m/Y H:i:s") . ":[" . $ip . "]:" . $_SERVER["HTTP_REFERER"] . ":\r\n");
                flock($f, LOCK_UN);
            }
            fclose($f);
            return 1;
        } else {
            return 0;
        }
    }
}

$date = date("dmY");
//$date="32052010";
$query = mysql_query("SELECT * FROM $table WHERE memberid = '" . intval($_GET["id"]) . "' LIMIT 1") or die ("������ �����������.1");
$object = mysql_fetch_object($query);

if ($object && $object->memberid) {
    $rank = $object->rank;
    $today = $object->hitstoday;
    $today = explode(" | ", $today);
    $datetoday = $today[0];
    if (isset($today[1])) {
        $hitstoday = $today[1];
    } else {
        $hitstoday = 0;
    }

    $days = $object->date;
    $days = explode(" | ", $days);
    $daytoday = $days[0];

    $hoststoday = $object->hoststoday;
    $allhosts = $object->allhosts;

    if (!isset($_SERVER["HTTP_REFERER"])) $_SERVER["HTTP_REFERER"] = "";

    $ref = $_SERVER["HTTP_REFERER"];
    if (strpos($ref, $object->url) !== FALSE) {
        //next check
        $ip = getip();

        /////////////////
        // ���� �������� �������� �� �� ���� ������ �������
        mysql_select_db("oldbk");
        $check = mysql_fetch_array(mysql_query("SELECT * from iplog where `ip` = '" . $ip . "' LIMIT 1; "));
        mysql_select_db("topsites");
        ///////////////////////////////////////////

        if ($check['id'] > 0) {
            $addhost = (int)(testhost($ip));
            $hoststoday = $hoststoday + $addhost;
            $suba = ", hoststoday=hoststoday +" . $addhost . ", allhosts=allhosts +" . $addhost . " ";

            $a = "UPDATE $table SET hitsin = hitsin + 1, hitstotal = hitstotal + 1 " . $suba . " WHERE memberid = '" . $_GET["id"] . "'";

            if ($date != $datetoday) {
                $b = "UPDATE $table SET hitstoday = '$date | 1' , hoststoday=1 , hitsin = 1  WHERE memberid = '" . $_GET["id"] . "'";
                $hitstoday = 1;
                $hoststoday = 1;
                //and make clear hostlist and add last ip
                $f = fopen($hosts, 'w');
                if (flock($f, LOCK_EX)) {
                    fwrite($f, date("d/m/Y H:i:s") . ":[" . $ip . "]:" . $_SERVER["HTTP_REFERER"] . ":\r\n");
                    flock($f, LOCK_UN);
                }

                fclose($f);
            } else {
                $hitsplus = $today[1] + 1;
                $b = "UPDATE $table SET hitstoday = '$date | $hitsplus' WHERE memberid = '" . $_GET["id"] . "'";
            }

            if ($date != "$daytoday") {
                $dayplus = $days[1] + 1;
                $c = "UPDATE $table SET date = '$date | $dayplus' WHERE memberid = '" . $_GET["id"] . "'";
            }
            dohits();
        }
    }

    // ������� ���������� ����������.
    // �������� ��� ��������
    $im = ImageCreateFromPNG("b/counter.png");

    // ���� ������
    $black = imagecolorallocate($im, 0, 0, 0);

    // ��������� ������
    imagestring($im, 1, 29, 19, $hitstoday, $black);
    imagestring($im, 1, 69, 19, $hoststoday, $black);

    Header("Content-type: image/jpeg");
    //����� �����������
    ImageJpeg($im);
    //��������� �����������, ����� �� ���������� ������
    imagedestroy($im);
} else {
    die ("������ ID." . $_GET["id"]);
}