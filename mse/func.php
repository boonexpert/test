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
error_reporting(1);

include ("conn.php");

  session_start();


if((isset($_POST['dashboard']))||(isset($_GET['check_admin']))){

$admin_login=$_POST['user_id'];

	$result_check_salt=MYSQL_QUERY("SELECT `NickName`,`Password`,`Salt` FROM `Profiles` WHERE `role`='3' AND `NickName` = '$admin_login' LIMIT 1");



	$sSalt=mysql_result($result_check_salt,0,"Salt");
	$aNickName=mysql_result($result_check_salt,0,"NickName");
	$aPass=mysql_result($result_check_salt,0,"Password");

      $sPwd=$_POST['pwd'];

if(($aPass==sha1(md5($sPwd).$sSalt)) && ($admin_login==$aNickName)) {

$_SESSION['mseusername']=$admin_login;
$status='valid';
$status.='&sess='.$_SESSION['mseusername'];
		}

			else {

session_destroy();
unset($_SESSION['mseusername']);

					$status='invalid';
				}
	}


if ($_GET['action']=='logout') {

unset($_SESSION['mseusername']);
session_destroy();

	}



if(isset($_GET['mLangId'])) $_SESSION['mLangId']=$_GET['mLangId'];

if(!$_SESSION['mLangId'])
 $_SESSION['mLangId'] = 'en';

include('translations/mse-'.$_SESSION['mLangId'].'.php');

error_reporting(0);

function imp_exp($category,$lang,$lang_src){

include('translations/mse-'.$_SESSION['mLangId'].'.php');

      /**************************** EXPORT ****************************/

print '<li><a href="#" class="expimp" onClick="javascript:$(\'#exportmodal\').load(\'export.php?mLangId='.$_SESSION['mLangId'].'&catID='.$category.'&lang='.$lang.'&langSrc='.$lang_src.'\');""><i class="icon-arrow-up"></i> '.$mse_lang['Export'].'</a></li>';


      /**************************** IMPORT ****************************/

print '<li><a href="#" class="expimp" onClick="javascript:$(\'#exportmodal\').load(\'iframeimport.php\');"><i class="icon-arrow-down"></i> '.$mse_lang['Import'].'</a></li>';

      }


