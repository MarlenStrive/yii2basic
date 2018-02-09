<?php
namespace common\fixtures;

use yii\test\ActiveFixture;

class PresentationFixture extends ActiveFixture
{
    public $modelClass = 'common\models\Presentation';
    
    public $depends = [
        'common\fixtures\UserFixture',
        'common\fixtures\CategoryFixture',
    ];
}