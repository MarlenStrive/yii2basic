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
    }

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
     * Shows presentation pages
     * 
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
        $model = Presentation::getUserQueryConditions()->andWhere(['public_url' => $slug])->one();
        
        if (!is_null($model)) {
            return $model;
        }
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
