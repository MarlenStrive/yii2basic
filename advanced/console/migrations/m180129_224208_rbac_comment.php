<?php

use yii\db\Migration;
use rmrevin\yii\module\Comments\Permission;
use rmrevin\yii\module\Comments\rbac\ItsMyComment;
use common\rbac\HasPresentationRule;

/**
 * Class m180129_224208_rbac_comment
 */
class m180129_224208_rbac_comment extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $authManager = Yii::$app->getAuthManager();
        
        $itsMyCommentRule = new ItsMyComment();
        $authManager->add($itsMyCommentRule);
        
        $hasPresentationRule = new HasPresentationRule();
        $authManager->add($hasPresentationRule);
        
        $authManager->add(new \yii\rbac\Permission([
            'name' => Permission::CREATE,
            'ruleName' => $hasPresentationRule->name,
            'description' => 'Can create own comments',
        ]));
        $authManager->add(new \yii\rbac\Permission([
            'name' => Permission::UPDATE,
            'description' => 'Can update all comments',
        ]));
        $authManager->add(new \yii\rbac\Permission([
            'name' => Permission::UPDATE_OWN,
            'ruleName' => $itsMyCommentRule->name,
            'description' => 'Can update own comments',
        ]));
        $authManager->add(new \yii\rbac\Permission([
            'name' => Permission::DELETE,
            'description' => 'Can delete all comments',
        ]));
        $authManager->add(new \yii\rbac\Permission([
            'name' => Permission::DELETE_OWN,
            'ruleName' => $itsMyCommentRule->name,
            'description' => 'Can delete own comments',
        ]));
        
        $user = $authManager->getRole('user');
        $authManager->addChild($user, $authManager->getPermission(Permission::CREATE));
        
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $authManager = Yii::$app->getAuthManager();
        
        $permissions = [
            Permission::CREATE,
            Permission::UPDATE,
            Permission::UPDATE_OWN,
            Permission::DELETE,
            Permission::DELETE_OWN,
        ];
        foreach ($permissions as $permission) {
            $authManager->remove($authManager->getPermission($permission));
        }
        
        $itsMyCommentRule = new ItsMyComment();
        $authManager->remove($authManager->getRule($itsMyCommentRule->name));
        
        $hasPresentationRule = new HasPresentationRule();
        $authManager->remove($authManager->getRule($hasPresentationRule->name));
    }

}
