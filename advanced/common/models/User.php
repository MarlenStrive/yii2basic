<?php

namespace common\models;

use dektrium\user\models\User as BaseUser;
use yii\helpers\ArrayHelper;

class User extends BaseUser
{
    /**
     * @return array 
     */
    public static function getListData()
    {
        $users = User::find()->all();
        return ArrayHelper::map($users, 'id', 'username');
    }

}