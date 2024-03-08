<?php

namespace frontend\modules\hr\controllers;

use Yii;
use common\models\Province;
use common\models\ProvinceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Countries;

/**
 * ProvinceController implements the CRUD actions for Province model.
 */
class ProvinceController extends Controller
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
     * Lists all Province models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProvinceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
        public function actionDistricts() {
    
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $out = [];
    if (isset($_POST['depdrop_parents'])) {
        $parents = $_POST['depdrop_parents'];
        if ($parents != null) {
            $prov_id = $parents[0];
          
             $province=Province::find()->where(['idProvince'=>$prov_id])->one();
             $districts=$province->districts;
              if(!empty($districts)){
                 
                 foreach (  $districts as $d) {
                    
                $out[]=['id'=>$d->idDistrict,'name'=>$d->district];
        } 
                }
             
            
           
            return ['output'=>$out, 'selected'=>''];
        }
    }
    return ['output'=>'', 'selected'=>''];
}



    public function actionPopulateProvince($code)
    {
        //Yii::$app->response->format = Response::FORMAT_JSON;
       
        $provinces = Province::find()->andWhere(['country_id' =>$this->findCountryByCode($code)])->all();
      /*  $data = [['id' => '', 'name' => '']];
        foreach ($provinces as $province) {
         $data[] = ['id' => $province->idProvince, 'name' => $province->province];

           
        }
    return ['data' => $data];*/

      if (count($provinces) > 0) {
        echo "'<option></option>'";
       
        foreach ($provinces as $province) {
            echo "<option value='" . $province->idProvince . "'>" . $province->province . "</option>";
        }
    } else {
        echo "'<option></option>'";
    }
    }

    /**
     * Displays a single Province model.
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
     * Creates a new Province model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Province();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idProvince]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Province model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idProvince]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Province model.
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
     * Finds the Province model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Province the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Province::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function findCountryByCode($code)
    {
        $model = Countries::find()
        ->where(['country_code' => $code])
        ->one();

     return $model->id;
    }
}
