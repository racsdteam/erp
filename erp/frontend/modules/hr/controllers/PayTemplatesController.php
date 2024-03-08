<?php

namespace frontend\modules\hr\controllers;

use Yii;
use frontend\modules\hr\models\PayTemplates;
use frontend\modules\hr\models\PayTemplateItems;
use frontend\modules\hr\models\PayTemplatesSearch;
use frontend\modules\hr\models\PayStructureDeductions;
use frontend\modules\hr\models\PayItems;
use frontend\modules\hr\models\EmpPayExclusions;
use common\models\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PayTemplatesController implements the CRUD actions for PayTemplates model.
 */
class PayTemplatesController extends Controller
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
     * Lists all PayTemplates models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PayTemplatesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionTest(){
        $v='0.075';
        var_dump(floatVal($v));
    }

    /**
     * Displays a single PayTemplates model.
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

    public function actionSelection()
    {
         $model = new PayTemplates();
        return $this->render('_form-select', [
            'model' => $model,
        ]);
    }
    
     public function actionSort($id){
      $model = $this->findModel($id);
       
        if (Yii::$app->request->post()) {
           $id_ary = explode(",",$_POST["row_order"]);
           $sequence=1;
	
	for($i=0;$i<count($id_ary);$i++) {
   
       $item=PayTemplateItems::findOne($id_ary[$i]);
        
        if($item!=null){
           
            $item->display_order= $sequence;
            if(!$flag=$item->save(false)){
              $errorMsg=Html::errorSummary($model); 
              Yii::$app->session->setFlash('error',$errorMsg);
              break;
              
            }
        }else{
            $flag=false;
            $errorMsg="Line Item with Id ".$id_ary[$i]." not found"; 
            Yii::$app->session->setFlash('error',$errorMsg); 
            break;
        }
	    $sequence++; 
	}
       
      if($flag){
          $succesMsg="Pay Structure Items Order Changed !" ;
          Yii::$app->session->setFlash('success',$succesMsg);   
      }     
    
      return $this->redirect(['view','id'=>$model->id]);
        }
      
      return $this->render('_sort',['model'=>$model]);   
        
    }
    
    public function actionPayExclude(){
        
        if(Yii::$app->request->isAjax){
            $post=file_get_contents('php://input');
            $data=json_decode($post,true);
            $res=[];
            if(!empty($data)){
                
             $res=$this->excludePay($data);
                
            }else{
                
              $res['status']=0;
              $res['data']['error']="No item payment information found !";  
            }
            
             return json_encode($res);   
        }
        
    }

    private function excludePay($data){
               $res=[];
               $model =EmpPayExclusions::find()->where(['pay_id'=>$data['pay_id'],'tmpl'=>$data['tmpl'],'tmpl_line'=>$data['tmpl_line']])->one();
              if($model==null){
                $model=new EmpPayExclusions();
                $model->pay_id=$data['pay_id'];
                $model->tmpl=$data['tmpl'];
                $model->tmpl_line=$data['tmpl_line'];
            }
            
             $model->active=$data['state'] ? 0 : 1;
             $model->user=Yii::$app->user->identity->user_id;
             $msg=$model->active ? 'Item has been excluded from employee pay' : ' Item has been included in employee pay ';
               if($model->save()){
                
                $res['status']=1;
                $res['data']['msg']=$msg;
             }else{
                 $res['status']=0;
                 $res['data']['error']=Html::errorSummary($model); ;
              }
              
              return $res;
    }

    /**
     * Creates a new PayTemplates model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PayTemplates();
        $modelsItem = [new PayTemplateItems];
        $modelSettings = new \yii\base\DynamicModel([
        'copy', 'copyTemplate'
    ]);
    
    $modelSettings
     ->addRule('copyTemplate', 'required',['when' => function ($model) {
        return $model->copy == '1';
    }, 'whenClient' =>'isCopyOptionChecked'])   
    ->addRule(['copy'],'boolean')
    ->addRule(['copyTemplate'],'integer');
        
        
        if (Yii::$app->request->post()) {
          
      
          
              if(isset($_POST['PayTemplates'])){
                
                  $model->attributes=$_POST['PayTemplates'];
                   $modelSettings->attributes=$_POST['DynamicModel'];
                  $modelsItem= Model::createMultiple(PayTemplateItems::classname());
                        Model::loadMultiple($modelsItem , Yii::$app->request->post()); 
                        
                 $renderForm=function()use($model,$modelsItem){
                     return $this->renderAjax('_form', [
            'model' => $model,
            'modelsItem' => (empty($modelsItem)) ? [new PayTemplateItems] :  $modelsItem ,
            
        ]); 
                      };
                  
                  
                              $transaction = \Yii::$app->db4->beginTransaction();
                try {
                    
                        
                  if($model->save()){
                      
                  
                  if($modelSettings->copy && !empty($modelSettings->copyTemplate)) {
              
             $tmpl=PayTemplates::findOne($modelSettings->copyTemplate);
             $model->setPayItems($tmpl->lineItems);
             
              $transaction->commit();
                     $successMsg="Pay Template Created !"; 
                     Yii::$app->session->setFlash('success',$successMsg);   
                    return $this->redirect(['index']);  
               
          }    
                      
                         if(!empty($modelsItem)){
                         foreach ($modelsItem as $lineItem) {
                          
                            
                            $lineItem->tmpl=$model->id;
                            
                           
                           
                             
                            if (! ($flag =$lineItem->save())) {
                                 $model->addErrors($lineItem->getErrors());
                                $transaction->rollBack();
                                break;
                            }
                          
                           
                          
                        }
                             
                         }
                       
                      if($model->hasErrors()) {
                          
                         $errorMsg=Html::errorSummary($model);  
                         Yii::$app->session->setFlash('error',$errorMsg);
                         return $renderForm(); 
                          
                      }   
                           
                      
                    $transaction->commit();
                     $successMsg="Pay Template Created !"; 
                     Yii::$app->session->setFlash('success',$successMsg);   
                    return $this->redirect(['index']);   
                    
                  }else{
                    $errorMsg=Html::errorSummary($model); 
                    Yii::$app->session->setFlash('error',$errorMsg); 
                    return $renderForm(); 
                      
                    }
                } 
                   catch (Exception $e) {
                    $transaction->rollBack();
                } 
                 
                    
              }
              
        
               
              
        }

        if(Yii::$app->request->isAjax){
             return $this->renderAjax('_form', [
            'model' => $model,
            'modelsItem' => (empty($modelsItem)) ? [new PayTemplateItems] :  $modelsItem ,'modelSettings'=>$modelSettings
            
        ]);
            
        }
        return $this->render('_form', [
            'model' => $model,
           'modelsItem' => (empty($modelsItem)) ? [new PayTemplateItems] :  $modelsItem ,'modelSettings'=>$modelSettings
           
        ]);
    }
  
  public function actionCopyList(){
    
    $models = PayTemplates::find()
				->where(['active'=>1])
				->orderBy('id DESC')
				->all();
				
		if (!empty($models)) {
			foreach($models as $tmpl) {
				echo "<option value='".$tmpl->id."'>".$tmpl->name."</option>";
			}
		} else {
			echo "<option>-</option>";
		}  
}  
    public function actionTestQuery(){
        
        // $modelsItem = PayTemplateItems::find()->structure(1)->all();
        /* foreach( $modelsItem  as $it){
             
             var_dump($item->item.':'.$it->item_categ);
         }*/
         
         $baseList =PayItems::find()->alias('tbl_items')->select('tbl_items.id,tbl_items.edCode,tbl_items.edDesc,cat.code as category')
                             ->innerJoin('pay_item_categories as cat', 'cat.id = tbl_items.edCategory')
                             ->asArray()->all();
    $earningsType=ArrayHelper::map(array_filter($baseList, function ($var) {
           return ($var['category'] == 'BASIC' || $var['category'] == 'ALW');
           
           
}), 'id', 'edDesc');              
             
             var_dump($earningsType);
             
    }

    /**
     * Updates an existing PayTemplates model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelsItem = $model->lineItems;
        $modelSettings = new \yii\base\DynamicModel([
        'copy', 'copyTemplate'
    ]);
    
    $modelSettings
     ->addRule('copyTemplate', 'required',['when' => function ($model) {
        return $model->copy == '1';
    }, 'whenClient' =>'isCopyOptionChecked'])   
    ->addRule(['copy'],'boolean')
    ->addRule(['copyTemplate'],'integer');
        
         

       if (Yii::$app->request->post()) {
          
        
          
              if(isset($_POST['PayTemplates'])){
                  
                  $model->attributes=$_POST['PayTemplates'];
                   $modelSettings->attributes=$_POST['DynamicModel'];
                  
                  $oldIDs = ArrayHelper::map($modelsItem, 'id', 'id');
                  $modelsItem = Model::createMultiple(PayTemplateItems::classname(), $modelsItem);
                  Model::loadMultiple($modelsItem, Yii::$app->request->post());
                  $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsItem, 'id', 'id')));
                  $errors=[];
                  $render=function()use($model,$modelsItem){
                   return $this->render('_form', [
            'model' => $model,
            'modelsItem' => (empty($modelsItem)) ? [new PayTemplateItems] :  $modelsItem ,
            
        ]);    
                  };
              
            
                                     $transaction = \Yii::$app->db4->beginTransaction();
                try {
                    
                     if (!empty($deletedIDs)) {
                       
                       
                       $model->removeItems($deletedIDs);
                                }
                            
                    
                       if($model->save(false)){
                           
                           
                               if($modelSettings->copy && !empty($modelSettings->copyTemplate)) {
              
             $tmpl=PayTemplates::findOne($modelSettings->copyTemplate);
             $model->setPayItems($tmpl->lineItems);
             
              $transaction->commit();
                     $successMsg="Pay Template Updated !"; 
                     Yii::$app->session->setFlash('success',$successMsg);   
                    return $this->redirect(['index']);  
               
          }    
             
                           
                             foreach ($modelsItem as $lineItem) {
                            
                            
                            $lineItem->tmpl=$model->id;
                          if (!$lineItem->save()) {
                                $errors[]=Html::errorSummary($lineItem);
                                $transaction->rollBack();
                                break;
                            }
                          
                           
                          
                        }
                       }else{
                      
                      $errors[]=Html::errorSummary($model);
                  }
                       
                     
                        if (!empty($errors)) {
                            
                $success=false;
              
               foreach ($errors as $err) {
                 
                 $errorText .= $err;  
                   
                }
            
                 
                
            }
            else{
                $success=true;
               }
                      if(!$success) {
                          
                         
                         Yii::$app->session->setFlash('error',$errorText);
                         return $render(); 
                       
                      }   
                           
                      
                     $transaction->commit();
                     $successMsg="Pay Template Updated !"; 
                     Yii::$app->session->setFlash('success',$successMsg);   
                     return $this->redirect(['index']);   
                        
                    
                } catch (Exception $e) {
                    $transaction->rollBack();
                } 
                
                      
                          
                      
                  
                     
                  
              }
         
           
         
         
        }

       if(Yii::$app->request->isAjax){
             return $this->renderAjax('_form', [
            'model' => $model,
            'modelsItem' => (empty($modelsItem)) ? [new PayTemplateItems] :  $modelsItem , $modelsItem ,'modelSettings'=>$modelSettings
            
        ]);
            
        }
        return $this->render('_form', [
            'model' => $model,
           'modelsItem' => (empty($modelsItem)) ? [new PayTemplateItems] :  $modelsItem , $modelsItem ,'modelSettings'=>$modelSettings
           
        ]);
    }

    /**
     * Deletes an existing PayTemplates model.
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
     * Finds the PayTemplates model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PayTemplates the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PayTemplates::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
