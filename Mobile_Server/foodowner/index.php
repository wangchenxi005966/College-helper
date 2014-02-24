<?php
include_once("top.php");
require 'SQL-DAO.php';
require_once("check.php");
header("Content-Type:text/html;charset=utf-8");
?>
<?php
include_once("show.php");
?>
<table width="72%" height="500" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="1%" height="315" bgcolor="#FAF3CE"></td>
    <td width="20%" valign="top"><?php include_once("left.php");?></td>
    <td width="1%" bgcolor="#FAF3CE"></td>
	<td width="78%" valign="top" bgcolor="#FFBD9D"><?php include_once("right.php");?></td>
  </tr>
</table>
<?php
include_once("bottom.php");
?>
