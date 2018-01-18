<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\assets\CreatePresentationAsset;

/* @var $this yii\web\View */
/* @var $model common\models\Presentation */
/* @var $form yii\widgets\ActiveForm */

CreatePresentationAsset::register($this);
?>

<div class="presentation-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'is_public')->textInput() ?>

    <?= $form->field($model, 'image_preview')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'publication_date')->textInput() ?>

    <?= $form->field($model, 'expiration_date')->textInput() ?>

    <?= $form->field($model, 'public_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rating')->textInput() ?>

    <?= $form->field($model, 'category_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
