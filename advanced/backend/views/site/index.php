<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Presentations Exchange';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Welcome</h1>
        <p class="lead">Nice to see you.</p>
        <p>
            <?= Html::a(Yii::t('app', 'View Presentations'), ['/presentation'], ['class' => 'btn btn-lg btn-success']) ?>
        </p>
    </div>

    <div class="body-content">
    </div>

</div>
