<?php

use yii\helpers\Html;

/**
 * @var \yii\web\View $this
 * @var \common\models\User $model
 */

/** @var \common\models\Profile $profile */
$profile = $model->profile;
$publicFields = (is_array($profile->public_fields)) ? $profile->public_fields : explode(',', $profile->public_fields);

$this->title = $model->username;
$this->params['breadcrumbs'][] = $this->title;

$name = $profile->getPublicName();
if (empty($name)) {
    $name = $model->username;
}
$location = $profile->getPublicLocation();

?>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-6">
        <div class="row">
            <div class="col-sm-6 col-md-4">
                <?= Html::img($profile->getAvatarUrl(230), [
                    'class' => 'img-rounded img-responsive',
                    'alt' => $profile->user->username,
                ]) ?>
            </div>
            <div class="col-sm-6 col-md-8">
                <h4><?= Html::encode($name) ?></h4>
                <ul style="padding: 0; list-style: none outside none;">
                    <?php if (in_array('website', $publicFields) && !empty($profile->website)) { ?>
                        <li>
                            <i class="glyphicon glyphicon-globe text-muted"></i> 
                            <?= Html::a(Html::encode($profile->website), Html::encode($profile->website), ['target' => '_blank']) ?>
                        </li>
                    <?php } ?>
                    <?php if (in_array('public_email', $publicFields) && !empty($profile->public_email)) { ?>
                        <li>
                            <i class="glyphicon glyphicon-envelope text-muted"></i> <?= Html::a(Html::encode($profile->public_email), 'mailto:' . Html::encode($profile->public_email)) ?>
                        </li>
                    <?php } ?>
                    <?php if (!empty($location)) { ?>
                        <li>
                            <i class="glyphicon glyphicon-map-marker text-muted"></i> <?= Html::encode($location) ?>
                        </li>
                    <?php } ?>
                    <?php if (in_array('timezone', $publicFields) && !empty($profile->timezone)) { ?>
                        <li>
                            <i class="glyphicon glyphicon-time text-muted"></i> <?= Html::encode($profile->timezone) ?>
                        </li>
                    <?php } ?>
                    <?php if (in_array('language', $publicFields) && !empty($profile->language)) { ?>
                        <li>
                            <i class="glyphicon glyphicon-pencil text-muted"></i> <?= Html::encode($profile->language) ?>
                        </li>
                    <?php } ?>
                    <li>
                        <i class="glyphicon glyphicon-time text-muted"></i> <?= Yii::t('user', 'Joined on {0, date}', $model->created_at) ?>
                    </li>
                </ul>
                
            </div>
        </div>
        <?php if (in_array('bio', $publicFields) && !empty($profile->bio)) { ?>
            <div class="row">
                <div class="col-sm-12">
                    <p class="profile-bio"><?= Html::encode($profile->bio) ?></p>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
