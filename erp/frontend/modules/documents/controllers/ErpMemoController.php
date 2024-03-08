<?php
namespace frontend\modules\documents\controllers;

use Yii;
use common\models\ErpMemo;
use common\models\ErpMemoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\ErpMemoFlow;
use common\models\ErpMemoFlowRecipients;
use common\models\ErpRequisition;
use common\models\ErpRequisitionFlow;
use common\models\ErpRequisitionItems;
use common\models\ErpRequisitionAttachement;
use common\models\ErpRequisitionFlowRecipients;
use common\models\ErpMemoApproval;
use common\models\ErpMemoRemark;
use common\models\ErpMemoSupportingDoc;
use common\models\ErpRequestPayment;
use common\models\ErpDocumentAttachment;
use common\models\User;
use yii\db\Query;
use yii\data\Pagination;
use common\models\Model;
use yii\web\UploadedFile;
use common\models\ErpMemoCateg;
use common\models\ErpDocumentAttachMerge;
use yii\helpers\ArrayHelper;
use common\models\UserHelper;
use common\components\Constants;
use yii\filters\AccessControl;

/**
 * ErpMemoController implements the CRUD actions for ErpMemo model.
 */
class ErpMemoController extends Controller
{
    private $mParams;
    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            
             // For cross-domain AJAX request
        'corsFilter'  => [
            'class' => \yii\filters\Cors::className(),
            'cors'  => [
                // restrict access to domains:
                //'Origin'                           => static::allowedDomains(),
                'Origin'                           => ['*'],
                'Access-Control-Request-Method'    => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Allow-Credentials' =>false,
                'Access-Control-Max-Age'           => 3600, // Cache (seconds)
                'Access-Control-Allow-Headers' => ['Range'],
                'Access-Control-Request-Headers' => ['*']
            ],
        ],
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
     * Lists all ErpMemo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ErpMemoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    
    
    public function actionMemoTracking($id){

 if (Yii::$app->request->isAjax) {
       
       
            return   $this->renderAjax('doc-tracking',['id'=>$id]);
     
     
         }
         else{
             
              return $this->render('doc-tracking',['id'=>$id]);
         }

   
    
    }
    
        public function actionDrafts()
    {
        
        return $this->render('drafts');
    }
        public function actionPending()
    {

        return $this->render('pending');
    }
    
         public function actionDone($id)
    {
         if(!isset($id) || $id==null){
          Yii::$app->session->setFlash('failure',"Invalid Memo ID");    
             
         }else{
             $user=Yii::$app->user->identity->user_id; 
              Yii::$app->db->createCommand()
                      ->update('erp_memo_approval_flow', ['status' =>'archived'], ['memo_id' =>$id,'approver'=>$user,'status' =>'pending'])
                      ->execute();  
                  Yii::$app->session->setFlash('success',"Memo has been succesfully archived"); 
             
           }
         
  
       return $this->redirect(['pending']);
    }
    
         public function actionMyMemo()
    {

        return $this->render('my-memos');
    }
    /**
     * Displays a single ErpMemo model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        
        $model=$this->findModel($id);
        Yii::$app->db->createCommand()
                      ->update('erp_memo', ['is_new' =>0], ['id' =>$id,'created_by'=>Yii::$app->user->identity->user_id])
                      ->execute();
       
       Yii::$app->db->createCommand()
                      ->update('erp_memo_approval_flow', ['is_new' =>0], ['approver' =>Yii::$app->user->identity->user_id])
                      ->execute();
                      
                      
           if($model->status=='approved'){
   
    
       $q=" SELECT m_ap.* FROM erp_memo_approval as m_ap inner join erp_memo  as m on m.id=m_ap.memo_id
      where m_ap.memo_id={$id} and m.created_by='".Yii::$app->user->identity->user_id."' and m_ap.approval_action='approved' and m_ap.approval_status='final'";
 $com = Yii::$app->db->createCommand($q);
 $row= $com->queryOne(); 
 if(!empty($row)){
     
    Yii::$app->db->createCommand()
                      ->update('erp_memo_approval', ['is_new' =>0], ['id' =>$row['id']])
                      ->execute();   
 }
 

           }           
                        
      
        return $this->render('view', [
            'model' =>$model
        ]);
    }
    
        public function actionTest()
    {
        $q="select m.*,r.* from erp_memo m inner join erp_requisition r on m.id=r.reference_memo where m.created_by!=r.requested_by";
        $com = Yii::$app->db->createCommand($q);
        $rows= $com->queryAll();
        
       /* foreach($rows as $r){
            
            Yii::$app->db->createCommand()
                      ->update('erp_memo', ['created_by' =>$r['requested_by']], ['memo_code' =>$r['memo_code']])
                      ->execute();
        }*/
        
