<?php

namespace backend\assets;

use yii\web\AssetBundle;

class PresentationAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
        'js/html2canvas.min.js',
        'js/presentation.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
