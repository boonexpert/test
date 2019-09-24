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

if($_SESSION['mseusername']){

$file_import=$_POST['file_import'];
$category=$_POST['category'];

if($_GET['mLangId'])
$mLangId=$_GET['mLangId'];
else
$mLangId=$_POST['mLangId'];

include('translations/mse-'.$mLangId.'.php');



if($_FILES['file_import']['name']) {

// 	  $n_name=generateNewName();
	  $out = array();
	  $filename=$_FILES['file_import']['name'];

	  preg_match('/\S+\.(\S+)$/', $filename, $out);

	  $upl_status= move_uploaded_file($_FILES['file_import']['tmp_name'], "tmp/".$_FILES['file_import']['name']);
	  $getFileName=$_FILES['file_import']['name'];

	  if($upl_status!='0') $upl_status='<font class="font_info">'.$mse_lang['File successfully uploaded'].'<br>';
	    else
	  $upl_status='<center><font class="font_error">'.$mse_lang['Error uploading file!'].'</font></center>';


  if(($out[1]=='csv')||($out[1]=='php')||($out[1]=='xml')) {

      switch ($out[1]){

	case 'csv':
	  $upl_status.='<br>'.$mse_lang['File type'].': <b>csv</b><br>';
	  $upl_status.=compile_csv($getFileName,$mse_lang);
	break;

	case 'php':
	  $upl_status.='<br>'.$mse_lang['File type'].': <b>php</b><br>';
	  $upl_status.=compile_php($getFileName,$mse_lang);
	break;

	case 'xml':
	  $upl_status.='<br>'.$mse_lang['File type'].': <b>xml</b><br>';
	  $upl_status.=compile_xml($getFileName,$mse_lang);
	break;

      }
    }
  else
    {
    $upl_status='<center><font class="font_error">'.$mse_lang['You can upload only'].'</font></center>';
    unlink("tmp/$getFileName");
    }
  }
else
  $upl_status="<center><font class='font_info'>{$mse_lang['Please select file']}</font></center>";

?>


	    <LINK href="bootstrap/css/bootstrap.css" type=text/css rel=stylesheet>
	    <LINK href="css/style.css" type=text/css rel=stylesheet>

    <?php


$result_get_this_lang = MYSQL_QUERY("SELECT `Title`,`Name` FROM `sys_localization_languages` WHERE `ID`='$langToProceed' LIMIT 1");


$langTitle=mysql_result($result_get_this_lang,0,"Title");
$langCode=mysql_result($result_get_this_lang,0,"Name");


    $result_get_catname = MYSQL_QUERY("SELECT `Name` FROM `sys_localization_categories` WHERE `ID`='$catToProceed'");

$cat_name=mysql_result($result_get_catname,0,'Name');

?>

<table cellpadding=0 cellspacing=0 border=0 width=100%>

<tr><td class="info_column_td" style='height:100px'>
  <center>
      <?php print $mse_lang['Select language file on your computer and press "Update"']?><br>
      <span style="color:#777777;"><i><?php print $mse_lang['only language files']?></i></span>
    <br><br>


  <form action='import.php' method='POST' enctype='multipart/form-data'>
      <?php # cat_selection(0);?>

    <input type='hidden' name='mLangId' value='<?php print $mLangId?>'>

    <input type='file' name='file_import' size='20'>
	<br><br>
    <input type='submit' class='btn' value=' <?php print $mse_lang['Upload']?>  '>

  </form>

</center>
</td></tr>



  <tr><td valign=top style='padding:20px'>

<?php print $upl_status.'</font>'?>

<!--       <iframe src='frame_load.php' width=100% height=430 name='filelist' style='border:none'></iframe> -->


</td></tr>



</table>

<?php
}
?>
