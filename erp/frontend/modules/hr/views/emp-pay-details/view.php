<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;
use frontend\modules\hr\models\PayStructureEarnings;
use frontend\modules\hr\models\PayStructureDeductions;
use frontend\modules\hr\models\PayItems;
use frontend\modules\hr\models\EmpAdditionalPay;
use frontend\modules\hr\models\EmpPayOverrides;
use frontend\modules\hr\models\EmpPayDetails;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmpPayDetails */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Employee Pay Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<style>
    .not-active td{
     background-color: #EBEBE4;    
    }
    
</style>

<?php


if(Yii::$app->session->hasFlash('success')){
  Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
   
    
}

if(Yii::$app->session->hasFlash('error')){
  Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));
    
}

?>
    
    
<div class="card card-default">
         
          <div class="card-body">
              
         <?php
               $emp=$model->payEmployee;
               $payGrade=$model->payLevel;
               $payGrp=$model->payGroup;
               
               $payFr= $payGrp->frequency0;
               $payTmpl=$payGrp->payTemplate;
              
              
              
              
             
                //--------------------regular earnings--------------------------------
                $modelsEarnings =$payTmpl->earningsLines();
                
                //--------------------regular deductions--------------------------------
                 $modelsDeduction =$payTmpl->deductionsLines();
               
               
               
         $attributes = [
   
    [
        'columns' => [
            [
                'attribute'=>'first_name', 
                'label'=>'First Name',
                'value'=>$emp->first_name,
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:30%']
            ],
            
             [
                'attribute'=>'last_name', 
                'label'=>'Last Name',
                'value'=>$emp->last_name,
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:30%']
            ],
           
        ],
    ],
    [
        
     'columns' => [
            [
                'attribute'=>'org_unit', 
                'label'=>'Department/Unit/Office',
                'value'=>$emp->employmentDetails->orgUnitDetails->unit_name,
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:30%']
            ],
            
             [
                'attribute'=>'postion', 
                'label'=>'Position',
                'value'=>$emp->employmentDetails->positionDetails->position,
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:30%']
            ],
           
        ],   
        
        
        
        ],
    
     [
        'columns' => [
            [
                'attribute'=>'base_pay', 
                'label'=>'Basic Pay',
                 'format' => 'html',
                 'value'=>'<b><span style="font-size:14px" class="badge badge-info ">'.$model->base_pay.'</span></b>',
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:30%']
            ],
            [
                'attribute'=>'pay_grade', 
                 'label'=>'Pay Level',
                'value'=>$payGrade->name,
                'valueColOptions'=>['style'=>'width:30%'], 
                'displayOnly'=>true
            ],
        ],
    ],
   [
        'columns' => [
            [
                'attribute'=>'pay_group', 
                'label'=>'Payroll Group',
                'value'=>$payGrp->name,
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:30%']
            ],
            [
                'attribute'=>'pay_tmpl', 
                'label'=>'Pay Template',
                'value'=>$payTmpl->name,
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:79%']
            ],
            
        ],
    ],
    [
       'columns'=>[
          [
                'attribute'=>'pay_basis', 
                 'label'=>'Pay Basis',
                'value'=>$model->pay_basis,
                'valueColOptions'=>['style'=>'width:30%'], 
                'displayOnly'=>true
            ],
           [
                'attribute'=>'pay_frequency', 
                 'label'=>'Pay Frequency',
                'value'=>$payFr->name,
                'valueColOptions'=>['style'=>'width:30%'], 
                'displayOnly'=>true
            ],
           
           
           ] 
        
        
        ] 
 
];

