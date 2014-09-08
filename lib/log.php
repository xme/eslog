<?php

// Change the patch to your /vendor directory
// See the Elasticsearch PHP API document for more details
// http://www.elasticsearch.org/guide/en/elasticsearch/client/php-api/current/
require '/var/www/vendor/autoload.php';

class OC_esLog {

	public function __construct(){		

	}

	public static function log($path,$path2,$action,$protocol='http'){
		if(isset($_SERVER['PHP_AUTH_USER']) && !empty($_SERVER['PHP_AUTH_USER']))
			$user = $_SERVER['PHP_AUTH_USER'];
		else
			$user = OCP\User::getUser();

		// Replace user with the right value
		if ($action == 'User login attempt' || $action == 'User login') {
			$user = $path;
			$path = '';
		}

		if ($action == 'File shared' || $action == 'File unshared') {
			$vars=$path;
			$file=basename($vars['fileTarget']);
			$folder=dirname($vars['fileTarget']);
			$user=$vars['uidOwner'];
			if (!empty($vars['shareWith'])) {
				$folder2=$vars['shareWith'];
			}
			else {
				$folder2=\OCP\Util::linkToPublic('files') .'&t=' . $vars['token'];
			}
			$path=$vars['fileTarget'];
			$path2='';
		}

		$folder = is_array($path)?dirname($path['path']):dirname($path);
		$file = is_array($path)?basename($path['path']):basename($path);
		
		if (empty($folder2))
			$folder2 = is_array($path2)?dirname($path2['path']):(!empty($path2)?dirname($path2):'');
		$file2 = is_array($path2)?basename($path2['path']):(!empty($path2)?basename($path2):'');		
		$type='unknown';
		
		if(!empty($file2)){
			if($protocol=='http'){
				$type = \OC\Files\Filesystem::filetype($folder2.'/'.$file2); 
			}
			elseif($protocol=='caldav'){
				$type = $_SERVER['CONTENT_TYPE']; 
			}
			elseif($protocol=='carddav'){
				$type = $_SERVER['CONTENT_TYPE']; 
			}
			else{
				$CONFIG_DATADIRECTORY = OC_Config::getValue( "datadirectory", OC::$SERVERROOT."/data" );
				if(is_dir($CONFIG_DATADIRECTORY.'/'.$user.'/files')){
					$type='unknown';
					if(is_file($CONFIG_DATADIRECTORY.'/'.$user.'/files'.$folder.$file)) $type='file';
					elseif(is_dir($CONFIG_DATADIRECTORY.'/'.$user.'/files'.$folder.$file)) $type='dir';
				}
			}
			if(strpos($type,';')){
				$type=substr($type,0,strpos($type,';'));
			}
		} 
		
		self::send2elasticsearch($user, $protocol, $type, $folder, $file,$folder2,$file2, $action);
	}
	
	public static function send2elasticsearch($user, $protocol, $type, $folder, $file,$folder2,$file2, $action)
	{
		$params = array();
		$params['hosts'] = array(
			OC_Appconfig::getValue('eslog', 'eslog_host', '127.0.0.1:9200')
		);
		if (OC_Appconfig::getValue('eslog', 'eslog_auth', 'none') != "none") {
			$params['connectionParams']['auth'] = array(
				OC_Appconfig::getValue('eslog', 'eslog_user', ''),
				OC_Appconfig::getValue('eslog', 'eslog_password', ''),
				OC_Appconfig::getValue('eslog', 'eslog_auth', 'none')
			);
		}

		$client = new Elasticsearch\Client($params);

		// $date = date('Y-m-d H:i:s');
		$date = date('c');
		$request=$_REQUEST;
		if(isset($request['password'])) $request['password']='******';
		
		$server=$_SERVER;
		if(isset($server['PHP_AUTH_PW'])) $server['PHP_AUTH_PW']='******';
		if(isset($server['HTTP_COOKIE'])) $server['HTTP_COOKIE']='******';
		if(isset($server['HTTP_AUTHORIZATION'])) $server['HTTP_AUTHORIZATION']='******';

		if (isset($server['REMOTE_ADDR'])) {
			$remote_address = $server['REMOTE_ADDR'];
		}
		if (isset($server['REMOTE_PORT'])) {
			$remote_port = $server['REMOTE_PORT'];
		}
		
		$vars=serialize(array(
			'request'=>$request,
			'server'=>$server
		));
		$params = array();
		$params['index'] = OC_Appconfig::getValue('eslog', 'eslog_index', 'owncloud');
		$params['type'] = OC_Appconfig::getValue('eslog', 'eslog_type', 'owncloud');
		$params['body'] = array(
			'@timestamp' => $date,
			'user' => $user,
			'src_ip' => $remote_address,
			'src_port' => $remote_port,
			'date' => $date,
			'proto' => $protocol,
			'content_type' => $type,
			'folder' => $folder,
			'file' => $file,
			'folder2' => $folder2,
			'file2' => $file2,
			'action' => $action,
			'variables' => $vars
		);
		$ret = $client->index($params);
	}
}
