<?php

class mth {
	
	var $_mth = array();
		
	function __construct(){
		
		ini_set('error_reporting', 'E_ALL & ~E_NOTICE & ~E_STRICT');
		
		$this->sqlInjectionSecurity();
		
		// site 
		$this->_mth['site'] = "http://localhost/";

	}

	function arasiniAl($veri,$baslangic,$bitis){
		$veri = explode($baslangic,$veri);
		$veri = $veri[1];
		$veri = explode($bitis,$veri);
		$veri = $veri[0];
		return $veri;
	}
	
	function sqlInjectionSecurity(){
		$inj = array ('select', 'insert', 'delete', 'update', 'drop table', 'union', 'null', 'SELECT', 'INSERT', 'DELETE', 'UPDATE', 'DROP TABLE', 'UNION', 'NULL','order by','order  by');
		for ($i = 0; $i < sizeof ($_GET); ++$i){
			for ($j = 0; $j < sizeof ($inj); ++$j){
				foreach($_GET as $gets){
					if(preg_match ('/' . $inj[$j] . '/', $gets)){
						$temp = key ($_GET);
						$_GET[$temp] = '';
						exit('<iframe title="YouTube video player" width="800" height="600" src="http://www.youtube.com/embed/bzen6iORGIk" frameborder="0" allowfullscreen></iframe>');
						continue;
					}
				}
			}
		}			
	}
}

?>