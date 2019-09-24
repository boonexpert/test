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


if($_GET['mLangId'])
$mLangId=$_GET['mLangId'];
else
$mLangId=$_POST['mLangId'];


  $langToProceed=$_GET['lang'];
  $catToProceed=$_GET['catID'];
  $langSrc=$_GET['langSrc'];
  $what_export=$_GET['export'];
  
  
  $result_get_this_lang = MYSQL_QUERY("SELECT `Title`,`Name` FROM `sys_localization_languages` WHERE `ID`='$langToProceed' LIMIT 1");

  $langTitle=mysql_result($result_get_this_lang,0,"Title");
  $langCode=mysql_result($result_get_this_lang,0,"Name");


      $result_get_catname = MYSQL_QUERY("SELECT `Name` FROM `sys_localization_categories` WHERE `ID`='$catToProceed'");

  $cat_name=mysql_result($result_get_catname,0,'Name');
?>
 <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 id="exportmodalLabel"><?php print $mse_lang['Export'].' '.$langTitle.' '.$mse_lang['language file for'].' "'.$cat_name;?></h4>
  </div>
  <div class="modal-body">





<table cellpadding=0 cellspacing=0 border=0 width=100%>


<tr><td class="info_column_td left_info_td">
<table cellpadding='0' cellspacing='0' border='0'>
<tr>
<td width=10 style='padding:5px;'>
<?php
/****************** To CSV ***********************/
print '<a href="frame_filelist.php?mLangId='.$mLangId.'&export=csv&lang='.$langToProceed.'&catID='.$catToProceed.'&langSrc='.$langSrc.'&langCode='.$langCode.'" class="links_popup" target="filelist"><img src="images/icons/csv-48.png" border=0 title="'.$mse_lang['Export to CSV'].'"></a>
</td><td>
<a href="frame_filelist.php?mLangId='.$mLangId.'&export=csv&lang='.$langToProceed.'&catID='.$catToProceed.'&langSrc='.$langSrc.'&langCode='.$langCode.'" class="links_popup" target="filelist">'.$mse_lang['Export to CSV'].'</a>

</td></tr>

<!--/******************* To PHP **********************/ -->
<tr><td style="padding:5px;">

<a href="frame_filelist.php?mLangId='.$mLangId.'&export=php&lang='.$langToProceed.'&catID='.$catToProceed.'&langSrc='.$langSrc.'&langCode='.$langCode.'" class="links_popup" target="filelist"><img src="images/icons/php-48.png" border=0 title="'.$mse_lang['Export to PHP'].'"></a>

</td><td>

<a href="frame_filelist.php?mLangId='.$mLangId.'&export=php&lang='.$langToProceed.'&catID='.$catToProceed.'&langSrc='.$langSrc.'&langCode='.$langCode.'" class="links_popup" target="filelist">'.$mse_lang['Export to PHP'].'</a>

 </td></tr>

<!--/******************* To XML **********************/ -->
<tr><td style="padding:5px;">

<a href="frame_filelist.php?mLangId='.$mLangId.'&export=xml&lang='.$langToProceed.'&catID='.$catToProceed.'&langSrc='.$langSrc.'&langCode='.$langCode.'" class="links_popup" target="filelist"><img src="images/icons/xml-48.png" border=0 title="'.$mse_lang['Export to XML'].'"></a>

</td><td>

<a href="frame_filelist.php?mLangId='.$mLangId.'&export=xml&lang='.$langToProceed.'&catID='.$catToProceed.'&langSrc='.$langSrc.'&langCode='.$langCode.'" class="links_popup" target="filelist">'.$mse_lang['Export to XML'].'</a>

</td></tr>
<!--//*****************************************/-->


    </table>
    </td>

<td valign=top style="border-left:solid 1px #EEE;">

<iframe src="frame_filelist.php?mLangId='.$mLangId.'" width=100% height=330 name="filelist" style="border:none"></iframe>
';
}
?>


&nbsp;
</td></tr></table>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>