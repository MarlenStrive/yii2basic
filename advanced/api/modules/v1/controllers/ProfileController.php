<?php

namespace api\modules\v1\controllers;

use Yii;
use api\common\controllers\ActiveController;
use common\models\Profile;

class ProfileController extends ActiveController
{
    public $modelClass = 'common\models\Profile';

    /** @var string */
    protected $fieldsList = ['name', 'second_name', 'public_email', 'website', 'country',
                    'city', 'timezone', 'language', 'gravatar_email', 'bio'];

    /**
     * Displays a profile for the logged user.
     * 
     * @return \yii\db\ActiveRecordInterface the model being displayed
     */
    public function actionViewOwn()
    {
        $currentUserId = Yii::$app->user->identity->id;
        
        $model = Profile::find()
            ->select($this->fieldsList)
            ->where(['user_id' => $currentUserId])
            ->one();
        
        return $model;
    }

    /**
     * Update a profile for the logged user.
     *
     * @return \yii\db\ActiveRecordInterface the model being updated
     * @throws ServerErrorHttpException if there is any error when updating the model
     */
    public function actionUpdateOwn()
    {
        $currentUserId = Yii::$app->user->identity->id;
        
        $model = Profile::findOne(['user_id' => $currentUserId]);
        
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->save() === false && !$model->hasErrors()) {
            throw new ServerErrorHttpException(Yii::t('app', 'Failed to update the object for unknown reason.'));
        }
        
        return array_intersect_key($model->attributes, array_flip($this->fieldsList));
    }

}