        var_dump('Done');
        
    }
    
       public function actionView2($id)
    {
        return $this->render('view2', [
            'model' => $this->findModel($id),
        ]);
    }
    
    public function actionPdfData($id)
    {
  
  $model= $this->findModel($id);
  
  $user=Yii::$app->user->identity->user_id;
 
 if($model->created_by==$user) {
   
   Yii::$app->db->createCommand()
                      ->update('erp_memo', ['is_new' =>0], ['id' =>$id,'created_by'=>$user])
                      ->execute();  
 }
         
        Yii::$app->db->createCommand()
                      ->update('erp_memo_approval_flow', ['is_new' =>0], ['approver' =>Yii::$app->user->identity->user_id])
                      ->execute();
    
//=====================================================================end update status============================================================


       \yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
 
  
          $url = "css/kv-mpdf-bootstrap.min.css";
          //$url="css/bootstrap.min.css";
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
     //------------------fix image not showing---------------------------------------------------    
         //$mpdf->showImageErrors = true;
         $mpdf->curlAllowUnsafeSslRequests = true;
        //--------------------------setting footer-------------------------------------
        $mpdf->SetHTMLFooter('<img src="img/footer.png"/>');
       
        
         
         $mpdf->WriteHTML($this->renderPartial('view2', [
            'model' => $model,]));
       $content= $mpdf->Output();
       return $content;
        exit;
    }
    
    function actionTest1(){
     
        $html = '
<html>
<head>
<style>
body {font-family: sans-serif;
	font-size: 10pt;
}
p {	margin: 0pt; }
table.items {
	border: 0.1mm solid #000000;
}
td { vertical-align: top; }
.items td {
	border-left: 0.1mm solid #000000;
	border-right: 0.1mm solid #000000;
}
table thead td { background-color: #EEEEEE;
	text-align: center;
	border: 0.1mm solid #000000;
	font-variant: small-caps;
}
.items td.blanktotal {
	background-color: #EEEEEE;
	border: 0.1mm solid #000000;
	background-color: #FFFFFF;
	border: 0mm none #000000;
	border-top: 0.1mm solid #000000;
	border-right: 0.1mm solid #000000;
}
.items td.totals {
	text-align: right;
	border: 0.1mm solid #000000;
}
.items td.cost {
	text-align: "." center;
}
</style>
</head>
<body>

<!--mpdf
<htmlpageheader name="myheader">
<table width="100%"><tr>
<td width="50%" style="color:#0000BB; "><span style="font-weight: bold; font-size: 14pt;">Acme Trading Co.</span><br />123 Anystreet<br />Your City<br />GD12 4LP<br /><span style="font-family:dejavusanscondensed;">&#9742;</span> 01777 123 567</td>
<td width="50%" style="text-align: right;">Invoice No.<br /><span style="font-weight: bold; font-size: 12pt;">0012345</span></td>
</tr></table>
</htmlpageheader>

<htmlpagefooter name="myfooter">
<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
Page {PAGENO} of {nb}
</div>
</htmlpagefooter>

<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->

<div style="text-align: right">Date: 13th November 2008</div>

<table width="100%" style="font-family: serif;" cellpadding="10"><tr>
<td width="45%" style="border: 0.1mm solid #888888; "><span style="font-size: 7pt; color: #555555; font-family: sans;">SOLD TO:</span><br /><br />345 Anotherstreet<br />Little Village<br />Their City<br />CB22 6SO</td>
<td width="10%">&nbsp;</td>
<td width="45%" style="border: 0.1mm solid #888888;"><span style="font-size: 7pt; color: #555555; font-family: sans;">SHIP TO:</span><br /><br />345 Anotherstreet<br />Little Village<br />Their City<br />CB22 6SO</td>
</tr></table>

<br />

<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
<thead>
<tr>
<td width="15%">Ref. No.</td>
<td width="10%">Quantity</td>
<td width="45%">Description</td>
<td width="15%">Unit Price</td>
<td width="15%">Amount</td>
</tr>
</thead>
<tbody>
<!-- ITEMS HERE -->
<tr>
<td align="center">MF1234567</td>
<td align="center">10</td>
<td>Large pack Hoover bags</td>
<td class="cost">&pound;2.56</td>
<td class="cost">&pound;25.60</td>
</tr>
<tr>
<td align="center">MX37801982</td>
<td align="center">1</td>
<td>Womans waterproof jacket<br />Options - Red and charcoal.</td>
<td class="cost">&pound;102.11</td>
<td class="cost">&pound;102.11</td>
</tr>
<tr>
<td align="center">MR7009298</td>
<td align="center">25</td>
<td>Steel nails; oval head; 30mm x 3mm. Packs of 1000.</td>
<td class="cost">&pound;12.26</td>
<td class="cost">&pound;325.60</td>
</tr>
<tr>
<td align="center">MF1234567</td>
<td align="center">10</td>
<td>Large pack Hoover bags</td>
<td class="cost">&pound;2.56</td>
<td class="cost">&pound;25.60</td>
</tr>
<tr>
<td align="center">MX37801982</td>
<td align="center">1</td>
<td>Womans waterproof jacket<br />Options - Red and charcoal.</td>
<td class="cost">&pound;102.11</td>
<td class="cost">&pound;102.11</td>
</tr>
<tr>
<td align="center">MR7009298</td>
<td align="center">25</td>
<td>Steel nails; oval head; 30mm x 3mm. Packs of 1000.</td>
<td class="cost">&pound;12.26</td>
<td class="cost">&pound;325.60</td>
</tr>
<tr>
<td align="center">MF1234567</td>
<td align="center">10</td>
<td>Large pack Hoover bags</td>
<td class="cost">&pound;2.56</td>
<td class="cost">&pound;25.60</td>
</tr>
<tr>
<td align="center">MX37801982</td>
<td align="center">1</td>
<td>Womans waterproof jacket<br />Options - Red and charcoal.</td>
<td class="cost">&pound;102.11</td>
<td class="cost">&pound;102.11</td>
</tr>
<tr>
<td align="center">MR7009298</td>
<td align="center">25</td>
<td>Steel nails; oval head; 30mm x 3mm. Packs of 1000.</td>
<td class="cost">&pound;12.26</td>
<td class="cost">&pound;325.60</td>
</tr>
<tr>
<td align="center">MF1234567</td>
<td align="center">10</td>
<td>Large pack Hoover bags</td>
<td class="cost">&pound;2.56</td>
<td class="cost">&pound;25.60</td>
</tr>
<tr>
<td align="center">MX37801982</td>
<td align="center">1</td>
<td>Womans waterproof jacket<br />Options - Red and charcoal.</td>
<td class="cost">&pound;102.11</td>
<td class="cost">&pound;102.11</td>
</tr>
<tr>
<td align="center">MR7009298</td>
<td align="center">25</td>
<td>Steel nails; oval head; 30mm x 3mm. Packs of 1000.</td>
<td class="cost">&pound;12.26</td>
<td class="cost">&pound;325.60</td>
</tr>
<tr>
<td align="center">MF1234567</td>
<td align="center">10</td>
<td>Large pack Hoover bags</td>
<td class="cost">&pound;2.56</td>
<td class="cost">&pound;25.60</td>
</tr>
<tr>
<td align="center">MX37801982</td>
<td align="center">1</td>
<td>Womans waterproof jacket<br />Options - Red and charcoal.</td>
<td class="cost">&pound;102.11</td>
<td class="cost">&pound;102.11</td>
</tr>
<tr>
<td align="center">MF1234567</td>
<td align="center">10</td>
<td>Large pack Hoover bags</td>
<td class="cost">&pound;2.56</td>
<td class="cost">&pound;25.60</td>
</tr>
<tr>
<td align="center">MX37801982</td>
<td align="center">1</td>
<td>Womans waterproof jacket<br />Options - Red and charcoal.</td>
<td class="cost">&pound;102.11</td>
<td class="cost">&pound;102.11</td>
</tr>
<tr>
<td align="center">MR7009298</td>
<td align="center">25</td>
<td>Steel nails; oval head; 30mm x 3mm. Packs of 1000.</td>
<td class="cost">&pound;12.26</td>
<td class="cost">&pound;325.60</td>
</tr>
<tr>
<td align="center">MR7009298</td>
<td align="center">25</td>
<td>Steel nails; oval head; 30mm x 3mm. Packs of 1000.</td>
<td class="cost">&pound;12.26</td>
<td class="cost">&pound;325.60</td>
</tr>
<tr>
<td align="center">MF1234567</td>
<td align="center">10</td>
<td>Large pack Hoover bags</td>
<td class="cost">&pound;2.56</td>
<td class="cost">&pound;25.60</td>
</tr>
<tr>
<td align="center">MX37801982</td>
<td align="center">1</td>
<td>Womans waterproof jacket<br />Options - Red and charcoal.</td>
<td class="cost">&pound;102.11</td>
<td class="cost">&pound;102.11</td>
</tr>
<tr>
<td align="center">MR7009298</td>
<td align="center">25</td>
<td>Steel nails; oval head; 30mm x 3mm. Packs of 1000.</td>
<td class="cost">&pound;12.26</td>
<td class="cost">&pound;325.60</td>
</tr>
<!-- END ITEMS HERE -->
<tr>
<td class="blanktotal" colspan="3" rowspan="6"></td>
<td class="totals">Subtotal:</td>
<td class="totals cost">&pound;1825.60</td>
</tr>
<tr>
<td class="totals">Tax:</td>
<td class="totals cost">&pound;18.25</td>
</tr>
<tr>
<td class="totals">Shipping:</td>
<td class="totals cost">&pound;42.56</td>
</tr>
<tr>
<td class="totals"><b>TOTAL:</b></td>
<td class="totals cost"><b>&pound;1882.56</b></td>
</tr>
<tr>
<td class="totals">Deposit:</td>
<td class="totals cost">&pound;100.00</td>
</tr>
<tr>
<td class="totals"><b>Balance due:</b></td>
<td class="totals cost"><b>&pound;1782.56</b></td>
</tr>
</tbody>
</table>


<div style="text-align: center; font-style: italic;">Payment terms: payment due in 30 days</div>


</body>
</html>
';



$mpdf = new \Mpdf\Mpdf([
	'margin_left' => 20,
	'margin_right' => 15,
	'margin_top' => 48,
	'margin_bottom' => 25,
	'margin_header' => 10,
	'margin_footer' => 10
]);

$mpdf->SetProtection(array('print'));
$mpdf->SetTitle("Acme Trading Co. - Invoice");
$mpdf->SetAuthor("Acme Trading Co.");
$mpdf->SetWatermarkText("Paid");
$mpdf->showWatermarkText = true;
$mpdf->watermark_font = 'DejaVuSansCondensed';
$mpdf->watermarkTextAlpha = 0.1;
$mpdf->SetDisplayMode('fullpage');

$mpdf->WriteHTML($html);

$mpdf->Output();
    }
    
    //------------------------------------------fetch tab-----------------------------------------------------------------
     public function actionFetchTab()
    {
    $step_number = $_REQUEST["step_number"];
    
    $model=new ErpMemo();
   
    if(isset($_GET['active-step'])){
        
        $step_number=$_GET['active-step']; 
    }
    
    if(isset($_GET['memo_id'])){
        
        $model =ErpMemo::find()->where(['id' =>$_GET['memo_id']])->one();
        $model1 =ErpMemoCateg::find()->where(['id' =>$model->type])->one();
   
   
   //------------------------------------------if memo for requisition-----------------------------------  
        if($model1->categ_code=='PR'){
            
       
   if($step_number==0){
           
        
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
       
           
     if($step_number==1){
           
             
       $model2=ErpRequisition::find()->where(['reference_memo'=>$model->id])->one() ; 
    
        if($model2!=null){
            
          return $this->renderAjax('page-viewer2', [
         'model' => $model2,
         
    ]);
        
         
        }
        
        else{
            
            
            return   ' <div class="error-page">
        <h2 class="headline text-yellow"> 404</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-yellow"></i> Oops! Requisition Form not found.</h3>

          <p>
            We could not find Requisition Form.
            
          </p>

        </div>
     
      </div>';
        }
       
       
           }
        
       
       if($step_number==2)
          {
           
         $query = ErpRequisitionAttachement::find()->where(['pr_id' =>$model2->id]);
    $countQuery = clone $query;
    $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>1]);
    $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all(); 
        
          if(!empty($models)){
            
          return $this->renderAjax('page-viewer3', [
         'models' => $models,
         'pages' => $pages,
        'step'=>$step_number,
        'container'=>$step_number+1
    ]);
        
         
        }else{
            
            
            return   '<div class="alert alert-warning alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                No Supporting Document(s) Found!
              
               </div>';
        }
       
       
      
         
     }  
     
     
    /* if($step_number==3)
          {
        
        $model=new ErpMemoApproval();   
      return $this->renderAjax('approval-work-flow', [
         'model' => $model,
        
    ]);
       
      
         
     }*/
     
     
        
        }
        
        //---------------------end Memo for Requisition---------------------------------------
        
        
     //----------------------------------------memo for Request for payment---------------------------------------   
       else if($model1->categ_code=='RFP'){
           
      if($step_number==0){
           
        
        if($model!=null){
            
          return $this->renderAjax('page-viewer1', [
         'model' => $model,
         
    ]);
        
         
        }
        
    
        else{
            
            
            return   ' <div class="error-page">
        <h2 class="headline text-yellow"> 404</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-yellow"></i> Oops! Memo not found.</h3>

          <p>
            We could not find Memo.
            
          </p>

        </div>
     
      </div>';
        }
       
       
           }
           
                       
       if($step_number==1)
          {
           
           $q=" SELECT *  FROM erp_request_payment where memo='".$model->id."' ";
     $com = Yii::$app->db->createCommand($q);
     $row = $com->queryOne();

        $query = ErpDocumentAttachMerge::find()->where(['document'=>$row['invoice'],'visible'=>'1']);
    $countQuery = clone $query;
    $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>1]);
    $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all();
        
        if(!empty($models)){
        
              return $this->renderAjax('page-viewer4', [
         'models' => $models,
         'pages'=>$pages,
         'step'=>$step_number
         
    ]);
            
         
        }else{
            
               
         return   '<div class="alert alert-danger alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                No Attachements Found !
              
               </div>';
        }
       
      
         
     }  
           
           
       }
      
      
       else{
           
           if($step_number==0){
           
        
        if($model!=null){
            
          return $this->renderAjax('page-viewer1', [
         'model' => $model,
         
    ]);
        
         
        }
        
    
        else{
            
            
            return   ' <div class="error-page">
        <h2 class="headline text-yellow"> 404</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-yellow"></i> Oops! Memo not found.</h3>

          <p>
            We could not find Memo.
            
          </p>

        </div>
     
      </div>';
        }
       
       
           } 
      
             
       if($step_number==1)
          {
           
             
    $query = ErpMemoSupportingDoc::find()->where(['memo' =>$model->id]);
    $countQuery = clone $query;
    $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>1]);
    $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all(); 
        
          if(!empty($models)){
            
          return $this->renderAjax('page-viewer3', [
         'models' => $models,
         'pages' => $pages,
        'step'=>$step_number,
        'container'=>$step_number+1
    ]);
        
         
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
            
            
        }
       
          
    }else{
        
      return   ' <div class="error-page">
        <h2 class="headline text-yellow"> 404</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-yellow"></i> Oops! Expected Memo ID .</h3>

          <p>
            We could not find Memo Id.
            
          </p>

        </div>
     
      </div>';
    }
   
    }
    
     public function actionViewSupportingDocs($id)
    {
        
   
      $pdf = new \LynX39\LaraPdfMerger\PdfManage; 
        $q = new Query;
                                               $q->select([
                                                   'support_doc.doc_upload',
                                                   
                                               ])->from('erp_memo_supporting_doc as support_doc ')->where(['memo' =>$id]);
                                   
                                               $command0 = $q->createCommand();
                                               $rows1= $command0->queryAll();
                                               
                                                
              foreach($rows1 as $row1)  {
                
                                                        $pdf->addPDF($row1['doc_upload'], 'all');
                                                        //$merger->addFile($rows3[0]['attach_upload']);
                                                       //$pdf->addPDF($rows3[0]['attach_upload'], 'all');
           
              }
              if(!empty($rows1))
              $createdPdf = $pdf->merge();
              else
                $pdf->addPDF('uploads/error/no_document.pdf', 'all');
                 $createdPdf = $pdf->merge();
              return $createdPdf;
               exit;
    } 
    
    
        public function actionViewPdf($id)
    {
   
    if (Yii::$app->request->isAjax) {
           
            return $this->renderAjax('viewer',[ 'model' => $this->findModel($id),'status'=>$_GET['status']]);
        }
       return $this->render('viewer',[ 'model' => $this->findModel($id),'status'=>$_GET['status']]);
    }

    
    
     public function actionViewMemoPdf()
    {
      if(!isset($_GET['id']) || !is_numeric($_GET['id']) || intval($_GET['id'])<1){
          
           return   '<div class="alert alert-danger alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                Invalid Memo ID!
              
               </div>'; 
          
      }
      $id=$_GET['id'];
    
      $model=ErpMemo::find()->where(['id'=>$id])->One();
      
      if(!is_object($model)){
          
          return   '<div class="alert alert-danger alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                Memo Could Not be found!
              
               </div>';  
      }
      
      
      return $this->renderAjax('page-viewer1', [
          'model' => $this->findModel($id),
         
    ]);
    }
    
   
    
    public function actionCategPr()
    
    {
       
             $model = new ErpMemo();
             $model0 = new ErpMemoSupportingDoc();
             
             $model1 = new ErpRequisition();
             $modelsRequisitionItems = [new ErpRequisitionItems];
             $model2 = new ErpRequisitionAttachement();
             
             $mParams=array();
             $mParams['model']= $model;
             $mParams['model0']= $model0;
             $mParams['model1']= $model1;
             $mParams['model2']= $model2;
             $mParams['modelsRequisitionItems']=$modelsRequisitionItems;
             $mParams['categ']=Constants::MEMO_TYPE_PR;
         
            return $this->render('_form',['mParams'=>$mParams]);
        
      }
      
       public function actionCategTr(){
             
            
             $model = new ErpMemo();
             $model0 = new ErpMemoSupportingDoc();
             
             $mParams=array();
             $mParams['model']= $model;
             $mParams['model0']= $model0;
             $mParams['categ']=Constants::MEMO_TYPE_TR;
         
            return $this->render('_form',['mParams'=>$mParams]);
        
      }
      
       public function actionCategRfp(){
        
             $model = new ErpMemo();
             $model0 = new ErpMemoSupportingDoc();
             
             $mParams=array();
             $mParams['model']= $model;
             $mParams['model0']= $model0;
             $mParams['categ']=Constants::MEMO_TYPE_RFP;
         
            return $this->render('_form',['mParams'=>$mParams]);
      }
      
       public function actionCategO(){
        
             $model = new ErpMemo();
             $model0 = new ErpMemoSupportingDoc();
             
             $mParams=array();
             $mParams['model']= $model;
             $mParams['model0']= $model0;
             $mParams['categ']=Constants::MEMO_TYPE_OTHER;
         
            return $this->render('_form',['mParams'=>$mParams]);
      }
  
  
    private function setParams($params){
        
        $this->$mParams=$params;
    }
    /**
     * Creates a new ErpMemo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ErpMemo();
        $model0 = new ErpMemoSupportingDoc();
        
         //-------handle type pr---------------
        $model1 = new ErpRequisition();
        $modelsRequisitionItems = [new ErpRequisitionItems];
        $model2 = new ErpRequisitionAttachement();
        
         //-------handle type Req for payment---------------
        $model3 = new ErpRequestPayment();
        
         //-------set default return models param---------------
        $mParams=array();
             
        $mParams['model']= $model;
        $mParams['model0']= $model0;
        
       
        $mParams['model1']= $model1;
        $mParams['modelsRequisitionItems']=$modelsRequisitionItems;
        $mParams['model2']= $model2;
        //--------set default memo type---------------------------
        $mParams['categ']=Constants::MEMO_TYPE_OTHER;
           
          
        
    
       if(Yii::$app->request->post()){
          
           
           if(!isset($_POST['ErpMemo'])){
               
                Yii::$app->session->setFlash('error',Constants::MEMO_INVALID_POST);     
                return $this->render('_form',['mParams'=>$mParams]); 
               
             }
           
           
           $model->attributes=$_POST['ErpMemo'];
           
           
           $exponent =2; // Amount of digits
            $min = pow(10,$exponent);
            $max = pow(10,$exponent+1)-1;
          
            $value = rand($min, $max);
            $unification= "m"."-".date("Ymdhms")."-".$value;
            
            $model->memo_code= $unification;
            $model->created_by=Yii::$app->user->identity->user_id;
            
            $pos=UserHelper::getPositionInfo(Yii::$app->user->identity->user_id);
            
            if(!empty($pos)){
               
            $model->user_position=$pos['id'];
            }
           
           $categ=ErpMemoCateg::find()->where(['id'=>$model->type])->one(); 
           $mParams['categ']=$categ->categ_code;
    //-----------------------------------------memo save--------------------------------------------------
    
           if(!$flag=$model->save()){
            Yii::$app->session->setFlash('failure',Html::errorSummary($model));     
            return $this->render('_form',['mParams'=>$mParams]);
           }
            
        
             if(isset($_POST['ErpMemoSupportingDoc'])){
             
             $model0->doc_uploaded_files = UploadedFile::getInstances($model0, 'doc_uploaded_files');
                   
                    if(!empty( $model0->doc_uploaded_files)){
                 
                       $files=$model0->doc_uploaded_files;
                 
                
                 
                 foreach($files as $key => $file){
                 
                    
                
                 $exponent = 3; // Amount of digits
 $min = pow(10,$exponent);
 $max = pow(10,$exponent+1)-1;
 //1
 $value = rand($min, $max);
 $unification= date("Ymdhms")."".$value;
  
   $temp= explode(".",   $file->name);
   $ext = end($temp);
   $path_to_doc='uploads/memo/attachements/'. $unification.".{$ext}";
   
   $model0=new ErpMemoSupportingDoc(); 
   $model0->doc_upload=$path_to_doc;
   $model0->memo=$model->id;
   $model0->doc_name=$file->name;
   $model0->uploaded_by=Yii::$app->user->identity->user_id;
                  
                  if(! $flag=$model0->save(false)){
                        
                        Yii::$app->session->setFlash('error',Html::errorSummary($model0)); 
                        return $this->render('_form',['mParams'=>$mParams]);
                
                  }  
                 
               $file->saveAs( $path_to_doc);  
                     
                 }
                 
              
                 
             }
            
               
        
             
            }   
            
      
   
   
  
   
   
   
   //-----------------------------------------check if is memo for requisition---------------------------      
         if($categ->categ_code==Constants::MEMO_TYPE_PR){
             
                
                
                 if(isset($_POST['ErpRequisition'])){
            
            $model1->attributes=$_POST['ErpRequisition'];
            $exponent =2; // Amount of digits
            $min = pow(10,$exponent);
            $max = pow(10,$exponent+1)-1;
            //1
            $value = rand($min, $max);
            $unification= "pr"."-".date("Ymdhms")."-".$value;
            $model1->requisition_code= strtoupper($unification);
            $model1->reference_memo=$model->id;
            $model1->requested_by=Yii::$app->user->identity->user_id;
  
  //------------------------------------------requisition save--------------------------------------  
  
        if(!$flag=$model1->save(false)){
             Yii::$app->session->setFlash('error',Html::errorSummary($model1)); 
             return $this->render('_form',['mParams'=>$mParams]);  
        }
           
           
           
                 $model1->excel_file= UploadedFile::getInstance($model1, 'excel_file');
                 
                 
                 
                  if ($model1->excel_file!=null) {
                  
                   $file=$model1->excel_file;
                   $filename = 'reqs'.uniqid().$file->extension; 
                   $file->saveAs( "uploads/temp/".$filename );    
                   $inputfile=  "uploads/temp/".$filename;
                    
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
               $sheetData = $sheet->toArray(null, true, true, true);
           
               
             $total_amount=0; 
            for($i=2;$i<=$highestRow;$i++){
            //---------------------designation and quantity not null---------------------------------------------    
               
             if($sheet->getCell('B'.$i)->getValue()!=null && $sheet->getCell('E'.$i)->getValue()!=null){
                    
              $modelItem= new ErpRequisitionItems();
              $modelItem->designation=$sheet->getCell('B'.$i)->getValue();
              $modelItem->specs=$sheet->getCell('C'.$i)->getValue();
              $modelItem->uom=$sheet->getCell('D'.$i)->getValue();
              $modelItem->quantity=$sheet->getCell('E'.$i)->getValue() !=null ? $sheet->getCell('E'.$i)->getValue(): 0 ;
              $modelItem->badget_code=$sheet->getCell('F'.$i)->getValue();
              $modelItem->unit_price=$sheet->getCell('G'.$i)->getValue()!=null? $sheet->getCell('G'.$i)->getValue() : 0;
              
              if($modelItem->quantity !=0 && $modelItem->unit_price!=0){
                
                $total_amount=$modelItem->quantity * filter_var($modelItem->unit_price, FILTER_SANITIZE_NUMBER_INT);
                $total_amount=number_format($total_amount);
                  
              }
              $modelItem->total_amount=$sheet->getCell('H'.$i)->getValue()!=null && is_numeric($sheet->getCell('H'.$i)->getValue())?$sheet->getCell('H'.$i)->getValue(): $total_amount;
              
              $modelItem->requisition_id= $model1->id;
              $flag=$modelItem->save(false);
                    
                }

             
              
              
              
             /*var_dump("DES :".$sheet->getCell('B'.$i)->getValue() ." SPECS : ".$sheet->getCell('C'.$i)->getValue()." UOM :"
             .$sheet->getCell('D'.$i)->getValue()." QTY :".$sheet->getCell('E'.$i)->getValue()." BCODE :".$sheet->getCell('F'.$i)->getValue()." UP :"
             .$sheet->getCell('G'.$i)->getValue()." TOT :".$sheet->getCell('H'.$i)->getValue());*/
            
             
          
            }  
            
            
                  
                      
                  }
                  
                  else{
                      
                 $modelsRequisitionItems= Model::createMultiple(ErpRequisitionItems::classname());
                 Model::loadMultiple($modelsRequisitionItems , Yii::$app->request->post()); 
  
  //---------------------------------check items------------------------------------------------------               
                 if(!empty($modelsRequisitionItems)){
                 
                    $transaction = \Yii::$app->db->beginTransaction();
                try {
                    
                     
                        foreach ($modelsRequisitionItems as $modelItem) {
                           
                                  
                                  if($modelItem!=new ErpRequisitionItems()){
                                
                                $modelItem->requisition_id =$model1->id ;
                                $modelItem->user=Yii::$app->user->identity->user_id;
                                //var_dump($modelItem->attributes);
                            
                            if (! ($flag = $modelItem->save(false))) {
                                $transaction->rollBack();
                               
                                 
                                 Yii::$app->session->setFlash('error',Html::errorSummary($modelItem)); 
                                 return $this->render('_form',['mParams'=>$mParams]);                }
                        }
                    
                }
                   //die(); 
                   
                    if ($flag) {
                        $transaction->commit();
                      
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
                     
                      
                      
                  }
                 
                 
                 
             }
        //----------------------------Requisition--supporting doc----------------------------------------------

           if(isset($_POST['ErpRequisitionAttachement'])){
               
              $post= $_POST['ErpRequisitionAttachement'];
              $model2->attach_files = UploadedFile::getInstances($model2, 'attach_files');
                   
                    if(!empty( $model2->attach_files)){
                 
                     $files=$model2->attach_files;
                 
                
                 
                 foreach($files as $file){
                     
                
                 $exponent = 3; // Amount of digits
 $min = pow(10,$exponent);
 $max = pow(10,$exponent+1)-1;
 //1
 $value = rand($min, $max);
 $unification= date("Ymdhms")."".$value;
  
   $temp= explode(".",   $file->name);
   $ext = end($temp);
   $path_to_attach='uploads/pr/attachements/'. $unification.".{$ext}";
    
   
   
                 $attModel=new ErpRequisitionAttachement();
                 $attModel->attach_name=$file->name;
                 $attModel->created_by=Yii::$app->user->identity->user_id;
                 $attModel->pr_id=$model1->id;
                 $attModel->attach_upload=$path_to_attach ;
                  
                  if(! $flag=$attModel->save(false)){
                     
              
                   
                   Yii::$app->session->setFlash('error',Html::errorSummary($attModel)); 
                                 return $this->render('_form',['mParams'=>$mParams]);  
                   
                  }  
                 
               $file->saveAs( $path_to_attach);   
                     
                 }
                 
              
                 
             }
            
               
        
             
            }        
   
           

             
         }
         
       
  }//-------------------------------end type pr-------------------------------------------------------
          
          
           else if($categ->categ_code==Constants::MEMO_TYPE_RFP)
          {
                 
                 if(isset($_POST['ErpRequestPayment'])){
                          $model3->attributes=$_POST['ErpRequestPayment'];
                          $model3->memo=$model->id;
                          $model3->save(false);
                 }
          }
          
    
   
           
        
        Yii::$app->session->setFlash('success',"Memo Saved Successfully !");
        return $this->redirect(['drafts']);
      
       
       
           
           
           
       }

    }
 
 
 
  //--------------------------------render memo partial---------------------------------------------------------
     public function actionCreatePartial()
    {
        $model = new ErpMemo();

        return $this->renderAjax('_form-partial', [
            'model' => $model,
        ]);
    }
    //========================================================forwrd memo========================================
