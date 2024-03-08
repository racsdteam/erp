<?php

namespace frontend\modules\hr\controllers;

use Yii;
use frontend\modules\hr\models\PcTarget;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * LPcTargetController implements the CRUD actions for PcTarget model.
 */
class PcTargetController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
                'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                 
                   [
        'actions' => ['index'],
        'allow' => true,
        'matchCallback' => function ($rule, $action) {
            return \Yii::$app->user->identity->isAdmin();
        },
    ],
                ],
                 ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all PcTarget models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => PcTarget::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
        public function actionGetTarget($id)
    {
        $dataProvider = PcTarget::find()->where(["pa_id"=>$id])->all();
        

        return $this->renderAjax('pc_targets', [
            'dataProvider' => $dataProvider,'id' => $id
        ]);
    }
    /**
     * Displays a single PcTarget model.
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
     * Creates a new PcTarget model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id,$position_level)
    {
        $model = new PcTarget();

          if(Yii::$app->request->post()) {
                    
            $model->attributes=$_POST['PcTarget'];
            $model->pa_id= (int) $id;
             $model->kpi_weight= (float) $_POST['PcTarget']['kpi_weight'];
            $model->save();
            return $this->redirect(['performance-contract/view', 'id' =>$id]);
        }

        return $this->renderAjax('create', [
            'model' => $model,"position_level" =>$position_level
        ]);
    }

    /**
     * Updates an existing PcTarget model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PcTarget model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model= $this->findModel($id);
        $this->findModel($id)->delete();

       return $this->redirect(['performance-contract/view', 'id' =>$model->pa_id]);
    }

    /**
     * Finds the PcTarget model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PcTarget the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PcTarget::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
