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

session_start();


include 'func.php';

if (isset($_GET['mLangId'])) $_SESSION['mLangId'] = $_GET['mLangId'];


if (!$_SESSION['mLangId'])
    $_SESSION['mLangId'] = 'en';

require_once('translations/mse-' . $_SESSION['mLangId'] . '.php');

if ($_SESSION['mseusername']) {
    if ((isset($_GET['lang'])) && (!empty($_GET['lang']))) $_SESSION['lang'] = $_GET['lang'];
    if (!$_SESSION['lang']) $_SESSION['lang'] = 1;
    if ((isset($_GET['lang_src'])) && (!empty($_GET['lang_src']))) $_SESSION['lang_src'] = $_GET['lang_src'];
    if (!$_SESSION['lang_src']) $_SESSION['lang_src'] = "1";
    if ((isset($_GET['category'])) && (!empty($_GET['category']))) $_SESSION['category'] = $_GET['category'];
    if ((isset($_GET['page'])) && (!empty($_GET['page']))) $_SESSION['page'] = $_GET['page'];
    if ((isset($_GET['emails'])) && (!empty($_GET['emails']))) $_SESSION['emails'] = $_GET['emails'];
    if ($_GET['values'] == 'missed') $_SESSION['missed'] = '1';
    if ((isset($_POST['search_word'])) && (!empty($_POST['search_word']))) {
        $_SESSION['category'] = '';
        $_SESSION['search'] = $_POST['search_word'];
        $pagethis = 0;
        $_SESSION['page'] = 1;
    }
    if ((isset($_GET['search_word'])) && (!empty($_GET['search_word']))) {
        $_SESSION['category'] = '';
        $_SESSION['search'] = $_GET['search_word'];
        $pagethis = 0;
        $_SESSION['page'] = 1;
    }

    if ($_GET['values'] == 'missed') unset($_SESSION['search']);
    if ($_SESSION['search']) unset($_SESSION['missed']);
    if (($_GET['select_filters']) || ($_GET['ch_lang']) || ($_GET['values'] == 'all') || (isset($_GET['resetsearch']))) {
        $_SESSION['page'] = 1;
        unset($_SESSION['search']);
        unset($_SESSION['missed']);
    }
    show_header('3.0');
    $src_langGet = getLangName($_SESSION['lang_src']);
    $srclangTitle = $src_langGet['title'];
?>

    <div class="alert fade in alertblock">
        <button type="button" class="close closealert">×</button>
        <div id="alertinfo"></div>
    </div>

<?php
    print <<<html
        <tr><td colspan=3>
        <table border=0 width=100% cellpadding=10 cellspacing=0 style='border-collapse:collapse'>
        <tr>
html;

    if (!empty($_SESSION['search'])) {
        $search_sql = "WHERE `Key` REGEXP '" . $_SESSION['search'] . "'";

        $result_searchkeys = MYSQL_QUERY("SELECT `IDKey` FROM `sys_localization_strings` WHERE `String` REGEXP '" . $_SESSION['search'] . "' AND `IDLanguage`=" . $_SESSION['lang'] . "");

        if (mysql_num_rows($result_searchkeys) > 0) {

            $isrch = 0;

            $search_str = ' OR ';

            while ($srch_keys = mysql_fetch_object($result_searchkeys)) {

                $isrch++;

                $search_str .= " `ID`='{$srch_keys->IDKey}' ";

                if ($isrch != mysql_num_rows($result_searchkeys)) $search_str .= " OR ";

            }
            $search_str .= '';
        }

    } else {

        $search_sql = "WHERE `IDCategory`='" . $_SESSION['category'] . "'";
        $search_str = '';

    }


    /*** IF MODE MISSED ***/

    if (!empty($_SESSION['missed'])) {


        $result_emptykeys1 = MYSQL_QUERY("SELECT `ID` FROM `sys_localization_keys` WHERE `IDCategory`='{$_SESSION['category']}' ORDER BY `ID` DESC");

        while ($emp_keys = mysql_fetch_object($result_emptykeys1)) {

            $result_emptykeys = MYSQL_QUERY("SELECT `IDKey`,`String` FROM `sys_localization_strings` WHERE `IDLanguage`='{$_SESSION['lang']}' AND `IDKey`='{$emp_keys->ID}'");


            $imiss = 0;

            if (mysql_num_rows($result_emptykeys) < 1) {

                $imiss++;


                $empty_zadd .= " `ID`='{$emp_keys->ID}' ";

                $empty_zadd .= " OR ";

            } else
                if ((mysql_result($result_emptykeys, 0, 'String') == '') || (mysql_result($result_emptykeys, 0, 'String') == ' ')) {

                    $imiss++;


                    $empty_zadd .= " `ID`='{$emp_keys->ID}' ";

                    $empty_zadd .= " OR ";


                }

        }

        $empty_zadd .= " `ID`='0' ";


        $search_sql .= " AND ($empty_zadd)";
        $_SESSION[''];
    }

    /*** EOF IF MODE MISSED ***/

    /************************ PAGES **************************/


    $base_query = "SELECT * FROM `sys_localization_keys` $search_sql $search_str ORDER BY `ID` DESC";

    $result_getkeys_all = MYSQL_QUERY($base_query);

    $num_all = mysql_num_rows($result_getkeys_all);

    $pages = ceil($num_all / $toshow);

    if ($num_all == $toshow) $_SESSION['page'] = '0';

    if ((empty($_SESSION['page'])) || ($_SESSION['page'] == 1) || ($_GET['values'] == 'all') || ($_GET['values'] == 'missed')) {
        $pagethis = 0;
        $_SESSION['page'] = 1;
    } else
        $pagethis = $toshow * $_SESSION['page'] - $toshow;


    $pPrint = '';

    for ($iPage = 1; $iPage < $pages + 1; $iPage++) {

        if ((empty($_SESSION['page'])) && ($iPage == 1)) $bold = 'pageact';
        else
            if ($_SESSION['page'] == $iPage) $pageact = 'pageact'; else $pageact = '';

        $pPrint .= "<div class='pages $pageact' onclick='window.location=\"?category={$_SESSION['category']}&lang_src={$_SESSION['lang_src']}&lang={$_SESSION['lang']}&page=$iPage\"'>" . $iPage . "</div>";


    }


    /*********************** EOF PAGES **************************/

    print <<<CODE
      <form action='index.php' method='GET'>
	      <input type='hidden' name='select_filters' value='1'>
     <td align=right colspan=4>
CODE;

    if ($toshow < $num_all)
        print "<center>$pPrint</center>";


    print '<div class="catselect"><font class="msg">' . $mse_lang['Category:'] . '</font> ';
    cat_selection(1);
    print <<<CODE
      </td></tr>
      </form>
      <form action='index.php' method='GET'>
	      <input type='hidden' name='select_filters' value='1'>
	    <tr><td class='title' style='width:15%'>{$mse_lang['Key']}</td>
	      <td class='title' style='width:40%'>
CODE;

    if (!$_SESSION['search'])
        src_lang_selection();
    else
        print $srclangTitle;

    print "</td>
	      <td class='title' style='width:5%'></td>
	      <td class='title' style='width:40%'>";

    lang_selection();

    print <<<CODE
</td></tr>
    </form>
    <form action='index.php' name='cells_window' method='POST'>
      <input type='hidden' name='ch_lang' value='{$_SESSION['lang']}'>
      <input type='hidden' name='ch_lang_src' value='{$_SESSION['lang_src']}'>

	<input type='hidden' name='ch_category' value='{$_SESSION['category']}'>
	<input type='hidden' name='ch_value' value='1'>
CODE;

    $iEven = 0;
    $nothing_to_show = 0;

    $getkeys_query = $base_query . " LIMIT $pagethis,$toshow";

    $result_getkeys = MYSQL_QUERY($getkeys_query);

    while ($lang_keys = mysql_fetch_object($result_getkeys)) {

        $iEven++;

        if ($iEven % 2) $aeven = 'odd'; else $aeven = 'even';

        $get_eng_string_query = "
				SELECT * FROM `sys_localization_strings`
				      WHERE `IDLanguage`='" . $_SESSION['lang_src'] . "'
				      AND `IDKey`='{$lang_keys->ID}' LIMIT 1";

        $getstring_query = "
				SELECT * FROM `sys_localization_strings`
				      WHERE `IDLanguage`='" . $_SESSION['lang'] . "'
				      AND `IDKey`='{$lang_keys->ID}' LIMIT 1";

        $result_getstring = MYSQL_QUERY($getstring_query);
        $lang_value = mysql_result($result_getstring, 0, "String");
        $approved = mysql_result($result_getstring, 0, "ok");
        $result_eng_string_query = MYSQL_QUERY($get_eng_string_query);


        $rows = 3;
        $orig_string = mysql_result($result_eng_string_query, 0, "String");
        $lang_keysID = $lang_keys->ID;
        $lang_key = $lang_keys->Key;

        if ($_GET['values'] == 'missed') {

            $missed_sel = 1;

            if (empty($lang_value)) {
                ++$nothing_to_show;

                show_result($_SESSION['lang'], $lang_keysID, $aeven, $iEven, $rows, $lang_value, $orig_string, $lang_key, $status, $approved);
            }

        } else {
            show_result($_SESSION['lang'], $lang_keysID, $aeven, $iEven, $rows, $lang_value, $orig_string, $lang_key, $status, $approved);
        }
    }

    print '<tr><td align=center colspan=4>';


    if ($_POST['ch_value'] == 1) print '<font class="msg">' . $mse_lang['Successfully saved'] . '</font><p>';

    if (($missed_sel == 1) && ($nothing_to_show == 0) || ($iEven == 0))
        print '<font class="msg">' . $mse_lang['No values found'] . '</font>';

    elseif
    ((empty($_SESSION['category']) && (empty($_SESSION['lang']))))
        print '<font class="msg">' . $mse_lang['Please select language and category'] . '</font>';
    else
        print '<img src="images/save.png" title="' . $mse_lang['Save changes'] . '" onClick="document.cells_window.submit();" class="saveimg">';

    $url_root = BX_DOL_URL_ROOT;

    ?>
    </td>
    </form>
    </tr></table>


    <script language=JavaScript>

        function checkthis(IDKey, IDLanguage) {

            sSiteUrl = "<?php print $url_root;?>";

            if (document.getElementById('checkthis_' + IDKey).checked == true) {
                ok = 1;
                approved = 'approved';
                color = "#b0f4b3";
            } else {
                ok = 0;
                approved = 'disapproved';
                color = "#ffffff";
            }

            sUrl = sSiteUrl + 'mse/xml/checkthis.php?IDKey=' + IDKey + '&l=' + IDLanguage + '&ok=' + ok;


            $.post(sUrl,
                function (sResponse) {
                    if (sResponse == 'success') {
// 		    alert('KeyID '+IDKey+' is '+approved);
                        document.getElementById('dest_' + IDKey).style = 'background-color:' + color + ';border:solid 1px #eaeaea;padding:10px;font-size:14px;';


                    } else {
                        alert("Error: " + sResponse);

                    }
                });


        }
    </script>


    </td>
    </tr>
    </table>
    </body>
    </html>
    <?php
} else {

    header("location: login.php?status=$status");

}

?>