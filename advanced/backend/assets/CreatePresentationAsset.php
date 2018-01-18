<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class CreatePresentationAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/jquery.steps.min.js',
        'js/createPresentation.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
