<?php

/* @var $this yii\web\View */
/* @var $presentation common\models\Presentation */

$link = Yii::$app->urlManager->createAbsoluteUrl(['presentation/view', 'id' => $presentation->id]);
?>

Presentation '<?= $presentation->title ?>' has been changed.

Follow the link below to view more details:

<?= $link ?>
