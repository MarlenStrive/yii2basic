<?php

namespace common\widgets\reveal;

use yii\web\AssetBundle;

class RevealWidgetAsset extends AssetBundle
{
    public $sourcePath = __DIR__ . '/assets';
    
    public $js = [
        'js/reveal.js',
    ];
    
    public $css = [
        'css/reveal.css',
        'css/theme/white.css',
    ];
}