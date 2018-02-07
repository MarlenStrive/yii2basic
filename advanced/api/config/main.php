<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-api',
    'name' => 'Presentations Exchange API',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => 'api\modules\v1\Module',
        ],
        'oauth2' => [
            'class' => \filsh\yii2\oauth2server\Module::class,
            'tokenParamName' => 'accessToken',
            'tokenAccessLifetime' => 3600 * 24,
            'storageMap' => [
                'user_credentials' => 'api\common\models\User',
            ],
            'grantTypes' => [
                'user_credentials' => [
                    'class' => 'OAuth2\GrantType\UserCredentials',
                ],
                'refresh_token' => [
                    'class' => 'OAuth2\GrantType\RefreshToken',
                    'always_issue_new_refresh_token' => true,
                ],
            ],
            // need to add to solve bug in /filsh/yii2-oauth2-server/Server.php
            'components' => [
                'request' => function () {
                    return \filsh\yii2\oauth2server\Request::createFromGlobals();
                },
                'response' => [
                    'class' => \filsh\yii2\oauth2server\Response::class,
                ],
            ],
        ],
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableUnconfirmedLogin' => true,
            'enableFlashMessages' => false,
            'confirmWithin' => 21600,
            'cost' => 12,
            'modelMap' => [
                'User' => 'api\common\models\User',
                'Profile' => 'common\models\Profile',
            ],
            'admins' => ['admin'],
        ],
    ],
    'components' => [
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
            'enableCookieValidation' => false,
            'enableCsrfValidation' => false,
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
            //'enablePrettyUrl' => true,
            //'enableStrictParsing' => true,
            //'showScriptName' => false,
            'rules' => [
                'POST v1/oauth2/<action:\w+>' => 'oauth2/rest/<action>',
                'GET v1/profile' => 'v1/profile/view-own',
                'POST v1/profile' => 'v1/profile/update-own',
                
                //['class' => 'yii\rest\UrlRule', 'controller' => 'v1/presentation'], // dont need all these actions
                'GET v1/presentations' => 'v1/presentation/list',
                'POST v1/presentation/<slug>/<number:\d+>' => 'v1/presentation/update-page',
            ],
        ],
    ],
    'params' => $params,
];
