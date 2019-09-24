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
<?php

//  include("fckeditor.php");

?>
  <title>Edit</title>

  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<LINK href="css/style.css" type=text/css rel=stylesheet>


<script src="ckeditor/ckeditor.js"></script>



</head>

<body cellpadding='0' cellspacing='0' leftmargin='0' topmargin='0'>


<?php

$keyID=$_GET['keyID'];
?>
  <form name='form_edit_selected'>

<textarea cols="100" id="editor1" name="editor1" rows="10"></textarea>




<div align="right" style="padding:10 10 0 0px"><img src="images/save.png" onClick="GetContents('<?php print $keyID;?>');self.close();" class="saveimg"></div>


</font>


<script type="text/javascript">

	// Replace the <textarea id="editor1"> with an CKEditor instance.
	CKEDITOR.replace( 'editor1');

	document.getElementById('editor1').value = opener.document.getElementById('dest_<?php print $_GET['keyID'];?>').value;
	
	document.ready(function(){

    	var editor = CKEDITOR.instances.editor1;
	var value = opener.document.getElementById('dest_<?php print $_GET['keyID'];?>').value;

	// Check the active editing mode.
	if ( editor.mode == 'wysiwyg' )
	{
		// Insert HTML code.
		// http://docs.ckeditor.com/#!/api/CKEDITOR.editor-method-insertHtml
		editor.insertHtml( value );
	}
	else
		alert( 'You must be in WYSIWYG mode!' );

	})



	
  function GetContents(textname) {
	// Get the editor instance that you want to interact with.
	var editor = CKEDITOR.instances.editor1;

	// Get editor contents
	// http://docs.ckeditor.com/#!/api/CKEDITOR.editor-method-getData
	opener.document.getElementById('dest_'+textname).value=editor.getData();
  }

</script>


</body>
</html>