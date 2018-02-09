<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use backend\assets\CreatePresentationAsset;
use dosamigos\tinymce\TinyMce;
use dosamigos\datepicker\DateRangePicker;
use common\models\Category;

/* @var $this yii\web\View */
/* @var $model common\models\Presentation */
/* @var $form yii\widgets\ActiveForm */
?>

    <?php $form = ActiveForm::begin(['options' => ['id' => 'presentation-form']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->widget(TinyMce::className(), [
        'options' => ['rows' => 6],
        'language' => 'en',
        'clientOptions' => [
            'plugins' => [
                "advlist autolink lists link charmap print preview anchor",
                "searchreplace visualblocks code",
                "insertdatetime table contextmenu paste"
            ],
            'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
        ]
    ]);?>

    <?= $form->field($model, 'publication_date')->widget(DateRangePicker::className(), [
        'attributeTo' => 'expiration_date', 
        'form' => $form,
        'language' => 'en',
        'size' => 'lg',
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ],
    ])->label(Yii::t('app', 'Publication dates (from - to)'));?>

    <?= $form->field($model, 'category_id')->dropDownList(Category::getDataList(),
            ['prompt' => '---- Select category ----'])->label(Yii::t('app', 'Category')) ?>

    <div class="form-group">
        <?php if ($model->isNewRecord || $model->getPagesCount() == 0) {
            echo Html::submitButton(Yii::t('app', 'Next: Create Pages'), ['class' => 'btn btn-primary']);
        } else {
            echo Html::submitButton(Yii::t('app', 'Next: Update Pages'), ['class' => 'btn btn-success']);
        } ?>
    </div>
    
    <?php ActiveForm::end(); ?>
