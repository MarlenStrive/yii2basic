<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $models array common\models\Presentation */

$this->title = 'Presentations Exchange';
?>
<div class="site-index">

    <div class="jumbotron">
        <h2>Here You can see example of our users works</h2>
        <p>
            <?= Html::a(Yii::t('app', 'Sign up'), ['/user/registration/register']) ?>
            or
            <?= Html::a(Yii::t('app', 'Sign in'), ['/user/security/login']) ?>
            to see more
        </p>
    </div>

    <div class="body-content">

        <div class="row">
            <?php foreach ($models as $model) { ?>
                <div class="col-lg-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            
                            <h2 class="maxwidth-300 ellipsis" data-toggle="tooltip" title="<?= Html::encode($model->title) ?>">
                                <?= Html::encode($model->title) ?>
                            </h2>
                            
                        </div>
                        <div class="panel-body">
                            <p> Created <?= Yii::$app->formatter->asDate($model->created_at, 'dd MMM Y') ?></p>
                            <?= $this->render('/presentation/_image_preview', ['model' => $model]); ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

    </div>
</div>

<?php 
$js = <<< 'SCRIPT'
$(function () { 
    $("[data-toggle='tooltip']").tooltip(); 
});;
SCRIPT;
$this->registerJs($js);
