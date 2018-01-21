<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\assets\PresentationAsset;
use dosamigos\selectize\SelectizeTextInput;
use common\models\User;
use common\widgets\reveal\RevealWidget;

/* @var $this yii\web\View */
/* @var $model common\models\Presentation */

PresentationAsset::register($this);

$this->title = Yii::t('app', 'Finish Presentation: {nameAttribute}', [
    'nameAttribute' => $model->title,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Presentations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Finish Presentation');
?>
<div class="presentation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row" style="margin: auto; height:400px; width: 400px; border: 1px solid black;">
        <iframe id="slides" width="400" height="400" marginheight="0" marginwidth="0"
            src="<?= Yii::$app->getUrlManager()->createUrl(['presentation/presentation', 'id' => $model->id]) ?>">
        </iframe>
    </div>
    
    <?php $form = ActiveForm::begin(['options' => ['id' => 'presentation-form']]); ?>

    <?= $form->field($model, 'image_preview')->dropDownList(range(1, $model->getPagesCount())) ?>

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

    <?= $form->field($model, 'is_public')->checkBox(['selected' => $model->is_public]) ?>

    <?= $form->field($model, 'editor_ids')->dropDownList(User::getListData(), ['multiple' => true]) ?>

    <?= $form->field($model, 'viewer_ids')->dropDownList(User::getListData(), ['multiple' => true]) ?>

    <div class="form-group">
        <?= Html::button(Yii::t('app', 'Save'), ['class' => 'btn btn-success', 'id' => 'save-btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script src="/assets/8eb71703/jquery.js"></script>
<script>
$(function() {
    
    $("#save-btn").on("click", function(e) {
        
        var pageNumber = parseInt($('select[name="Presentation[image_preview]"] option:selected').val()) + 1;
        var pageContent = $("#slides").contents().find("#page-" + pageNumber).get(0);
        
        html2canvas(pageContent).then(function(canvas) {
            
            var image = canvas.toDataURL("image/png");
            $("<textarea name='Presentation[image-preview-content]' class='hide'>" + image + "</textarea>")
                    .appendTo("#presentation-form");
            
            $("#presentation-form").submit();
        });
    });
    
    
    $("[name='Presentation[image_preview111]']").on("change", function() {
        var pageNumber = parseInt(this.value) + 1;
        var pageContent = $("#slides").contents().find("#page-" + pageNumber).get(0);
        
        html2canvas(pageContent).then(function(canvas) {
            document.body.appendChild(canvas);
        });
        
        /*html2canvas(document.querySelector("page-" + pageNumber), {height: 500}).then(function(canvas) {
            console.log(canvas);
            document.querySelector("image-preview-canvas").innerHTML(canvas);
        });
        */
        
        /*html2canvas($("#page-" + pageNumber).get(0)).then( function (canvas) {
            console.log(canvas);
        });*/
        
        /*
        html2canvas($("#page-" + pageNumber).get(0)).then( function (canvas) {
            theCanvas = canvas;
            //document.body.appendChild(canvas);
$("#image-preview-canvas").append(canvas);

            / *
            // Convert and download as image 
            Canvas2Image.saveAsPNG(canvas); 
            $("#image-preview-canvas").append(canvas);
            // Clean up 
            //document.body.removeChild(canvas);
            
            console.log($("#image-preview-canvas"));
            console.log('hello');
            * /
        });
        */
    });
    
});
</script>