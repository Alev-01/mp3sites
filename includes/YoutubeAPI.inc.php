<?php
define("ANY",0);
define("PC",1);
define("MOBILE",2);


/**
 * This class fetching live streaming links of youtube videos, both for mobile (real player) and PC (flash player)
 *
 *@author Rochak Chauhan [www.dmwtechnologies.com]
 */
class YouTubeAPI {
	private $startIndex=1;
	private $format=PC;
	private $maxResults=10;
	private $keyword="";
	private $feedString="";
	private $downloadUrl="http://demo.dmwtechnologies.com/YouTubeDownloader/index.php";
	
	public function __construct($keyword,$maxResults=10,$startIndex=1,$format=ANY) {
		$this->keyword=$keyword;
		$this->format=$format;
		$this->maxResults=$maxResults;
		$this->startIndex=$startIndex;
		$url="http://gdata.youtube.com/feeds/api/videos?vq=$keyword&start-index=$startIndex&max-results=$maxResults";
		$this->feedString=$this->getXmlCodeViaFopen($url);
	}

	/**
	 * Function to get the XML code from the YouTubeAPI
	 *
	 * @param string $url
	 * @access private
	 * 
	 * @return string
	 */
	private function getXmlCodeViaFopen($url){
		$returnStr="";
		$fp=fopen($url, "r") or die("ERROR: Illigal YouTube API URL");
		while (!feof($fp)) {
			$returnStr.=fgetc($fp);
		}
		fclose($fp);
		return $returnStr;
	}
	/**
	 *Function to download remote content of an URL using wget
	 *
	 *@author Rochak Chauhan
	 *@param string $url
	 *
	 *@return string
	 */
	private function getHtmlCodeViaWget($url){
			//get HTML CODE
			$rand=".".microtime(true)."_".rand(0,9999999);
			$tmp="tmp".$rand.".html";
			system("wget -q $url -O - >> $tmp");
			system("chmod 777 $tmp");
			system("chown ".FTP_USER.":".FTP_USER." $tmp");
			$returnStr=file_get_contents($tmp);
			unlink($tmp);
			return $returnStr;
	}
	/**
	 *Function to download remote content of an URL via cURL
	 *
	 *@author Rochak Chauhan
	 *@param string $url
	 *
	 *@return string
	 */
	private function getHtmlCodeViaCurl($url){
	    $userAgent=array();
	    $userAgent[]="Opera/9.50 (Windows NT 5.1; U; en)";
	    $userAgent[]="Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, like Gecko) Version/3.1 Safari/525.13";
	    $userAgent[]="Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; FDM; MEGAUPLOAD 1.0; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30)";
	    $userAgent[]="Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.12) Gecko/20080201 Firefox/2.0.0.12";
	    $userAgent[]="Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; FDM; MEGAUPLOAD 1.0; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30)";
	    $userAgent[]="Mozilla/5.0 (Windows; U; Windows NT 5.1; en) AppleWebKit/522.15.5 (KHTML, like Gecko) Version/3.0.3 Safari/522.15.5";
	    $total1=count($userAgent)-1;
	    $rand1=rand(0,$total1);
	    
	    
	    $curl = curl_init() or die("FATAL ERROR: cURL support is not found on this server.");
	    curl_setopt($curl, CURLOPT_USERAGENT, $userAgent[$rand1]);
	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($curl, CURLOPT_TIMEOUT, 20);
	    return curl_exec($curl);    
	}

	/**
	 * Function to get the Title from the XML/RSS Feed
	 * 
	 * @param string $str
	 * @access private
	 * @return string
	 */
	private function getTitle($str) {
		$final=array();
		$returnArray=array();
		$pattern="/<title type='text'>(.*)\<\/title\>/Uis";
		preg_match_all($pattern, $str, $returnArray, PREG_SET_ORDER);
		if(isset($returnArray[0][1])) {
			return $returnArray[0][1];
		}
		else {
			return "NA";
		}
	}