function show_header($ver,$type=""){

require_once('translations/mse-lang-list.php');
include('translations/mse-'.$_SESSION['mLangId'].'.php');

foreach($mse_lang_list as $mLangId => $mLangTitle) {

  $lActClass='';

  if($_SESSION['mLangId']==$mLangId) $lActClass='active';

    $topmainmenu.= <<<LANGSELECT

  <li class="$lActClass"><a href="?mLangId=$mLangId">$mLangTitle</a></li>

LANGSELECT;

}


$topmainmenu.= <<<CODE
<li class="divider-vertical"></li>
<li><a href='#' onclick="window.location='?action=logout'"><img class="divlogout"> {$mse_lang['Logout']}</a></li>

CODE;

$eType='';

if($type=='email') {

  $eType=": ".$mse_lang['E-mail Templates'];

}


?>

<html>

    <head>
    <title>Master Language Editor v.<?php print $ver.' '.$eType?> for Boonex Dolphin 7.4.x</title>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

	    <LINK href="bootstrap/css/bootstrap.css" type=text/css rel=stylesheet>
	    <LINK href="css/style.css" type=text/css rel=stylesheet>
	      <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	    <script type="text/javascript" src="js/jquery.textarearesizer.compressed.js"></script>
	    <script type="text/javascript" src="js/func.js"></script>
	    <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
	    

    </head>

    <body cellpadding='0' cellspacing='0' leftmargin='0' topmargin='0'>

<div id="exportmodal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="exportmodalLabel" aria-hidden="true">
 
</div>


<div id="addlangkeymodal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="addlangkeymodalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="addlangkeymodalLabel"><?php print $mse_lang['Add new language key...'];?></h3>
  </div>
  <div class="modal-body" style="height:410px;">

<form id="addkeyform" name="addkeyform" method="POST">
<label for="selectedCategoryAddKey" style="display:inline;bottom:5px;position:relative;font-weight:bold;">
<?php print $mse_lang['Category:'];?>
</label>
<select name="selectedCategoryAddKey" id="selectedCategoryAddKey" style="line-height:19px;width:100%;" class='ttooltip' data-toggle='tooltip' data-placement='bottom' data-original-title='<?php print $mse_lang['Category explanation']?>'>

<?php
$result_cats = MYSQL_QUERY("SELECT `ID`,`Name` FROM `sys_localization_categories`");


  while ($cat_keys=mysql_fetch_object($result_cats)){

    print <<<CODE
	  <option value="{$cat_keys->ID}">{$cat_keys->Name}</option>
CODE;

    }
  
?>
</select>

<br>
    <label for="newlangkey" style="display:inline;bottom:5px;position:relative;font-weight:bold;"><?php print $mse_lang['Key'];?></label>

    <input type="text" id="newlangkey" name="newlangkey" style="height:30px;width:100%;" placeholder="<?php print $mse_lang['ExampleKey'];?>" class='ttooltip'  data-toggle='tooltip' data-placement='top' data-original-title='<?php print $mse_lang['New key explanation']?>'>
    <div class="valuesbar"><?php print $mse_lang['Values'];?>:</div>

<?php

print lang_selection('', $addlangflag=1);

?>
</form>

    </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> <?php print $mse_lang['Cancel']?></button>
    <button class="btn btn-primary" id="addnewkeyclick"><i class="icon-ok icon-white"></i> <?php print $mse_lang['Save changes']?></button>

  </div>



<script>
$('.copytolangs').click(function(){  $('.newlangval').val($('.firstlang').val());});

$(function(){

$('.expimp').live('click',function(){

  $('#exportmodal').css({"width":"100px"}).modal("show").animate({"width":"710px"},600);


});



$('.ttooltip').tooltip();

  $('#addnewkeyclick').live('click',function(e){
  e.preventDefault();

      if($.trim($('#newlangkey').val()).length == 0)
	alert("<?php print $mse_lang['Please enter a language key']?>")
      else
	{
	var aParams = {
	    addlangkey:1,
	    serialize: $('#addkeyform').serialize(),
	    };
	$.ajax({
		type: 'POST',
		url: "receiver.php",
		data: aParams,
		success: function(sData) {
		if(sData=="200") {
		      $('#addlangkeymodal').modal("hide");
		      $('#alertinfo').html("<?php print $mse_lang['New key added']?>");
		      $('.alert').show().animate({"opacity":"1"},100).animate({"opacity":"0"},200).animate({"opacity":"1"},100).animate({"opacity":"0"},200).animate({"opacity":"1"},100).animate({"opacity":"0"},200).animate({"opacity":"1"},100);

		      console.log('sData: '+sData);
		      
		      $('#addkeyform').find("input[type=text], textarea").val("");
		      
		    }
		    else
		    {
			if(sData=='137') alert('<?php print $mse_lang['Key exists']?>');
		      else
			alert("<?php print $mse_lang['Possible error']?> "+sData);
		    }
		},
		dataType: 'text',
		async: true
	});

	}


  })
  

    $('.closealert').live('click', function(){
      $('.alert').animate({"opacity":"0"},100).hide();
    });
  
});
</script>

</div>


<div class="navbar">
              <div class="navbar-inner">
                <div class="container">

                   <a class="brand" href="#" style="font-size:16px;color:#08C;line-height:25px;"><b>Master Language Editor</b> v. <?php print $ver.$eType;?></a>
                   


                  <div class="nav-collapse collapse navbar-responsive-collapse">


                    <ul class="nav">
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php print $mse_lang['Menu']?> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
			  <li class="nav-header"><?php print $mse_lang['Show only']?></li>
<?php
if(!empty($_SESSION['category'])){

    if(empty($_SESSION['missed'])) $class_all='active'; else $class_all='';

    if(!strpos($_SERVER['SCRIPT_FILENAME'], 'emails')>0){
      print '<li class="'.$class_all.'"><a href=# onclick="window.location=\'index.php?values=all\'"><i class="icon-th-list"></i> '.$mse_lang['All values'].'</a></li>';


      if(!$_SESSION['search']){

	if($_SESSION['missed']) $class_miss='active'; else $class_miss='';
	  print '<li class="'.$class_miss.'"><a href=# onclick="window.location=\'index.php?values=missed\'"><i class="icon-warning-sign"></i> '.$mse_lang['Missed values'].'</a></li>';

      }
    }
}
else
{
if(!strpos($_SERVER['SCRIPT_FILENAME'], 'emails')>0)
 print '<li class="disabled"><a href=#>'.$mse_lang['SelectCategoryToSeeMenu'].'</a></li>';

}
if(strpos($_SERVER['SCRIPT_FILENAME'], 'emails')>0){
  $class_e='active';
  $class_s='';
  }
    else
    {
  $class_s='active';
    $class_e='';
  }
    
?>

<li class="<?php print $class_s?>"><a href="#" onclick="window.location='index.php?resetsearch'"><i class="icon-font"></i> <?php print $mse_lang['Language strings'];?></a></li>
<li class="<?php print $class_e?>"><a href="#" onclick="window.location='emails.php?resetsearch&mpage=1'"><i class=" icon-envelope"></i> <?php print $mse_lang['E-mail templates'];?></a></li>


                           <li class="divider"></li>
		    <li class="nav-header"><?php print $mse_lang['Export-Import'];?></li>
<?php
if(!strpos($_SERVER['SCRIPT_FILENAME'], 'emails')>0) {
  if(!empty($_SESSION['category'])){
  
    imp_exp($_SESSION['category'],$_SESSION['lang'],$_SESSION['lang_src']);
    
    print <<<CODEM
      <li class="divider"></li>
      <li class="nav-header">{$mse_lang['Administration']}</li>
      <li><a href="#addlangkeymodal" data-toggle="modal"><i class="icon-plus"></i> {$mse_lang['Add new language key...']}</a></li>
CODEM;
    }
  else
    print <<<CODE
      <li class="disabled"><a href="#"><i class="icon-remove"></i> {$mse_lang['Please choose a category']}</a></li>
CODE;
}
  else {
    print <<<CODEM
      <li class="disabled"><a href="#"><i class="icon-remove"></i> {$mse_lang['Available for strings only']}</a></li>
      <li class="divider"></li>
      <li class="nav-header">{$mse_lang['Administration']}</li>
      <li class="disabled"><a href="#"><i class="icon-plus"></i> {$mse_lang['Available for strings only']} </a></li>
CODEM;
}
?>
	
                        </ul>
                      </li>
                    </ul>



<?php
  search_form_header();
?>
 

	<ul class="nav pull-right">
	<?php print $topmainmenu; ?>
	</ul>
      </div><!-- /.nav-collapse -->
    </div>
  </div><!-- /navbar-inner -->
</div><!-- /navbar -->

<?php
if(!strpos($_SERVER['SCRIPT_FILENAME'], 'emails')>0) {
?>
<div class="btn-group" style="top:60px;left:20px;">
  <button class="btn fastbuttons ttooltip"  data-toggle='tooltip' data-placement='right' data-original-title='<?php print $mse_lang['Fast search for language key explanation']?>' id="_ABOUT_US"><?php print $mse_lang['About us']?></button>
  <button class="btn fastbuttons ttooltip"  data-toggle='tooltip' data-placement='right' data-original-title='<?php print $mse_lang['Fast search for language key explanation']?>' id="_TERMS_OF_USE"><?php print $mse_lang['Terms of use']?></button>
  <button class="btn fastbuttons ttooltip"  data-toggle='tooltip' data-placement='right' data-original-title='<?php print $mse_lang['Fast search for language key explanation']?>' id="_PRIVACY"><?php print $mse_lang['Privacy policy']?></button>

  <button class="btn fastbuttons ttooltip"  data-toggle='tooltip' data-placement='right' data-original-title='<?php print $mse_lang['Fast search for language key explanation']?>' id="_FAQ_INFO"><?php print $mse_lang['FAQ']?></button>
  <button class="btn fastbuttons ttooltip"  data-toggle='tooltip' data-placement='right' data-original-title='<?php print $mse_lang['Fast search for language key explanation']?>' id="_CONTACT"><?php print $mse_lang['Contact']?></button>
  <button class="btn fastbuttons ttooltip"  data-toggle='tooltip' data-placement='right' data-original-title='<?php print $mse_lang['Fast search for language key explanation']?>' id="_copyright"><?php print $mse_lang['Copyright']?></button>
</div>
<?php
}
?>

<script>
  $(function(){

    $(".fastbuttons").click(function(){
    
      document.location.href='?search_word='+this.id;
      return false;
    });

  });
</script>



    <table border=0 width=100% cellpadding=15 cellspacing=0 style='margin-top: 50px;'>


<?php


}


function search_form($type){
include('translations/mse-'.$_SESSION['mLangId'].'.php');
  $fAction='index.php';
  $fName='search_form';

if($type=='email'){

  $fAction='emails.php';
  $fName='em_search_form';

}
include('translations/mse-'.$_SESSION['mLangId'].'.php');



?>


	<table border=0 cellpadding=5 cellspacing=0 width=550>
	  <tr>
	    <td align=right>
	    </td>
	   </tr>
<tr><td colspan=2>
<div class='fastlinks'>
<?php

function actpass($link) {

  if($_SESSION['search']==$link)
    return "active";
      else
    return "";

}

?>






</div>

</td></tr>
</table>
</form>

<?php
}

/****************************************************/



