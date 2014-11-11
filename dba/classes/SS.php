<?php
class SS {

	public static $uri;
	private static $gl;
	private static $trash;

	public static function setUri($_uri) {
		self::$uri = $_uri;

		return null;
	}

	public static function getUri() {
		return self::$uri;
	}

	public static function setTrash($data) {
		self::$trash = $data;

		return null;
	}

	public static function getTrash() {
		return self::$trash;
	}

	public static function setLinker($hash, $encoding = "UTF-8") {
		/* Seo-Studio Linker init */
		$gl_hash = $hash;
		// сюда вписываем хеш
		$gl_path = $_SERVER['DOCUMENT_ROOT'] . '/' . $gl_hash . '/';
		// поправляем путь, если надо
		$gl_uri = $_SERVER['REQUEST_URI'];
		// URI текущей страницы *
		$GL_CHARSET = $encoding;
		// кодировка, используемая сайтом
		include_once ($gl_path . 'gl.php');
		/* Linker init end */
		global $gl;
		self::$gl = $gl;
	}

	public static function redirectSend($location) {
		header(self::urlStatus(301));
		header('Location: http://' . $location);
		die(); 
	}
	
	public static function addSlashUrl () {
		if (substr(self::$uri, -1) != '/' && empty($_SERVER['QUERY_STRING']) && substr(self::$uri, -5) != '.html') {
			self::redirectSend($_SERVER['HTTP_HOST'] . self::$uri . '/');
		}
	}
	
	public static function replaceInUri($replace, $type = 'str') {
		header(self::urlStatus(301));
		if ($type == 'str') {
			header('Location: http://' . $_SERVER['HTTP_HOST'] . str_replace($replace, '', self::$uri));
		} elseif ($type == 'regexp') {
			header('Location: http://' . $_SERVER['HTTP_HOST'] . preg_replace($replace, '', self::$uri));
		}
		die();
	}

	public static function getLinker($center = 'y') {
		if ($center != 'y') {
			$linker['texts'] = '<div>' . self::$gl -> printTexts() . '</div>';
			$linker['links'] = '<div>' . self::$gl -> printInternals() . '</div>';
		} else {
			$linker['texts'] = '<center><div>' . self::$gl -> printTexts() . '</div>';
			$linker['links'] = '<div>' . self::$gl -> printInternals() . '</div></center>';
		}
		return $linker;
	}

	public static function wwwNOwww($type = 'Y') {
		/*
		 * @return void
		 */
		if ($type == 'Y') {
			if (substr($_SERVER['HTTP_HOST'], 0, 4) != 'www.') {
				header(self::urlStatus(301));
				header('Location: http://www.' . $_SERVER['HTTP_HOST'] . self::getUri());
				die();
			}
		} elseif ($type == 'N') {
			if (substr($_SERVER['HTTP_HOST'], 0, 4) == 'www.') {
				header(self::urlStatus(301));
				header('Location: http://' . str_replace('www.', '', $_SERVER['HTTP_HOST']) . self::getUri());
				die();
			}
		}
	}

	public static function error404($page) {
		header(self::urlStatus(404));
		include ($page);
		die();
	}

