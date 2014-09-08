<?php
$tmpl = new OC_Template('eslog', 'settings');
$tmpl->assign('eslog_host', OC_Appconfig::getValue('eslog', 'eslog_host','127.0.0.1:9200'));
$tmpl->assign('eslog_auth', OC_Appconfig::getValue('eslog', 'eslog_auth','none'));
$tmpl->assign('eslog_user', OC_Appconfig::getValue('eslog', 'eslog_user',''));
$tmpl->assign('eslog_password', OC_Appconfig::getValue('eslog', 'eslog_password',''));
$tmpl->assign('eslog_index', OC_Appconfig::getValue('eslog', 'eslog_index','owncloud'));
$tmpl->assign('eslog_type', OC_Appconfig::getValue('eslog', 'eslog_type','owncloud'));

return $tmpl->fetchPage();