function search_form_header(){
include('translations/mse-'.$_SESSION['mLangId'].'.php');

	$searchTextHolder = $mse_lang['Type keyword to search'];
    if($_SESSION['search'])
	$searchTextHolder = $mse_lang['Search results for'].' "'.$_SESSION['search'].'". '. $mse_lang['Select category to reset search'];

	
print <<<CODE
<form action='{$fAction}' name='{$fName}' method='GET' class="navbar-search pull-left">
    <div class="input-prepend">
      <span class="add-on"><i class="icon-search"></i></span>
      <input type='text' class='span2 ttooltip'  data-toggle='tooltip' data-placement='bottom' data-original-title='{$mse_lang['Search explanation']}' name='search_word' style="height:30px;width:470px;" placeholder='$searchTextHolder'>
      <span class="add-on addonright ttooltip" data-toggle='tooltip' data-placement='bottom' data-original-title='{$mse_lang['Reset search']}'><a href="?resetsearch"><i class="icon-remove"></i></a></span>
    </div>
 </form>
CODE;
 
}
 
function highlighter_text($text, $words)
{
    $split_words = explode( " " , $words );
    foreach($split_words as $word)
    {
        $color = "#FFFF00";
        $text = preg_replace("|($word)|Ui" ,
            "<span style=\"background:".$color.";\"><b>$1</b></span>" , $text );
    }
    return $text;
}


function objectsIntoArray($arrObjData, $arrSkipIndices = array())
{
    $arrData = array();

    // if input is object, convert into array
    if (is_object($arrObjData)) {
        $arrObjData = get_object_vars($arrObjData);
    }

    if (is_array($arrObjData)) {
        foreach ($arrObjData as $index => $value) {
            if (is_object($value) || is_array($value)) {
                $value = objectsIntoArray($value, $arrSkipIndices); // recursive call
            }
            if (in_array($index, $arrSkipIndices)) {
                continue;
            }
            $arrData[$index] = $value;
        }
    }
    return $arrData;
}


function replace_link($src_file){

      chmod($src_file, 0777);

		$handle = fopen($src_file, "rb");
		  $cont_processed = fread($handle, filesize($src_file));
		fclose($handle);

	$cont_processed = str_replace('<link>', "link", $cont_processed);

unlink($src_file);

		$w=fopen($src_file,'w');
		  $success=fwrite($w,$cont_processed);
		fclose($w);
}

