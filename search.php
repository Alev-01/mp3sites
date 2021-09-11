<?php
include("include.php");
?>
<link href="<?php echo $mth->_mth['site']; ?>css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $mth->_mth['site']; ?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $mth->_mth['site']; ?>js/mth_music.js"></script>
<?php
echo '<div id="playlist"><ul>';

$keyword=$_POST['q'];
$keyword=urlencode($keyword);

if($keyword==""){
	echo '<div class="not">Alanı Boş bırakırsanız, size yardımcı olamayız ki... :)</div>';
	die;
}


require_once("includes/YouTubeAPI.inc.php");
$api=new YouTubeAPI($keyword,15,1);
$result=$api->getStreamingLinks();

$total=count($result);
for($i=0;$i<$total;$i++){

	$mobileUrl=$flvUrl="#";
	$imageSrc=$result[$i]['thumbnailUrl'];
	$title=$result[$i]['title'];

	if(isset($result[$i]['flvurl'])){
		$flvUrl=$result[$i]['flvurl'];
		$flvUrl = $mth->arasiniAl($flvUrl,'http://www.youtube.com/watch?v=','&');	
	}
	
	echo '<li><a style="cursor:pointer;" class="song" onclick="play(\''.$flvUrl.'\')">'.$title.'</a></li>';
}

echo '</div></ul>';
?>