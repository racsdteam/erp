<?php

use yii\helpers\Html;
use yii\helpers\Url;
//use yii\widgets\ActiveForm;
use yii\bootstrap4\ActiveForm;
use common\models\User;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use yii\db\Query;

use buttflattery\formwizard\FormWizard;
use common\models\ErpRequisitionType;
use dosamigos\tinymce\TinyMce;
use common\models\ErpMemoCateg;
use common\models\ErpMemo;
use common\models\ErpMemoSupportingDocType;
use common\models\ErpMemoSupportingDoc;
use common\models\ErpRequisitionAttachement;
use frontend\assets\SmartWizardAsset;
SmartWizardAsset::register($this); 
use common\models\ErpRequisitionItems;
use common\components\Constants;
?>


<style>


btn.kv-file-upload{display:none;} 

btn.excel-upload{display:none;}

.btn-cancel{display:none;} 


.req-items{
	display:none;
}



#items tr td .total_one,.TotalCell{background-color:#ffd9b3;font-family:"Lucida Console", Monaco, monospace, sans-serif;font-weight:bold;}
#items tr td.TotalCell{font-family:"Arial Black", Gadget, sans-serif}


</style>


<!-- -------------------Memo model3ory--------------------------------------->
<?php

extract($mParams);

if(isset($categ)){
 
 $mcateg=ErpMemoCateg::find()->where(['categ_code'=>$categ])->one();   
 $mcategName=$mcateg->categ;
}




?>

<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default ">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fa fa-file-o"></i> Memo Category : <?= $mcategName ?></h3>
                       </div>
               
           <div class="card-body">

 <?php if($model->hasErrors()) :?>
            
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i></h4>
               <?= Html::errorSummary($model, ['encode' => false]) ?>
              </div>
            
            <?php endif?>
            
                  
<?php  
  $user=Yii::$app->user->identity;
  
  ?>

   <?php if (Yii::$app->session->hasFlash('success')){

$msg=  Yii::$app->session->getFlash('success');

  echo '<script type="text/javascript">';
  echo 'showSuccessMessage("'.$msg.'");';
  echo '</script>';
  

   }
 
  ?>

 <?php if (Yii::$app->session->hasFlash('error')){

$msg=  Yii::$app->session->getFlash('error');

  echo '<script type="text/javascript">';
  echo 'showErrorMessage("'.$msg.'");';
  echo '</script>';
  

   }
 
  ?>


<?php $form = ActiveForm::begin([
                                'options' => ['enctype' => 'multipart/form-data', 'data-toggle'=>'validator'],
                                'id'=>'dynamic-form', 
                                 'action' => ['erp-memo/update?id='.$id],
                               'enableClientValidation'=>true,
                               'enableAjaxValidation' => false,
                               'method' => 'post',
                              
                               ]); ?>

       <div id="smartwizard">
            
            
            <ul class="nav">
                
                 <li><a class="nav-link" href="#step-1">Page 1<br /><small>Add Memo Details </small></a></li>
                 
                <?php if($categ==Constants::MEMO_TYPE_PR) : ?>
               
               
                <li><a class="nav-link" href="#step-2">Page 2<br /><small>Add Requisition Details</small></a></li>
                <li><a class="nav-link"  href="#step-3">Page 3<br /><small>Add  Requisition Items</small></a></li>
                <li><a class="nav-link" href="#step-4">Page 4<br /><small>Requisition Support.Doc(s)</small></a></li>
                
                <?php else: ?>
                 
               <li><a class="nav-link" href="#step-2">Page 2<br /><small>Add Memo Support.Doc(s)</small></a></li>
                 
               <?php endif ;?> 
                
                
                
               
            </ul>

            <div class="tab-content">
                
              
                
                <div id="step-1" class="tab-pane" role="tabpanel">
                   
                    <h2>Add Memo Details</h2>
           
 
      <?= $form->field($model, 'type')->hiddenInput(['value'=>$mcateg->id])->label(false); ?>
 
 
   <?php if($categ==Constants::MEMO_TYPE_RFP) : ?>
    
     <label> Invoice Document CODE/ Invoice Title</label>
          <select class="form-control m-select2" style="width: 100%;" name="ErpRequestPayment[invoice]" data-validation="required">
                <?php
                
  $query = new Query;
                                     $query	->select(['doc.*' ])
                                     ->from('erp_document as doc ')
                                     ->where(['type' => 22])
                                     ->orderBy([ 'doc.timestamp' => SORT_DESC]);
                                     $command = $query->createCommand();
                                     $rows22= $command->queryAll(); 


                foreach($rows22 as $row22): 
                $q222 = new Query;
              $q222->select(['p.*'])
              ->from('erp_request_payment as p')
              ->where(['p.invoice' =>$row22['id']]);
              $command222 = $q222->createCommand();
                  $row222= $command222->queryAll();
               if(empty($row222)) 
               {
                ?> 
                <option value="<?= $row22['id'] ?>"><?= $row22['doc_code']." / ".$row22['doc_title'] ?> </option>
                 <?php
                 }
                 endforeach;?>
          </select>
   
   <?php endif;?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label('Title/Subject') ?>
   
              
             

    
