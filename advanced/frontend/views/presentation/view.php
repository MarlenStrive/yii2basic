<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;
use rmrevin\yii\module\Comments\widgets\CommentListWidget;
use rmrevin\yii\module\Comments\Permission as CommentPermission;

/* @var $this yii\web\View */
/* @var $model common\models\Presentation */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Presentations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="presentation-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-6">
            <div class="row" style="margin: auto; height:400px; width: 400px; border: 1px solid black;">
                <iframe id="slides" width="400" height="400" marginheight="0" marginwidth="0"
                    src="<?= Yii::$app->getUrlManager()->createUrl(['presentation/content', 'slug' => $model->public_url]) ?>">
                </iframe>
            </div>
        </div>
        <div class="col-md-6">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'label' => Yii::t('app', 'Author'),
                        'format' => 'raw',
                        'value' => Html::a($model->user->username, ['profile/slug', 'slug' => $model->user->username], ['target' => '_blank']),
                    ],
                    'created_at:datetime',
                    'rating',
                    [
                        'label' => Yii::t('app', 'Category'),
                        'value' => $model->category->category,
                    ],
                    [
                        'label' => Yii::t('app', 'Tags'),
                        'value' => implode(', ', ArrayHelper::getColumn($model->tags, 'name')),
                    ],
                    'description:html',
                ],
            ]) ?>
        </div>
    </div>

    <?php if (!Yii::$app->user->can(CommentPermission::CREATE)) { ?>
        <p class="warning"></p>
        <div class="alert alert-warning">
            <strong>Warning!</strong> You should have at least one presentation on this site to have ability
            to leave comments.
        </div>
    <?php } ?>
    <?= CommentListWidget::widget([
        'entity' => 'presentation-' . $model->id,
    ]); ?>

</div>