	/**
	 * Function to get the FLV/SWF url from the XML/RSS Feed
	 * 
	 * @param string $str
	 * @access private
	 * @return string
	 */
	private function getFlvUrl($str) {
		$final=array();
		$returnArray=array();
		$pattern="/<media:player url='(.*)'/Uis";
		//$pattern="/<media:content url='(.*)' type='application\/x-shockwave-flash'/Uis";
		preg_match_all($pattern, $str, $returnArray, PREG_SET_ORDER);

		if(isset($returnArray[0][1])) {
			return $returnArray[0][1];
		}
		else {
			return "#";
		}
	}

	/**
	 * Function to get the mobile streaming url from the XML/RSS Feed
	 * 
	 * @param string $str
	 * @access private
	 * @return string
	 */
	private function getMobileUrl($str) {

		$final=array();
		$returnArray=array();
		$pattern="/<media:content url='(.*)' type='video\/3gpp'/Uis";
		preg_match_all($pattern, $str, $returnArray, PREG_SET_ORDER);

		if(isset($returnArray[1][1])) {
			return $returnArray[1][1];
		}
		else {
			return "#";
		}
	}

	/**
	 * Function to get the video thumbnail from the XML/RSS Feed
	 * 
	 * @param string $str
	 * @access private
	 * @param boolean $returnAllThumbsAsArray
	 * @return string
	 */
	private function getThumbnailUrl($str,$returnAllThumbsAsArray=false) {
		$final=array();
		$returnArray=array();
		$imgArray=array();
		$imgPattern="/<media:thumbnail url='(.*)'/Uis";
		preg_match_all($imgPattern, $str, $tmp, PREG_SET_ORDER);
		
		$c=count($tmp);
		$l=-1;
		foreach($tmp as $key=>$value){
			$value=$value[1];
			$imgArray[]=$value;
		}
		if($returnAllThumbsAsArray===true){
			return $imgArray;
		}
		else{
			return $imgArray[3];
		}
	}

	/**
	 * Function to get Streaming link info
	 *
	 * @param string $feed
	 * @access public
	 * @return array
	 */
	public function getStreamingLinks() {
		$feed=$this->feedString;
		$final=array();
		$returnArray=array();
		$pattern="/<title type='text'>(.*)<category scheme='http:\/\/gdata.youtube.com\/schemas\/2007\/keywords.cat'/Uis";
		preg_match_all($pattern, $feed, $returnArray, PREG_SET_ORDER);

		for($i=1;$i<count($returnArray);$i++){
			$str=$returnArray[$i][0];
			$title=$this->getTitle($str);
			$flvUrl=$this->getFlvUrl($str);
			$mobileUrl=$this->getMobileUrl($str);
			$thumbnailUrl=$this->getThumbnailUrl($str);
			if ($this->format==PC) {
				$final[]=array("title"=>$title,"flvurl"=>$flvUrl,"thumbnailUrl"=>$thumbnailUrl);
			}
			elseif ($this->format==MOBILE) {
				$final[]=array("title"=>$title,"mobileurl"=>$mobileUrl,"thumbnailUrl"=>$thumbnailUrl);
			}
			else {
				$final[]=array("title"=>$title,"flvurl"=>$flvUrl,"mobileurl"=>$mobileUrl,"thumbnailUrl"=>$thumbnailUrl);
			}
		}
		return $final;
	}

	/**
	 * Function to get the downloadable link of the flv file
	 *
	 * @param string $youtubeUrl
	 * @return array on success else false
	 * @access public
	 */
	public function getDownloadLink($youtubeUrl) {
		// get download link Page
		$post_data="url=$youtubeUrl";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->downloadUrl);
		curl_setopt($ch, CURLOPT_POST, 1 );
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$htmlCode = curl_exec($ch);
		curl_close($ch);
		$returnArray=array();
		// extract link from the htmlcode
		$pattern="/<a href='(.*)\<\/a\>/Uis";
		preg_match_all($pattern, $htmlCode, $returnArray, PREG_SET_ORDER);
		if(isset($returnArray[0][1])) {
			$str=trim($returnArray[0][1]);
			$pos=strpos($str,"'");
			$link=substr($str,0,$pos);
			$title=strip_tags($returnArray[0][0]);
			return array("title"=>$title,"link"=>$link);
		}
		else {
			return false;
		}
	}
}
?>