<?= $form->field($model, 'description')->widget(TinyMce::className(), [
    'options' => ['rows' => 18],
    'language' => 'en',
    'clientOptions' => [
        'plugins' => [
            "advlist autolink lists link charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste"
        ],
        'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
    ]
]);?>    

  <?= $form->field($model, 'expiration_date', ['template' => '
                         {label} 
                       <div class="input-group col-sm-12">
                        <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                    <i class="fas fa-calendar"></i>
                                </span>
                                
                                </div>
                     
                         {input}
                         
                           
                       </div>{error}{hint}
               '])->textInput(['maxlength' => false,'class'=>['form-control date'],'placeholder'=>'Expiration date...'])->label("Expiration Date")?> 
            
              

                </div>
   
   
   <!-- ---------------------------------------step 2--------------------------------------------------------------------->             
                <div id="step-2" class="tab-pane" role="tabpanel">
                    
                    <?php if($categ==Constants::MEMO_TYPE_PR) : ?>
                    
                   
                    <h2>Purchase Requisition Details</h2>
                     <div class="form-group"> 
                    
                   
<?php $items=ArrayHelper::map(ErpRequisitionType::find()->all(), 'id', 'type');
$currency_types=["Rwfrs"=>"Rwandan Francs","$" => "USD"];
?>
                    <?= $form->field($model1, 'type')
        ->dropDownList(
            $items,           // Flat array ('id'=>'label')
            ['prompt'=>'Select type...','class'=>['form-control m-select2']]    // options
        )->label('Requisition Type')?>
                   
        </div>  
        
        

                <?= $form->field($model1, 'title')->textInput(['maxlength' => true,'class'=>['form-control','placeholder'=>'Requisition Title...']]) ?>
            

                 <?= $form->field($model1, 'currency_type')
        ->dropDownList(
            $currency_types,
            ['prompt'=>'Select...','class'=>['form-control m-select2']]    // options
        )?>

  
  <?php 
  $items =["1"=>"Yes","0"=>"No"];
  
  $model1->choice=1;
  $items2=['1'=>'Add Items','2'=>'import from Excel'];
  ?>
                   
                  <?php echo $form->field($model1, 'is_tender_on_proc_plan')->inline(true)->radioList($items);?>         
 
 
               
                    <?php else : ?>
                       
            
                    <h2>Add Supporting Document(s)</h2>
                    
                    <?php
                    
                        $preview=array();
                        $config_prev=array();
                        
                    
                    if(!$model->isNewRecord){
                        
                     $docs=ErpMemoSupportingDoc::find()->where(['memo'=>$model->id])->all(); 
                     
                     if(!empty($docs)){
                         
                         foreach($docs as $doc){
                             
                             $preview[]=Yii::$app->request->baseUrl."/".$doc->doc_upload;
                             $config=(object)['type'=>"pdf",  'caption'=>$doc->doc_name, 'key'=>$doc->id ,
                             'url' => \yii\helpers\Url::toRoute(['erp-memo-supporting-doc/delete','id'=>$doc->id]),
                             'downloadUrl'=>Yii::$app->request->baseUrl."/".$doc->doc_upload];
                             $config_prev[]=$config;
                         }
                     }
                        
                    }
                   
                    
                    ?>
                    
                     <?= $form->field($model0, 'doc_uploaded_files[]')->widget(FileInput::classname(), [
                                                 'options' => ['accept' => 'file/*','multiple'=>true,'id'=>'input-id'],
                                                 'pluginOptions'=>['allowedFileExtensions'=>['pdf','jpg'],'showUpload' => false,
                                                  'uploadUrl' => '/erp-memo-supporting-doc/create',
                                                   'initialPreview'=>!empty($preview)?$preview:[],
                                                   'overwriteInitial'=>false,
                                                   'initialPreviewAsData'=>true,
                                                   'initialPreviewFileType'=>'image',
                                                   'initialPreviewConfig'=>$config_prev,
                                                   'purifyHtml'=>true,
                                                   'uploadAsync'=>false,
                                                  
  ],     
                                                
                                                                                    
  ])?>
                     
           
                    <?php endif;?>
                
                 </div>
              
                
                
                         <div id="step-3" class="tab-pane" role="tabpanel">
                             
                              <?php if($categ==Constants::MEMO_TYPE_PR) : ?>
                             
           <div style="text-align:center"><?php  echo $form->field($model1, 'choice')->inline(true)->radioList($items2,['class'=>'choice'])->label(false);?> </div> 
     
            
            <div id="items-1" class="req-items">
                              
                  
                    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper2', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items2', // required: css class selector
        'widgetItem' => '.item', // required: css class
        'limit' => 500, // the maximum times, an element can be added (default 999)
        'min' => 1, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $modelsRequisitionItems[0],
        'formId' => 'dynamic-form',
        'formFields' => [
           'designation',
            'specs',
           'uom',
            'quantity',
            'unit_price',
            'total_amount',
            'badget_code'
           // 'attach_description'
           
        ],
    ]); ?>
   
    
    <div class="table-responsive">
     <table id="items" style="width:100%" class="table table-bordered table-striped">
        <thead>
            <tr>
               
    <th  style="color:#2196f3;font-weight:bold;" colspan="8" >
        
   <h4 style="display:inline;" ><i class="fa fa-cart-arrow-down"></i> Add Purchase Requisition Items</h4>
    
    </th>
    
   
                
            </tr>
            <tr>
               
                <th  style="width:150px">Item Description</th>
                <th style="width:150px">Specs</th>
                 <th>Unit Of Measure</th>
                  <th>Quantity</th>
                   <th>Badget Code</th>
                   <th style="width:100px">Unit Price</th>
                   <th style="width:120px">Total Price</th>
                    
                <th>
                 <i class="fas fa-cog"></i>
                </th>
            </tr>
        </thead>
        <tbody class="container-items2">
       <?php foreach ($modelsRequisitionItems as $i => $modelRequisitionitem): ?>
            <tr class="item">
                
                
                <td>
                    
                     <?php
                            // necessary for update action.
                            if (! $modelRequisitionitem->isNewRecord) {
                                echo Html::activeHiddenInput($modelRequisitionitem, "[{$i}]id");
                            }
                        ?> 
                 
                 <?= $form->field($modelRequisitionitem, "[{$i}]designation")->textarea(['rows' => '3'])->label(false) ?>
                
                 
                    
                  
                </td>
                <td >
                 <?=  
                 $form->field($modelRequisitionitem, "[{$i}]specs")->textarea(['rows' => '3'])->label(false) 
                              
                 
                 ?> 
                </td>
                
                 <td >
                    
                    <?=  
                 $form->field($modelRequisitionitem, "[{$i}]uom")->textInput(['class'=>['form-control'],'placeholder'=>'UoM...'])->label(false) 
                 
                              
                 
                 ?> 
                </td>
                
                <td >
                    
                    <?=  
                 $form->field($modelRequisitionitem, "[{$i}]quantity")->textInput(
                     ['onchange' => 'getTotal($(this))','onkeyup' => 'getTotal($(this))','class'=>['form-control'],'placeholder'=>'Qt...'])->label(false) 
                              
                 
                 ?> 
                </td>
                
                <td>
                   <?=  
                 $form->field($modelRequisitionitem, "[{$i}]badget_code")->textInput(['class'=>['form-control'],'placeholder'=>'Code...'])->label(false) 
                              
                 
                 ?>  
                    
                </td>
                
                 <td>
                    
                    <?=  
                 $form->field($modelRequisitionitem, "[{$i}]unit_price")->
                 textInput(['onchange' => 'getTotal($(this))','onkeyup' => 'getTotal($(this))',
                 'class'=>'form-control unit_price ','placeholder'=>'UP...'])->label(false) 
                              
                 
                 ?> 
                 </td>
                 
                  <td >
                    
                    <?=  
                 $form->field($modelRequisitionitem, "[{$i}]total_amount")->textInput(['autofocus' => true,
                 'class'=>'form-control total_one ','placeholder'=>'TP...'])->label(false) 
                              
                 
                 ?> 
                </td>
              
                <td class="text-center vcenter">
                    <button type="button" class="remove-item btn btn-danger btn-xs bg-red btn-circle"><span style="font-size:16px;" class="fa fa-minus-circle "></span></button>
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
        
        <tfoot>
    <tr>
       <td style="font-size:18px" align="right" colspan="6"><b>Total Price :</b></td>
      <td  class="TotalCell">0</td>
      <td  class="text-center"><button type="button" class="add-item btn btn-success btn-xs bg-green btn-circle"><span style="font-size:16px;" class="fa fa-plus-circle"></span></button></td>
    </tr>
  </tfoot>
    </table>
   </div> 
    
    <?php DynamicFormWidget::end(); ?>
    
    </div>
    
           
             
     <div  id="items-2" class="row req-items">          
              
  <div class="card-body">
   
    
   <?Php 
    
   
   