function compile_xml($fileName,$mse_lang){

      $xmlUrl = 'tmp/'.$fileName;

// 	replace_link($xmlUrl);


      $xmlStr = file_get_contents($xmlUrl);
      $xmlObj = simplexml_load_string($xmlStr,'SimpleXMLElement', LIBXML_NOCDATA);
      $arrXml = objectsIntoArray($xmlObj);

$LangInfo=$arrXml['langInfo'];
$Strings=$arrXml['string_value'];



  $new_lang=0;

  $LangSrcInfo['Name']=$LangInfo['langCode'];
  $LangSrcInfo['langID']=$LangInfo['langID'];
  $LangSrcInfo['langCat']=$LangInfo['langCat'];
  $LangSrcInfo['Title']=$LangInfo['langName'];
  $LangSrcInfo['Flag']=$LangInfo['langFlag'];


  if(!empty($LangSrcInfo))
  {

      $lang_exist_check="SELECT `ID` FROM `sys_localization_languages` WHERE `Title`='".$LangSrcInfo['Title']."' AND `Name`='".$LangSrcInfo['Name']."'";
      $request_lang_check=MYSQL_QUERY($lang_exist_check);


    if(mysql_num_rows($request_lang_check)<1) {

    $langCat='1';
    $langCode=$LangSrcInfo['Name'];

 $lang_add="INSERT INTO `sys_localization_languages` (`Title`,`Name`,`Flag`)
    VALUES
      ('{$LangSrcInfo['Title']}','{$LangSrcInfo['Name']}','{$LangSrcInfo['Flag']}')";

$request_lang_add=MYSQL_QUERY($lang_add);



if($request_lang_add)
	$file_enabled=1;
else $error_0=$mse_lang['Error installing new language'].' '.mysql_error();

 $last_ins = @mysql_query("select last_insert_id() as lng_id");
	    $lid = mysql_fetch_assoc($last_ins);

    $langID=$lid['lng_id'];

$new_lang=1;

    }
    else {

	$langID=mysql_result($request_lang_check,0,'ID');
	$langCode=$LangSrcInfo['Name'];
	$langCat=1;
	$file_enabled=1;
    }
  }


  if($file_enabled==1) {

  $status='';
  $error_cnt=0;
  $str_cnt=0;
  $new_str_cnt=0;
  $upd_str_cnt=0;


$i=0;

while(!empty($Strings[$i])){


$value=str_replace("'","\'",$Strings[$i]['string']);
$keyid=str_replace("'","\'",$Strings[$i]['key']);


    $exist_check="SELECT `ID` FROM `sys_localization_keys` WHERE `Key`='$keyid' LIMIT 1";
    $request_check=MYSQL_QUERY($exist_check);

    if(mysql_num_rows($request_check)>0) {

	$checkKeyID=mysql_result($request_check,0,'ID');

  if($new_lang==1){
    $request_update=MYSQL_QUERY("INSERT INTO `sys_localization_strings` (`String`,`IDKey`,`IDLanguage`)
		  VALUES ('$value','$checkKeyID','$langID')");
$error_insert_str=mysql_error();
  }
  else
  {

	$exist_string_check="SELECT `ID` FROM `sys_localization_strings` WHERE `IDKey`='$keyid' AND `IDLanguage`='$langID' LIMIT 1";
	    $request_string_check=MYSQL_QUERY($exist_string_check);

if(mysql_num_rows($request_string_check)==0) {

      $request_update=MYSQL_QUERY("INSERT INTO `sys_localization_strings` (`String`,`IDKey`,`IDLanguage`)
		  VALUES ('$value','$checkKeyID','$langID')");
}

	  $do_update="UPDATE `sys_localization_strings` SET `String`='$value' WHERE `IDKey`='$checkKeyID' AND `IDLanguage`='$langID'";
	  $request_update=MYSQL_QUERY($do_update);
$error_do_update=mysql_error();
  }
	if($request_update)
	  {
	    $upd_str_cnt++;
	    $status.="<hr><br>&nbsp;&nbsp;&nbsp;".$mse_lang['Key updated']."<b> ".htmlspecialchars($keyid)."</b>: ".htmlspecialchars($value).". <br> ".mysql_error();
	  }
	else
	  {
	    $error_cnt++;
	    $status.="<br><br><font color=red>".$mse_lang['Error with UPDATE']." <b>$keyid</b>: </font>".$error_do_update.' '.$error_insert_str;
	  }
    }

    if(!mysql_num_rows($request_check))
    {
	    $do_insert_keys=MYSQL_QUERY("INSERT INTO `sys_localization_keys` (`IDCategory`,`Key`) VALUES ('$langCat','$keyid')");
$error_rep1=mysql_error();
    $last_ins = @mysql_query("select last_insert_id() as lng_id");
	    $lid = mysql_fetch_assoc($last_ins);

    if($lid['lng_id']>0)
	    $do_insert_str=MYSQL_QUERY("INSERT INTO `sys_localization_strings` (`String`,`IDKey`,`IDLanguage`)
		VALUES ('$value','".$lid['lng_id']."','$langID')");
$error_rep2=mysql_error();
	if(($do_insert_str)&&($do_insert_keys))
	  {
	    $new_str_cnt++;
	    $status.="<br>&nbsp;&nbsp;&nbsp;<font color='green'>".$mse_lang['Key inserted']." - $keyid</font>";
	  }
	    else
	  {
	    $error_cnt++;
	    $status.="<br><font color=red>".$mse_lang['Error with INSERT']." <b>$keyid</b>: </font><br>$error_rep1<br>$error_rep2";

	  }

    }

$str_cnt++;
++$i;
  }



$status.="<hr><br>".$mse_lang['Imported language']." {$LangSrcInfo['Title']}
<br>".$mse_lang['code']." {$LangSrcInfo['Name']}
<br>".$mse_lang['flag']." {$LangSrcInfo['Flag']}
<br>ID: $langID
";

  if($error_cnt>0) $status.="<br><br>".$mse_lang['Finished with ']." $error_cnt ".$mse_lang['errors'].".<br><br>";
	    else
	    $status.="<hr>".$mse_lang['Successfully finished!']."<br><br>";

  $status.=$mse_lang['Updated strings']." <b>$upd_str_cnt</b><br>
		 ".$mse_lang['New strings']." <b>$new_str_cnt</b><br>
		  ".$mse_lang['Total strings']." <b>$str_cnt</b><br>";
}
else
  $status="<center><font class='font_error'>".$mse_lang['Error in language file']." '$fileName': $report_checknew</font></center>";

    unlink("tmp/$fileName");

$status.='<br>'.$error_0;

  return $status;
}

/**********************************************************/

function compile_php($fileName,$mse_lang){


$file_array = file("tmp/$fileName");

$new_lang=0;

  include ("tmp/$fileName");

if($LANG_INFO){
  $aLangContent=$LANG;
  $LangSrcInfo=$LANG_INFO;
}

if($aLangInfo){
  $LangSrcInfo=$aLangInfo;
}


  if(!empty($LangSrcInfo))
  {

      $lang_exist_check="SELECT `ID`,`Name` FROM `sys_localization_languages` WHERE `Title`='".$LangSrcInfo['Title']."' AND `Name`='".$LangSrcInfo['Name']."'";
      $request_lang_check=MYSQL_QUERY($lang_exist_check);


    if(mysql_num_rows($request_lang_check)<1) {


    $langCat='1';
    $langCode=$LangSrcInfo['Name'];

 $lang_add="INSERT INTO `sys_localization_languages` (`Title`,`Name`,`Flag`)
    VALUES
      ('{$LangSrcInfo['Title']}','{$LangSrcInfo['Name']}','{$LangSrcInfo['Flag']}')";

$request_lang_add=MYSQL_QUERY($lang_add);

if($request_lang_add)
	$file_enabled=1;
else $error_0=$mse_lang['Error installing new language'].' '.mysql_error();

 $last_ins = @mysql_query("select last_insert_id() as lng_id");
	    $lid = mysql_fetch_assoc($last_ins);

    $langID=$lid['lng_id'];

$new_lang=1;

    }
    else {
	$langID=mysql_result($request_lang_check,0,'ID');
	$langCode=mysql_result($request_lang_check,0,'Name');
	$langCat=1;
	$file_enabled=1;
    }
  }
else
  {

$langID=$langVars['langID'];
$langCat=$langVars['langCat'];
$langCode=$langVars['langCode'];


if((!empty($langID))&&(!empty($langCode))&&(!empty($langCat))) $file_enabled=1;

  }

  if($file_enabled==1) {


  $status='';
  $error_cnt=0;
  $str_cnt=0;
  $new_str_cnt=0;
  $upd_str_cnt=0;

  foreach ($aLangContent as $keyid => $value) {

$value=str_replace("'","''",$value);
$keyid=str_replace("'","''",$keyid);

    $exist_check="SELECT `ID` FROM `sys_localization_keys` WHERE `Key`='$keyid' LIMIT 1";
    $request_check=MYSQL_QUERY($exist_check);

    if(mysql_num_rows($request_check)>0) {

	$checkKeyID=mysql_result($request_check,0,'ID');

  if($new_lang==1){
    $request_update=MYSQL_QUERY("INSERT INTO `sys_localization_strings` (`String`,`IDKey`,`IDLanguage`)
		  VALUES ('$value','$checkKeyID','$langID')");
$error_insert_str=mysql_error();
  }
  else
  {

	$exist_string_check="SELECT `ID` FROM `sys_localization_strings` WHERE `IDKey`='$keyid' AND `IDLanguage`='$langID' LIMIT 1";
	    $request_string_check=MYSQL_QUERY($exist_string_check);

if(mysql_num_rows($request_string_check)<1) {

      $request_update=MYSQL_QUERY("INSERT INTO `sys_localization_strings` (`String`,`IDKey`,`IDLanguage`)
		  VALUES ('$value','$checkKeyID','$langID')");
}

	  $do_update="UPDATE `sys_localization_strings` SET `String`='$value' WHERE `IDKey`='$checkKeyID' AND `IDLanguage`='$langID'";
	  $request_update=MYSQL_QUERY($do_update);
$error_do_update=mysql_error();
  }
	if($request_update)
	  {
	    $upd_str_cnt++;
	    $status.="<hr><br>&nbsp;&nbsp;&nbsp;".$mse_lang['Key updated']."<b> $keyid</b>: ".htmlspecialchars($value).". <br> ".mysql_error();
	  }
	else
	  {
	    $error_cnt++;
	    $status.="<br><br><font color=red>".$mse_lang['Error with UPDATE']." <b>$keyid</b>: </font>".$error_do_update.' '.$error_insert_str;
	  }
    }

    if(!mysql_num_rows($request_check))
    {
	    $do_insert_keys=MYSQL_QUERY("INSERT INTO `sys_localization_keys` (`IDCategory`,`Key`) VALUES ('$langCat','$keyid')");
$error_rep1=mysql_error();
    $last_ins = @mysql_query("select last_insert_id() as lng_id");
	    $lid = mysql_fetch_assoc($last_ins);

    if($lid['lng_id']>0)
	    $do_insert_str=MYSQL_QUERY("INSERT INTO `sys_localization_strings` (`String`,`IDKey`,`IDLanguage`)
		VALUES ('$value','".$lid['lng_id']."','$langID')");
$error_rep2=mysql_error();
	if(($do_insert_str)&&($do_insert_keys))
	  {
	    $new_str_cnt++;
	    $status.="<br>&nbsp;&nbsp;&nbsp;<font color='green'>{$mse_lang['Key inserted']} - $keyid</font>";
	  }
	    else
	  {
	    $error_cnt++;
	    $status.="<br><font color=red>{$mse_lang['Error with INSERT']} <b>$keyid</b>: </font><br>$error_rep1<br>$error_rep2";

	  }

    }

$str_cnt++;
  }



$status.="<hr><br>".$mse_lang['Imported language']." {$LangSrcInfo['Title']}
<br>".$mse_lang['code']." {$LangSrcInfo['Name']}
<br>".$mse_lang['flag']." {$LangSrcInfo['Flag']}
<br>ID: $langID

";

  if($error_cnt>0) $status.="<br><br>".$mse_lang['Finished with']." $error_cnt ".$mse_lang['errors'].".<br><br>";
	    else
	    $status.="<hr>".$mse_lang['Successfully finished!']."<br><br>";

  $status.=$mse_lang['Updated strings']." <b>$upd_str_cnt</b><br>
		  ".$mse_lang['New strings']." <b>$new_str_cnt</b><br>
		  ".$mse_lang['Total strings']." <b>$str_cnt</b><br>";
}
else
  $status="<center><font class='font_error'>".$mse_lang['Error in language file']." '$fileName': $report_checknew</font></center>";

    unlink("tmp/$fileName");

$status.='<br>'.$error_0;

  return $status;
}

function compile_csv($fileName,$mse_lang){


$fileName ="tmp/$fileName";


$nameExploded=explode('-',$fileName);

  $langID=$nameExploded['1'];
  $langCat=$nameExploded['2'];
  $langCode=$nameExploded['3'];

  $status='';
  $error_cnt=0;
  $str_cnt=0;
  $new_str_cnt=0;
  $upd_str_cnt=0;

$file_array = file($fileName);

$row = 0;
if (($handle = fopen($fileName, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
        $num = count($data)-1;
        $row++;


$keyid = $data[0];
$value = $data[2];

$value=str_replace("'","''",$value);
$keyid=str_replace("'","''",$keyid);


	    $exist_check="SELECT `ID` FROM `sys_localization_keys` WHERE `IDCategory`='{$langCat}' AND `Key`='{$keyid}' LIMIT 1";
		$request_check=MYSQL_QUERY($exist_check);

$error=mysql_error();
	$checkKeyID=mysql_result($request_check,0,'ID');
    if(mysql_num_rows($request_check)>0) {

      $exist_string_check="SELECT `ID` FROM `sys_localization_strings` WHERE `IDKey`='$keyid' AND `IDLanguage`='$langID' LIMIT 1";
		  $request_string_check=MYSQL_QUERY($exist_string_check);
// $status.= $exist_string_check.'<br><br>';
      if(mysql_num_rows($request_string_check)<1) {

	    $request_update=MYSQL_QUERY("INSERT INTO `sys_localization_strings` (`String`,`IDKey`,`IDLanguage`)
			VALUES ('$value','$checkKeyID','$langID')");
// $status.= "INSERT INTO `sys_localization_strings` (`String`,`IDKey`,`IDLanguage`) VALUES ('$value','$checkKeyID','$langID')".'<br><br>';
      }



	$do_update="UPDATE `sys_localization_strings` SET `String`='{$value}' WHERE `IDKey`='{$checkKeyID}' AND `IDLanguage`='{$langID}'";


	$request_update=MYSQL_QUERY($do_update);

	if($request_update)
	  {
	    $upd_str_cnt++;
	    $status.="<br>&nbsp;&nbsp;&nbsp;{$mse_lang['Key updated']}<b> $keyid</b>".mysql_error();
	  }
	else
	  {
	    $error_cnt++;
	    $status.="<br><font color=red>{$mse_lang['Error updating with']} <b>$keyid</b>: </font>".mysql_error();
	  }
    }
    else
    {
	    $do_insert_keys=MYSQL_QUERY("INSERT INTO `sys_localization_keys` (`IDCategory`,`Key`) VALUES ('{$langCat}','{$keyid}')");

    $last_ins = @mysql_query("select last_insert_id() as lng_id");
	    $lid = mysql_fetch_assoc($last_ins);

    if($lid['lng_id']>0)
	    $do_insert_str=MYSQL_QUERY("INSERT INTO `sys_localization_strings` (`String`,`IDKey`,`IDLanguage`)
		VALUES ('{$value}','".$lid['lng_id']."','{$langID}')");

	if($do_insert_str)
	  {
	    $new_str_cnt++;
	    $status.="<br>&nbsp;&nbsp;&nbsp;<font color='green'>{$mse_lang['Key inserted']} - $keyid</font>";
	  }
	    else
	  {
	    $error_cnt++;
	    $status.="<br><font color=red>{$mse_lang['Error inserting with']} <b>$keyid</b>: </font> $error ".mysql_error();
	  }
    }
$str_cnt++;

    }
    fclose($handle);
}

if($error_cnt>0)
    $status.="<br><br>{$mse_lang['Finished with']} $error_cnt {$mse_lang['errors']}.<br><br>";
	  else
	  $status.="<hr>{$mse_lang['Successfully finished']}<br><br>";

$status.="{$mse_lang['Updated strings']} <b>$upd_str_cnt</b><br>
		{$mse_lang['New strings']} <b>$new_str_cnt</b><br>
		{$mse_lang['Total strings']} <b>$str_cnt</b><br>";

    unlink("$fileName");

return $status;

}

function get_date(){

  $date=date("dmy_hi");

  return $date;
}

function filelist($what_export,$langToProceed,$catToProceed,$langSrc,$langCode){

include('translations/mse-'.$_SESSION['mLangId'].'.php');

$lang_getvars=getLangName($langToProceed);

$langTitle=$lang_getvars['title'];
$langCode=$lang_getvars['name'];

print "<table cellpadding=5 cellspacing=0 border=0 width=100% class='table table-striped'>
	  <tr><td colspan=3 style='padding-bottom:11px;text-align:center;'>
	  
	    <a href='frame_filelist.php?mLangId={$_SESSION['mLangId']}&export=$what_export&lang=".$langToProceed."&catID=".$catToProceed."&langSrc=".$langSrc."&action=export&langCode=$langCode' class='btn btn-large btn-primary'><i class='icon-arrow-down icon-white'></i>
	      {$mse_lang['click to export']} $what_export...
	    </a>
	  </td></tr>";

  $i = 0;
$dir="langs/$what_export/";
  $handle = opendir($dir);

  while($file = readdir($handle))
  {
    if ($file != '.' && $file != '..')
    {
      $func[$i] = $file;
	  chmod($func[$i], 0644);

	  print '<tr><td><a href="'.$dir.$func[$i].'" class="filelist">
		      <img src="images/icons/'.$what_export.'-32.png" title="'.$mse_lang['Download this file'].'">
		    </a>
		    </td>
		      <td>
		  <a href="'.$dir.$func[$i].'" class="filelist" title="'.$mse_lang['Download this file'].'">'.$func[$i].'</a></td>
		  <td>

		  <a href="?export='.$what_export.'&catID='.$catToProceed.'&lang='.$langToProceed.'&langSrc='.$langSrc.'&langCode='.$langCode.'&del='.$func[$i].'" class="filelist">
		      <i class="icon-remove" title="'.$mse_lang['Delete this file'].'"></i></a></td>';
      $i++;
    }
  }
if($i==0) print '<tr><td colspan=2 style="padding-top: 50px;" align=center>
  <font class="filelist">'.$mse_lang['No files here'].'</font></td>';

print "</table>";

}

function get_csv($lang,$category,$langCode,$langSrc){

include('translations/mse-'.$_SESSION['mLangId'].'.php');

    $result_get_catname = MYSQL_QUERY("SELECT `Name` FROM `sys_localization_categories` WHERE `ID`='$category'");

$cat_name=mysql_result($result_get_catname,0,'Name');
$cat_name_s=str_replace(' ','_',$cat_name);

    $result_get_keys = MYSQL_QUERY("SELECT `ID`,`Key` FROM `sys_localization_keys` WHERE `IDCategory`='$category'");

  while ($lang_data=mysql_fetch_object($result_get_keys)){

$getstrings_query="SELECT `String` FROM `sys_localization_strings` WHERE `IDLanguage`='$lang' AND `IDKey`='".$lang_data->ID."' LIMIT 1";
$getstringsSrc_query="SELECT `String` FROM `sys_localization_strings` WHERE `IDLanguage`='$langSrc' AND `IDKey`='".$lang_data->ID."' LIMIT 1";

    $result_get_strings = MYSQL_QUERY($getstrings_query);
    $result_getSrc_strings = MYSQL_QUERY($getstringsSrc_query);

    $getStr=str_replace('"','""',mysql_result($result_get_strings,0,'String'));
    $getSrcStr=str_replace('"','""',mysql_result($result_getSrc_strings,0,'String'));

      $array_csv.='"'.$lang_data->Key.'";"'.$getSrcStr.'";"'.$getStr.'";
';
  }

/************************************/

$getdatesrc=get_date();


$csvextension=".csv";
$filenamesrc=$cat_name_s."-".$lang.'-'.$category.'-'.$langCode."-".$getdatesrc.$csvextension;
$filepath="langs/csv/";

  $file=$filepath.$filenamesrc.$csvextension;
  $w=fopen($file,'w');
  $success=fwrite($w,$array_csv);
  fclose($w);

  $c=fopen($filepath.$filenamesrc.'.zip','w');
  fclose($c);

  $zip = new ZipArchive;
  if ($zip->open($filepath.$filenamesrc.'.zip') === TRUE) {
      $zip->addFile($file,$filenamesrc.$csvextension);
      $zip->close();
  }
else {
      $status= $mse_lang['Sorry, failed to create file.<br>Check if directory'].' '.$filepath.' '.$mse_lang['has chmod 0777 and PHP compiled zip extention'].'';
unlink($filepath.$filenamesrc.'.zip');
}

unlink($file);

}


function get_xml($lang,$category,$langCode){

include('translations/mse-'.$_SESSION['mLangId'].'.php');

    $result_get_catname = MYSQL_QUERY("SELECT `Name` FROM `sys_localization_categories` WHERE `ID`='$category'");

$cat_name=mysql_result($result_get_catname,0,'Name');


$cat_name_s=str_replace(' ','_',$cat_name);

    $result_get_keys = MYSQL_QUERY("SELECT `ID`,`Key` FROM `sys_localization_keys` WHERE `IDCategory`='$category'");

    $result_get_langTitle = MYSQL_QUERY("SELECT `Title`,`Flag` FROM `sys_localization_languages` WHERE `ID`='$lang' LIMIT 1");

$langTitle=mysql_result($result_get_langTitle,0,'Title');
$langFlag=mysql_result($result_get_langTitle,0,'Flag');

$array_php='<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<page>
  <langInfo>
      <langName>'.$langTitle.'</langName>
      <langCode>'.$langCode.'</langCode>
      <langID>'.$lang.'</langID>
      <langFlag>'.$langFlag.'</langFlag>
      <langCat>'.$cat_name.'</langCat>
  </langInfo>

  <Date>'.date("Y-m-d H-s-i").'</Date>
  <timestamp>'.mktime().'</timestamp>


';


  while ($lang_data=mysql_fetch_object($result_get_keys)){



$getstrings_query="SELECT `String` FROM `sys_localization_strings` WHERE `IDLanguage`='$lang' AND `IDKey`='".$lang_data->ID."' LIMIT 1";

    $result_get_strings = MYSQL_QUERY($getstrings_query);

$string=mysql_result($result_get_strings,0,'String');

      $array_php.="	<string_value>\r\n";
      $array_php.="		<keyid>".$lang_data->ID."</keyid>\r\n";
      $array_php.="		<key><![CDATA[".$lang_data->Key."]]></key>\r\n";
      $array_php.="		<string><![CDATA[".$string."]]></string>\r\n";
      $array_php.="	</string_value>\r\n";


  }
 $array_php.="</page>\r\n";

$getdatesrc=get_date();

$fileextension=".xml";

$filenamesrc=$cat_name_s."-".$lang.'-'.$category.'-'.$langCode."-".$getdatesrc.$fileextension;

$filepath="langs/xml/";

  $file=$filepath.$filenamesrc.$fileextension;
  $w=fopen($file,'w');
  $success=fwrite($w,$array_php);
  fclose($w);

  $c=fopen($filepath.$filenamesrc.'.zip','w');
  fclose($c);

  $zip = new ZipArchive;
  if ($zip->open($filepath.$filenamesrc.'.zip') === TRUE) {
      $zip->addFile($file,$filenamesrc.$fileextension);
      $zip->close();
  }
else
      print $mse_lang['Sorry, failed to create file.<br>Check if directory'].' '.$filepath.' '.$mse_lang['has chmod 0777 and PHP compiled zip extention'].'';


unlink($file);

}

function get_php($lang,$category,$langCode){

include('translations/mse-'.$_SESSION['mLangId'].'.php');

    $result_get_catname = MYSQL_QUERY("SELECT `Name` FROM `sys_localization_categories` WHERE `ID`='$category'");

$cat_name=mysql_result($result_get_catname,0,'Name');
$cat_name_s=str_replace(' ','_',$cat_name);

    $result_get_keys = MYSQL_QUERY("SELECT `ID`,`Key` FROM `sys_localization_keys` WHERE `IDCategory`='$category'");

$array_php='<?php 

$langVars=array(
      \'langCode\'=>\''.$langCode.'\',
      \'langCat\'=>\''.$cat_name.'\',
      \'langID\'=>\''.$lang.'\'
);

$aLangContent = array(
';


  while ($lang_data=mysql_fetch_object($result_get_keys)){

$getstrings_query="SELECT `String` FROM `sys_localization_strings` WHERE `IDLanguage`='$lang' AND `IDKey`='".$lang_data->ID."' LIMIT 1";

    $result_get_strings = MYSQL_QUERY($getstrings_query);

$string=addslashes(mysql_result($result_get_strings,0,'String'));
$langDataKey=addslashes($lang_data->Key);

      $array_php.="	'".$langDataKey."' => '".$string."',
";

  }
 $array_php.='
);
?>';

$getdatesrc=get_date();

$phpextension=".php";

$filenamesrc=$cat_name_s."-".$lang.'-'.$category.'-'.$langCode."-".$getdatesrc.$phpextension;

$filepath="langs/php/";

  $file=$filepath.$filenamesrc.$phpextension;
  $w=fopen($file,'w');
  $success=fwrite($w,$array_php);
  fclose($w);

  $c=fopen($filepath.$filenamesrc.'.zip','w');
  fclose($c);

  $zip = new ZipArchive;
  if ($zip->open($filepath.$filenamesrc.'.zip') === TRUE) {
      $zip->addFile($file,$filenamesrc.$phpextension);
      $zip->close();
  }
else
      print $mse_lang['Sorry, failed to create file.<br>Check if directory'].' '.$filepath.' '.$mse_lang['has chmod 0777 and PHP compiled zip extention'].'';

unlink($file);

}

function cat_selection($autosubmit){

include('translations/mse-'.$_SESSION['mLangId'].'.php');

 $result_getlangs = MYSQL_QUERY("SELECT `ID`,`Name` FROM `sys_localization_categories`");

if($autosubmit==1) $sel_add=" onChange='javascript:form.submit(this);'";

  print "<select name='category' $sel_add class='langselect ttooltip' data-toggle='tooltip' data-placement='bottom' data-original-title='{$mse_lang['Category choose explanation']}'>";

print "<option value=''>{$mse_lang['Select category']}</option>";

    while ($cat_data=mysql_fetch_object($result_getlangs)){

    $selected='';

      if($_SESSION['category']==$cat_data->ID) $selected="selected=selected";
	print "<option value='{$cat_data->ID}' $selected>{$cat_data->ID} {$cat_data->Name}</option>";
  }
if($_SESSION['category']=='0') $selected1="selected=selected";
print "<option value='0' $selected1>{$mse_lang['Other']}</option>";
print '</select>';


}

function src_lang_selection($email_tpl=''){

include('translations/mse-'.$_SESSION['mLangId'].'.php');

$first_opt='';
if($email_tpl) $first_opt="<option value='0'>{$mse_lang['Default']}</option>";

 $result_getlangs = MYSQL_QUERY("SELECT `ID`,`Name`,`Flag`,`Title` FROM `sys_localization_languages`");

print "<font class='msg'>{$mse_lang['Source language']}</font> ";
  print "<select name='lang_src' onChange='javascript:form.submit(this);' class='langselect ttooltip'  data-toggle='tooltip' data-placement='top' data-original-title='{$mse_lang['Source language to translate']}'>'";

print $first_opt;

  while ($s_lang_data=mysql_fetch_object($result_getlangs)){

  $sselected='';

    if($_SESSION['lang_src']==$s_lang_data->ID) $sselected="selected=selected";
      print "<option value='{$s_lang_data->ID}' $sselected>{$s_lang_data->ID} {$s_lang_data->Title}</option>";
  }

print '</select>';

}

function lang_selection($email_tpl='', $addlangflag=0){

include('translations/mse-'.$_SESSION['mLangId'].'.php');

$first_opt='';
if($email_tpl) $first_opt="<option value='0'>{$mse_lang['Default']}</option>";

 $result_getlangs = MYSQL_QUERY("SELECT `ID`,`Name`,`Flag`,`Title` FROM `sys_localization_languages` ORDER BY `ID`");

 
   if($addlangflag==1){

  $i=0;
  $box="";
  $cls="";
	while ($lang_data=mysql_fetch_object($result_getlangs)){

	  if($i==0){
	    $box=<<<CODE
	    <div class="copytoall"><button class="btn btn-small copytolangs ttooltip"  data-toggle='tooltip' data-placement='bottom' data-original-title='{$mse_lang['Copy to all languages explanation']}' type="button"><i class="icon-chevron-down"></i> {$mse_lang['Copy to all languages']}</button></div>
CODE;
	    $cls="firstlang";
	  }
	  else {
	    $box="";
	    $cls="newlangval";
	  }
$i=1;
	    $retcode.= <<<CODE
	      <div class="langvaldiv">$box
		  <label for="newlangval_{$lang_data->ID}" class="langnamebar">{$lang_data->Title}</label>
		  <textarea id="newlangval_{$lang_data->ID}" name="newlangval_{$lang_data->ID}" class="$cls ttooltip"  data-toggle='tooltip' data-placement='top' data-original-title='{$mse_lang['Language value explanation']} {$lang_data->Title}' placeholder="{$mse_lang['Example']} ({$mse_lang['for']} {$lang_data->Title})"></textarea>
	      </div>
CODE;

	}
	
	  return $retcode;
    }
  else
    {
      print "<font class='msg'>{$mse_lang['Edit language']}</font> ";
      print "<select name='lang' onChange='javascript:form.submit(this);' class='langselect ttooltip'  data-toggle='tooltip' data-placement='top' data-original-title='{$mse_lang['Target language to translate']}'>'";

      print $first_opt;

	while ($lang_data=mysql_fetch_object($result_getlangs)){

	$selected='';

	  if($_SESSION['lang']==$lang_data->ID) $selected="selected=selected";
	    print "<option value='{$lang_data->ID}' $selected>{$lang_data->ID} {$lang_data->Title}</option>";
	}

      print '</select>';

    }

}

function getLangName($langID){

$result_get_this_lang = MYSQL_QUERY("SELECT `Title`,`Name` FROM `sys_localization_languages` WHERE `ID`='$langID' LIMIT 1");

$lang['title']=mysql_result($result_get_this_lang,0,"Title");
$lang['name']=mysql_result($result_get_this_lang,0,"Name");

return $lang;
}

/***************************** SAVE E-MAILS *********************************/
if($_POST['em_value']=='1') {

$em_lang=$_POST['em_lang'];
$keyid=$_POST['keyid'];
$targ_keyid=$_POST['targ_keysID'];

$name=$_POST['em_name'];

$mSubject=$_POST['subject'];
$mBody=$_POST['message'];



for($i=0;$i<count($mSubject);++$i) {

if((!empty($mSubject[$i]))&&(!empty($mBody[$i]))) {
  $check_string_query=MYSQL_QUERY("SELECT `ID` FROM `sys_email_templates` WHERE `name`='{$name[$i]}' AND `LangID`='$em_lang' LIMIT 1");

  if(mysql_num_rows($check_string_query)<1)
	    $updatestring_query="INSERT INTO `sys_email_templates` (`LangID`,`Name`,`Subject`,`Body`) VALUES ('$em_lang','{$name[$i]}','{$mSubject[$i]}','{$mBody[$i]}')";
  else{
	$keyid1=mysql_result($check_string_query,0,'ID');
	$updatestring_query="UPDATE `sys_email_templates` SET `Subject`='{$mSubject[$i]}', `Body`='{$mBody[$i]}' WHERE `ID`='$keyid1'";

  }

}

  if((empty($mSubject[$i]))||(empty($mBody[$i])))
      $updatestring_query="DELETE FROM `sys_email_templates` WHERE `ID`='$targ_keyid[$i]'";



      $dbquery = MYSQL_QUERY($updatestring_query);


  if(mysql_error()) print mysql_error().'<br>';
}

    $status = $mse_lang['Successfully saved'];

    }

/***************************** SAVE STRINGS *********************************/
if($_POST['ch_value']=='1') {

  foreach ($_POST as $keyid => $value) {

    if($keyid=='ch_lang') $ch_lang=$value;
    if($keyid=='ch_category') $ch_category=$value;

	if(($keyid!='ch_value')&&($keyid!='ch_lang')&&($keyid!='ch_category')) {

    $if_string_query="SELECT `IDKey` FROM `sys_localization_strings` WHERE `IDKey`='$keyid' AND `IDLanguage`='$ch_lang'";

	$dbquery_if = MYSQL_QUERY($if_string_query);

$value_mod=addslashes($value);

      if(mysql_num_rows($dbquery_if)>0){

	  $getstring_query="UPDATE `sys_localization_strings` SET `String`='$value_mod' WHERE `IDKey`='$keyid' AND `IDLanguage`='$ch_lang'";

    $dbquery = MYSQL_QUERY($getstring_query);

	}
      else
	if(!empty($value)) {
	  $getstring_query="INSERT INTO `sys_localization_strings` (`String`,`IDKey`,`IDLanguage`) VALUES ('$value_mod','$keyid','$ch_lang')";
	  $dbquery = MYSQL_QUERY($getstring_query);

	  }

	    if($dbquery)
	      $status = $mse_lang['Successfuly saved'];
	    else
	      $status = "<font color='red'><b>{$mse_lang['Error in']} $keyid: ".mysql_error().'</b></font>';
	}

      }

    }

function show_emails($sess_lang,$lang_keys_id,$target_keysID,$aeven,$iEven,$rows,$lang_value,$origString,$name,$origSubject,$subject,$desc){

include('translations/mse-'.$_SESSION['mLangId'].'.php');

print "<input type='hidden' name='keyid[]' value='$lang_keys_id'>
      <input type='hidden' name='em_name[]' value='$name'>
      <input type='hidden' name='lang[]' value='$sess_lang'>
      <input type='hidden' name='targ_keysID[]' value='$target_keysID'>
<tr><td class='key_td_$aeven'>{$mse_lang['Message ID']} $lang_keys_id<br><br><b>$name</b><br><br>$desc<br></td>
<td class='orig_td_$aeven' style='width:400px'><div id='src_$lang_keys_id'>
<b>{$mse_lang['Subject']}</b><br>
    <input type='text' size=52 value='$origSubject' id='src_subj_$lang_keys_id' disabled style='background:#ffffff;color:#000000;width:100%'><br><br>
<b>{$mse_lang['Message']}</b><br>
    <textarea id='mail_src_$lang_keys_id' rows='$rows' class='resizable' disabled style='background:#ffffff;color:#000000;width:100%'>
$origString
</textarea>

</div></td>";

    print '<td class="copybox">
	    <img src="images/icons/copy.png" onClick="javascript:copy_orig_mail(\''.$lang_keys_id.'\');" class="btn_arrow ttooltip"  data-toggle="tooltip" data-placement="top" data-original-title="'.$mse_lang['Copy from the left column'].'">
	    <br>
	    <img src="images/eye.png" onClick="javascript:window.open(\'view_email.php?keyID='.$lang_keys_id.'\',\'editor_window\',
    \'height=630,width=800,status=yes,toolbar=no,menubar=no,location=no\');" class="btn_arrow ttooltip"  data-toggle="tooltip" data-placement="top" data-original-title="'.$mse_lang['Open editor'].'" style="max-width:40px;">
	  ';

    print "</td>";

    print "<td class='trans_td_$aeven' style='width:400px'>


<b>{$mse_lang['Subject']}</b><br>
      <input type='text' name='subject[]' id='dest_subj_$lang_keys_id' size=52 value='$subject' style='width:100%'><br><br>
<b>{$mse_lang['Message']}";

if($target_keysID) print " (id = $target_keysID)";

print ":</b><br>
      <textarea id='dest_$lang_keys_id' name='message[]' style='width:100%' rows='$rows' class='resizable'>$lang_value</textarea>";

    print "</td></tr>";

}

function show_result($sess_lang,$lang_keys_id,$aeven,$iEven,$rows,$lang_value,$origString,$lang_key,$status=0,$approved=0){

include('translations/mse-'.$_SESSION['mLangId'].'.php');

  if($approved==1){
    $background='#b0f4b3';
    $checked='checked';
  }
  else{
    $background='#ffffff';
  }

if($_SESSION['search']) {


$lang_key = highlighter_text($lang_key, $_SESSION['search']);
// $origString = highlighter_text($origString, $words);


}


print "<tr id='line_$lang_keys_id'><td class='key_td_$aeven'><i>#$iEven</i><br>{$mse_lang['key id']} ".$lang_keys_id."<br><b>".$lang_key.'</b><br><br>
'.$status.'
</td>';

print "<td class='orig_td_$aeven' style='width:400px'><div id='src_$lang_keys_id'>".$origString."</div></td>".'<td class="copybox">
	<img src="images/icons/copy.png" onClick="javascript:copy_orig(\''.$lang_keys_id.'\');" class="btn_arrow ttooltip"  data-toggle="tooltip" data-placement="top" data-original-title="'.$mse_lang['Copy from the left column'].'" title="'.$mse_lang['Copy from the left column'].'">
	<br>
	<img src="images/eye.png" onClick="javascript:window.open(\'pop_editor.php?keyID='.$lang_keys_id.'\',\'editor_window\',
\'height=630,width=800,status=yes,toolbar=no,menubar=no,location=no\');" style="max-width:40px;" class="btn_arrow ttooltip"  data-toggle="tooltip" data-placement="bottom" data-original-title="'.$mse_lang['Open visual editor'].'">
      '."</td><td class='trans_td_$aeven' style='width:400px'>
	<textarea id='dest_$lang_keys_id' name='$lang_keys_id' cols='100' rows='$rows' class='resizable'  style='background-color:$background;border:solid 1px #eaeaea;padding:10px;font-size:14px;width:100%'>$lang_value</textarea></td>
</tr>";

}
?>
