<?
defined('AntiBK') or die ("Доступ запрещен!");
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td align="center" valign="top" width="210"><?echo $info -> character ($guid);$equip -> showEquipment ();?></td>
    <td align="left" valign="top" nowrap style="padding-left: 3px;"><br>
<?
foreach ($behaviour as $key => $min_level)
  echo ($level >= $min_level) ?"$lang[$key] $char_stats[$key]<br>" :"";
echo ($char_stats['ups'] > 0) ?" <a class='nick' href='?action=skills'>+ $lang[ups]</a> " :'';
echo ($char_stats['skills'] > 0) ?"&bull; <a class='nick' href='?action=skills'><b> $lang[skills]</b></a><br>" :"<br>";
echo "<br>";
echo "$lang[exp] <b>".getExp ($exp)."</b> (".getExp ($next_up).")<br>";
echo "$lang[level] $level<br>";
echo "$lang[wins] $win<br>";
echo "$lang[loses] $lose<br>";
echo "$lang[draws] $draw<br>";
echo "$lang[money] <b>$money</b> кр.";
echo ($prof) ?"<br>$lang[prof] <b>".$lang['prof_'.$prof]."</b>" :'';
echo ($clan) ?"<br>$lang[clan] $clan" :'';
$orden_dis = ($orden == 1) ?"Паладинский орден - " :(($orden == 2) ?"Армада - " :"");
echo ($orden == 1 || $orden == 2) ?"<br><strong>$orden_dis$stat_rang</strong><br></small>" :"<br><small>$lang[status] <strong>$status</strong>";
$return_status = ((time () - $char_db['last_return']) >= $char_db['return_time']) | false;
?>
    </td>
  </tr>
  <tr><td colspan="2"><small><?echo $equip -> needItemRepair ();?></small></td></tr>
</table>