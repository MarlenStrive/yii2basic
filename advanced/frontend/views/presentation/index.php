<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\PresentationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Presentations');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="presentation-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?= $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            [
                'label' => Yii::t('app', 'Title'),
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->title, ['presentation/slug', 'slug' => $model->public_url],
                            ['class' => 'maxwidth-300 ellipsis', 'data-toggle' => 'tooltip', 'title' => Html::encode($model->title)]);
                },
            ],
            /*[
                'label' => Yii::t('app', 'User'),
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->user->username, ['profile/slug', 'slug' => $model->user->username]);
                },
            ],*/
            'user.username',
            [
                'label' => Yii::t('app', 'Image Preview'),
                'format' => 'raw',
                'value' => function ($model) {
                    return '<div class="view-small-image-preview">' . $this->render('_image_preview', ['model' => $model]) . '</div>';
                },
            ],
            'created_at:datetime',
            'rating',
            'category.category',
            [
                'label' => Yii::t('app', 'Tags'),
                'value' => function ($model) {
                    return implode(', ', ArrayHelper::getColumn($model->tags, 'name'));
                },
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
