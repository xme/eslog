<?php

/**
 * ownCloud - Dashboard
 *
 * @author Patrick Paysant <ppaysant@linagora.com>
 * @copyright 2014 CNRS DSI
 * @license This file is licensed under the Affero General Public License version 3 or later. See the COPYING file.
 */
OC::$CLASSPATH['OC_Eslog'] = 'eslog/lib/log.php';
OC::$CLASSPATH['OC_esLog_Hooks'] = 'eslog/lib/hooks.php';

OCP\Util::addStyle('eslog', 'eslog');
OCP\Util::addScript('eslog', 'eslog');
OCP\App::registerAdmin('eslog','settings');
OCP\App::registerPersonal('eslog', 'settings');
/* HOOKS */
// Users
OC_HOOK::connect('OC_User', 'pre_login', 'OC_esLog_Hooks', 'prelogin');
OC_HOOK::connect('OC_User', 'post_login', 'OC_esLog_Hooks', 'login');
OC_HOOK::connect('OC_User', 'logout', 'OC_esLog_Hooks', 'logout');
// Filesystem
OC_HOOK::connect('OC_Filesystem', 'post_write', 'OC_esLog_Hooks', 'write');
OC_HOOK::connect('OC_Filesystem', 'post_delete', 'OC_esLog_Hooks', 'delete');
OC_HOOK::connect('OC_Filesystem', 'post_rename', 'OC_esLog_Hooks', 'rename');
OC_HOOK::connect('OC_Filesystem', 'post_copy', 'OC_esLog_Hooks', 'copy');
OC_HOOK::connect('\OC\Files\Storage\Shared', 'file_put_contents', 'OC_esLog_Hooks', 'all');
// Webdav
OC_HOOK::connect('OC_DAV', 'initialize', 'OC_esLog_Hooks', 'dav');
//Apps
OC_HOOK::connect('OC_App', 'post_enable', 'OC_esLog_Hooks', 'app_enable');
OC_HOOK::connect('OC_App', 'pre_disable', 'OC_esLog_Hooks', 'app_disable');
// Cleanning settings
\OCP\BackgroundJob::addRegularTask('OC_Eslog', 'clean');
if (isset($_POST['superlog_lifetime']) && is_numeric($_POST['superlog_lifetime'])) {
OC_Appconfig::setValue('eslog', 'superlog_lifetime', $_POST['superlog_lifetime']);
}


