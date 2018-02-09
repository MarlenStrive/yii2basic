<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Category;
use dosamigos\selectize\SelectizeTextInput;

/* @var $this yii\web\View */
/* @var $model frontend\models\PresentationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="container presentation-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1,
        ],
    ]); ?>
    
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'title') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'category_id')->dropDownList(Category::getDataList(),
                ['prompt' => '---- Select category ----'])->label(Yii::t('app', 'Category')) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'username') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'tagNames')->widget(SelectizeTextInput::className(), [
                'loadUrl' => ['tag/list'],
                'options' => ['class' => 'form-control'],
                'clientOptions' => [
                    'plugins' => ['remove_button'],
                    'valueField' => 'name',
                    'labelField' => 'name',
                    'searchField' => ['name'],
                    'create' => true,
                ],
            ])->hint('Use commas to separate tags') ?>
        </div>
    </div>
    
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
