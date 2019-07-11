<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'text/xml' => 'yii\web\XmlParser',
            ],
        ],
        'response' => [
            'format' => yii\web\Response::FORMAT_JSON,
            'charset' => 'UTF-8',
            'formatters' => [
                'json' => [
                    'class' => 'yii\web\JsonResponseFormatter',
                    'prettyPrint' => YII_DEBUG,
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                ],
            ],
        ],
        'user' => [
            'identityClass' => 'api\models\User',
            'enableAutoLogin' => false,
            'enableSession' => false,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'v1/site/index',
                'v1/register' => 'v1/site/register',
                'v1/authorize' => 'v1/site/authorize',
                'v1/accesstoken' => 'v1/site/accesstoken',
                'v1/profile' => 'v1/site/profile',
                'v1/logout' => 'v1/site/logout',

                'v1/<_c:[\w-]+>' => 'v1/<_c>/index',
                'v1/<_c:[\w-]+>/create' => 'v1/<_c>/create',
                'v1/<_c:[\w-]+>/update/<id>' => 'v1/<_c>/update',
                'v1/<_c:[\w-]+>/view/<id>' => 'v1/<_c>/view',
                'v1/<_c:[\w-]+>/delete/<id>' => 'v1/<_c>/delete',

            ],
        ],
    ],
    'params' => $params,
];
