<?php

use yii\db\Migration;

/**
 * Class m180126_155432_add_init_data
 */
class m180126_155432_add_init_data extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->insert('user', [
            'username' => 'admin',
            'password_hash' => Yii::$app->security->generatePasswordHash('admin'),
            'email' => 'admin@admin.com',
            'auth_key' => Yii::$app->security->generateRandomString(),
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        
        $adminId = $this->getUserId('admin');
        $this->insert('profile', [
            'user_id' => $adminId,
        ]);
        
        $auth = Yii::$app->authManager;
        $role = $auth->getRole('admin');
        $auth->assign($role, $adminId);
        
        
        $this->insert('user', [
            'username' => 'moderator',
            'password_hash' => Yii::$app->security->generatePasswordHash('moderator'),
            'email' => 'moderator@moderator.com',
            'auth_key' => Yii::$app->security->generateRandomString(),
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        
        $moderatorId = $this->getUserId('moderator');
        $this->insert('profile', [
            'user_id' => $moderatorId,
        ]);
        
        $auth = Yii::$app->authManager;
        $role = $auth->getRole('moderator');
        $auth->assign($role, $moderatorId);
        
        
        $this->insert('user', [
            'username' => 'user',
            'password_hash' => Yii::$app->security->generatePasswordHash('user'),
            'email' => 'user@user.com',
            'auth_key' => Yii::$app->security->generateRandomString(),
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        
        $userId = $this->getUserId('user');
        $this->insert('profile', [
            'user_id' => $userId,
        ]);
        
        $auth = Yii::$app->authManager;
        $role = $auth->getRole('user');
        $auth->assign($role, $userId);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $usernames = ['admin', 'moderator', 'user'];
        
        foreach ($usernames as $username) {
            $userId = $this->getUserId($username);
            $auth->revokeAll($userId);
            $this->delete('user', 'username = :username', [':username' => $username]);
        }
    }

    private function getUserId($username)
    {
        $sql = 'select id from user where username = :username';
        return Yii::$app->db->createCommand($sql, [':username' => $username])->queryScalar();
    }
}
