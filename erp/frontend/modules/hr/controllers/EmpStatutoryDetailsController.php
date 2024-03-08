<?php

namespace frontend\modules\hr\controllers;

use Yii;
use frontend\modules\hr\models\EmpStatutoryDetails;
use frontend\modules\hr\models\EmpStatutoryDetailsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * EmpStatutoryDetailsController implements the CRUD actions for EmpStatutoryDetails model.
 */
class EmpStatutoryDetailsController extends Controller
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
     * Lists all EmpStatutoryDetails models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmpStatutoryDetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EmpStatutoryDetails model.
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
     * Creates a new EmpStatutoryDetails model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EmpStatutoryDetails();

        if ($model->load(Yii::$app->request->post())) {
           
           var_dump($_POST);die();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    
    public function actionBulkImport(){
               
               $temp_file='templates/rssb_numbers.xlsx';
               $spreadsheet = IOFactory::load($temp_file);
               $worksheet=$spreadsheet->getSheet(1);
               $highestRow= $worksheet ->getHighestRow();
               $highestColumn=$worksheet->getHighestColumn();
               
               $sheetData =$worksheet->toArray(null, true, true, true);
               $baseRow=2;
             
              
               $transaction = \Yii::$app->db->beginTransaction();
                 
              try{
                  
                  
               while(!empty($sheetData[$baseRow]['A'])){
                   
                   
                 $e=\frontend\modules\hr\models\Employees::findByEmpNo($sheetData[$baseRow]['A']) ;
                
                 if(!empty($e)){
                    
                     if(empty(($model=$e->statutoryDetails)))
                         $model = new EmpStatutoryDetails();
                         
                         $model->employee=$e->id;
                         $model->emp_pension_no=$sheetData[$baseRow]['B'];
                         $model->scenario='update';
                         
                         if($model->validate()){
         if($model->validate())
                       if(!$model->save()){
                    throw new UserException(Html::errorSummary($model));     
                        
                    } 
          
      }
                     
                     
                 }
             
             $baseRow++;  
                   
               }//end while
               
               
                $transaction->commit();
                var_dump("Done");
    }//-----------------------end try block--------
            
             catch(UserException $e){
                $transaction->rollback(); 
                die($e->getMessage());
               
            }
            catch(Exception $e){
                 $transaction->rollback();
                 die($e->getMessage());
            }
    }

    /**
     * Updates an existing EmpStatutoryDetails model.
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
     * Deletes an existing EmpStatutoryDetails model.
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
     * Finds the EmpStatutoryDetails model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EmpStatutoryDetails the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EmpStatutoryDetails::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
