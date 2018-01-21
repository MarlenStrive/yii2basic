<?php

/*use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\assets\PresentationAsset;
use dosamigos\selectize\SelectizeTextInput;
use common\models\User;
*/
use common\widgets\reveal\RevealWidget;

/* @var $this yii\web\View */
/* @var $model common\models\Presentation */

if (class_exists('yii\debug\Module')) {
    $this->off(\yii\web\View::EVENT_END_BODY, [\yii\debug\Module::getInstance(), 'renderToolbar']);
}

$content = '<div class="reveal"><div class="slides">';
foreach ($model->presentationPages as $page) {
    $content .= '<section>' . $page->content . '</section>';
}
$content .= '</div></div>';

?>

<div class="row" style="margin: auto; height:400px; width: 400px; border: 1px solid black;">
    <?= RevealWidget::widget(['content' => $content]) ?>
</div>

<div class="pages" class="text-center">
    <?php foreach ($model->presentationPages as $page) { ?>
        <div id="page-<?= $page->number ?>"><?= $page->content ?></div>
    <?php } ?>
</div>
