<?php

use yii\db\Migration;
use common\helpers\Permission;
use common\rbac\AuthorRule;

/**
 * Class m180126_154200_rbac_init
 */
class m180126_154200_rbac_init extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;
        
        // create permissions
        $manageUsers = $auth->createPermission(Permission::MANAGE_USERS);
        $manageUsers->description = 'Manage users';
        $auth->add($manageUsers);
        
        $manageCategories = $auth->createPermission(Permission::MANAGE_CATEGORIES);
        $manageCategories->description = 'Manage categories';
        $auth->add($manageCategories);
        
        
        $viewPresentation = $auth->createPermission(Permission::VIEW_PRESENTATION);
        $viewPresentation->description = 'View a presentation';
        $auth->add($viewPresentation);
        
        
        $authorRule = new AuthorRule;
        $auth->add($authorRule);
        
        
        $viewOwnPresentation = $auth->createPermission(Permission::VIEW_OWN_PRESENTATION);
        $viewOwnPresentation->description = 'View own presentation';
        $viewOwnPresentation->ruleName = $authorRule->name;
        $auth->add($viewOwnPresentation);
        
        
        $createPresentation = $auth->createPermission(Permission::CREATE_PRESENTATION);
        $createPresentation->description = 'Create a presentation';
        $auth->add($createPresentation);
        
        $managePresentation = $auth->createPermission(Permission::MANAGE_PRESENTATION);
        $managePresentation->description = 'Manage a presentation';
        $auth->add($managePresentation);
        
        
        
        $manageOwnPresentation = $auth->createPermission(Permission::MANAGE_OWN_PRESENTATION);
        $manageOwnPresentation->description = 'Manage own presentation';
        $manageOwnPresentation->ruleName = $authorRule->name;
        $auth->add($manageOwnPresentation);
        
        
        $auth->addChild($manageOwnPresentation, $managePresentation);
        $auth->addChild($managePresentation, $createPresentation);
        $auth->addChild($createPresentation, $viewPresentation);
        $auth->addChild($viewOwnPresentation, $viewPresentation);
        
        // create roles
        $user = $auth->createRole('user');
        $user->description = 'User';
        $auth->add($user);
        $auth->addChild($user, $manageOwnPresentation);
        $auth->addChild($user, $createPresentation);
        $auth->addChild($user, $viewOwnPresentation);
        $auth->addChild($user, $viewPresentation);
        
        $moderator = $auth->createRole('moderator');
        $moderator->description = 'Moderator';
        $auth->add($moderator);
        $auth->addChild($moderator, $user);
        $auth->addChild($moderator, $managePresentation);
        
        $admin = $auth->createRole('admin');
        $admin->description = 'Administrator';
        $auth->add($admin);
        $auth->addChild($admin, $moderator);
        $auth->addChild($admin, $manageUsers);
        $auth->addChild($admin, $manageCategories);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        Yii::$app->authManager->removeAll();
    }

}
