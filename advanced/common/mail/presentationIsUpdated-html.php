<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $presentation common\models\Presentation */

$link = Yii::$app->urlManager->createAbsoluteUrl(['presentation/view', 'id' => $presentation->id]);
?>
<div class="mail-presentation-edit">
    <p>Presentation <b><?= Html::encode($presentation->title) ?></b> has been changed.</p>
    <p>Follow the <?= Html::a('link', $link) ?> to view more details.</p>
</div>
