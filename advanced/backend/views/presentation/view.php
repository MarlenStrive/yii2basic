<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
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
            'user.username',
            'title',
            'description:html',
            [
                'label' => Yii::t('app', 'Is Public'),
                'value' => ($model->is_public) ? Yii::t('app', 'Yes') : Yii::t('app', 'No'),
            ],
            [
                'label' => Yii::t('app', 'Image Preview'),
                'format' => 'raw',
                'value' => Yii::t('app', '{number} page', ['number' => $model->image_preview])
                            . ' <div class="view-image-preview">' . $this->render('_image_preview', ['model' => $model]) . '</div>',
            ],
            'created_at:datetime',
            'updated_at:datetime',
            'publication_date',
            'expiration_date',
            'public_url',
            'rating',
            [
                'label' => Yii::t('app', 'Category'),
                'value' => $model->category->category,
            ],
            [
                'label' => Yii::t('app', 'Tags'),
                'value' => implode(', ', ArrayHelper::getColumn($model->tags, 'name')),
            ],
        ],
    ]) ?>

</div>