	public static function Js_popUp() {
		$theScript = '
        <script language="javascript" type="text/javascript">
        function popUp($id){
            $div=document.getElementById($id);
            if ($div.style.display==\'none\') $div.style.display=\'block\';
            else $div.style.display=\'none\';
            }
        </script>';
		return $theScript;
	}

	public static function rewrite($url, $path = '/') {
		if (is_array($url)) {
			foreach ($url as $key => $value) {
				if (self::getUri() == $key) {
					header(self::urlStatus('301'));
					header('Location: http://' . $_SERVER['HTTP_HOST'] . $value);
					die();
				}
			}
		} else {
			if (self::getUri() == $url) {
				header(self::urlStatus('301'));
				header('Location: http://' . $_SERVER['HTTP_HOST'] . $path);
				die();
			}
		}
	}

	public static function seoTexts($mainTable) {
		$queryExec = mysql_query("SELECT * FROM `" . $mainTable . "` WHERE `uri` = '" . mysql_real_escape_string(self::$uri) . "'");
		$sql = mysql_fetch_object($queryExec);
		if (!empty($sql -> text1) && !empty($sql -> text2)) {
			$script = '<div class="ns_hdr">
                    <p>' . $sql -> text1 . '
                    <a href="javascript:popUp(\'seo_text\')" class="test" title=""> подробнее <br /><br /></a></p>
                    <div id="seo_text"> ' . $sql -> text2 . '</div>
                    </div>
                    <script language="javascript" type="text/javascript">
                    popUp(\'seo_text\');
                    </script>';
		} elseif (!empty($sql -> text1)) {
			$script = $sql -> text1;
		}

		return $script;
	}

	public static function toUpper($string, $charset = "UTF-8") {
		$str = mb_substr(mb_strtoupper($string, $charset), 0, 1, $charset);
		$str .= mb_substr($string, 1, mb_strlen($string, $charset), $charset);

		return $str;
	}

	public static function toLower($string, $charset = "UTF-8") {
		$str = mb_substr(mb_strtolower($string, $charset), 0, 1, $charset);
		$str .= mb_substr($string, 1, mb_strlen($string, $charset), $charset);

		return $str;
	}

	public static function dbRedirects($table = 'seo_redirects') {
		$url = 'http://' . $_SERVER['HTTP_HOST'] . self::$uri;
		$exec = mysql_query("SELECT * FROM `" . $table . "` WHERE oldurl = '" . $url . "'");
		$red = mysql_fetch_object($exec);
		if (!empty($red -> oldurl)) {
			header('Location: ' . $red -> newurl, true, 301);
			exit();
		}
	}

	public static function Debug() {
		$styles = array('font-size:13px', 'font-weight: bold', 'color: #484848', 'position:fixed', 'left:5px', 'bottom:5px', 'border:1px solid #ccccc', 'border-radius: 6px', 'height: 100px', 'overflow: auto', 'max-width:500px', 'background:white', 'z-index:9999999999999999999', 'padding:3px');
		if (isset($_COOKIE['us_id']) && !empty($_COOKIE['us_id'])) {
			print '<textarea readonly style="' . implode('; ', $styles) . '">';
			$all_args = func_get_args();
			for ($i = 0; $i < func_num_args($all_args); $i++) {
				$data = func_get_arg($i);
				if (is_array($data) || is_object($data)) {
					print_r($data);
				} else {
					echo $data . "\n";
				}
			}
			print '</textarea>';
		}
	}

	public static function urlStatus($string) {

		$refresh = array(0 => 'не существует', 100 => 'HTTP/1.1 100 Continue', 101 => 'HTTP/1.1 101 Switching Protocols', 200 => 'HTTP/1.1 200 OK', 201 => 'HTTP/1.1 201 Created', 202 => 'HTTP/1.1 202 Accepted', 203 => 'HTTP/1.1 203 Non-Authoritative Information', 204 => 'HTTP/1.1 204 No Content', 205 => 'HTTP/1.1 205 Reset Content', 206 => 'HTTP/1.1 206 Partial Content', 300 => 'HTTP/1.1 300 Multiple Choices', 301 => 'HTTP/1.1 301 Moved Permanently', 302 => 'HTTP/1.1 302 Found', 303 => 'HTTP/1.1 303 See Other', 304 => 'HTTP/1.1 304 Not Modified', 305 => 'HTTP/1.1 305 Use Proxy', 307 => 'HTTP/1.1 307 Temporary Redirect', 400 => 'HTTP/1.1 400 Bad Request', 401 => 'HTTP/1.1 401 Unauthorized', 402 => 'HTTP/1.1 402 Payment Required', 403 => 'HTTP/1.1 403 Forbidden', 404 => 'HTTP/1.1 404 Not Found', 405 => 'HTTP/1.1 405 Method Not Allowed', 406 => 'HTTP/1.1 406 Not Acceptable', 407 => 'HTTP/1.1 407 Proxy Authentication Required', 408 => 'HTTP/1.1 408 Request Time-out', 409 => 'HTTP/1.1 409 Conflict', 410 => 'HTTP/1.1 410 Gone', 411 => 'HTTP/1.1 411 Length Required', 412 => 'HTTP/1.1 412 Precondition Failed', 413 => 'HTTP/1.1 413 Request Entity Too Large', 414 => 'HTTP/1.1 414 Request-URI Too Large', 415 => 'HTTP/1.1 415 Unsupported Media Type', 416 => 'HTTP/1.1 416 Requested Range Not Satisfiable', 417 => 'HTTP/1.1 417 Expectation Failed', 500 => 'HTTP/1.1 500 Internal Server Error', 501 => 'HTTP/1.1 501 Not Implemented', 502 => 'HTTP/1.1 502 Bad Gateway', 503 => 'HTTP/1.1 503 Service Unavailable', 504 => 'HTTP/1.1 504 Gateway Time-out', 505 => 'HTTP/1.1 505 HTTP Version Not Supported');
		return strtr($string, $refresh);

	}

	public static function translit($string) {

		// Русский алфавит
		$rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');

		// Английская транслитерация
		$eng = array('A', 'B', 'V', 'G', 'D', 'E', 'IO', 'ZH', 'Z', 'I', 'I', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'CH', 'SH', 'SH', '`', 'Y', '`', 'E', 'IU', 'IA', 'a', 'b', 'v', 'g', 'd', 'e', 'io', 'zh', 'z', 'i', 'i', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sh', '`', 'y', '`', 'e', 'iu', 'ia');

		return str_replace($eng, $rus, $string);

	}

	public static function relNextPrev($param, $pname, $value = 1, $first = 1) {
		if (isset($param) && $param > 0) {
			$prev = $param - $value;
			$next = $param + $value;
			switch($param) {
				case $first :
					$resu['next'] = '<link rel="next" href="http://' . $_SERVER['HTTP_HOST'] . str_replace($pname . $param, $pname . $next, self::$uri) . '" />' . "\n";
					break;

				case $first+$value :
					$resu['prev'] = '<link rel="prev" href="http://' . $_SERVER['HTTP_HOST'] . str_replace($pname . $param, '', self::$uri) . '" />' . "\n";
					$resu['next'] = '<link rel="next" href="http://' . $_SERVER['HTTP_HOST'] . str_replace($pname . $param, $pname . $next, self::$uri) . '" />' . "\n";
					break;

				default :
					$resu['prev'] = '<link rel="prev" href="http://' . $_SERVER['HTTP_HOST'] . str_replace($pname . $param, $pname . $prev, self::$uri) . '" />' . "\n";
					$resu['next'] = '<link rel="next" href="http://' . $_SERVER['HTTP_HOST'] . str_replace($pname . $param, $pname . $next, self::$uri) . '" />' . "\n";
					break;
			}
		}
		return $resu;
	}

	public static function anchors($filename, $sep_file, $separator = ' |') {
		$fcont = file($filename);
		$links = '';
		for ($i = 0; $i < count($fcont); $i++) {
			$anchor = explode($sep_file, $fcont[$i]);
			$links .= "<a href='" . $anchor[1] . "'>" . $anchor[0] . "</a>" . ($i == count($fcont) - 1 ? '' : $separator) . "\n";
		}
		return $links;
	}

	public static function titlePaging($param = 'p', $start = 1, $offset = 1) {
		if (isset($_GET[$param]) && $_GET[$param] > $start) {
			$num = $offset > 1 ? $_GET[$param] / $offset + 1 : $_GET[$param];
			$pg = 'Страница №' . $num . ' - ';
		} else {
			$pg = '';
		}
		return $pg;
	}

	public static function canonicalSlash($type = 1) {
		if ($type == 1) {
			if (substr(self::$uri, -1) != '/') {
				return '<link rel="canonical" href="http://' . $_SERVER['HTTP_HOST'] . self::$uri . '/" />';
			}
		} elseif ($type == 2) {
			if (substr(self::$uri, -1) == '/') {
				return '<link rel="canonical" href="http://' . $_SERVER['HTTP_HOST'] . substr(self::$uri, 0, -1) . '" />';
			}
		} else {
			return false;
		}

	}

	public static function canonical($url, $path = '/') {
		if (is_array($url)) {
			foreach ($url as $key => $value) {
				if (self::getUri() == $key) {
					return '<link rel="canonical" href="http://' . $_SERVER['HTTP_HOST'] . $value . '" />';
				}
			}
		} else {
			if (self::getUri() == $url) {
				return '<link rel="canonical" href="http://' . $_SERVER['HTTP_HOST'] . $path . '" />';
			}
		}
	}

}
