<?php

use yii\db\Migration;

/**
 * Class m180115_154200_rbac_init
 */
class m180115_154200_rbac_init extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;
        
        $createPresentation = $auth->createPermission('createPresentation');
        $createPresentation->description = 'Create a presentation';
        $auth->add($createPresentation);
        /*
        $updatePresentation = $auth->createPermission('updatePresentation');
        $updatePresentation->description = 'Update a presentation';
        $auth->add($updatePresentation);
        
        $deletePresentation = $auth->createPermission('deletePresentation');
        $deletePresentation->description = 'Delete a presentation';
        $auth->add($deletePresentation);
        */
        $manageUsers = $auth->createPermission('manageUsers');
        $manageUsers->description = 'Manage users';
        $auth->add($manageUsers);
        
        $moderator = $auth->createRole('moderator');
        $moderator->description = 'Moderator';
        $auth->add($moderator);
        $auth->addChild($moderator, $createPresentation);
        
        $admin = $auth->createRole('admin');
        $admin->description = 'Administrator';
        $auth->add($admin);
        $auth->addChild($admin, $moderator);
        $auth->addChild($admin, $manageUsers);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        Yii::$app->authManager->removeAll();
    }

}
