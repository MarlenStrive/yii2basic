<?php

//use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $page common\models\PresentationPage */

$this->title = Yii::t('app', 'Update Page: {nameAttribute}', [
    'nameAttribute' => $page->presentation->title,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Presentations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $page->presentation->title, 'url' => ['view', 'id' => $page->presentation->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Add New Page');

?>
<div class="presentation-update-page">

    <h1><?= Yii::t('app', 'Page {number}', ['number' => $page->number]) ?></h1>

    <?= $this->render('_pageForm', [
        'page' => $page,
    ]) ?>

</div>
