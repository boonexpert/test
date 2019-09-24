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
    <title>Master String Editor v.2.2 for Boonex Dolphin 7.4.x</title>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	    <LINK href="bootstrap/css/bootstrap.css" type=text/css rel=stylesheet>
<LINK href="css/style.css" type=text/css rel=stylesheet>
</head>
<body style="background:url('images/subtle_stripes.png') repeat">

<div style="width:100%;">

<div class="logindiv">

<div class="navbar-inner" style="border:none;font-size:25px;border:none;color:#08C;padding:8px;">
<img src='images/logo_48.png' hspace=10>

	 Master String Editor v.2.2
</div>

<?php
  if($_GET['status']=='invalid')
print "<br><center><font style='font-size:14px;color:#FF0000'>We are sorry, but you have no access with entered login information.</center></font>";
?>



  <div style="padding-top:30px;">
  <form class="form-horizontal" action="index.php" method='POST'>
    <input type='hidden' name='dashboard' value='1'>
    <input type="hidden" name="action" value="dashboard">
    <div class="control-group">
      <label class="control-label" for="inputEmail">Admin Login:</label>
      <div class="controls">
	<input type="text" id="inputEmail" placeholder="Login" name="user_id">
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="inputPassword">Admin Password:</label>
      <div class="controls">
	<input type="password" id="inputPassword" placeholder="Password" name="pwd">
      </div>
    </div>
    <div class="control-group">
      <div class="controls" style="margin-left:200px;">
	<button type="submit" class="btn" style="width:100px;">Log In</button>
      </div>
    </div>
  </form>

  </div>

</div>
</div>

</body>
</html>