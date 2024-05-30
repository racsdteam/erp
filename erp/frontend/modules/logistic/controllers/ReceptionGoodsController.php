<?php

namespace frontend\modules\logistic\controllers;

use Yii;
use common\models\ReceptionGoods;
use common\models\ItemsReception;
use common\models\ItemsReceptionSupporting;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use common\models\Model;
use common\models\UserHelper;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
/**
 * ReceptionGoodsController implements the CRUD actions for ReceptionGoods model.
 */
class ReceptionGoodsController extends Controller
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
     * Lists all ReceptionGoods models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ReceptionGoods::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ReceptionGoods model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('viewer', [
            'model' => $this->findModel($id),
        ]);
    }
      public function actionView2($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    public function actionDraft()
    {
        return $this->render('draft');
    }
    public function actionPending()
    {
        return $this->render('pending');
    }
    public function actionApproved()
    {
        return $this->render('approved');
    }
    /**
     * Creates a new ReceptionGoods model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
     
      public function actionPdfData($id)
    {
   $model= $this->findModel($id);

       \yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
 
  
          $url = "css/kv-mpdf-bootstrap.min.css";
          $stylesheet = file_get_contents($url);
          
          $url1 = "css/mpdf.css";
          $stylesheet1 = file_get_contents($url1);
       
        $mpdf = new \Mpdf\Mpdf(['format' =>'A4','mode'=>'c']);
        //----------------------------add bootsrap classes---------------------------
       $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
       //------------------------bootsr grid system---------------------------------
        $mpdf->WriteHTML($stylesheet1, \Mpdf\HTMLParserMode::HEADER_CSS);
     //-----------------prevent body overlapping footer-----------------------------------------     
         
         $mpdf->setAutoBottomMargin = 'stretch';
        //--------------------------setting footer-------------------------------------
        $mpdf->SetHTMLFooter('<img src="img/footer.png"/>');
       
        
         
         $mpdf->WriteHTML($this->renderPartial('view', [
            'model' => $model,]));
       $content= $mpdf->Output();
       return $content;
        exit;
    }
    
    
    
        //------------------------------------------fetch tab-----------------------------------------------------------------
     public function actionFetchTab()
    {
    $step_number = $_REQUEST["step_number"];
    
  
    if(isset($_GET['id'])){
        
        $model =ReceptionGoods::find()->where(['id' =>$_GET['id']])->one();
     
        if($model!=null){
            
          return $this->renderAjax('page-viewer1', [
         'model' => $model,
         
    ]);
        
         
        }else{
            
            
             return   ' <div class="error-page">
        <h2 class="headline text-yellow"> 404</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-yellow"></i> Oops! Memo not found.</h3>

          <p>
            We could not find Memo .
            
          </p>

        </div>
     
      </div>';
        }
           }
    
    }
    
    public function actionGetSupportDocs($id){
        
        
    $query = ItemsReceptionSupporting::find()->where(['reception' =>$id]);
    $countQuery = clone $query;
    $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>1]);
    $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all(); 
        
          if(!empty($models)){
              
             if (Yii::$app->request->isAjax) {
            
          return $this->renderAjax('page-viewer3', [
         'models' => $models,
         'pages' => $pages,
         'stepcontent'=>$_GET['stepcontent']
    ]);
    
          }else{
        return $this->render('page-viewer3', [
         'models' => $models,
         'pages' => $pages,
         'stepcontent'=>$_GET['stepcontent']
    ]); 
              
          }
        
         
        }else{
            
         return   ' <div class="error-page">
        <h2 class="headline text-yellow"> 404</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-yellow"></i> Oops! Supporting Doc(s) not found.</h3>

          <p>
            We could not find Memo Supporting Docs.
            
          </p>

        </div>
     
      </div>';
            
            
            
            
            
           
        }     
        
    }
    
    
      public function actionGetLop($id){
        
        
    $model = ReceptionGoods::find()->where(['id' =>$id])->one();
    
          if(!empty($model)){
              
             if (Yii::$app->request->isAjax) {
            
          return $this->renderAjax('page-viewer4', [
         'model' => $model,
    ]);
    
          }else{
        return $this->render('page-viewer4', [
         'model' => $model,
         
    ]); 
              
          }
        
         
        }else{
            
         return   ' <div class="error-page">
        <h2 class="headline text-yellow"> 404</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-yellow"></i> Oops! Supporting Doc(s) not found.</h3>

          <p>
            We could not find Memo Supporting Docs.
            
          </p>

        </div>
     
      </div>';
            
            
            
            
            
           
        }     
        
    }
    
    public function actionCreate()
    {
        $model = new ReceptionGoods();
        $modelsItem = [new ItemsReception];
         $ItemsReceptionSupporting = new ItemsReceptionSupporting();
          
          
            if(Yii::$app->request->post()){
           //var_dump(Yii::$app->request->post());die();
           
           
           $model->attributes=$_POST['ReceptionGoods'];
           $exponent =2; // Amount of digits
            $min = pow(10,$exponent);
            $max = pow(10,$exponent+1)-1;
            //1
            $value = rand($min, $max);
            $unification= "G_R"."-".date("Ymdhms")."-".$value;
            
            $model->number= $unification;
            $model->user=Yii::$app->user->identity->user_id;
             $model->uploaded_file2 = UploadedFile::getInstance($model, 'uploaded_file2');
                   
                    if($model->uploaded_file2!=null){
                 
                       $file2=$model->uploaded_file2;
                 
                 $exponent = 3; // Amount of digits
 $min = pow(10,$exponent);
 $max = pow(10,$exponent+1)-1;
 $value = rand($min, $max);
 $unification= date("Ymdhms")."".$value;
  
   $temp= explode(".",   $file2->name);
   $ext = end($temp);
   $path_to_doc2='uploads/logistic/delivery_notes/'. $unification.".{$ext}";
   $model->delivery_notes=$path_to_doc2;
   
                 }

if($flag=$model->save(false)){
              
        $file2->saveAs( $path_to_doc2);    
              

                 $modelsItem= Model::createMultiple(ItemsReception::classname());
                 Model::loadMultiple($modelsItem , Yii::$app->request->post()); 
  
  //---------------------------------check items------------------------------------------------------               
                 if(!empty($modelsItem)){
                     
                     
                 
                    $transaction = \Yii::$app->db->beginTransaction();
                try {
                    
                     
                        foreach ($modelsItem as $modelItem) {
                           
                               
                                 if($modelItem !=new ItemsReception()){
                                
                                $modelItem->reception_good =$model->id ;
                                $modelItem->total_price =$modelItem->item_qty* $modelItem->item_unit_price;
                                $modelItem->staff_id=Yii::$app->user->identity->user_id;
                            
                            if (! ($flag = $modelItem->save(false))) {
                                $transaction->rollBack();
                               
                                Yii::$app->session->setFlash('failure',Html::errorSummary($modelItem));  
                                  
                            }
                        }
                    
                }
                  
                   
                    if ($flag) {
                        $transaction->commit();
                      
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
                  } 
               
             if(isset($_POST['ItemsReceptionSupporting'])){
             
             $ItemsReceptionSupporting->attach_files = UploadedFile::getInstances($ItemsReceptionSupporting, 'attach_files');
                   
                    if(!empty( $ItemsReceptionSupporting->attach_files)){
                 
                       $files=$ItemsReceptionSupporting->attach_files;

                 foreach($files as $key => $file){
                 
                    
                
                 $exponent = 3; // Amount of digits
 $min = pow(10,$exponent);
 $max = pow(10,$exponent+1)-1;
 //1
 $value = rand($min, $max);
 $unification= date("Ymdhms")."".$value;
  
   $temp= explode(".",   $file->name);
   $ext = end($temp);
   $path_to_doc='uploads/logistic/reception_supporting_doc/'. $unification.".{$ext}";
   
   $ItemsReceptionSupporting=new ItemsReceptionSupporting(); 
   $ItemsReceptionSupporting->doc=$path_to_doc;
   $ItemsReceptionSupporting->reception=$model->id;
   $ItemsReceptionSupporting->uploaded_by=Yii::$app->user->identity->user_id;
                  
                  if(! $flag=$ItemsReceptionSupporting->save(false)){
                     
            Yii::$app->session->setFlash('failure',Html::errorSummary($ItemsReceptionSupporting));  

                  }  
                 
               $file->saveAs( $path_to_doc);  
                     
                 }
                 
              
                 
             }
            
               
        
             
            }   
            
       return $this->redirect(['approved']);
      
       }
       else{
           
          Yii::$app->session->setFlash('failure',"GRN could not be saved  !"); 
           
           
         }
       
           
           
           
       }
        return $this->render('create', [
            'model' => $model,'modelsItem'=>$modelsItem,'ItemsReceptionSupporting'=>$ItemsReceptionSupporting,
        ]);
    }

    /**
     * Updates an existing ReceptionGoods model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        $position1info=UserHelper::getPositionInfo($model->end_user_officer);
        $model->position1=$position1info['id'];
        
        $position2info=UserHelper::getPositionInfo($model->store_keeper);
        $model->position2=$position2info['id'];
        
        
        $modelsItem = ItemsReception::find()->where(['reception_good'=>$model->id])->all();
        if(empty($modelsItem))
        {
          $modelsItem = [new ItemsReception];
        }
         $ItemsReceptionSupporting = new ItemsReceptionSupporting();
        
        if(Yii::$app->request->post())
        {

           $model->attributes=$_POST['ReceptionGoods'];
           $exponent =2; // Amount of digits
            $min = pow(10,$exponent);
            $max = pow(10,$exponent+1)-1;
    
            $value = rand($min, $max);
            $unification= "G_R"."-".date("Ymdhms")."-".$value;
            
            $model->number= $unification;
            $model->user=Yii::$app->user->identity->user_id;

             $model->uploaded_file = UploadedFile::getInstance($model, 'uploaded_file');
             
             
             
            
                   
                    if($model->uploaded_file!=null){
                 
                  if (file_exists( $model->reception_upload)) {
            unlink( $model->reception_upload);
        }
          
                 
                       $file=$model->uploaded_file;
                 
                 $exponent = 3; // Amount of digits
 $min = pow(10,$exponent);
 $max = pow(10,$exponent+1)-1;
 //1
 $value = rand($min, $max);
 $unification= date("Ymdhms")."".$value;
  
   $temp= explode(".",   $file->name);
   $ext = end($temp);
   $path_to_doc='uploads/logistic/good_received/'. $unification.".{$ext}";
   $model->reception_upload=$path_to_doc;
   
                 }
                 
             $model->uploaded_file2 = UploadedFile::getInstance($model, 'uploaded_file2');
                   
                    if($model->uploaded_file2!=null){
                 
                              if (file_exists( $model->delivery_notes)) {
            unlink( $model->delivery_notes);
        }
          
                       $file2=$model->uploaded_file2;
                 
                 $exponent = 3; // Amount of digits
 $min = pow(10,$exponent);
 $max = pow(10,$exponent+1)-1;
 $value = rand($min, $max);
 $unification= date("Ymdhms")."".$value;
  
   $temp= explode(".",   $file2->name);
   $ext = end($temp);
   $path_to_doc2='uploads/logistic/delivery_notes/'. $unification.".{$ext}";
   $model->delivery_notes=$path_to_doc2;
   
                 }
//var_dump($model->procument_officer);die();
if($flag=$model->save(false)){
             if($model->uploaded_file!=null){ 
        $file->saveAs( $path_to_doc);      
             }
             if($model->uploaded_file2!=null){
        $file2->saveAs( $path_to_doc2);    
             }
                 $oldIDs = ArrayHelper::map($modelsItem, 'id', 'id');
                 
                 $modelsItem= Model::createMultiple(ItemsReception::classname());
                 Model::loadMultiple($modelsItem , Yii::$app->request->post()); 
   $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsItem, 'id', 'id')));
   
  //---------------------------------check items------------------------------------------------------               
                 if(!empty($modelsItem)){
                     
                      if (!empty($deletedIDs)) {
                        ItemsReception::deleteAll(['id' => $deletedIDs]);
                    }
                 
                    $transaction = \Yii::$app->db->beginTransaction();
                try {
                    
                     
                        foreach ($modelsItem as $modelItem) {
                           
                               
                                 if($modelItem !=new ItemsReception()){
                                
                                $modelItem->reception_good =$model->id ;
                                $modelItem->total_price =$modelItem->item_qty* $modelItem->item_unit_price;
                                $modelItem->staff_id=Yii::$app->user->identity->user_id;
                            
                            if (! ($flag = $modelItem->save(false))) {
                                $transaction->rollBack();
                               
                                Yii::$app->session->setFlash('failure',Html::errorSummary($modelItem));  
                                  
                            }
                        }
                    
                }
                  
                   
                    if ($flag) {
                        $transaction->commit();
                      
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
                  } 
               
             if(isset($_POST['ItemsReceptionSupporting'])){
             
             $ItemsReceptionSupporting->attach_files = UploadedFile::getInstances($ItemsReceptionSupporting, 'attach_files');
                   
                    if(!empty( $ItemsReceptionSupporting->attach_files)){
                 
                       $files=$ItemsReceptionSupporting->attach_files;

                 foreach($files as $key => $file){
                 
                    
                
                 $exponent = 3; // Amount of digits
 $min = pow(10,$exponent);
 $max = pow(10,$exponent+1)-1;
 //1
 $value = rand($min, $max);
 $unification= date("Ymdhms")."".$value;
  
   $temp= explode(".",   $file->name);
   $ext = end($temp);
   $path_to_doc='uploads/logistic/reception_supporting_doc/'. $unification.".{$ext}";
   
   $ItemsReceptionSupporting=new ItemsReceptionSupporting(); 
   $ItemsReceptionSupporting->doc=$path_to_doc;
   $ItemsReceptionSupporting->reception=$model->id;
   $ItemsReceptionSupporting->uploaded_by=Yii::$app->user->identity->user_id;
                  
                  if(! $flag=$ItemsReceptionSupporting->save(false)){
                     
            Yii::$app->session->setFlash('failure',Html::errorSummary($ItemsReceptionSupporting));  

                  }  
                 
               $file->saveAs( $path_to_doc);  
                     
                 }
                 
              
                 
             }
            
               
        
             
            }   
            
       return $this->redirect(['approved']);
      
       }
       else{
           
          Yii::$app->session->setFlash('failure',"GRN could not be saved  !"); 
           
           
         }
       
           
           
           
       }
       
       
        return $this->render('update', [
            'model' => $model,'modelsItem'=>$modelsItem,'ItemsReceptionSupporting'=>$ItemsReceptionSupporting,
        ]);
    }

    /**
     * Deletes an existing ReceptionGoods model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['approved']);
    }

    /**
     * Finds the ReceptionGoods model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ReceptionGoods the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ReceptionGoods::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
