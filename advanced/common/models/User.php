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
        // TODO: this list depends of the role of the current user
        $users = User::find()->all();
        return ArrayHelper::map($users, 'id', 'username');
    }
    
    public static function afterInsert($event){
        var_dump($event);
        exit('UserEvents::handleBeforeLogin');
    }

}