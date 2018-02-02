<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\assets\PresentationAsset;
use dosamigos\selectize\SelectizeTextInput;
use common\models\User;


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
            src="<?= Yii::$app->getUrlManager()->createUrl(['presentation/content', 'id' => $model->id]) ?>">
        </iframe>
    </div>
    
    <?php $form = ActiveForm::begin(['options' => ['id' => 'presentation-form']]); ?>

    <?= $form->field($model, 'image_preview')->dropDownList($model->getPagesOptionsList()) ?>

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
    
    <?php $withoutCurrentUser = ($model->user_id == Yii::$app->user->identity->id); ?>
    <?= $form->field($model, 'is_public')->checkBox(['selected' => $model->is_public]) ?>
    <?= $form->field($model, 'editor_ids')->dropDownList(User::getUsersListData($withoutCurrentUser), ['multiple' => true]) ?>

    <?= $form->field($model, 'viewer_ids')->dropDownList(User::getUsersListData($withoutCurrentUser), ['multiple' => true]) ?>

    <div class="form-group">
        <?= Html::button(Yii::t('app', 'Save'), ['class' => 'btn btn-success', 'id' => 'save-btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>