public function actionMemoForwardAction(){
   
   
  
   
    if(isset($_POST['ErpMemo'])){
     
     $action=$_POST['ErpMemo']['action'];
     $remark=$_POST['ErpMemo']['remark'];
     $recipients=$_POST['ErpMemo']['recipients_names'];
     $id=$_POST['ErpMemo']['id'];
     $user=Yii::$app->user->identity->user_id;
      
     $model=ErpMemo::find()->where(['id'=>$id])->One();
     
     if($model!=null){
      
      $flow=ErpMemoFlow::find()->where(['memo'=>$model->id])->One();   
         if($flow==null){
      
         $flow=new ErpMemoFlow(); 
         $flow->memo=$model->id;
         $flow->creator=$user;
         $flow->save(false);   
         
     }
     
      //-----------------------------------------------get action handler--------------------------------------------------
    $q1=" SELECT r.id as r_id  FROM erp_memo_flow_recipients as r 
    where r.recipient={$user} and r.flow_id={$flow->id} order by r.timestamp desc ";
    $command = Yii::$app->db->createCommand($q1);
    $r1 = $command->queryAll();
     
    if(!empty($recipients)){
 foreach($recipients as $key=>$value){
    $recipientModel=new ErpMemoFlowRecipients();
    $recipientModel->flow_id=$flow->id;
    $recipientModel->recipient=$value;
    $recipientModel->sender=$user;
    $recipientModel->remark =$remark;
    $flag=$recipientModel->save(false);
    
    //=================================================notification================================================================
   //---------------------------------sender--------------------------------------
   
    $q7=" SELECT u.first_name,u.last_name,p.position FROM user as u  inner join erp_persons_in_position as pp  on u.user_id=pp.person_id
    inner join erp_org_positions as p  on pp.position_id=p.id  where pp.person_id='".$user."' ";
                                           $command7= Yii::$app->db->createCommand($q7);
                                           $row7 = $command7->queryOne();
                                           $sender=$row7['first_name']." ".$row7['last_name']." /".$row7['position'];
                                         
                                           //-------------------------receiver---------------------------
                                            $user2=User::find()->where(['user_id'=>$value])->One();
                                            $recipient=$user2->first_name." ".$user2->last_name;
                                            
                                            
                                            if($flag){
                                                
                                                 $flag1= Yii::$app->mailer->compose( ['html' =>'userNotification-html'],
    [
        'recipient' =>$recipient,'sender'=>$sender ,'doc'=>'Memo','date'=>date("Y-m-d H:i:s")
       
    ])
->setFrom(['no_reply@rac.co.rw' => 'RAC SYSTEM'])
->setTo([$user2->email=>$recipient])
->setSubject('ERP Notification')
//->setTextBody('You Can Change Login Password After Sign in')
->send();   
                                            }
                                            
//=============================================end notification================================================================================ 

  
    }
 } 
 
  if($remark!=''){
     
      //--------------------------------------saving remark----------------------------------
  $remarkkModel=new ErpMemoRemark();
  $remarkkModel->remark=$remark;
  $remarkkModel->memo=$model->id;
  $remarkkModel->author=$user;
  $flag=$remarkkModel->save(false);
 }
 
 if($flag){
    //--------------------------if recipeint forwared------------------------------------------------------
 
  Yii::$app->db->createCommand()
                      ->update('erp_memo_flow_recipients', ['status' =>'done',], ['recipient' =>$user,'flow_id'=>$flow->id])
                      ->execute();
  //------------------------------if creator forwared--------------------------
  
   
                      
Yii::$app->session->setFlash('success',"Memo forwarded for further processing !");


}else{
   Yii::$app->session->setFlash('failure',"Memo could not be forwarded !"); 
    
}


 if($model->status!='drafting'){
   return $this->redirect(['pending']);  
    
       
   }else{
       
       Yii::$app->db->createCommand()
                      ->update('erp_memo', ['status' =>'processing'], ['id' =>$model->id])
                      ->execute();
    return $this->redirect(['drafts']);   
     
   }
     
     }
      
     
   
     
   
   
    
  


   }
   
  


}

