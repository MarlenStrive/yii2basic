<?php

use yii\db\Migration;

/**
 * Class m180126_155432_add_init_data
 */
class m180126_155432_add_init_data extends Migration
{
    //public $adminId = 1;
    
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
        
        $auth = Yii::$app->authManager;
        $role = $auth->getRole('admin');
        $auth->assign($role, $adminId);
        
        $this->insert('profile', [
            'user_id' => $adminId,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $adminId = $this->getUserId('admin');
        
        $auth = Yii::$app->authManager;
        $role = $auth->getRole('admin');
        $auth->revokeAll($adminId);
        
        $this->delete('user', 'username = :username', [':username' => 'admin']);
    }

    private function getUserId($username)
    {
        $sql = 'select id from user where username = :username';
        return Yii::$app->db->createCommand($sql, [':username' => $username])->queryScalar();
    }
}
