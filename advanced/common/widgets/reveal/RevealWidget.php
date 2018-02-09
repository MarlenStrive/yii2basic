<?php

namespace common\widgets\reveal;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;

class RevealWidget extends Widget
{
    public $content = '';

    /**
     * @inheritdoc
     */
    public function run()
    {
        echo Html::tag('div', Html::tag('div', $this->content, ['class' => 'slides']), ['class'=>'reveal']);
        
        $this->registerClientScript();
    }

    /**
     * register client scripts (css, javascript)
     */
    public function registerClientScript()
    {
        $view = $this->getView();
        $asset = RevealWidgetAsset::register($view);
        
        $js = "
            Reveal.initialize({
                controls: true,
                controlsBackArrows: 'visible',
                progress: true,
                slideNumber: true,
                history: true,
                keyboard: true,
                embedded: true,
                center: true
            });
        ";
        
        $view->registerJs($js);
    }

}
