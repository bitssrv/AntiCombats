<?
session_start ();
error_reporting (E_ALL);
ini_set ('display_errors', true);
ini_set ('html_errors', false);
ini_set ('error_reporting', E_ALL);

define ('AntiBK', true);

include ("engline/config.php");
include ("engline/dbsimple/Generic.php");
include ("engline/data/data.php");
include ("engline/functions/functions.php");

$adb = DbSimple_Generic::connect($database['adb']);
$adb->query("SET NAMES ? ",$database['db_encoding']);
$adb->setErrorHandler("databaseErrorHandler");

$login = $_POST['login'];
$password = $_POST['password'];
?>
<html>
<head>
<title>Анти Бойцовский Клуб</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="styles/style.css" type="text/css">
<script type="text/javascript">
if (navigator.appName != 'Netscape')
{
	alert('Поддерживается только браузер Mozilla Firefox');
	location.href = 'index.php';
}
</script>
</head>
<body bgcolor="#ffffff">
<?
$top = "Произошла ошибка:<br><br><span class='err'>";
$bot = "</span><br><br><a href='javascript: window.history.go(-1);' class='us2'>Назад</a><hr>";

if (empty($login) || empty($password))
	die ("$top Вы не ввели логин либо пароль.$bot");

$char_info = $adb -> selectRow ("	SELECT 	`guid`, 
											`password`, 
											`city`, 
											`block`, 
											`room`, 
											`city` 
									FROM `characters` 
									WHERE `login` = ?s", $login) or die ("$top Логин $login не найден в базе.$bot");
$guid = $char_info['guid'];
$online = $adb -> selectCell ("SELECT `guid` FROM `online` WHERE `guid` = ?d", $guid);

$history = History::setguid($guid);

if (session_is_registered ('guid') || $online)
{
	$adb -> query ("DELETE FROM `online` WHERE `guid` = ?d", $guid);
	session_unregister ('guid');
	$history -> authorization (0, $char_info['city'], 'wrong_count');
	die ("$top Двое или больше пользователей пытаются играть с одной машины!<br>Попробуйте войти еще раз!$bot");
}
else if (SHA1 ($guid.':'.$password) != $char_info['password'])
{
	$history -> authorization (0, $char_info['city'], 'wrong_password');
	die ("$top Неверный пароль для $login.$bot");
}
else if ($char_info['block'])
{
	$history -> authorization (0, $char_info['city'], 'blocked');
	die ("$top Внимание!!! Персонаж $login заблокирован!$bot");
}

if (session_is_registered ('guid'))
{
	session_unregister ('guid');
	session_register ('guid');
}
else
	session_register ('guid');
$ip = $_SERVER['REMOTE_ADDR'];

$adb -> query ("INSERT INTO `online` (`guid`, `login_display`, `ip`, `city`, `room`, `last_time`) 
				VALUES (?d, ?s, ?s, ?s, ?s, ?d);", $guid ,$login ,$ip ,$char_info['city'] ,$char_info['room'] ,time ());
$adb -> query ("UPDATE `characters` SET `last_go` = ?d WHERE `guid` = ?d", time () ,$guid);
$zayavka_c_m = 1;
$zayavka_c_o = 1;
$battle_ref  = 0;
session_register ('zayavka_c_m', 'zayavka_c_o', 'battle_ref');
$history -> authorization (1, $char_info['city']);
?>
Авторизация окончена...
<script type="text/javascript">location.href = 'game.php';</script>
</body>
</html>