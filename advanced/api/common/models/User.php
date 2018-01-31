<?php

namespace api\common\models;

use Yii;
use common\models\User as BaseUser;
use \OAuth2\Storage\UserCredentialsInterface;
use dektrium\user\helpers\Password;

class User extends BaseUser implements UserCredentialsInterface
{
    /** @inheritdoc */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        /** @var \filsh\yii2\oauth2server\Module $module */
        $module = Yii::$app->getModule('oauth2');
        $token = $module->getServer()->getResourceController()->getToken();
        return !empty($token['user_id'])
            ? static::findIdentity($token['user_id'])
            : null;
    }

    /** @inheritdoc */
    public function checkUserCredentials($username, $password)
    {
        $user = static::findByUsername($username);
        if (empty($user)) {
            return false;
        }
        
        return Password::validate($password, $user->password_hash);
    }

    /** @inheritdoc */
    public function getUserDetails($username)
    {
        $user = static::findByUsername($username);
        return ['user_id' => $user->getId()];
    }
}
