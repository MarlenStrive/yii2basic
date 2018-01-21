<?php

//use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $presentation common\models\Presentation */
/* @var $page common\models\PresentationPage */

$this->title = Yii::t('app', 'Add New Page: {nameAttribute}', [
    'nameAttribute' => $presentation->title,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Presentations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $presentation->title, 'url' => ['view', 'id' => $presentation->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Add New Page');

?>
<div class="presentation-new-page">

    <h1><?= Yii::t('app', 'Page {number}', ['number' => $page->number]) ?></h1>

    <?= $this->render('_pageForm', [
        'page' => $page,
    ]) ?>

</div>
