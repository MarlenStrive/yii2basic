<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\assets\StatusAsset;
StatusAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\Status */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="status-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php /*= $form->field($model, 'message')->textarea(['rows' => 6])*/ ?>
    <div class="row">
        <div class="col-md-8">
            <?= $form->field($model, 'message')->widget(\yii\redactor\widgets\Redactor::className(), [
                'clientOptions' => [
                    'imageUpload' => \yii\helpers\Url::to(['/redactor/upload/image']),
                ],
            ] ) ?>
        </div>
        <div class="col-md-4">
            <p>Remaining: <span id="counter2">0</span></p>
        </div>
    </div>

    <?= $form->field($model, 'permissions')->dropDownList($model->getPermissions(), 
            ['prompt' => '- Choose Your Permissions -']) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
