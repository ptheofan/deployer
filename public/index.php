<?php

// change the following paths if necessary
$yii = dirname(__FILE__).'/../yii/yii.php';
$config = require_once(dirname(__FILE__).'/../application/config/main.php');
$local = require_once(dirname(__FILE__).'/../application/config/local.php');

require_once($yii);

// Blend local and main config
$config = CMap::mergeArray($config, $local);

Yii::createWebApplication($config)->run();
