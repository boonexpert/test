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

include 'func.php';

error_reporting(0);

  session_start();

if(isset($_GET['mLangId'])) $_SESSION['mLangId']=$_GET['mLangId'];

if(!$_SESSION['mLangId'])
 $_SESSION['mLangId'] = 'en';

require_once('translations/mse-'.$_SESSION['mLangId'].'.php');



if(isset($_POST['dashboard'])){

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

if($_SESSION['mseusername']){

    if(isset($_GET['lang'])) $_SESSION['lang']=$_GET['lang'];

    if(!$_SESSION['lang']) $_SESSION['lang']=0;



    if(isset($_GET['lang_src'])) $_SESSION['lang_src']=$_GET['lang_src'];

    if(!$_SESSION['lang_src']) $_SESSION['lang_src']="0";

    if((isset($_GET['category']))&&(!empty($_GET['category']))) $_SESSION['category']=$_GET['category'];

    if((isset($_GET['mpage']))&&(!empty($_GET['mpage']))) $_SESSION['mpage']=$_GET['mpage'];

    if((isset($_GET['emails']))&&(!empty($_GET['emails']))) $_SESSION['emails']=$_GET['emails'];

    if((isset($_POST['search_word']))&&(!empty($_POST['search_word']))) {

	    $_SESSION['category']='';

	    $_SESSION['search']=$_POST['search_word'];
	    $pagethis=0;
	    $_SESSION['page']=1;
    }

if((isset($_GET['search_word']))&&(!empty($_GET['search_word']))) {

	    $_SESSION['category']='';

	    $_SESSION['search']=$_GET['search_word'];

$_SESSION['mpage']=1;
}

      if(isset($_GET['resetsearch'])) {

	  $_SESSION['page']=1;
	  unset($_SESSION['search']);
	  unset($_SESSION['missed']);

      }
      
$sLangSrc=$_SESSION['lang_src'];
$sLang=$_SESSION['lang'];


show_header('2.1','email');

?>



    <?php


    $langGet=getLangName($_SESSION['lang']);

    $langTitle=$langGet['title'];
    $langCode=$langGet['name'];




    print '<tr><td colspan=3>';

print '<br>
<div class="alert alert-info" style="margin:0;top:60px;display:block;">
<button type="button" class="close" data-dismiss="alert">×</button>
<font class="infoi">i</font> '.$mse_lang['To delete mail rule'].'
</div>';


    print "<table border=0 width=100% cellpadding=15 cellspacing=0 style='border-collapse:collapse'>";

    print "<tr>";


      if(!empty($_SESSION['search']))
	{
	
	$search_sql="WHERE `Key` REGEXP '".$_SESSION['search']."'";
$searchadd = " AND `Subject` REGEXP '".$_SESSION['search']."' OR `Body` REGEXP '".$_SESSION['search']."'";
	$result_searchkeys = MYSQL_QUERY("SELECT `ID`, `Subject` FROM `sys_email_templates` WHERE `Subject` REGEXP '".$_SESSION['search']."' OR `Body` REGEXP '".$_SESSION['search']."'");

	$base_query = "SELECT `ID`, `Subject` FROM `sys_email_templates` WHERE `Subject` REGEXP '".$_SESSION['search']."' OR `Body` REGEXP '".$_SESSION['search']."'";
	
    if(mysql_num_rows($result_searchkeys)>0) {

	  $isrch=0;

	  $search_str=' OR ';

	  while ($srch_keys=mysql_fetch_object($result_searchkeys)){

	    $isrch++;

	    $search_str.=" `ID`='{$srch_keys->IDKey}' ";

	    if($isrch!=mysql_num_rows($result_searchkeys)) $search_str.=" OR ";

	    }
// 	      $search_str.='';
	  }

	}
      else
	{
$searchadd = '';
	  $search_str='';
$iPage=1;

 $base_query = "SELECT `ID` FROM `sys_email_templates` $search_sql WHERE `LangID`='$sLangSrc' ORDER BY `ID` DESC";

	}

    /************************ PAGES **************************/

      $result_getkeys_all = MYSQL_QUERY($base_query);

	$num_all=mysql_num_rows($result_getkeys_all);

    $mpages=ceil($num_all/$mailstoshow);
// print 'pages: '.$mpages;
    if($num_all==$mailstoshow) $_SESSION['mpage']='0';

      if((empty($_SESSION['mpage']))||($_SESSION['mpage']==1)||($_GET['values']=='all')||($_GET['values']=='missed'))
	  {
	    $mpagethis=0;
	    $_SESSION['mpage']=1;
	  }
	else
      $mpagethis=$mailstoshow*$_SESSION['mpage']-$mailstoshow;


	$pPrint='';

	for($iPage=1;$iPage<$mpages+1;$iPage++){

//       if((empty($_SESSION['page']))&&($iPage==1)) $bold='pageact';
// 	else
	if($_SESSION['mpage']==$iPage) $pageact='pageact'; else $pageact='';

	  $pPrint.="<div class='pages $pageact' onclick='window.location=\"?lang_src={$_SESSION['lang_src']}&lang={$_SESSION['lang']}&mpage=$iPage\"'>".$iPage."</div>";

// 	  $pPrint.="<a href='?lang_src=".$_SESSION['lang_src']."&lang=".$_SESSION['lang']."&mpage=$iPage' class='pages'>$bold".$iPage."</b></a>";
// 	  if($iPage!=$mpages) $pPrint.="<font class='pages'>&nbsp; | &nbsp;</font>";

	}


    /*********************** EOF PAGES **************************/

      print "<form action='emails.php' method='GET'>
	      <input type='hidden' name='select_filters' value='1'>";
      print '<td align=right colspan=4 style="padding-top: 40px;">';

	if($mailstoshow<$num_all)
	  print "<center>$pPrint</center>";
	  
	  print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      </td></tr></form>
      
      <form action='emails.php' method='GET'>
	      <input type='hidden' name='select_filters' value='1'>";
	    print "<tr><td class='title' style='width:15%'>{$mse_lang['Key']}</td>
	      <td class='title' style='width:40%'>";

    if(!$_SESSION['search'])
	      src_lang_selection(1);
    else
	print $langTitle;

    print "</td>
	      <td class='title' style='width:5%'></td>
	      <td class='title' style='width:40%'>";

	      lang_selection(1);

    print "</td></tr>";

    print "</form>";

    print "<form action='emails.php' name='cells_window' method='POST'>
      <input type='hidden' name='em_lang' value='$sLang'>
      <input type='hidden' name='em_lang_src' value='$sLangSrc'>

	<input type='hidden' name='em_value' value='1'>";

    $iEven=0;
    $nothing_to_show=0;

$base_query_src="SELECT * FROM `sys_email_templates` WHERE `LangID`='$sLangSrc' $searchadd LIMIT $mpagethis,$mailstoshow";


      $result_getkeys_src = MYSQL_QUERY($base_query_src);
// echo $base_query_src;
// print $base_query_src.'<br>';
// print mysql_num_rows($result_getkeys_src);

      while ($lang_src_keys=mysql_fetch_object($result_getkeys_src)){

	$iEven++;

	  if($iEven % 2) $aeven='odd'; else $aeven='even';

			      $getstring_query="
				SELECT `ID`,`Body`,`Subject` FROM `sys_email_templates`
				      WHERE `LangID`='$sLang' AND `Name`='".$lang_src_keys->Name."'
				      LIMIT 1";
// echo '<br>p: '.$getstring_query;
    $result_getstring = MYSQL_QUERY($getstring_query);

$lang_target=mysql_fetch_object($result_getstring);

	  $result_eng_string_query = MYSQL_QUERY($get_eng_string_query);

// $lang_target - target
// $lang_src_keys - source


    $rows=15;
// show_emails($sess_lang,$lang_keys_id,$target_keysID,$aeven,$iEven,$rows,
// $lang_value,$+origString,$name,$+origSubject,$subject,$desc){
	      show_emails($_SESSION['lang'],$lang_src_keys->ID,$lang_target->ID,$aeven,$iEven,$rows,$lang_target->Body,$lang_src_keys->Body,$lang_src_keys->Name,$lang_src_keys->Subject,$lang_target->Subject,$lang_src_keys->Desc);

      }

    print '<tr><td align=center colspan=4>';

    if($_POST['em_value']==1) print '<font class="msg">'.$mse_lang['Successfully saved'].'</font><p>';

      if(($missed_sel==1)&&($nothing_to_show==0)||($iEven==0))
    print '<font class="msg">No values found<br>'.$mse_lang['Please select category'].'</font>';

//       else
// 	  if ($_SESSION['lang']=='')
// 	      print '<font class="msg">Please, select language and category</font>';

	  else
	  print '<img src="images/save.png" title="'.$mse_lang['Save changes'].'" onClick="document.cells_window.submit();" class="saveimg">';

	  print '
	      </td>
	      </form>
	      </tr></table>';
    ?>

    </td></tr></table>
</body>
</html>
<?php } else
{

header("location: login.php?status=$status");

}

?>
