<?php

use app\models\User;
use yii\caching\FileCache;
use yii\log\FileTarget;
use yii\web\JsonParser;
use yii\web\Request;
use yii\web\Response;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$routes = require(__DIR__ . '/routes.php');
$container = require __DIR__ . '/container.php';

$config = [
    'id' => 'loan-app',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    //удалить
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'class' => Request::class,
            'parsers' => [
                'application/json' => JsonParser::class
            ],
            'enableCookieValidation' => false,
            'enableCsrfValidation' => false, // Отключаем для API
        ],
        'response' => [
            'class' => Response::class,
            'format' => Response::FORMAT_JSON,
        ],
        'user' => [
            'identityClass' => User::class,
            'enableAutoLogin' => false,
            'enableSession' => false,
        ],
        'cache' => [
            'class' => FileCache::class,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => FileTarget::class,
                    'levels' => ['error', 'warning'],
                    'logFile' => '@runtime/logs/api.log',
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => $routes,
        ],
        'db' => $db,
    ],
    'container' => $container,
    'params' => $params,
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],
    ];
}

return $config;