// View file rendering the widget
echo DetailView::widget([
    'model' => $model,
    'attributes' => $attributes,
    'mode' => 'view',
    'bordered' =>true,
    'striped' => true,
    'condensed' =>true,
    'responsive' => true,
    'hover' => false,
    'hAlign'=>'right',
    'vAlign'=>'middle',
   
   
   
]);
         ?>
  <div class="card">
      
         <div class="card-body">
            
         
            <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="custom-content-above-reg-tab" data-toggle="pill" 
                href="#custom-content-above-reg" role="tab" aria-controls="custom-content-above-reg" aria-selected="true">
                   <i class="fas fa-coins"></i> Regular Pay</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-content-above-suppl-tab" data-toggle="pill" href="#custom-content-above-suppl" 
                role="tab" aria-controls="custom-content-above-suppl" aria-selected="false"><i class="fas fa-coins"></i> Supplemental Pay </a>
              </li>
             </ul>   
            
             <div class="tab-content" id="custom-content-above-tabContent">
            
              <div class="tab-pane fade active show" id="custom-content-above-reg" role="tabpanel" aria-labelledby="custom-content-above-reg-tab">
          
   
     <div class="table-responsive">
                  <table id="tbl-ed"  class="table">
                    <thead>
                    <tr>
                    <th width="20%"><i class="fas fa-cog"></i> </th>
                      <th>Pay Name</th>
                       <th>Pay Formula</th>
                         <th>Pay Amount</th>
                   
                    </tr>
                    
                    </thead>
                    <tbody>
                    <tr>
                        <td class=" text-muted" colspan="4"><b><i class="ionicons ion-ios-plus-outline"></i> Earnings</b></td>
                        <?php for($i=1 ;$i<4;$i++){ ?>
                        <td style="display: none;"></td>
                        <?php }?>
                        </tr>      
                    <?php foreach($modelsEarnings as $eLine):  ?> 
                    <?php
                  
                    $payItem=$eLine->payItem;
                    $exemption=$eLine->payExclusion($model->id);
                    $exempted=!empty($exemption) ? true : false;
                    $override=$eLine->payOverride($model->id) 
                     
                    ?>
                    <tr class="<?php if($exempted){echo'not-active';}?>">
                    <td> 
                  <?php $data=array("pay_id"=>$model->id,"tmpl"=>$payTmpl->id,"tmpl_line"=>$eLine->id )?> 
                  <input type="checkbox" name="my-checkbox" data-params='<?php echo json_encode($data) ?>'  data-url=<?=Url::to(['pay-templates/pay-exclude'])?>
                   data-bootstrap-switch data-off-color="danger" data-on-color="success" <?php echo $exempted ?'': 'checked' ;?> >
                  
                  <?=Html::a('<i class="fas fa-pencil-alt"></i>', !empty($override)?  Url::to(['emp-pay-overrides/update','id'=>$override->id]):
                     Url::to(['emp-pay-overrides/create','tmpl'=>$payTmpl->id,'id'=>$eLine->id,'emp_pay'=>$model->id]), 
                     ['class'=>['text-sm text-info pl-2 action-modal'],
                            'title' => Yii::t('app', 'Override')
                        ]);?>  
                    
                  </td>   
                    <td><?= sprintf("%s (%s)",$payItem->name,$payItem->code)?></td>
                    
                   
                    
                     <td><?=
                     $eLine->formula; ?>
                     </td>
                    
                     <td class="font-weight-bold"><?php 
                  $amount= ($eLine->payItem->category=='BASE') ? decimalFormat($model->base_pay) : decimalFormat($eLine->payAmount($model->id));
                    echo number_format($amount);
                     ?>
                     </td>
                     
                      </tr>
                      <?php endforeach ?>
                      
                      <!----------------------------deductions------------------------------------------->
                      <tr>
                        <td colspan="4" class="text-muted"><b><i class="ionicons ion-ios-minus-outline"></i> Deductions</b></td>
                      <?php for($i=1 ;$i<4;$i++){ ?>
                        <td style="display: none;"></td>
                        <?php }?>
                   
                    </tr>      
                    <?php foreach( $modelsDeduction as $dLine):  ?> 
                    <?php 
                   
                    $payItem=$dLine->payItem;
                    $exemption=$dLine->payExclusion($model->id);
                    $exempted=!empty($exemption) ? true : false;
                    $override=$dLine->payOverride($model->id)
                       
                    ?>
                    <tr class="<?php if($exempted){echo'not-active';} ?>">
                     <td>
                         <?php $data=array("pay_id"=>$model->id,"tmpl"=>$payTmpl->id,"tmpl_line"=>$dLine->id) ?> 
                  <input type="checkbox" name="reg-exempt" data-params='<?php echo json_encode($data) ?>' data-url=<?=Url::to(['pay-templates/pay-exclude'])?> 
                   data-bootstrap-switch data-off-color="danger" data-on-color="success" <?php echo $exempted ? '':'checked' ?> > 
                  <?=
                  Html::a('<i class="fas fa-pencil-alt"></i>', !empty($override)?  Url::to(['emp-pay-overrides/update','id'=>$override->id]):
                     Url::to(['emp-pay-overrides/create','tmpl'=>$payTmpl->id,'id'=>$dLine->id,'emp_pay'=>$model->id]), 
                     ['class'=>['text-sm text-info pl-2 action-modal'],
                            'title' => Yii::t('app', 'Override')
                        ]);
                  ?> 
                   
                    </td>  
                    <td><?= sprintf("%s (%s)",$payItem->name,$payItem->code)?></td>
                  
                  
                    <td>
                     <?= $dLine->formula ?>
                     </td>
                    
                     <td class="font-weight-bold"><?php 
                      $amount=decimalFormat($dLine->payAmount($model->id));
                    
                     echo number_format($amount);  
                      
                      ?>
                     </td>
                     
                       
                      </tr>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                </div> 
          
              </div>
              <div class="tab-pane fade" id="custom-content-above-suppl" role="tabpanel" aria-labelledby="custom-content-above-suppl-tab">
              
                <div class="d-flex  flex-sm-row flex-column  justify-content-start mt-2">
  
     <p>
        <?= Html::a('<i class="fas fa-plus"></i> Supplemental Pay', ['emp-pay-supplements/create','emp'=>$emp->id], 
        ['class' => 'btn btn-outline-success btn-sm  action-modal','title'=>'Add Pay Supplement']) ?>
    </p>  
    
   
       
   </div> 
             
         <div class="table-responsive">
                  <table id="tbl-suppl"  class="table">
                    <thead>
                    <tr>
                 
                      <th>Pay Name</th>
                      <th>Pay Amount</th>
                      <th>Pay Group</th>
                      
                    </tr>
                    
                    </thead>
                    <tbody>
                      
                    <?php foreach($emp->paySupplements  as $suppl):  ?> 
                
                    <tr>
                    
                    <td><?php
                    
                    
                     echo sprintf("%s (%s)",$suppl->supplType->name,$suppl->supplType->code)." ".
                        Html::a('<i class="fas fa-pencil-alt"></i>', Url::to(['emp-pay-supplements/update','id'=>$suppl->id]), 
                     ['class'=>['text-sm text-info action-modal'],
                            'title' => Yii::t('app', 'Update')
                        ]); ;
                    
                    
                    ?>
                    
                    
                    
                    </td>
                    
                 
                    
                     <td><?php 
                   
                    
                    echo number_format(decimalFormat($suppl->amount));
                     ?>
                     </td>
                     
                     <td><?php 
                   
                    
                    echo $suppl->payGroup0->name
                     ?>
                     </td>
                      
                      </tr>
                      <?php endforeach ?>
                      
                     
                    </tbody>
                  </table>
                </div>        
                 
              </div>
             
            </div>
        
       
        </div>
      
      </div>       
  
 
       
           
         
