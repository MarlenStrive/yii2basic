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
        /*'user' => [
            'class' => 'dektrium\user\models\User',
            'identityClass' => 'common\models\User',
        ],*/
    ],
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableUnconfirmedLogin' => true,
            'enableFlashMessages' => false,
            'confirmWithin' => 21600,
            'cost' => 12,
            'modelMap' => [
                'User' => 'common\models\User',
                'Profile' => 'common\models\Profile',
            ],
            'admins' => ['admin'],
            //'on ' . \common\models\User::EVENT_AFTER_INSERT => ['common\models\User', 'afterInsert'],
        ],
    ],
];
