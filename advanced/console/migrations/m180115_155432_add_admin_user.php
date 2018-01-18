<?php

use yii\db\Migration;

/**
 * Class m180115_155432_add_admin_user
 */
class m180115_155432_add_admin_user extends Migration
{
    public $adminId = 1;
    
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
        
        $auth = Yii::$app->authManager;
        $role = $auth->getRole('admin');
        $auth->assign($role, $this->adminId);
        
        $this->insert('profile', [
            'user_id' => $this->adminId,
        ]);
        
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole('admin');
        $auth->revokeAll($this->adminId);
        
        $this->delete('user', 'username = :username', [':username' => 'admin']);
    }

}
