<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
//use yii\filters\VerbFilter;
//use yii\filters\AccessControl;
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
    /*public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }*/

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * return matched tags
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
