<?php

// Add this file into remote.php
// require_once 'apps/superlog/spy.php';
require_once 'apps/eslog/lib/log.php';
require_once 'apps/eslog/lib/hooks.php';
OC_esLog_Hooks::defaulthook($_SERVER);