echo  $form->field($model1, 'excel_file')->widget(FileInput::classname(), [
                                                 'options' => ['accept' => 'file/*','multiple' => false,'id'=>'input-file'],
                                                 'pluginOptions'=>['allowedFileExtensions'=>[ 'xlsx','xlsx', 'xls',], 'uploadClass' => 'btn btn-info',
                                                 'showUpload' => true,
                                                 'uploadUrl' =>\yii\helpers\Url::toRoute(['erp-requisition-items/excel-upload']),
                                                 'overwriteInitial'=>false,
                                                 'initialPreviewAsData'=>true,
                                                 'initialPreviewFileType'=>'any',
                                                 'initialPreview'=>false
                                               
                                                  
  ],     
                                                
                                                                                    
  ]);





?>
  </div>
             
      </div>
      
      <?php endif;?>
               
                </div>
              
                <div id="step-4" class="tab-pane" role="tabpanel">
                   
                    <?php if($categ==Constants::MEMO_TYPE_PR) : ?>
                   
                  <h3 class="border-bottom border-gray pb-2">Upload Supporting Doc(s) if available</h3>   
                
                    <?php
                    
                    if(!$model1->isNewRecord){
                        
                     $docs1=ErpRequisitionAttachement::find()->where(['pr_id'=>$model1->id])->all(); 
                     $preview1=array();
                        $config_prev1=array();
                     
                     if(!empty($docs1)){
                         
                         foreach($docs1 as $doc1){
                             
                             $preview1[]=Yii::$app->request->baseUrl.'/'.$doc1->attach_upload;
                             $config1=(object)[type=>"pdf",  caption=>$doc1->attach_name, key=>$doc1->id, 
                             'url' => \yii\helpers\Url::toRoute(['erp-requisition-attachement/delete','id'=>$doc1->id])];
                             $config_prev1[]=$config1;
                         }
                     }
                        
                    }
                   
                    
                    ?>
                  
                 
                  
                  
                  <?= $form->field($model2, 'attach_files[]')->widget(FileInput::classname(), [
                                                 'options' => ['accept' => 'file/*','multiple' => true
                                                 
                                                 ],
                                                 'pluginOptions'=>['allowedFileExtensions'=>['pdf','jpg'],
                                                 'showUpload' => false,
                                                 'uploadUrl' => '/erp-requisition-attachement/create',
                                                 'initialPreview'=>!empty($preview1)?$preview1:[],
                                                 'overwriteInitial'=>false,
                                                 'initialPreviewAsData'=>true,
                                                 'initialPreviewFileType'=>'image',
                                                 'initialPreviewConfig' =>$config_prev1,
                                                 'purifyHtml'=>true,
                                                 'uploadAsync'=>false,
                                                  
  ],     
                                                
                    
                    
                    
                                                                                    
  ])?>
  
  <?php endif?>
                </div>
                
                
  
