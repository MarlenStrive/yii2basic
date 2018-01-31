<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'facebook' => [
                    'class' => 'dektrium\user\clients\Facebook',
                    'clientId' => '1855695951107135',
                    'clientSecret' => '45e7d1afd5962addec05c73bf9871bf5',
                ],
            ],
        ],
    ],
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableUnconfirmedLogin' => true,
            'enableFlashMessages' => false,
            'confirmWithin' => 21600,
            'cost' => 12,
            'modelMap' => [
                'User' => [
                    'class' => 'common\models\User',
                    'on ' . \common\models\User::AFTER_CREATE => ['common\models\User', 'afterCreate'],
                    'on ' . \common\models\User::AFTER_REGISTER => ['common\models\User', 'afterRegister'],
                ],
                'Profile' => 'common\models\Profile',
            ],
            'admins' => ['admin'],
        ],
        'comments' => [
            'class' => 'rmrevin\yii\module\Comments\Module',
            'userIdentityClass' => 'common\models\User',
            'useRbac' => true,
        ],
    ],
];
