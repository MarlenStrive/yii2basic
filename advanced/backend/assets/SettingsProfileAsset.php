<?php

namespace backend\assets;

use yii\web\AssetBundle;

class SettingsProfileAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    public $js = [
        'js/settingsProfile.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
