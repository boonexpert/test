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

  include("func.php");

  session_start();

// echo $_SESSION['mseusername'];
if($_SESSION['mseusername']){


?>
	    <LINK href="bootstrap/css/bootstrap.css" type=text/css rel=stylesheet>
	    <LINK href="css/style.css" type=text/css rel=stylesheet>
<?php



  $langToProceed=$_GET['lang'];
  $catToProceed=$_GET['catID'];
  $langSrc=$_GET['langSrc'];
  $what_export=$_GET['export'];
  $langCode=$_GET['langCode'];

if(isset($_GET['del'])) {

  unlink("langs/$what_export/".$_GET['del']);

}

if(!empty($_GET['action'])){


  switch ($what_export) {

    case "csv":
      get_csv($langToProceed,$catToProceed,$langCode,$langSrc);
    break;

    case "php":
      get_php($langToProceed,$catToProceed,$langCode);
    break;

    case "xml":
      get_xml($langToProceed,$catToProceed,$langCode);
    break;

  }
}

if($what_export)  filelist($what_export,$langToProceed,$catToProceed,$langSrc,$langCode);
  else
  print '<font class="filelist">'.$mse_lang['Select action on the left panel'].'</font>';
}
?>
