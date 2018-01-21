<?php

namespace backend\controllers;

use Yii;
use common\models\Presentation;
use common\models\PresentationSearch;
use common\models\PresentationPage;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
//use yii\widgets\ActiveForm;

/**
 * PresentationController implements the CRUD actions for Presentation model.
 */
class PresentationController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Presentation models.
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
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Used inside iframe to show presentation pages
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionPresentation($id)
    {
        return $this->renderAjax('viewIframe', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Presentation model.
     * If creation is successful, the browser will be redirected to the 'updateContent' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Presentation();
        if ($model->load(Yii::$app->request->post())) {
            
            $model->fillDefaultValues();
            if ($model->save()) {
                return $this->redirect(['new-page', 'id' => $model->id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Add new page to the Presentation.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the Presentation model cannot be found
     */
    public function actionNewPage($id)
    {
        $presentation = $this->findModel($id);
        $page = $presentation->getNewPage();
        
        if ($page->load(Yii::$app->request->post())) {
            
            if ($page->save()) {
                
                $data = Yii::$app->request->post('PresentationPage');
                
                $redirect = isset($data['new']) ? 'new-page' : 'finish-update';
                
                return $this->redirect([$redirect, 'id' => $presentation->id]);
            }
        }
        
        return $this->render('newPage', [
            'presentation' => $presentation,
            'page' => $page,
        ]);
    }

    public function actionFinishUpdate($id)
    {
        $model = $this->findModel($id);
        
        if ($model->load(Yii::$app->request->post())) {
            
            if ($model->save()) {
                
                $data = Yii::$app->request->post('Presentation');
                
                $model->savePreviewImage($data["image-preview-content"]);
                
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        
        return $this->render('finishUpdate', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Presentation model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($model->getPagesCount() > 0) {
                return $this->redirect(['update-page', 'id' => $model->id, 'number' => 1]);
            }
            return $this->redirect(['new-page', 'id' => $model->id]);
        }
        
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionUpdatePage($id, $number)
    {
        $page = PresentationPage::findPage($id, $number);
        
        if ($page->load(Yii::$app->request->post()) && $page->save()) {
            
            $data = Yii::$app->request->post('PresentationPage');
            if (isset($data['finish'])) {
                return $this->redirect(['finish-update', 'id' => $id]);
            }
            if ($page->number < $page->presentation->getPagesCount()) {
                return $this->redirect(['update-page', 'id' => $id, 'number' => $number + 1]);
            }
            return $this->redirect(['new-page', 'id' => $id]);
        }
        
        return $this->render('updatePage', [
            'page' => $page,
        ]);
    }

    /**
     * Deletes an existing Presentation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing PresentationPage model.
     * @param integer $id
     * @param integer $number
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeletePage($id, $number)
    {
        $page = PresentationPage::findPage($id, $number);
        
        $page->delete();
        
        return $this->redirect(['update-page', 'id' => $id, 'number' => $number - 1]);
    }

    /**
     * Displays a single Presentation model.
     * @param string $slug
     * @return mixed
     */
    /*public function actionSlug($slug)
    {
        // TODO: move to frontend
        $model = Presentation::find()->where(['public_url' => $slug])->one();
        if (!is_null($model)) {
            return $this->render('view', [
                'model' => $model,
            ]);
        }
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }*/

    /**
     * Finds the Presentation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Presentation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Presentation::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
