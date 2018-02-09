<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use common\models\Tag;
use yii\web\Response;

/**
 * Tag controller
 */
class TagController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Return matched tags
     *
     * @return string json
     */
    public function actionList($query)
    {
        $models = Tag::findAllByName($query);
        $items = [];
        
        foreach ($models as $model) {
            $items[] = ['name' => $model->name];
        }
        
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        return $items;
    }

}
