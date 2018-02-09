<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'name' => 'Presentations&nbsp;Exchange',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'user' => [
            'controllerMap' => [
                'recovery' => [
                    'class' => 'dektrium\user\controllers\RecoveryController',
                    'layout' => '@app/views/layouts/main-login', // to change layout for the forgot password page
                ],
            ],
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
            'rules' => [
                'presentation' => 'presentation/index',
                'presentation/index' => 'presentation/index',
                'presentation/create' => 'presentation/create',
                'presentation/view/<id:\d+>' => 'presentation/view',
                'presentation/update/<id:\d+>' => 'presentation/update',
                'presentation/delete/<id:\d+>' => 'presentation/delete',
                'presentation/newPage/<id:\d+>' => 'presentation/new-page',
                'presentation/updatePage/<id:\d+>/<number:\d+>' => 'presentation/update-page',
                'presentation/finishUpdate/<id:\d+>' => 'presentation/finish-update',
                'presentation/deletePage/<id:\d+>/<number:\d+>' => 'presentation/delete-page',
                'presentation/content/<id:\d+>' => 'presentation/content',
                'tag/list' => 'tag/list',
            ],
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@dektrium/user/views' => '@app/views/user',
                ],
            ],
        ],
    ],
    'params' => $params,
];
