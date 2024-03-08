<?php

namespace frontend\controllers;

use Yii;
use common\models\ErpPersonsInPosition;
use common\models\ErpPersonsInPositionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;

/**
 * ErpPersonsInPositionController implements the CRUD actions for ErpPersonsInPosition model.
 */
class ErpPersonsInPositionController extends Controller
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
     * Lists all ErpPersonsInPosition models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ErpPersonsInPositionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ErpPersonsInPosition model.
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

    public function actionPopulateNames()
    {
        $ids=$_GET['ids'];
        
        
        
        $data=array();
        $i=0;
        foreach($ids as $id){
           
            $query = new Query;
            $query	->select([
                'u.*',
                
            ])->from('user as u ')->join('INNER JOIN', 'erp_persons_in_position as pp',
                'u.user_id=pp.person_id')->where(['position_id'=>$id,'pp.status'=>1]);
    
            $command = $query->createCommand();
            $rows= $command->queryAll();
            foreach ($rows as $row) {
                $i++;
               $data[]=$row['user_id'];
               
               //----------------------find out if someone is in interim for him------------------
               $q7=" SELECT inter.*  FROM  erp_person_interim  as inter 
                                           where inter.person_interim_for='".$row['user_id']."' and status='active' ";
                                            $command7= Yii::$app->db->createCommand($q7);
                                           $row7 = $command7->queryOne();
                                           
                                           if(!empty($q7)){
                                     $data[]=$row7['person_in_interim'];           
                                               
                                           }
            }
            
        }
       return json_encode($data);
        

      /*if (count($rows) > 0) {
        echo "'<option></option>'";
       
        foreach ($rows as $row) {
            echo "<option value='" . $row['user_id'] . "'>" . $row['first_name']." ".$row['last_name'] . "</option>";
        }
    } else {
        echo "'<option></option>'";
    }*/

    
//echo $data;
   
    }

    /**
     * Creates a new ErpPersonsInPosition model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ErpPersonsInPosition();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ErpPersonsInPosition model.
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
     * Deletes an existing ErpPersonsInPosition model.
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
     * Finds the ErpPersonsInPosition model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ErpPersonsInPosition the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ErpPersonsInPosition::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
