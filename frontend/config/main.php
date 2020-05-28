<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'language' => 'ru',
    'name' => 'ZooBro',
    'id' => 'app-frontend',
    'homeUrl' => '/',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'v1' => [
            'class' => 'frontend\modules\v1\Module',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => '',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            //'enableStrictParsing' => true,
            'rules' => [
                [
                    'class' => \yii\rest\UrlRule::class,
                    'controller' => ['v1/user'],
                    'extraPatterns' => [
                        'POST auth' => 'auth',
                        'OPTIONS auth' => 'options',

                        'POST register' => 'register',
                        'OPTIONS register' => 'options',

                        'GET index' => 'index',
                        'OPTIONS index' => 'options',

                        'POST update' => 'update',
                        'OPTIONS update' => 'options',

                        'POST password-reset' => 'password-reset',
                        'OPTIONS password-reset' => 'options',

                        'POST set-password' => 'set-password',
                        'OPTIONS set-password' => 'options',
                    ],
                    'pluralize' => false,
                ],
                [
                    'class' => \yii\rest\UrlRule::class,
                    'controller' => ['v1/pets'],
                    'extraPatterns' => [
                        'GET index' => 'index',
                        'OPTIONS index' => 'options',

                        'POST create' => 'create',
                        'OPTIONS create' => 'options',

                        'POST update' => 'update',
                        'OPTIONS update' => 'options',
                    ],
                    'pluralize' => false,
                ],
                [
                    'class' => \yii\rest\UrlRule::class,
                    'controller' => ['v1/orders'],
                    'extraPatterns' => [
                        'GET index' => 'index',
                        'OPTIONS index' => 'options',

                        'POST create' => 'create',
                        'OPTIONS create' => 'options',

                        'POST update' => 'update',
                        'OPTIONS update' => 'options',
                    ],
                    'pluralize' => false,
                ],
                [
                    'class' => \yii\rest\UrlRule::class,
                    'controller' => ['v1/orders-admin'],
                    'extraPatterns' => [
                        'GET index' => 'index',
                        'OPTIONS index' => 'options',
                    ],
                    'pluralize' => false,
                ],
            ],
        ],

    ],
    'params' => $params,
];
