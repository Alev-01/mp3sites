<?php include("include.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>KeyifleDinle</title>
<base href="<?php echo $mth->_mth['site']; ?>" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/cufon-yui.js"></script>
<script type="text/javascript" src="js/font.js"></script>
<script type="text/javascript" src="js/mth_music.js"></script>
<script type="text/javascript" src="js/swfobject.js"></script>
<script src="js/jwplayer.js" type="text/javascript" ></script>
<script type="text/javascript">
$(document).ready(function(){
	Cufon.replace('#header_right h2');
});
</script>
<style type="text/css"></style>
</head>

<body>
<div id="wrapper">
  <div id="header"><a href="#"><img src="images/invite_friend.png" alt="Arkadaşlarını Davet Et" width="208" height="29" border="0" class="invite_friend" /></a>
    <div class="clear"></div>
    <img src="images/logo.png" alt="Logo" width="176" height="196" class="logo" />
    <div id="header_right">
      <h2>Hoşgeldin<strong>iz</strong>;</h2>
      <span>Keyifle Müzik Dinle uygulamamıza hoşgeldin. Aşağıdaki arama kutusuna aramak istediğin şarkıyı yazıp, ara butonuna veya enter tuşuna basarak arama yapabilirsin... Bak keyfine... :)</span>
      <div id="search">
	<form action="javascript:search_find();" method="post">
        <input type="text" name="q" id="q" />
        <input type="image" src="images/search_button.png" />
	</form>
      </div>
    </div>
  </div>
  <div id="content">
    <div id="content_top"></div>
    <div id="content_wrappper">
      <div id="player"></div>
      <div class="clear"></div>
      <div id="contenct">
      	<div id="results">
        	<div id="playlist"></div>
        </div>
        <div id="advertise"><img src="images/advertise.jpg" alt="Reklam" width="300" height="101" /></div>
        <div class="clear"></div>
      </div>
    </div>
    <div id="footer">Yazılım ve Tasarım : <a href="http://mtahir.net">Tahir Hasan</a></div>
  </div>
</div>
<center><p>
    <a href="http://validator.w3.org/check?uri=referer"><img
        src="http://www.w3.org/Icons/valid-xhtml10"
        alt="Valid XHTML 1.0 Transitional" width="88" height="31" border="0" /></a></p>
</center>
</body>
</html>