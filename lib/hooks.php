<?php

// Hooks definition

class OC_esLog_Hooks {
	
	// ----------------
	// Users management
	// ----------------

	static public function prelogin($vars) {
		OC_esLog::log($vars['uid'],'/','User login attempt');
	}
	static public function login($vars) {
		OC_esLog::log($vars['uid'],'/','User login');
	}
	static public function logout($vars) {
		OC_esLog::log($vars['uid'],'/','User logout');
	}
	static public function createuser($vars) {
		OC_esLog::log($vars['uid'],'/','New user created');
	}
	static public function deleteuser($vars) {
		OC_esLog::log($vars['uid'],'/','User deleted');
	}
	static public function creategroup($vars) {
		OC_esLog::log($vars['gid'],'/','New group created');
	}
	static public function deletegroup($vars) {
                OC_esLog::log($vars['gid'],'/','Group deleted');
	}
	static public function addtogroup($vars) {
		OC_esLog::log($vars['gid'],$vars['uid'],'User added to group');
	}
	static public function removefromgroup($vars) {
		OC_esLog::log($vars['gid'],$vars['uid'],'User removed from group');
	}
	static public function setpassword($vars) {
		OC_esLog::log($vars['uid'],'/','User password changed');
	}

	// ---------------------
	// Filesystem operations
	// ---------------------

	static public function write($path) {
		OC_esLog::log($path,NULL,'File written');
	}
	static public function delete($path) {
		OC_esLog::log($path,NULL,'File deleted');
	}
	static public function rename($paths) {
		if(isset($_REQUEST['target'])){
			OC_esLog::log($paths['oldpath'],$paths['newpath'],'File moved');
		}
		else{
			OC_esLog::log($paths['oldpath'],$paths['newpath'],'File renamed');
		}		
	}
	static public function copy($paths) {
		OC_esLog::log($paths['oldpath'],$paths['newpath'],'File copied');
	}
	
	// -----------------
	// Shares operations
	// -----------------

	static public function share($path) {
		OC_esLog::log($path, NULL,'File shared');
	}
	static public function unshare($path) {
		OC_esLog::log($path, NULL,'File unshared');
	}
	static public function shareexpiration($vars) {
		OC_esLog::log($vars, NULL,'File share expiration changed');
	}
	
	// ------
	// Webdav
	// ------

	static public function dav($vars) {
		OC_esLog::log('/','/','Webdav');
	}

	// ---------------
	// Apps management
	// ---------------

	static public function appenable($vars) {
		OC_esLog::log($vars['app'], NULL, 'App enabled');
	}
	static public function appdisable($vars) {
		OC_esLog::log($vars['app'], NULL, 'App disabled');
	}

	static public function defaulthook($vars) {
		$action='unknown';		
		$path=$vars;
		$protocol='http';
			
		if(isset($vars['SCRIPT_NAME']) && basename($vars['SCRIPT_NAME'])=='remote.php'){
			$paths=explode('/',$vars['REQUEST_URI']);
			$pos=array_search('remote.php',$paths);
			$protocol=$paths[$pos+1];
			$path='';
			for($i=$pos+2 ; $i<sizeof($paths) ; $i++){
				$path.='/'.$paths[$i];
			}
			
			$action=strtolower($vars['REQUEST_METHOD']);
			
			
			if($protocol=='webdav'){	
				if($action=='put') $action='write';			
			}
			if($protocol=='carddav'){			
							
			}
			if($protocol=='caldav'){			
							
			}
			
			
		} 

		if(!in_array($action,array('head'))){
			OC_esLog::log($path,NULL,$action,$protocol);
		}		
		
	}
}

