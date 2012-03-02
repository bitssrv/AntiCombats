<?
defined('AntiBK') or die ("Доступ запрещен!");

$char->test->Admin();
?>
<script src="scripts/sha1.js" type="text/javascript"></script>
<script type="text/javascript">
function deleteChar (d_guid)
{
  $.post('ajax_admin.php', 'do=delete_char&d_guid='+d_guid, function (data){
    var error = top.exploder(data);
    
    if (error[0] == 'complete')
      $('tr#'+d_guid).hide();
	});
}

$(function (){
  $('#getSHA1').click(function (){
    $('#sha1text').val(SHA1($('#text').val()));
  });
  $('div[name=content]').hide();
  $('div[id=mainc]').show();
  $('input[name=changetype]').click(function (){
    $('div[name=content]').hide();
    $('div[id='+$(this).attr('id')+'c]').show();
  });
  $('img.remove').click(function (){
    deleteChar($(this).attr('id'));
  });
});
</script>
<style>
.remove {cursor: pointer;}
</style>
<font color='red' id='error'><?$char->error->getFormattedError($error, $parameters);?></font>
<table width="100%">
  <tr>
    <td align="left">
      <input type="button" class="nav" value="Основное" id="main" name="changetype">
      <input type="button" class="nav" value="Персонажи" id="characters" name="changetype">
    </td>
    <td align="right">
      <input type="button" class="nav" value="Админ панель" onclick="window.open('admin/index.php', '', 'menubar=no,status=no');">
      <input type="button" class="nav" value="<?echo $lang['refresh'];?>" id="refresh">
      <input type="button" class="nav" value="<?echo $lang['return'];?>" id="link" link="inv">
    </td>
  </tr>
</table>
<div id="mainc" name="content">
<font color='red'>Глобальные переменные:</font>
<table border="1" cellspacing="0" cellpadding="0" width="100%">
<tr style="font-weight: bold;">
<?
foreach ($_SESSION as $key => $value)
  echo "<td>$key</td>";
?>
</tr>
<tr>
<?
foreach ($_SESSION as $key => $value)
  echo "<td>$value</td>";
?>
</tr></table>
<font color='red'>Cookies:</font>
<table border="1" cellspacing="0" cellpadding="0" width="100%">
<tr style="font-weight: bold;">
<?
foreach ($_COOKIE as $key => $value)
  echo "<td>$key</td>";
?>
</tr>
<tr>
<?
foreach ($_COOKIE as $key => $value)
  echo "<td>$value</td>";
?>
</tr></table>
<font color='red'>Lasts:</font>
<table border="1" cellspacing="0" cellpadding="0" width="100%">
<tr style="font-weight: bold;">
<td>next_shape</td>
<td>last_go</td>
<td>last_return</td>
<td>last_time</td>
</tr>
<tr>
<?
echo "<td>".date('d.m.y H:i:s', $char_db['next_shape'])."</td>";
echo "<td>".date('d.m.y H:i:s', $char_db['last_go'])."</td>";
echo "<td>".date('d.m.y H:i:s', $char_db['last_return'])."</td>";
echo "<td>".date('d.m.y H:i:s', $char_db['last_time'])."</td>";
?>
</tr>
</table>
<font color='red'>SHA1:</font>
<input type='text' id='text' style='width: 40%;'><input type='submit' id='getSHA1' value='Зашифровать'><input type='text' id='sha1text' readonly style='width: 40%;'><br>
<?
?>
</div>
<div id="charactersc" name="content" style="display: none;">
<?
$all_characters = $adb->select("SELECT * FROM `characters` ORDER BY `guid`;");
?>
<font color='red'>Персонажи:</font>
<table border="1" cellspacing="0" cellpadding="0" width="100%">
<tr style="font-weight: bold;">
<td>Guid</td>
<td>Login</td>
<td>Level</td>
<td>Exp</td>
<td>Money</td>
<td>City</td>
<td>Room</td>
<td> </td>
</tr>
<tr>
<?
foreach ($all_characters as $one_character)
{
  echo "<tr id='$one_character[guid]'>";
  echo "<td>$one_character[guid]</td>";
  echo "<td>$one_character[login]</td>";
  echo "<td>$one_character[level]</td>";
  echo "<td>$one_character[exp]</td>";
  echo "<td>$one_character[money]</td>";
  echo "<td>$one_character[city]</td>";
  echo "<td>$one_character[room]</td>";
  echo "<td width='14'><img src='img/icon/clear.gif' width='14' height='14' border='0' alt='Удалить персонажа' id='$one_character[guid]' class='remove'></td>";
  echo "</tr>";
}
?>
</tr></table>
</div>
<?
?>