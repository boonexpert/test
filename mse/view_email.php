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
?>




<html>
<head>

<title>Edit</title>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<LINK href="css/style.css" type=text/css rel=stylesheet>




</head>

<body cellpadding='0' cellspacing='0' leftmargin='0' topmargin='0'>


<?php

$keyID=$_GET['keyID'];
?>
<form name='form_edit_selected'>

<textarea cols="100" id="field_edit" name="field_edit" rows="10"></textarea>

  <div align="right" style="padding:10px 10px 0 0px"><img src="images/save.png" onClick="checkit('<?php print $keyID?>');self.close();" class="saveimg"></div>

  </font>

<script src="ckeditor/ckeditor.js"></script>

<script type="text/javascript">




	
	
	

towrite=opener.document.getElementById('dest_<?php print $_GET['keyID'];?>').value;


str_replace('<bx_include_auto:_email_header.html />','&lt;bx_include_auto:_email_header.html /&gt;');
str_replace('<Sender>','&lt;Sender&gt;');
str_replace('<Recipient>','&lt;Recipient&gt;');
str_replace('<SenderNickName>','&lt;SenderNickName&gt;');
str_replace('<RealName>','&lt;RealName&gt;');
str_replace('<Domain>','&lt;Domain&gt;');
str_replace('<recipientID>','&lt;recipientID&gt;');
str_replace('<Email>','&lt;Email&gt;');
str_replace('<SiteName>','&lt;SiteName&gt;');
str_replace('<MessageText>','&lt;MessageText&gt;');
str_replace('<ConfirmationLink>','&lt;ConfirmationLink&gt;');
str_replace('<ConfCode>','&lt;ConfCode&gt;');
str_replace('<MatchProfileLink>','&lt;MatchProfileLink&gt;');
str_replace('<StrID>','&lt;StrID&gt;');
str_replace('<ProfileUrl>','&lt;ProfileUrl&gt;');
str_replace('<MediaType>','&lt;MediaType&gt;');
str_replace('<UserExplanation>','&lt;UserExplanation&gt;');
str_replace('<ProfileReference>','&lt;ProfileReference&gt;');
str_replace('<VKissLink>','&lt;VKissLink&gt;');
str_replace('<your message here>','&lt;your message here&gt;');
str_replace('<ViewLink>','&lt;ViewLink&gt;');
str_replace('<Subscription>','&lt;Subscription&gt;');

str_replace('<SysUnsubscribeLink>','&lt;SysUnsubscribeLink&gt;');
str_replace('<SpammerUrl>','&lt;SpammerUrl&gt;');
str_replace('<SpammerNickName>','&lt;SpammerNickName&gt;');
str_replace('<Page>','&lt;Page&gt;');
str_replace('<Get>','&lt;Get&gt;');
str_replace('<SpamContent>','&lt;SpamContent&gt;');
str_replace('<String1>','&lt;String1&gt;');

str_replace('<Subject>','&lt;Subject&gt;');
str_replace('<NickName>','&lt;NickName&gt;');
str_replace('<EmailS>','&lt;EmailS&gt;');
str_replace('<NickNameB>','&lt;NickNameB&gt;');
str_replace('<EmailB>','&lt;EmailB&gt;');
str_replace('<sCustDetails>','&lt;sCustDetails&gt;');

str_replace('<ShowAdvLnk>','&lt;ShowAdvLnk&gt;');

str_replace('<Who>','&lt;Who&gt;');
str_replace('<site_email>','&lt;site_email&gt;');
str_replace('<ActionType>','&lt;ActionType&gt;');
str_replace('<FanLink>','&lt;FanLink&gt;');
str_replace('<ItemDesc>','&lt;ItemDesc&gt;');
str_replace('<FanName>','&lt;FanName&gt;');
str_replace('<ViewType>','&lt;ViewType&gt;');
str_replace('<FriendUrl>','&lt;FriendUrl&gt;');
str_replace('<MediaUrl>','&lt;MediaUrl&gt;');



	// Replace the <textarea id="field_edit"> with an CKEditor instance.
	CKEDITOR.replace( 'field_edit');

// 	document.getElementById('field_edit').value = opener.document.getElementById('dest_<?php print $_GET['keyID'];?>').value;


	

