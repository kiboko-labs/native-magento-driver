<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

include __DIR__ . '/vendor/autoload.php';

$GLOBALS['DB_USERNAME'] = isset($GLOBALS['MYSQL_USER']) ? $GLOBALS['MYSQL_USER'] : 'root';
$GLOBALS['DB_PASSWORD'] = isset($GLOBALS['MYSQL_PASS']) ? $GLOBALS['MYSQL_PASS'] : null;
$GLOBALS['DB_NAME'] = isset($GLOBALS['TEST_ENV_NUMBER']) ? 'test'.$GLOBALS['TEST_ENV_NUMBER'] : 'test';
