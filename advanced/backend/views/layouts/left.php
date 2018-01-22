<?php
use yii\helpers\Html;

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

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Presentations', 'icon' => 'file-code-o', 'url' => ['/presentation']],
                    ['label' => 'Categories', 'icon' => 'users', 'url' => ['/category']], // if admin, if user has permission to view Categories list - use RBAC
                    ['label' => 'Users', 'icon' => 'users', 'url' => ['/user/admin/index']], // if admin
                ],
            ]
        ) ?>

    </section>

</aside>