</div><!--end div contnt ---->

</div><!--end div wizard ---->

<?php ActiveForm::end(); ?>

</div>
</div>
</div>
</div>



<?php
$url=Url::to(['erp-persons-in-position/populate-names']);  
$url_excel=Url::to(['erp-requisition-items/excel-import']); 

$t=$model3->categ_code;

$script = <<< JS





function getTotal(item){

var idString=item.attr('id') ;
var arr= idString.split("-"); 
var  id=arr[1];


var price=document.getElementById('erprequisitionitems-'+id+'-unit_price').value;
var quatity=document.getElementById('erprequisitionitems-'+id+'-quantity').value;

/*if(price){
    
    var p=price.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
    document.getElementById('erprequisitionitems-'+id+'-unit_price').value=p;
}*/


if(!price){
  price=0;  
}
if(!quatity){
  quatity=0;  
}

//--------------------remove separator----------------
if(price && price!=0){
//price=price.replace(/([.,])(\d\d\d\D|\d\d\d$)/g,'$2');  
price=price.replace(/,/g, '');
}

var tot=parseInt(price)*parseFloat(quatity);



//-----------add separator------------------
//var tot1=tot.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")

 document.getElementById('erprequisitionitems-'+id+'-total_amount').value=tot;
  
 $('.total_one').number( true);
 
 var sum=0;
 $(".total_one").each(function() {

    var value = $(this).val();
    
    value=value.replace(/,/g, '');
   
    if(!isNaN(value) && value.length != 0) {
        sum += parseInt(value);
    }
   
   
      
});
 

 
 $('#items tr').each(function() {
  
  var tot3=sum.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
  
  $(this).find(".TotalCell").text(tot3); 
    





 });
 
     
}