</div>
</div>

          <?php

function decimalFormat($amount){
    
 return   filter_var($amount, FILTER_SANITIZE_NUMBER_FLOAT,
FILTER_FLAG_ALLOW_FRACTION);
}         

$exemptUrl=Url::to(['pay-templates/pay-exclude']);

$script = <<< JS

$(document).ready(function()
                            {
      $('.btn-add-item').on('click',function () {   
        
        $("#form-add-item").submit();
       

});


         $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });
                       
       $('a[data-toggle="pill"]').on('shown.bs.tab', function(e) {
    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });
});                         
                                
        const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
                        
                                
      
    
  $('input[data-bootstrap-switch]').bootstrapSwitch('onSwitchChange',function (e,state) {
       $(this).bootstrapSwitch('state',!state,true);
       
       //-------------create json obj from string------------------
       var data = JSON.parse($(this).attr('data-params'));
           data.state=Number(state);
           
       var text=''; 
       
       if(!state){
           text+=data.item+" "+"will be excluded from employee pay!"}
           else{
              text+=data.item+" "+"will be included  in employee pay!"}
     Swal.fire({
  title: 'Are you sure?',
  text: text,
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText:'Yes, Confirm'
}).then((result) => {
  if (result.value) {
    $(this).bootstrapSwitch('toggleState',true);
    $.ajax({
    url: '$exemptUrl',
    dataType: 'json',
    type: 'post',
    contentType: 'application/json',
    data: JSON.stringify(data),
    processData: false,
    success: function( res, textStatus, jQxhr ){
       
 
        if(res.status==1){
        toastr.success(res.data.msg) 
    }else{
     
         $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Error',
        subtitle: 'Unable to process your request',
         body: res.data.error
      })   
        
    }  
        
    
  
    },
    error: function( jqXhr, textStatus, errorThrown ){
            $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Error',
        subtitle: 'Unable to process your request !',
         body: errorThrown
      })
    }
});
    
  }else{
      
        $(this).bootstrapSwitch('state',!state);
  }
})  
    
  
})  
 
 
 //--------------pay remove---------------------------------------------------------
 $('.pay-remove').click(function(e){
  
  Swal.fire({
  title: 'Are you sure?',
  text: 'You want to remove it from employee pay ?',
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText:'Yes, Confirm'
}).then((result) => {
  if (result.value) {
    
    $('#pay-remove-form').submit();
    
  }
})  
     
 });
  
});

JS;
$this->registerJs($script);

?>


