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

    /**
     * Returns presentations list for the curent user
     *
     * @return array|ActiveRecord[] presentations list for the current user
     */
    public function actionList()
    {
        $currentUserId = Yii::$app->user->identity->id;
        
        $models = Presentation::find()
            ->where(['user_id' => $currentUserId])
            ->all();
        
        return $models;
    }

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
        if (is_null($presentation) || !Yii::$app->user->can(Permission::MANAGE_PRESENTATION, ['id' => $presentation->id])) {
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
