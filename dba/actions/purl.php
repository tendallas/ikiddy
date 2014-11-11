<?
function connect_to_db() {
    require ($_SERVER['DOCUMENT_ROOT'].'/config.php');
    $server = DB_HOSTNAME;
    $user = DB_USERNAME;
    $password = DB_PASSWORD;
    $dbname = DB_DATABASE;
    $connect = mysql_connect($server, $user, $password);
    if (!$connect) {
        echo 'Connect error';
        exit();
    }
    $select_db = mysql_select_db($dbname, $connect);
    if (!$select_db) {
        echo 'False name of DB';
        exit();
    }
    print("DB connect OK <br />");
}

function safeTranslit($string) {
    $stranslit = array("Ґ" => "g", "«" => "", "+" => "", "&quot;" => "", "»" => "", "," => "", "Ё" => "yo", "Є" => "e", "Ї" => "yi", "І" => "i", "і" => "i", "ґ" => "g", "ё" => "yo", "№" => "n", "є" => "e", "ї" => "yi", "А" => "a", "Б" => "b", "В" => "v", "Г" => "g", "Д" => "d", "Е" => "e", "Ж" => "zh", "З" => "z", "И" => "i", "Й" => "y", "К" => "k", "Л" => "l", "М" => "m", "Н" => "n", "О" => "o", "П" => "p", "Р" => "r", "С" => "s", "Т" => "t", "У" => "u", "Ф" => "f", "Х" => "h", "Ц" => "ts", "Ч" => "ch", "Ш" => "sh", "Щ" => "sch", "Ъ" => "", "Ы" => "yi", "Ь" => "", "Э" => "e", "Ю" => "yu", "Я" => "ya", "а" => "a", "б" => "b", "в" => "v", "г" => "g", "д" => "d", "е" => "e", "ж" => "zh", "з" => "z", "и" => "i", "й" => "y", "к" => "k", "л" => "l", "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r", "с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "h", "ц" => "ts", "ч" => "ch", "ш" => "sh", "щ" => "sch", "ъ" => "'", '"' => "", "ы" => "yi", "ь" => "", "э" => "e", "ю" => "yu", "я" => "ya", "%" => "_", " " => "_", "/" => "_", "\\" => "_", "$" => "_", "@" => "_", "^" => "_", "&" => "_", "*" => "_", "{" => "_", "}" => "_", "~" => "_", "[" => "_", "]" => "_", "<" => "_", ">" => "_", "?" => "_");
    return strtr($string, $stranslit);
}

function generate_table($array, $table_id = 'content', $table_class = '') {
    $array_size = count($array);
    $perc = 100/$array_size;
    $table = '<table border="1" cellpadding="4" cellspacing="0" width="100%" ';
    $table .= !empty($table_id) ? " id='" . $table_id . "'" : '';
    $table .= !empty($table_class) ? " class='" . $table_class . "'" : '';
    $table .= ">\n";
    
        $table .= '<tr>';
        foreach ($array as $key => $value){
            $table .= '<td valign="middle" width="'.round($perc).'%" class="'.$key.'">'.$value.'</td>';
        }
        $table .= '</tr>';
    $table .= "</table>\n";

    return $table;
}

connect_to_db();
mysql_query("SET NAMES utf8");
$query = mysql_query("SELECT `product_id`, `name` FROM `product_description` WHERE language_id = 2");
while ($result = mysql_fetch_assoc($query)) {
    $result['translate'] = safeTranslit($result['name']);
    echo generate_table($result);
    //$upd = "INSERT INTO `url_alias`";
    //$upd.= "VALUES('', 'product_id=".$result['category_id']."', '".$result['translate']."')";
    //mysql_query($upd);
}
?>

