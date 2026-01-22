<?php

use yii\db\Connection;

/** @var array $params */

return [
    'class' => Connection::class,
    'dsn' => "pgsql:host={$params['dbhost']};port={$params['dbport']};dbname={$params['dbname']}",
    'username' => $params['dbuser'],
    'password' => $params['dbpass'],
    'charset' => 'utf8',
    'enableSchemaCache' => $params['enableSchemaCache'],
    'schemaCacheDuration' => $params['schemaCacheDuration'],
    'schemaCache' => $params['schemaCache'],
    'emulatePrepare' => $params['emulatePrepare'],
];
