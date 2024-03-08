<?php

namespace frontend\modules\hr\controllers;

use Yii;
use common\models\District;
use common\models\DistrictSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
/**
 * DistrictController implements the CRUD actions for District model.
 */
class DistrictController extends Controller
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
     * Lists all District models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DistrictSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single District model.
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
   public function actionSectors() {
    
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $out = [];
    if (isset($_POST['depdrop_parents'])) {
        $parents = $_POST['depdrop_parents'];
        if ($parents != null) {
            
            $district_id = $parents[0];
          
             $district=District::find()->where(['idDistrict'=>$district_id])->one();
             
             $sectors= $district->sectors;
              
              if(!empty( $sectors)){
                 
                 foreach ($sectors as $s) {
                    
                $out[]=['id'=>$s->idSector,'name'=>$s->sector];
        } 
                }
             
            
           
            return ['output'=>$out, 'selected'=>''];
        }
    }
    return ['output'=>'', 'selected'=>''];
}



    public function actionPopulateDistrict($id)
    {
        //Yii::$app->response->format = Response::FORMAT_JSON;
       
        $districts = District::find()->andWhere(['province_id' =>$id])->all();
      /*  $data = [['id' => '', 'name' => '']];
        foreach ($provinces as $province) {
         $data[] = ['id' => $province->idProvince, 'name' => $province->province];

           
        }
    return ['data' => $data];*/

      if (count($districts) > 0) {
        echo "'<option></option>'";
       
        foreach ($districts as $district) {
            echo "<option value='" . $district->idDistrict . "'>" . $district->district . "</option>";
        }
    } else {
        echo "'<option></option>'";
    }
    }
    /**
     * Creates a new District model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new District();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idDistrict]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing District model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idDistrict]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing District model.
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
     * Finds the District model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return District the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = District::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
