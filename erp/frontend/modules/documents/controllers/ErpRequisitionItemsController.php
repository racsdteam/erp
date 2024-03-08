<?php

namespace frontend\modules\documents\controllers;
use Yii;
use common\models\ErpRequisitionItems;
use common\models\ErpRequisitionItemsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\db\Query;
use yii\web\UploadedFile;

/**
 * ErpRequisitionItemsController implements the CRUD actions for ErpRequisitionItems model.
 */
class ErpRequisitionItemsController extends Controller
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
     * Lists all ErpRequisitionItems models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ErpRequisitionItemsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ErpRequisitionItems model.
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
     * Creates a new ErpRequisitionItems model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($form)
    {
        
        $modelsRequisitionItems = [new ErpRequisitionItems];

        return $this->renderAjax('_form', ['form'=>$form,
          'modelsRequisitionItems' => (empty($modelsRequisitionItems)) ? [new ErpRequisitionItems] : $modelsRequisitionItems
        ]);
    }
    
    public function actionExcelUpload(){
         $model = new ErpRequisitionItems();
         if (Yii::$app->request->post()) {
           
           $data=Yii::$app->request->post();
           $model->excel_file= UploadedFile::getInstance($model, 'excel_file');
          
        if ($model->excel_file==null) {
          return json_encode(['error'=>'No files found for upload.']); 
    
        }        $file=$model->excel_file;
       
        $filename= $file->name;
         
         return json_encode(['file'=>$filename]); 
      
        if(file_exists('uploads/temp/items.xlsx')){
    unlink('uploads/temp/items.xlsx');
}
       
        $file->saveAs( "uploads/temp/items.xlsx");
        
         }
        
    }
    
     public function actionExcelImport()
    {
        $model = new ErpRequisitionItems();
        $models=[new ErpRequisitionItems];

           
            
            
               
              $inputfile=  "uploads/temp/items.xlsx";
        
        try{
                
                $inputfiletype= \PHPExcel_IOFactory::identify($inputfile);
                $objreader= \PHPExcel_IOFactory::createReader($inputfiletype);
               $objPHPExcel= $objreader -> load($inputfile);
                
            }
            
            
            catch(Exception $e){
                die("Error!!!");
            }
            $sheet=$objPHPExcel->getSheet(0);
             $highestRow=$sheet->getHighestRow();
              $highestColumn=$sheet->getHighestColumn();
              
             /*for( $row=1 ; $row <= $highestRow ; $row ++){
                $rowdata[$row]= $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row,Null,True,False);
             }*/
             $sheetData = $sheet->toArray(null, true, true, true);
             //var_dump(  $highestRow);
            // var_dump( $highestColumn);die();
            for($i=2;$i<=$highestRow;$i++){

             $data['no']=$sheet->getCell('A'.$i)->getValue();
             $data['name']=$sheet->getCell('B'.$i)->getValue();
             $data['spec']=$sheet->getCell('C'.$i)->getValue();
             $data['uom']=$sheet->getCell('D'.$i)->getValue();
             $data['qty']=$sheet->getCell('E'.$i)->getValue();
            // $data[5]=$sheet->getCell('F'.$i)->getValue();
             //$data[6]=$sheet->getCell('H'.$i)->getValue();
             $rowsdata[]=$data;
            }

       /* $data['no']=$sheet->getCell('A132')->getValue();
        $data['name']=$sheet->getCell('B132')->getValue();
        $data['spec']=$sheet->getCell('C132')->getValue();
        $data['uom']=$sheet->getCell('D132')->getValue();
        $data['qty']=$sheet->getCell('E132')->getValue();
        $rowsdata[]=$data;*/
           
            return json_encode($rowsdata);
        
        
       
        
         
          
        
        
      
    }
    

    /**
     * Updates an existing ErpRequisitionItems model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            Yii::$app->session->setFlash('success',"Item Updated !");
           return  $this->redirect(Url::to(['erp-requisition/view', 'id' =>$_GET['req-id']]));
            //return true;
        }
        
        if(Yii::$app->request->isAjax){
            
            return $this->renderAjax('update', [
            'model' => $model,
        ]); 
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ErpRequisitionItems model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
       $flag= $this->findModel($id)->delete();
        
        return $flag;

       
    }

    /**
     * Finds the ErpRequisitionItems model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ErpRequisitionItems the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ErpRequisitionItems::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
