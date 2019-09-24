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

require_once( '../../inc/header.inc.php' );
require_once( BX_DIRECTORY_PATH_INC . 'design.inc.php' );

$IDKey=$_GET['IDKey'];
$IDLanguage=$_GET['l'];
$ok=$_GET['ok'];

if($ok==1)
	MYSQL_QUERY("UPDATE `sys_localization_strings` SET `ok`=1 WHERE `IDKey` = '$IDKey' AND `IDLanguage`='$IDLanguage' LIMIT 1");
else
	MYSQL_QUERY("UPDATE `sys_localization_strings` SET `ok`=0 WHERE `IDKey` = '$IDKey' AND `IDLanguage`='$IDLanguage' LIMIT 1");

if(!mysql_error())
  print 'success';
else
  print mysql_error();


?>