<?php

// change the following paths if necessary
$yii = dirname(__FILE__).'/../yii/yii.php';
$config = dirname(__FILE__).'/../application/config/main.php';
$local = dirname(__FILE__).'/../application/config/local.php';

// Blend local and main config
$config = CMap::mergeArray($config, $local);

require_once($yii);
Yii::createWebApplication($config)->run();
