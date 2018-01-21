<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $page common\models\PresentationPage */

?>
    <?php $form = ActiveForm::begin(['options' => ['id' => 'presentation-pages-form']]); ?>
    
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($page, 'content')->widget(TinyMce::className(), [
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
        </div>
        <div class="col-lg-6">
            <?= $form->field($page, 'note')->widget(TinyMce::className(), [
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
        </div>
    </div>
    
    <div class="form-group bottom-buttons">
        
        <?php if (!$page->isNewRecord && $page->number > 1) { ?>
        <?= Html::a(Yii::t('app', 'Delete current page'), ['delete-page', 'id' => $page->presentation_id, 'number' => $page->number], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this page?'),
                'method' => 'post',
            ],
        ]) ?>
        <?php } else if ($page->isNewRecord && $page->number > 1) { ?>
            <?= Html::a(Yii::t('app', 'Delete current page'), ['update-page', 'id' => $page->presentation_id, 'number' => $page->number - 1], [
                'class' => 'btn btn-danger']); ?>
        <?php } ?>
        
        <?php if ($page->number >= $page->presentation->getPagesCount()) { ?>
            <?= Html::submitButton(Yii::t('app', 'Next: Add new page'), ['class' => 'btn btn-primary', 'name' => 'PresentationPage[new]']) ?>
        <?php } else { ?>
            <?= Html::submitButton(Yii::t('app', 'Next: Edit next page'), ['class' => 'btn btn-success', 'name' => 'PresentationPage[edit]']) ?>
        <?php } ?>
        
        <?= Html::submitButton(Yii::t('app', 'Next: Finish Presentation'), ['class' => 'btn btn-success', 'name' => 'PresentationPage[finish]']) ?>
    </div>
    
    <?php ActiveForm::end(); ?>