JS;
$this->registerJs($script,$this::POS_HEAD);



if($model->isNewRecord){
    
    $label='Save';
}else{
    
    $label='Update';
}

$script = <<< JS

 


$(document).ready(function(){

            // Step show event
              $("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
                
         //--------------------------prevent backward validation       
                if(stepDirection=='backward')return true;
    
    data = $("#dynamic-form").data("yiiActiveForm");
$.each(data.attributes, function() {
    this.status = 3;
});
$("#dynamic-form").yiiActiveForm("validate");

 var content=tinymce.activeEditor.getContent({format: 'text'});
 

 if(content.trim()){
   $(".field-erpmemo-description").find(".invalid-feedback").empty(); 
   
   $(".field-erpmemo-description").addClass('has-success') ;   
 }
    var currentstep=stepNumber+1;
    

  
   
   if($("#step-"+currentstep).find(".invalid-feedback").contents().length >0){
            e.preventDefault();
            return false;
        }
        
       
   
    return true;
   
             
            });
            
            
            $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
            
               if(stepPosition === 'first'){
                   $("#prev-btn").addClass('disabled');
               }else if(stepPosition === 'last'){
                   $("#next-btn").addClass('disabled');
               }else{
                   $("#prev-btn").removeClass('disabled');
                   $("#next-btn").removeClass('disabled');
                   
               }
               
               $('.submit').css("display","none") ;
              //------------------------show Save button-------------------------------
              if(stepPosition === 'last')
              {
                 $('.submit').show(); 
            
                  
              }
              else{
                  
                $('.submit').css("display","none") ; 
              }
              
              //-----------------------excel import------------------------
              
               if(stepNumber ===2)
              {
                 $('.excel-import').show(); 
            
                  
              }
              else{
                  
                $('.excel-import').css("display","none") ; 
              }
              
               
            });

            // Toolbar extra buttons
            var btnFinish = $('<button></button>').text('{$label}')
                                             .addClass('btn btn-info submit')
                                             .on('click', function(){ $('#dynamic-form').submit();});
                                             
         
                                             
            var btnCancel = $('<button></button>').text('Cancel')
                                             .addClass('btn btn-danger btn-cancel')
                                             .on('click', function(){ $('#smartwizard').smartWizard("reset"); });
                                             
            var btnExcel = $('<button></button>').text('Import Data From  Excel')
                                             .addClass('btn btn-success excel-import')
                                             .on('click', function(){ 
                                         
                                              $('.collapse').slideToggle('slow'); 
                                            
                                            return false;
                                                 
                                             }); 
                                             
                                        smartWizardConfig.init(0,[btnFinish],theme='arrows',animation='none')
