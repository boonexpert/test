///*************************Product owner info********************************
///
///     author               : Boonexpert
///     contact info         : boonexpert@gmail.com
///
///*************************Product info**************************************
///
///                          Master String Editor + Email templates editor
///                          -----------------------------------------------------
///     version              : 2.1
///     date		   : 22 December 2011
///    compability          : Dolphin 7.0.x
///    License type         : Custom
///
/// IMPORTANT: This is a commercial product made by Boonexpert and cannot be modified for other than personal use.
/// This product cannot be redistributed for free or a fee without written permission from Boonexpert.
///
///     Upgrade possibilities : All future upgrades will be added to this product package
///
///****************************************************************************/

   function copy_orig_mail(key_id){

      document.getElementById('dest_subj_'+key_id).value=document.getElementById('src_subj_'+key_id).value;
      document.getElementById('dest_'+key_id).value=document.getElementById('mail_src_'+key_id).value;

  }

   function copy_orig(key_id){

      document.getElementById('dest_'+key_id).value=document.getElementById('src_'+key_id).innerHTML;

  }


  $(document).ready(function() {
			$('textarea.resizable:not(.processed)').TextAreaResizer();
			$('iframe.resizable:not(.processed)').TextAreaResizer();
		});