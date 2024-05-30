<?php

namespace frontend\modules\procurement\controllers;

use Yii;
use frontend\modules\procurement\models\TenderDocuments;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TenderDocumentsController implements the CRUD actions for TenderDocuments model.
 */
class TenderDocumentsController extends Controller
{
    /**
     * {@inheritdoc}
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
     * Lists all TenderDocuments models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => TenderDocuments::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

   /**
     * Displays a single Tenders model.
     * @param integer $_id
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
     * Creates a new Tenders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($tender_id,$lot_id,$section_code)
    {
        $model = new TenderDocuments();
        if (Yii::$app->request->isPost) {
            $user_id=Yii::$app->user->identity->user_id;
            $post_data=Yii::$app->request->post();
            $model->attributes=array_filter($post_data['TenderDocuments']);
            $model->user_id=$user_id;
            $model->lot_id=$lot_id;
            $model->section_code=$section_code;
            if ($model->save()) {
                // Record saved successfully

                return $this->redirect(['tenders/view','id'=>(string)$tender_id]);
            }
        }

        if (Yii::$app->request->isAjax)
        {  
            return $this->renderAjax('create', [
            'model' => $model,'section_code'=>$section_code
        ]);
    }

        return $this->render('create', [
            'model' => $model,'section_code'=>$section_code
        ]);
    }

    /**
     * Updates an existing Tenders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id,$tender_id,$section_code)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            $user_id=Yii::$app->user->identity->user_id;
            $post_data=Yii::$app->request->post();
            $model->attributes=array_filter($post_data['TenderDocuments']);
            $model->user_id=$user_id;
            $model->section_code=$section_code;
            if ($model->save()) {
                return $this->redirect(['tenders/view','id'=>(string) $tender_id]);
            }
        }
        if (Yii::$app->request->isAjax)
        {  
            return $this->renderAjax('update', [
            'model' => $model,'section_code'=>$section_code
        ]);
    }
        return $this->render('update', [
            'model' => $model,'section_code'=>$section_code
        ]);
    }

    /**
     * Deletes an existing Tenders model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id,$tender_id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['tenders/view','id'=>(string) $tender_id]);
    }

    /**
     * Finds the Tenders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return TenderDocuments the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TenderDocuments::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
