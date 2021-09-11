<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/mth_music.js"></script>
<script type="text/javascript" src="js/swfobject.js"></script>

<?php
include("include.php");

$w = $_POST["id"];

?>

<script type="text/javascript" src="player/jwplayer.js"></script>
<div id='mediaspace'>FLASH PLAYER YÜKLEYÝNÝZ.</div>
<script type='text/javascript'>
  jwplayer('mediaspace').setup({
    'flashplayer': 'player/player.swf',
    'file': 'http://www.youtube.com/watch?v=<?=$w ?>',
    'autostart': 'true',
    'controlbar': 'bottom',
    'width': '400',
    'height': '24'
  });
</script>