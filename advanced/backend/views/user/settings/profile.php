<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use dektrium\user\helpers\Timezone;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\assets\SettingsProfileAsset;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var common\models\Profile $model
 */

SettingsProfileAsset::register($this);

$publicFields = (is_array($model->public_fields)) ? $model->public_fields : explode(',', $model->public_fields);

$this->title = Yii::t('user', 'Profile settings');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>

<div class="row">
    <div class="col-md-3">
        <?= $this->render('/settings/_menu') ?>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= Html::encode($this->title) ?>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'id' => 'profile-form',
                    'options' => ['class' => 'form-horizontal'],
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-6\">{input}</div>\n<div class=\"col-sm-offset-3 col-lg-9\">{error}\n{hint}</div>",
                        'labelOptions' => ['class' => 'col-lg-3 control-label'],
                    ],
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                    'validateOnBlur' => false,
                ]); ?>

                    <?= $form->field($model, 'name') ?>
                    <?= $this->render('_public_checkbox', ['fieldName' => 'name', 'publicFields' => $publicFields]) ?>
                    
                    <?= $form->field($model, 'second_name') ?>
                    <?= $this->render('_public_checkbox', ['fieldName' => 'second_name', 'publicFields' => $publicFields]) ?>
                    
                    <?= $form->field($model, 'public_email') ?>
                    <?= $this->render('_public_checkbox', ['fieldName' => 'public_email', 'publicFields' => $publicFields]) ?>
                    
                    <?= $form->field($model, 'website')->label(Yii::t('app', 'Git profile link')) ?>
                    <?= $this->render('_public_checkbox', ['fieldName' => 'website', 'publicFields' => $publicFields]) ?>
                    
                    <?= $form->field($model, 'country') ?>
                    <?= $this->render('_public_checkbox', ['fieldName' => 'country', 'publicFields' => $publicFields]) ?>
                    
                    <?= $form->field($model, 'city') ?>
                    <?= $this->render('_public_checkbox', ['fieldName' => 'city', 'publicFields' => $publicFields]) ?>
                    
                    <?= $form
                        ->field($model, 'timezone')
                        ->dropDownList(
                            ArrayHelper::map(
                                Timezone::getAll(),
                                'timezone',
                                'name'
                            )
                        ); ?>
                    <?= $this->render('_public_checkbox', ['fieldName' => 'timezone', 'publicFields' => $publicFields]) ?>
                    
                    <?= $form->field($model, 'language') ?>
                    <?= $this->render('_public_checkbox', ['fieldName' => 'language', 'publicFields' => $publicFields]) ?>
                    
                    <?= $form
                        ->field($model, 'gravatar_email')
                        ->hint(Html::a(Yii::t('user', 'Change your avatar at Gravatar.com'), 'http://gravatar.com', ['target' => '_blank'])) ?>
                    
                    <?= $form->field($model, 'bio')->textarea() ?>
                    <?= $this->render('_public_checkbox', ['fieldName' => 'bio', 'publicFields' => $publicFields]) ?>
                    
                    <div class="form-group">
                        <div class="col-lg-offset-3 col-lg-6">
                            <?= Html::button(Yii::t('user', 'Save'), ['class' => 'btn btn-block btn-success', 'id' => 'save-btn']) ?>
                            <br>
                        </div>
                    </div>
                    
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
