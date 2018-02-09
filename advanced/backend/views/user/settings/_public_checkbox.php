<?php

use yii\helpers\Html;

/**
 * @var array $publicFields
 * @var string $fieldName
 */
?>

<div class="col-lg-offset-9 col-lg-3" style="margin-top: -50px;">
    <label>
        <?= Html::checkbox('Profile[public_fields][]', in_array($fieldName, $publicFields), ['value' => $fieldName]) ?>
        public
    </label>
</div>