/*         
 $('#smartwizard').smartWizard({
                    selected: 0,
                    theme: 'arrows',
                    justified: true,
                    autoAdjustHeight:false,
                    cycleSteps: false,
                    backButtonSupport: true,
                     enableURLhash:true,
                     transition: {
                         animation: 'none',
                            speed: '400', // Transion animation speed
                             easing:'' // Transition animation easing. Not supported without a jQuery easing plugin
  },
                   
     
  anchorSettings: {
      anchorClickable: true, // Enable/Disable anchor navigation
      enableAllAnchors: false, // Activates all anchors clickable all times
      markDoneStep: true, // Add done css
      markAllPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
      removeDoneStepOnNavigateBack: false, // While navigate back done step after active step will be cleared
      enableAnchorOnDoneStep: true // Enable/Disable the done steps navigation
  },
                    toolbarSettings: {toolbarPosition: 'both',
                                      toolbarButtonPosition: 'right',
                                      toolbarExtraButtons: [btnFinish]
                                    },
                                   contentURL:null,
                                   ajaxType: 'POST',
                                   contentCache:false,
            });
 */


            // External Button Events
            $("#reset-btn").on("click", function() {
                // Reset wizard
                $('#smartwizard').smartWizard("reset");
                return true;
            });

            $("#prev-btn").on("click", function() {
                // Navigate previous
                $('#smartwizard').smartWizard("prev");
                return true;
            });

            $("#next-btn").on("click", function() {
                // Navigate next
                /*$('#smartwizard').smartWizard("next");
                return true;*/
                
                alert();
            });

            $("#theme_selector").on("change", function() {
                // Change theme
                $('#smartwizard').smartWizard("theme", $(this).val());
                return true;
            });

            // Set selected theme on page refresh
            $("#theme_selector").change();
       
       
       
   

//-----------====================initilize select=-------------------------------------------------------


 $(function () {
    //Initialize Select2 Elements
   $(".m-select2").select2({width:'100%',theme: 'bootstrap4'});
   
 });
     
       
       
       
 //-----------------------------------requisition select events--------------------------------------------------      
       
 
 //-------------------------=========initialize dates and time widgets================--------------------------------------  
   	    
			$('.date').bootstrapMaterialDatePicker
			({
				time: false,
				clearButton: true
			});

			$('.time').bootstrapMaterialDatePicker
			({
				date: false,
				shortTime: false,
				format: 'HH:mm'
			});

   

//-----------------register input for automatic thousand separator----------------   
 
 
 $('.unit_price').number( true);
 
      
    
    var sum=0;
 $(".total_one").each(function() {

    var value = $(this).val();
    
    value=value.replace(/,/g, '');
   
    if(!isNaN(value) && value.length != 0) {
        sum += parseInt(value);
    }
   
   
      
});
 

 
 $('#items tr').each(function() {
  
  var tot3=sum.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
  
  $(this).find(".TotalCell").text(tot3); 
    

 });
 
 var radioValue = $("input[type='radio']:checked").val();
            if(radioValue){
               $("#items-"+radioValue).show(); 
               console.log(radioValue);
            }
       
       var radioValue = $("input[name='ErpRequisition[choice]']:checked").val();
            if(radioValue){
               $("#items-"+radioValue).show(); 
              
            }     
           
 
       
        });

 
 
 
 $('.import-from-excel').on('click', function (e) {
    $('.collapse').slideToggle('slow'); 
    
  e.preventDefault();
   e.stopPropagation(); 
 
  return false;
     
       
   
 });
 
 
 
 $("#input-file").on('fileuploadsuccess', function(event, data) {
        var out = '';
        $.each(data.files, function(key, file) {
            var fname = file.name;
            out = out + '<li>' + 'Uploaded file # ' + (key + 1) + ' - '  +  fname + ' successfully.' + '</li>';
        });
        $('#kv-success-2 ul').append(out);
        $('#kv-success-2').fadeIn('slow');
    });
 
 
 
$('#input-file').on('fileuploaded', function(e, data, previewId, index) {
    var form = data.form, files = data.files, extra = data.extra,
        response = data.response, reader = data.reader;
         
       var d=$.get('{$url_excel}').done(function (data) {
               
               for(var i=0;i<data.length;i++){
                     
                     
                     setTimeout(function(){ $( ".add-item" ).trigger( "click" );}, 
                     3000);
                     
                    
               }
              

        })

        .fail(function () {

            console.log("Ajax fail: ");

        });
        
       
       
       
       
   
  
    
});
 
$('#input-file').on('fileuploaderror', function(event, data, msg) {
    console.log('File uploaded', data.previewId, data.index, data.fileId, msg);
});



$('input[name="ErpRequisition[choice]"]').click(function(){
    
    	var value = $(this).val(); 
    
        $("div.req-items").hide();
        $("#items-"+value).show();
    });

JS;
$this->registerJs($script);

?>