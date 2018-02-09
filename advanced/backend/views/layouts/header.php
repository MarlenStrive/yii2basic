<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

/* @var $profile dektrium\user\models\Profile */
$profile = Yii::$app->user->identity->profile;
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?= Html::img($profile->getAvatarUrl(230), [
                            'class' => 'user-image',
                            'alt' => Yii::$app->user->identity->username,
                        ]) ?>
                        <span class="hidden-xs"><?= Yii::$app->user->identity->username ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <?= Html::img($profile->getAvatarUrl(230), [
                                'class' => 'img-circle',
                                'alt' => Yii::$app->user->identity->username,
                            ]) ?>
                            <p>
                                <?= Yii::$app->user->identity->username ?>
                                <small>Member since <?= Yii::$app->formatter->asDate(Yii::$app->user->identity->created_at, 'MMM. Y') ?> </small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <?= Html::a(
                                    'Profile',
                                    ['/user/settings/profile'],
                                    ['class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    'Sign out',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
