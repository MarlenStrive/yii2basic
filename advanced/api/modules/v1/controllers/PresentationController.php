<?php

namespace api\modules\v1\controllers;

use Yii;
use api\common\controllers\ActiveController;
use common\models\Presentation;
use common\models\PresentationPage;
use yii\web\ServerErrorHttpException;
use yii\web\NotFoundHttpException;
use common\helpers\Permission;

class PresentationController extends ActiveController
{
    public $modelClass = 'common\models\Presentation';
    
    // Define custom actions
    // public function actionAlive()
    // {
    //     return new ActiveDataProvider([
    //         'query' => Proxy::find()->where(['Alive' => 1]),
    //         'pagination' => false,
    //     ]);
    // }
    
    
    
    /**
     * Change the page in the presentation
     * 
     * @param string $slug public url of the Presentation
     * @param integer $number page number inside the Presentation
     * @return \yii\db\ActiveRecordInterface the model being updated
     * @throws NotFoundHttpException|ServerErrorHttpException
     */
    public function actionUpdatePage($slug, $number)
    {
        $presentation = Presentation::findOne(['public_url' => $slug]);
        if (is_null($presentation) || !Yii::$app->user->can(Permission::MANAGE_PRESENTATION, ['presentation' => $presentation])) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested presentation does not exist.'));
        }
        
        $page = PresentationPage::findPage($presentation->id, $number);
        
        $page->load(Yii::$app->getRequest()->getBodyParams(), '');
        
        if ($page->save() === false && !$page->hasErrors()) {
            throw new ServerErrorHttpException(Yii::t('app', 'Failed to update the object for unknown reason.'));
        }
        
        return array_intersect_key($page->attributes, array_flip(['content', 'note']));
    }

}
