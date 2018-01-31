<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\PresentationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Presentations');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="presentation-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Presentation'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user.username',
            'title',
            [
                'label' => Yii::t('app', 'Is Public'),
                'value' => function ($model) {
                    return ($model->is_public) ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
                },
            ],
            [
                'label' => Yii::t('app', 'Image Preview'),
                'format' => 'raw',
                'value' => function ($model) {
                    return '<div class="view-small-image-preview">' . $this->render('_image_preview', ['model' => $model]) . '</div>';
                },
            ],
            //'created_at',
            //'updated_at',
            //'publication_date',
            //'expiration_date',
            'public_url',
            'rating',
            
            'category.category',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
