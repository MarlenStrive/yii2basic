<?php
namespace frontend\controllers;

use Yii;
//use yii\base\InvalidParamException;
//use yii\web\BadRequestHttpException;
use yii\web\Controller;
//use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Presentation;
use frontend\models\PresentationSearch;
use yii\web\NotFoundHttpException;

/**
 * Presentation controller
 */
class PresentationController extends Controller
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
                        'actions' => ['index', 'slug', 'content'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }/*

    /**
     * @inheritdoc
     */
    /*public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }*/

    /**
     * Lists all public presentation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PresentationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Status model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    /*public function actionView($id)
    {
        // TODO: check that this model is public and not private
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        
        
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }*/

    /**
     * Displays a single Presentation model.
     * @param string $slug
     * @return mixed
     */
    public function actionSlug($slug)
    {
        return $this->render('view', [
            'model' => $this->findModelBySlug($slug),
        ]);
    }

    /**
     * Used inside iframe to show presentation pages
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionContent($slug)
    {
        return $this->renderAjax('viewIframe', [
            'model' => $this->findModelBySlug($slug),
        ]);
    }

    /**
     * Finds the Presentation model based on its slug value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $slug
     * @return Presentation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelBySlug($slug)
    {
        $model = Presentation::find()->where(['public_url' => $slug])->one();
        
        // TODO: add check that it is public and can be seen on frontend by this user
        
        // TODO: check that this model is public and not private
        // check user is in viewer or editor table
        // current date is between publication and expiration
        
        if (!is_null($model)) {
            return $model;
        }
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
