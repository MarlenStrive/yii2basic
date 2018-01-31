<?php

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