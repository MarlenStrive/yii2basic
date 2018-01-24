<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Presentation */

$src = (!empty($model->image))
    ? $model->image
    : 'images/image_preview.jpg';
?>

<img class="image-preview" src="<?= $src ?>" width="100%">