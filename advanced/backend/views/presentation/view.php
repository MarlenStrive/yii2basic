<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Presentation */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Presentations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="presentation-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'title',
            'description:html',
            'is_public',
            'image_preview',
            'created_at:datetime',
            'updated_at:datetime',
            'publication_date',
            'expiration_date',
            [
                'label' => Yii::t('app', 'Public Url'),
                'format' => 'raw',
                'value' => Html::a($model->public_url, Yii::$app->urlManagerFrontend->createAbsoluteUrl('presentation/' . $model->public_url), ['target' => '_blank']),
            ],
            'rating',
            [
                'label' => Yii::t('app', 'Category'),
                'value' => $model->category->category,
            ],
        ],
    ]) ?>

</div>
