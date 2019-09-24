<?php
///*************************Product owner info********************************
///
///     author               : Boonexpert
///     contact info         : boonexpert@gmail.com
///
///*************************Product info**************************************
///
///                          Master String Editor + Email templates editor
///                          -----------------------------------------------------
///     version              : 3.0
///     date		    : 24 September 2019
///    compability          : Dolphin 7.4.x
///    License type         : Custom
///
/// IMPORTANT: This is a commercial product made by Boonexpert and cannot be modified for other than personal use.
/// This product cannot be redistributed for free or a fee without written permission from Boonexpert.
///
///     Upgrade possibilities : All future upgrades will be added to this product package
///
///****************************************************************************/


error_reporting(0);

  session_start();

include ("conn.php");



if($_POST['addlangkey']) {



$params = array();
parse_str($_POST['serialize'], $params);





	$result_searchkeys = MYSQL_QUERY("SELECT `ID` FROM `sys_localization_keys` WHERE `Key` = '{$params['newlangkey']}'");
if(mysql_error()) $thiserror.=mysql_error()."\r\n\r\n";
	  if(mysql_num_rows($result_searchkeys)>0) {print "137"; exit;}
	else{
	$result_addkey = MYSQL_QUERY("INSERT INTO `sys_localization_keys` (`Key`,`IDCategory`) VALUES ('{$params['newlangkey']}',{$params['selectedCategoryAddKey']})");

if(mysql_error()) $thiserror.=mysql_error()."\r\n\r\n";

$i=0;
$valuestoadd="";
$lastID=mysql_insert_id();

  foreach($params as $lang => $value){

    if(($lang != 'newlangkey')&&($lang != 'selectedCategoryAddKey')) {
	if($value) {
	  if($i>0) {$comma=",";} else $comma="";
	  $lang = str_replace("newlangval_","",$lang);

	  $value = addslashes($value);

	  $valuestoadd.=<<<CODE
	  $comma('$lastID','$lang','$value')
CODE;

	  $i++;

	}
      }
  }
  
	$result_addvalues = MYSQL_QUERY("INSERT INTO `sys_localization_strings` (`IDKey`,`IDLanguage`,`String`) VALUES $valuestoadd");
if(mysql_error()) $thiserror.=mysql_error()."\r\n\r\n";
	}

if($thiserror) print $thiserror;
else
print "200";


}








?>
