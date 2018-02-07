<?php
namespace common\fixtures;

use yii\test\ActiveFixture;

class PresentationPageFixture extends ActiveFixture
{
    public $modelClass = 'common\models\PresentationPage';
    
    public $depends = [
        'common\fixtures\PresentationFixture',
    ];
}