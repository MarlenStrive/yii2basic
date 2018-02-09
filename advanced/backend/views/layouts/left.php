<?php
use yii\helpers\Html;
use common\helpers\Permission;

/* @var $profile dektrium\user\models\Profile */
$profile = Yii::$app->user->identity->profile;
?>

<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <?= Html::img($profile->getAvatarUrl(230), [
                    'class' => 'img-circle',
                    'alt' => Yii::$app->user->identity->username,
                ]) ?>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->username ?></p>
            </div>
        </div>

        <?php
            $menuItems = [['label' => Yii::t('app', 'Presentations'), 'icon' => 'file-code-o', 'url' => ['/presentation']]];
            if (Yii::$app->user->can(Permission::MANAGE_CATEGORIES)) {
                $menuItems[] = ['label' => Yii::t('app', 'Categories'), 'icon' => 'users', 'url' => ['/category']];
            }
            if (Yii::$app->user->can(Permission::MANAGE_USERS)) {
                $menuItems[] = ['label' => Yii::t('app', 'Users'), 'icon' => 'users', 'url' => ['/user/admin/index']];
            }
            $menuItems[] = ['label' => Yii::t('app', 'Profile'), 'icon' => 'user', 'url' => ['/user/settings/profile']];
        ?>
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => $menuItems,
            ]
        ) ?>

    </section>

</aside>
