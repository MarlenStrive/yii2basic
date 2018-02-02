<?php

namespace common\models;

use Yii;
use dektrium\user\models\User as BaseUser;
use yii\helpers\ArrayHelper;
use yii\base\Event;
use rmrevin\yii\module\Comments\interfaces\CommentatorInterface;

class User extends BaseUser implements CommentatorInterface
{
    /**
     * Get list of users with the role 'user'
     * 
     * @param boolean $withoutCurrentUser
     * @return array 
     */
    public static function getUsersListData($withoutCurrentUser = true)
    {
        $userIds = Yii::$app->authManager->getUserIdsByRole('user');
        if ($withoutCurrentUser) {
            $userIds = array_diff($userIds, [Yii::$app->user->identity->id]);
        }
        
        $users = User::find()->where(['id' => $userIds])->all();
        return ArrayHelper::map($users, 'id', 'username');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return self::findOne(['username' => $username]);
    }

    /**
     * Trigger for the event AFTER_CREATE
     * @param Event $event
     */
    public static function afterCreate($event)
    {
        // add moderator role to the created user
        $auth = Yii::$app->authManager;
        $auth->assign($auth->getRole('moderator'), $event->sender->id);
    }

    /**
     * Trigger for the event AFTER_REGISTER
     * @param Event $event
     */
    public static function afterRegister($event)
    {
        // add 'user' role to the registered user
        $auth = Yii::$app->authManager;
        $auth->assign($auth->getRole('user'), $event->sender->id);
    }

    public function getRoles()
    {
        $roles = Yii::$app->authManager->getRolesByUser($this->id);
        return ArrayHelper::getColumn($roles, 'name');
    }

    public function getCommentatorAvatar()
    {
        return $this->profile->getAvatarUrl(25);
    }

    public function getCommentatorName()
    {
        return $this->username;
    }

    public function getCommentatorUrl()
    {
        return ['profile/slug', 'slug' => $this->username];
    }

}