//---------------------------------------------------------memo approve----------------------------------------------
  //========================================================forwrd memo========================================
public function actionMemoApproveAction(){
   
   
    if(isset($_POST['ErpMemo'])){
     
     $action=$_POST['ErpMemo']['action'];
     $remark=$_POST['ErpMemo']['remark'];
     $recipients=$_POST['ErpMemo']['recipients_names'];
     $id=$_POST['ErpMemo']['id'];
     $user=Yii::$app->user->identity->user_id;
      
    //---------------------------------get MD------------------------------------- 
     $q=" SELECT pp.person_id from erp_org_positions as p left join erp_org_positions as p1 on p1.id=p.report_to 
     inner join erp_persons_in_position as pp on pp.position_id=p.id where p.position='Managing Director'";
    $command = Yii::$app->db->createCommand($q);
    $r_MD = $command->queryOne();
    
    
    //------------------------------------------find memo-----------------------------------------
     $memo=ErpMemo::find()->where(['id'=>$id])->One();
     
     
    //---------------------------------------get flow----------------------------------------------
     $flow=ErpMemoFlow::find()->where(['memo'=>$id])->One();
     
    
   
    
  
   //----------------------------approve------------------------------------------------------------ 
    
    $approval=new ErpMemoApproval();
    $approval->memo_id=$memo->id;
    $approval->approved_by=$user;
    $approval->approval_status="approved";
    $approval->remark=$remark;
    $approved=$approval->save(false);
    
    
     
  if($remark!=''){
     
      //--------------------------------------saving remark----------------------------------
  $remarkkModel=new ErpMemoRemark();
  $remarkkModel->remark=$remark;
  $remarkkModel->memo=$memo->id;
  $remarkkModel->author=$user;
  $remarkkModel->save(false);
  
      
  }
    
    //---------------------------------approve as MD-------------------
    
    if($user==$r_MD['person_id']){
      
     $approved=  Yii::$app->db->createCommand()
                      ->update('erp_memo', ['status' =>'approved'], ['id'=>$memo->id])
                      ->execute();
      
        
        
    }
    
    if( $approved){
      
      $q1=" SELECT c.categ as memo_type FROM erp_memo as m
 inner join erp_memo_categ as c  on c.id=m.type  
     where m.id=".$memo->id."";
     $com1 = Yii::$app->db->createCommand($q1);
     $row1 = $com1->queryone(); 
     
     
     if($row1['memo_type']=='Requisition'){
   
   //---------------------requisition  referenced by approved memo------------------------------------- 
    $req=ErpRequisition::find()->where(['reference_memo'=>$memo->id])->One();
   
   //----------------------check if req is not null-----------------------------------------
   
   
   
   
    $req_flow=new ErpRequisitionFlow();
    $req_flow->requisition=$req->id;
    $req_flow->creator=Yii::$app->user->identity->user_id;
    $req_flow_saved= $req_flow->save();
    
    if($req_flow_saved){
        
       if(!empty($recipients)){
 foreach($recipients as $key=>$value){
   
   
   
    $recipientModel=new ErpRequisitionFlowRecipients();
    $recipientModel->flow_id=$req_flow->id;
    $recipientModel->recipient=$value;
    $recipientModel->sender=$user;
    $recipientModel->remark =$remark;
    $forwarded=$recipientModel->save(false);
    
     //=================================================notification================================================================
   //---------------------------------sender--------------------------------------
   
    $q7=" SELECT u.first_name,u.last_name,p.position FROM user as u  inner join erp_persons_in_position as pp  on u.user_id=pp.person_id
    inner join erp_org_positions as p  on pp.position_id=p.id  where pp.person_id='".$user."' ";
                                           $command7= Yii::$app->db->createCommand($q7);
                                           $row7 = $command7->queryOne();
                                           $sender=$row7['first_name']." ".$row7['last_name']." /".$row7['position'];
                                         
                                           //-------------------------receiver---------------------------
                                            $user2=User::find()->where(['user_id'=>$value])->One();
                                            $recipient=$user2->first_name." ".$user2->last_name;
                                            
                                            
                                            if($flag){
                                                
                                                 $flag1= Yii::$app->mailer->compose( ['html' =>'userNotification-html'],
    [
        'recipient' =>$recipient,'sender'=>$sender ,'doc'=>'Requisition','date'=>date("Y-m-d H:i:s")
       
    ])
->setFrom(['no_reply@rac.co.rw' => 'RAC SYSTEM'])
->setTo([$user2->email=>$recipient])
->setSubject('ERP Notification')
//->setTextBody('You Can Change Login Password After Sign in')
->send();   
                                            }
                                            
//=============================================end notification================================================================================ 

  
    }
 }  
        
    }
    
        
     }//------------------------------------end for requisition-------------------------------------
     
     if($row1['memo_type']=='Travel Clearance'){
   
     //-----------------------------------------------------------do with travel clearance--------------------------    
         
     } 
        
        
    }
    
  
 
 //================================add recipients to the flow-==================================================
 if(!empty($recipients)){
 foreach($recipients as $key=>$value){
   
   
   
    $recipientModel=new ErpMemoFlowRecipients();
    $recipientModel->flow_id=$flow->id;
    $recipientModel->recipient=$value;
    $recipientModel->sender=$user;
    $recipientModel->remark =$remark;
    $forwarded= $recipientModel->save(false);
    
     //=================================================notification================================================================
   //---------------------------------sender--------------------------------------
   
    $q7=" SELECT u.first_name,u.last_name,p.position FROM user as u  inner join erp_persons_in_position as pp  on u.user_id=pp.person_id
    inner join erp_org_positions as p  on pp.position_id=p.id  where pp.person_id='".$user."' ";
                                           $command7= Yii::$app->db->createCommand($q7);
                                           $row7 = $command7->queryOne();
                                           $sender=$row7['first_name']." ".$row7['last_name']." /".$row7['position'];
                                         
                                           //-------------------------receiver---------------------------
                                            $user2=User::find()->where(['user_id'=>$value])->One();
                                            $recipient=$user2->first_name." ".$user2->last_name;
                                            
                                            
                                            if($flag){
                                                
                                                 $flag1= Yii::$app->mailer->compose( ['html' =>'userNotification-html'],
    [
        'recipient' =>$recipient,'sender'=>$sender ,'doc'=>'Memo','date'=>date("Y-m-d H:i:s")
       
    ])
->setFrom(['no_reply@rac.co.rw' => 'RAC SYSTEM'])
->setTo([$user2->email=>$recipient])
->setSubject('ERP Notification')
//->setTextBody('You Can Change Login Password After Sign in')
->send();   
                                            }
                                            
//=============================================end notification================================================================================ 

  
    }
 }


  

if($approved && $forwarded){
    
  
  $done=  Yii::$app->db->createCommand()
                      ->update('erp_memo_flow_recipients', ['status' =>'done'], ['recipient'=>$user,'flow_id'=>$flow->id])
                      ->execute(); 
  
  
  Yii::$app->session->setFlash('success',"Memo Approved and  forwarded Successfully!");
      
}else{
    
     Yii::$app->session->setFlash('failure',"Memo could not be Approved or forwarded !");
   
}


return $this->redirect(['pending']);

   
}

   }
   
   
   
   public function actionApprovedMemos(){
       
     return $this->render('approved-memos');  
       
   }

    /**
     * Updates an existing ErpMemo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
         
        $model =$this->findModel($id);
  //-------------------------memo supp docs------------------------------------------------      
        $model0=new ErpMemoSupportingDoc();
        
          //-------set default return models param---------------
        $mParams=array();
             
        $mParams['model']= $model;
        $mParams['model0']= $model0;
        
        $mcateg=ErpMemoCateg::find()->where(['id'=>$model->type])->one();   
        $mcateg_code=$mcateg->categ_code;
        
        if($mcateg_code=='PR'){
            
          $model1=ErpRequisition::find()->where(['reference_memo'=>$model->id])->One();
          //---------------------------req sup docs----------------------------------------------     
          $model2 =new ErpRequisitionAttachement();  
          
          if($model1!=null){
          
           $modelsRequisitionItems =ErpRequisitionItems::find()->where(['requisition_id'=>$model1->id])->all();     
          
              
          }
          
          if($model1==null){
              
            $model1 = new ErpRequisition();
            $exponent =2; // Amount of digits
            $min = pow(10,$exponent);
            $max = pow(10,$exponent+1)-1;
            //1
            $value = rand($min, $max);
            $unification= "pr"."-".date("Ymdhms")."-".$value;
            $model1->requisition_code= strtoupper($unification);
            $model1->reference_memo=$model->id;
            $model1->requested_by=Yii::$app->user->identity->user_id;
           
          }
          
          if(empty($modelsRequisitionItems)){
              
             $modelsRequisitionItems = [new ErpRequisitionItems]; 
          }
          
          $mParams['model1']= $model1;
          $mParams['modelsRequisitionItems']= $modelsRequisitionItems;
          $mParams['model2']= $model2;
        }
        
        if($mcateg_code=='RFP'){
            
             $model3=ErpRequestPayment::find()->where(['memo'=>$id])->One();
            
            if($model3==null){
                $model3 = new ErpRequestPayment(); 
            }
            
            $mParams['model3']= $model3;
            
        }
        $mParams['categ']=$mcateg_code;
     
   
           
           
           
          
       
      
      
       if(Yii::$app->request->post()){
           
            
           
           $model->attributes=$_POST['ErpMemo'];
           
            
    //-----------------------------------------memo save--------------------------------------------------        
            
           if($flag=$model->save(false)){
               
               
             if(isset($_POST['ErpMemoSupportingDoc'])){
             
             $model0->doc_uploaded_files = UploadedFile::getInstances($model0, 'doc_uploaded_files');
             
                
                 
                    
                    if(!empty( $model0->doc_uploaded_files)){
                 
                
       
                       
                       
                       $files=$model0->doc_uploaded_files;
                 
                
                 
                 foreach($files as $key => $file){
                 
                 
       
                    
                
                 $exponent = 3; // Amount of digits
 $min = pow(10,$exponent);
 $max = pow(10,$exponent+1)-1;
 //1
 $value = rand($min, $max);
 $unification= date("Ymdhms")."".$value;
  
   $temp= explode(".",   $file->name);
   $ext = end($temp);
   $path_to_doc='uploads/memo/attachements/'. $unification.".{$ext}";
   
   $doc=new ErpMemoSupportingDoc(); 
   $doc->doc_upload=$path_to_doc;
   $doc->memo=$model->id;
   $doc->doc_name=$file->name;
   $doc->uploaded_by=Yii::$app->user->identity->user_id;
   $doc->save(false);
   $file->saveAs( $path_to_doc);  
                     
                 }
                 
            
                 
             }
            
               
        
             
            }   
            
      
   
   
    
        $categ=ErpMemoCateg::find()->where(['id'=>$model->type])->one();
       
   
   
   //-----------------------------------------check if is memo for requisition---------------------------      
         if($categ->categ_code=='PR'){
             
                
                
                 if(isset($_POST['ErpRequisition'])){
            
                  $model1->attributes=$_POST['ErpRequisition'];
            
       
        
  
  //------------------------------------------requisition save--------------------------------------           
             if($flag= $model1->save(false)) {
                 
                 
                      $model1->excel_file= UploadedFile::getInstance($model1, 'excel_file');
                 
                 
                 
                  if ($model1->excel_file!=null) {
                  
                   $file=$model1->excel_file;
    
                    
                     
                     
                      if(file_exists('uploads/temp/items.xlsx')){
    unlink('uploads/temp/items.xlsx');
}
       
           $file->saveAs( "uploads/temp/items.xlsx");
           
           
        
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
               $sheetData = $sheet->toArray(null, true, true, true);
           
               
             $total_amount=0; 
            for($i=2;$i<=$highestRow;$i++){
            //---------------------designation and quantity not null---------------------------------------------    
               
                if($sheet->getCell('B'.$i)->getValue()!=null && $sheet->getCell('E'.$i)->getValue()!=null){
                    
              $modelItem= new ErpRequisitionItems();
              $modelItem->designation=$sheet->getCell('B'.$i)->getValue();
              $modelItem->specs=$sheet->getCell('C'.$i)->getValue();
              $modelItem->uom=$sheet->getCell('D'.$i)->getValue();
              $modelItem->quantity=$sheet->getCell('E'.$i)->getValue();
              $modelItem->badget_code=$sheet->getCell('F'.$i)->getValue();
              $modelItem->unit_price=$sheet->getCell('G'.$i)->getValue()!=null?$sheet->getCell('G'.$i)->getValue():0;
              
              if($sheet->getCell('E'.$i)->getValue()!=0 && $sheet->getCell('G'.$i)->getValue()!=0){
                
                $total_amount=$sheet->getCell('E'.$i)->getValue()* $sheet->getCell('G'.$i)->getValue();
                $total_amount=number_format($total_amount);
                  
              }
              $modelItem->total_amount=$sheet->getCell('H'.$i)->getValue()!=null?$sheet->getCell('H'.$i)->getValue():$total_amount;
              
              $modelItem->requisition_id= $model1->id;
              $flag=$modelItem->save(false);
                    
                }

             
              
              
              
             /*var_dump("DES :".$sheet->getCell('B'.$i)->getValue() ." SPECS : ".$sheet->getCell('C'.$i)->getValue()." UOM :"
             .$sheet->getCell('D'.$i)->getValue()." QTY :".$sheet->getCell('E'.$i)->getValue()." BCODE :".$sheet->getCell('F'.$i)->getValue()." UP :"
             .$sheet->getCell('G'.$i)->getValue()." TOT :".$sheet->getCell('H'.$i)->getValue());*/
            
             
          
            }  
            
            
                  
                      
                  }else{
                 
                 
                 $oldIDs = ArrayHelper::map($modelsRequisitionItems, 'id', 'id');
                 $modelsRequisitionItems= Model::createMultiple(ErpRequisitionItems::classname(), $modelsRequisitionItems);
                 Model::loadMultiple($modelsRequisitionItems , Yii::$app->request->post()); 
                 $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsRequisitionItems, 'id', 'id')));
                
                  
  //---------------------------------check items------------------------------------------------------               
                 if(!empty($modelsRequisitionItems)){
                 
                     
                     if (!empty($deletedIDs)) {
                        ErpRequisitionItems::deleteAll(['id' => $deletedIDs]);
                    }
                   
                   
                    $transaction = \Yii::$app->db->beginTransaction();
                try {
                    
                     
                        foreach ($modelsRequisitionItems as $modelItem) {
                           
                                  
                                  if($modelItem!=new ErpRequisitionItems()){
                               
                             $modelItem->requisition_id =$model1->id ;
                             $modelItem->user=Yii::$app->user->identity->user_id;
                            
                            if (! ($flag = $modelItem->save(false))) {
                                $transaction->rollBack();
                               
                                Yii::$app->session->setFlash('failure',Html::errorSummary($item));  
              return $this->render('_form',['mParams'=>$mParams]);
                            }
                        }
                    
                }
                   //die(); 
                   
                    if ($flag) {
                        $transaction->commit();
                      
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
                
             }
             
             }
        //----------------------------Requisition--supporting doc----------------------------------------------

           if(isset($_POST['ErpRequisitionAttachement'])){
               
              $post= $_POST['ErpRequisitionAttachement'];
              $model2->attach_files = UploadedFile::getInstances($model2, 'attach_files');
              
             
                   
                    if(!empty( $model2->attach_files)){
                 
                
                     
                     
                     $files=$model2->attach_files;
                 
                
                 
                 foreach($files as $file){
                     
                
                 $exponent = 3; // Amount of digits
 $min = pow(10,$exponent);
 $max = pow(10,$exponent+1)-1;
 //1
 $value = rand($min, $max);
 $unification= date("Ymdhms")."".$value;
  
   $temp= explode(".",   $file->name);
   $ext = end($temp);
   $path_to_attach='uploads/pr/attachements/'. $unification.".{$ext}";
    
   
   
                 $attModel=new ErpRequisitionAttachement();
                 $attModel->attach_name=$file->name;
                 $attModel->created_by=Yii::$app->user->identity->user_id;
                 $attModel->pr_id=$model1->id;
                 $attModel->attach_upload=$path_to_attach ;
                  
                  if(! $flag=$attModel->save(false)){
                     
               Yii::$app->session->setFlash('failure',Html::errorSummary($attModel));  
                   
               return $this->render('_form',['mParams'=>$mParams]);
                   
                  }  
                 
               $file->saveAs( $path_to_attach);   
                     
                 }
                 
              
                 
             }
            
               
        
             
            }        
                
    //------------------------------------------------------------error saving reqisition--------------------------------------                
             }else{
                
                 Yii::$app->session->setFlash('failure',Html::errorSummary($model1));  
                   
             return $this->render('_form',['mParams'=>$mParams]);
            
               
           }
           

             
         }
         
       
  }//-------------------------------end type pr-------------------------------------------------------
          
          
           else if($categ->categ_code=='RFP')
          {
                 
                 if(isset($_POST['ErpRequestPayment'])){
                          $model3->attributes=$_POST['ErpRequestPayment'];
                          $model3->memo=$model->id;
                          $model3->save(false);
                 }
          }
          
         Yii::$app->session->setFlash('success',"Memo updated Successfully !");
        
         if($model->status=='drafting'){
             
            return $this->redirect(['drafts']);  
         }else{
             
              return $this->redirect(['pending']);  
         }
           
        
       
       
      
       }//-------------------------------------------end memo save--------------------------------
       else{
           
          Yii::$app->session->setFlash('failure',"Memo could not be saved  !"); 
           
           
         }
       
           
           
           
       }

         return $this->render('_form',['id'=>$id,'mParams'=>$mParams]); 
    }

    /**
     * Deletes an existing ErpMemo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
       $flag=$this->findModel($id)->delete();
       
       if($flag){
       Yii::$app->session->setFlash('success',"Memo has been deleted!");    
           
       }else{Yii::$app->session->setFlash('failure',"Memo could not be deleted!");}
        
        
        return $this->redirect(['drafts']);
    }

    /**
     * Finds the ErpMemo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ErpMemo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ErpMemo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    /*
     public function beforeAction($action){
       

    if ($formTokenValue = \Yii::$app->request->post('_csrf-frontend')) {
        $sessionTokenValue = \Yii::$app->session->get('form_token_param');

        if ($formTokenValue != $sessionTokenValue ) {
            throw new \yii\web\HttpException(400, 'The form has already been submitted!.');
        }

        \Yii::$app->session->remove('form_token_param');
    }

    return parent::beforeAction($action);
        
       
        
    }*/
}
