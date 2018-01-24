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

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'user_id',
            'title',
            'description:html',
            //'is_public',
            'image_preview',
            'created_at:datetime',
            'updated_at:datetime',
            'publication_date',
            'expiration_date',
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