function str_replace(str_from,str_to){

  var intIndexOfMatch = towrite.indexOf(str_from);

    while (intIndexOfMatch != -1){
      towrite = towrite.replace( str_from, str_to )
      intIndexOfMatch = towrite.indexOf( str_from );
    }

}


    function checkit(textname){

    	var editor = CKEDITOR.instances.field_edit;
	myValue = editor.getData();

str_replaceBack('&lt;bx_include_auto:_email_header.html /&gt;','<bx_include_auto:_email_header.html />');
str_replaceBack('&lt;Sender&gt;','<Sender>');
str_replaceBack('&lt;Recipient&gt;','<Recipient>');
str_replaceBack('&lt;SenderNickName&gt;','<SenderNickName>');
str_replaceBack('&lt;RealName&gt;','<RealName>');
str_replaceBack('&lt;Domain&gt;','<Domain>');
str_replaceBack('&lt;recipientID&gt;','<recipientID>');
str_replaceBack('&lt;Email&gt;','<Email>');
str_replaceBack('&lt;SiteName&gt;','<SiteName>');
str_replaceBack('&lt;MessageText&gt;','<MessageText>');
str_replaceBack('&lt;ConfirmationLink&gt;','<ConfirmationLink>');
str_replaceBack('&lt;ConfCode&gt;','<ConfCode>');
str_replaceBack('&lt;MatchProfileLink&gt;','<MatchProfileLink>');
str_replaceBack('&lt;StrID&gt;','<StrID>');
str_replaceBack('&lt;ProfileUrl&gt;','<ProfileUrl>');
str_replaceBack('&lt;MediaType&gt;','<MediaType>');
str_replaceBack('&lt;UserExplanation&gt;','<UserExplanation>');
str_replaceBack('&lt;ProfileReference&gt;','<ProfileReference>');
str_replaceBack('&lt;VKissLink&gt;','<VKissLink>');
str_replaceBack('&lt;your message here&gt;','<your message here>');
str_replaceBack('&lt;ViewLink&gt;','<ViewLink>');
str_replaceBack('&lt;Subscription&gt;','<Subscription>');
str_replaceBack('&lt;SysUnsubscribeLink&gt;','<SysUnsubscribeLink>');
str_replaceBack('&lt;SpammerUrl&gt;','<SpammerUrl>');
str_replaceBack('&lt;SpammerNickName&gt;','<SpammerNickName>');
str_replaceBack('&lt;Page&gt;','<Page>');
str_replaceBack('&lt;Get&gt;','<Get>');
str_replaceBack('&lt;SpamContent&gt;','<SpamContent>');
str_replaceBack('&lt;String1&gt;','<String1>');
str_replaceBack('&lt;Subject&gt;','<Subject>');
str_replaceBack('&lt;NickName&gt;','<NickName>');
str_replaceBack('&lt;EmailS&gt;','<EmailS>');
str_replaceBack('&lt;NickNameB&gt;','<NickNameB>');
str_replaceBack('&lt;EmailB&gt;','<EmailB>');
str_replaceBack('&lt;sCustDetails&gt;','<sCustDetails>');
str_replaceBack('&lt;ShowAdvLnk&gt;','<ShowAdvLnk>');
str_replaceBack('&lt;Who&gt;','<Who>');
str_replaceBack('&lt;site_email&gt;','<site_email>');
str_replaceBack('&lt;ActionType&gt;','<ActionType>');
str_replaceBack('&lt;FanLink&gt;','<FanLink>');
str_replaceBack('&lt;ItemDesc&gt;','<ItemDesc>');
str_replaceBack('&lt;FanName&gt;','<FanName>');
str_replaceBack('&lt;ViewType&gt;','<ViewType>');
str_replaceBack('&lt;FriendUrl&gt;','<FriendUrl>');
str_replaceBack('&lt;MediaUrl&gt;','<MediaUrl>');
      }

function str_replaceBack(str_from,str_to){

  var intIndexOfMatch = myValue.indexOf(str_from);

    while (intIndexOfMatch != -1){
      myValue = myValue.replace( str_from, str_to )
      intIndexOfMatch = myValue.indexOf( str_from );
    }
	opener.document.getElementById('dest_<?php print $_GET['keyID']?>').value=myValue;
}



console.log(towrite);
// 	$(document).ready(function() {

    	var editor = CKEDITOR.instances.field_edit;
		document.getElementById('field_edit').value = towrite;

	// Check the active editing mode.
// 	if ( editor.mode == 'wysiwyg' )
// 	{
		// Insert HTML code.
		// http://docs.ckeditor.com/#!/api/CKEDITOR.editor-method-insertHtml
// 		editor.insertHtml( "123" );
// 	}
// 	else
// 		alert( 'You must be in WYSIWYG mode!' );

// 	})
</script>


</body>
</html>









