<?php

namespace frontend\modules\documents\controllers;

use Yii;
use common\models\ErpOrganization;
use common\models\ErpOrganizationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\ErpOrganizationAddress;
use common\models\ErpOrganizationContact;
use common\models\Countries;
use common\models\ErpOrgUnits;
use yii\filters\AccessControl;

/**
 * ErpOrganizationController implements the CRUD actions for ErpOrganization model.
 */
class ErpOrganizationController extends Controller
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
     * Lists all ErpOrganization models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ErpOrganizationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ErpOrganization model.
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
    
    public function actionDisplayOrgChart(){

        //$this->layout='login';
        return $this->render('view-org-chart');
    }

    //--------------------------------------------------org----------------------------------------
    public function actionGetJson(){
    
        //root unit

        $root_unit=ErpOrgUnits::find()->where(['parent_unit'=>null])->One();
       

        $json_data=array();
        $id=1;
        $parent=null;
        $baseUrl=Yii::$app->request->baseUrl;
        
        if($root_unit!=null){

             //-----------------------------------get MD office--------------------------------------------
        $q1="SELECT * from erp_org_units where parent_unit={$root_unit->id}";
        $com1 = Yii::$app->db->createCommand($q1);
        $rows = $com1->queryAll();
       

        //---------------------------------root position-----------------------------------------------------
        $position=$this->getParentPosition($rows[0]['id']);
            //-------------------------- root position--------------------------------
           // $position=$this->getParentPosition($root_unit->id);
            
            if(!empty($position)){
             
              //---------------------------------------------get positin status-----------------------
             $q4="SELECT position_status,position_level from erp_units_positions  where position_id={$position['id']} ";
    $com4= Yii::$app->db->createCommand($q4);
     $row4 = $com4->queryOne();  
                //------------------------person details
                
                $rows2=$this->getPersonsInPos($position['id']);
               
                
            if(!empty($rows2)){
                $image=$rows2[0]['user_image']!=''?$rows2[0]['user_image']:'uploads/profile/avatar-user.png';
                 $json_data[]=['id'=>$id,'parentId'=>$parent,'name'=>$rows2[0]['first_name']." ".$rows2[0]['last_name'],
                 'title'=>$position['position'],'status'=>$row4['position_status'] ,'level'=>$row4['position_level'] ,'phone'=>$rows2[0]['phone'], 'mail'=>$rows2[0]['email'],  'image'=>$baseUrl . '/'. $image];

               
     
             }

             else{
                 
                $image='uploads/profile/avatar-user.png';
                $json_data[]=['id'=>$id,'parentId'=>$parent,'name'=>"",
                'title'=>$position['position'],'status'=>$row4['position_status'],'level'=>$row4['position_level'] , 'phone'=>"", 'mail'=>"",  'image'=>$baseUrl.'/'.$image];}
            }
           else{
                 //echo json_encode(['flag'=>false,'message'=>'Unable  to show '.$sub->subdiv_name." ".$levl->level_name.' ,No person assigned to head Position!']);die();
                 $image='uploads/profile/avatar-user.png';
                 $json_data[]=['id'=>$id,'parentId'=>$parent,'name'=>"",
                 'title'=>$rows['unit_name'], 'phone'=>"", 'mail'=>"",  'image'=>$baseUrl.'/'.$image];
                 //echo json_encode( $json_data);
                // var_dump($json_data);die();
             }

          
        
      
      
      
      
         
         $data=$this->getChildPositions($id,$id,$position['id']);
         
         if($data!=0){
            $json_data=array_merge($json_data,$data);
          
         }
         
        
        //echo json_encode($json_data);die();
        /*if(!empty($rows5=$this->getChildUnits($root_unit->id))){
          
        

        }*/
             
        }else
        
        {//not root
        
        
        }
        //var_dump($root_unit->attributes);die();
        return json_encode( $json_data);
       
    }

    //-----------------------parent postion-----------------------------------
    public function getParentPosition($unit){
    
        $q1="SELECT p.id, p.position from erp_units_positions as up inner join erp_org_positions as 
        p on p.id=up.position_id where unit_id={$unit} and position_status='chief' ";
        $com1 = Yii::$app->db->createCommand($q1);
         $row1 = $com1->queryOne();
         return $row1;

    }
    //----------------------------------------------------------------------
    public function getPersonsInPos($pos){
    
        $q2="SELECT u.* from erp_persons_in_position as p inner join user as 
        u on p.person_id=u.user_id where position_id={$pos} ";
        $com2 = Yii::$app->db->createCommand($q2);
         $rows0 = $com2->queryAll();

         return $rows0;

    }

    public function getChildPositions($id,$parent,$position){
       
    $json_data=array()  ; 
    $baseUrl=Yii::$app->request->baseUrl;

    $q3="SELECT p.id,p.position,p.report_to from erp_org_positions as p left join erp_org_positions as 
    p1 on p1.id=p.report_to where p.report_to={$position} ";
    $com3= Yii::$app->db->createCommand($q3);
     $rows1 = $com3->queryAll();
     
     //var_dump($rows1 );die();
     
     if(!empty($rows1)){

        foreach($rows1 as $row){
            
            
            //---------------------------------------------get positin status-----------------------
             $q4="SELECT position_status,position_level from erp_units_positions  where position_id={$row['id']} ";
    $com4= Yii::$app->db->createCommand($q4);
     $row4 = $com4->queryOne();
              //------------------------person details
            //var_dump($row['id']);die();
                $rows2=$this->getPersonsInPos($row['id']);
              
                
            if(!empty($rows2)){
                
                if(count($rows2)>1){
                    
                    foreach($rows2 as $row2){
                        
                        $id++;
                $image=$row2['user_image']!=''?$row2['user_image']:'uploads/profile/avatar-user.png';
                 $json_data[]=['id'=>$id,'parentId'=>$parent,'name'=>$row2['first_name']." ".$row2['last_name'],
                 'title'=>$row['position'],'status'=>$row4['position_status'] ,'level'=>$row4['position_level'] ,'phone'=>$row2['phone'], 'mail'=>$row2['email'],  'image'=>$baseUrl . '/'. $image];  
                    }
                }else{
                
                $id++;
                $image=$rows2[0]['user_image']!=''?$rows2[0]['user_image']:'uploads/profile/avatar-user.png';
                 $json_data[]=['id'=>$id,'parentId'=>$parent,'name'=>$rows2[0]['first_name']." ".$rows2[0]['last_name'],
                 'title'=>$row['position'],'status'=>$row4['position_status'] ,'level'=>$row4['position_level'] ,'phone'=>$rows2[0]['phone'], 'mail'=>$rows2[0]['email'],  'image'=>$baseUrl . '/'. $image];
}
               
     
             }else{
                $id++;
                $image='uploads/profile/avatar-user.png';
                $json_data[]=['id'=>$id,'parentId'=>$parent,'name'=>"",
                'title'=>$row['position'],'status'=>$row4['position_status'],'level'=>$row4['position_level'] , 'phone'=>"", 'mail'=>"",  'image'=>$baseUrl .'/'.$image];

             }

           
            //var_dump($row['id']);die();
           
          $data= $this->getChildPositions($id,$id,$row['id']);
          //var_dump($row);die();
          if(!empty($data)){
            $json_data=array_merge($json_data,$data); 
            $id=$id+count($data);
          }
         
         // if($row['id']==4){break;} 
       
          // $level=$level+count($data);
           //var_dump($level);
        } 

     }
     
     
     return $json_data;
    
    }


    /**
     * Creates a new ErpOrganization model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($force_step=null)
    {
        $step = isset($force_step)? $force_step:'1';
       
      
        $model=isset($_SESSION['org_id'])?$this->findOrgById($_SESSION['org_id']): new ErpOrganization();
       
        if($model==null){
            $model = new ErpOrganization();
        }
        
       
        $contact =isset($_SESSION['contact_id'])?$this->findContactById($_SESSION['contact_id']): new ErpOrganizationContact();
       
        if($contact ==null){
            $contact =new ErpOrganizationContact();
        }

        $address=isset($_SESSION['address_id'])?$this->findAddressById($_SESSION['address_id']): new ErpOrganizationAddress();
        
        if($address!=null && $address!=new ErpOrganizationAddress()){
           
        $address->country_code=$this->findCountryById($address->country)->country_code;   
        }

        $msg='';
        $flag=false;
        if(isset($_POST['ErpOrganization'])){
            $model->attributes=$_POST['ErpOrganization'];
            if($flag=$model->save()){
                $_SESSION['org_id']=$model->id;
                $step=2;
                if(isset($_POST['mode'])&&$_POST['mode']=='update'){
                                 
                    $msg="Organization Info Updated!";
                }else{
                  $msg="Organization Info  Saved!";  
                }
             }else{$step=1;} 

        }

        if(isset($_POST['ErpOrganizationAddress'])){
            $address->attributes=$_POST['ErpOrganizationAddress'];
            $address->org=$model->id;
            $address->country=$this->findCountryByCode( $address->country_code)->id;
          
            if($flag=$address->save()){
                $_SESSION['address_id']=$address->id;
                $step=3;
            
                if(isset($_POST['mode'])&&$_POST['mode']=='update'){
                                 
                    $msg="Address Info Updated!";
                }else{
                  $msg="Address Info  Saved!";  
                }
               
             }else{$step=2;} 

        }

        if(isset($_POST['ErpOrganizationContact'])){
            $contact->attributes=$_POST['ErpOrganizationContact'];
            $contact->org=$model->id;
           // var_dump($contact->attributes);die();
            if($flag=$contact->save()){
                $_SESSION['contact_id']=$contact->id;
                $step=4;
                if(isset($_POST['mode'])&&$_POST['mode']=='update'){
                                 
                    $msg="Contact Info Updated!";
                }else{
                  $msg="Contact Info  Saved!";  
                }
             }else{$step=3;} 

        }
        if(isset($_POST['step'])&&$_POST['step']=='submit'){

           
            
            if(isset($_SESSION['org_id'])){
        
                unset($_SESSION['org_id']);
            }
            if(isset($_SESSION['address_id'])){
        
                unset($_SESSION['address_id']);
            }
            if(isset($_SESSION['contact_id'])){
        
                unset($_SESSION['contact_id']);
            }

            $model= new ErpOrganization();
       
            $contact = new ErpOrganizationContact();
           
            $address=new ErpOrganizationAddress();
            
            return  $this->redirect(['index']);
        }

        if($flag){ Yii::$app->session->setFlash('success',$msg);}
     
        
    
        return $this->render('info-wizard-form', [
            'model' => $model,'address'=> $address,'contact'=>$contact,'isAjax'=>false,'step'=>$step
        ]);
    }

    /**
     * Updates an existing ErpOrganization model.
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
     * Deletes an existing ErpOrganization model.
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
     * Finds the ErpOrganization model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ErpOrganization the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ErpOrganization::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function findOrgById($id){
        
        $model=ErpOrganization::find()
        ->where(['id'=> $id])
         ->One();
        return  $model;
        
    }
    public function  findContactById($id){
        
        $model=ErpOrganizationContact::find()
        ->where(['id'=> $id])
         ->One();
        return  $model;
        
    }

    public function  findAddressById($id){
        
        $model=ErpOrganizationAddress::find()
        ->where(['id'=> $id])
         ->One();
        return  $model;
        
    }
    public function findCountryByCode($code)
    {
        $model = Countries::find()
        ->select('*')
        ->where(['country_code' => $code])
        ->one();

     return $model;
    }
    public function findCountryById($id)
    {
        $model = Countries::find()
        ->select('*')
        ->where(['id' => $id])
        ->one();

     return $model;
    }
   
}
