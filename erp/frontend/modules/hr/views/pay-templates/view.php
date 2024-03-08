<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\db\Query;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use frontend\modules\hr\models\PayTemplateItems;
use frontend\modules\hr\models\PayItems;
/* @var $this yii\web\View */
/* @var $model frontend\modules\auction\models\Auctions */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Pay Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>


<?php if (Yii::$app->session->hasFlash('success')): ?>
  
  <?php 
  $msg=Yii::$app->session->getFlash('success');

  echo '<script type="text/javascript">';
  echo "Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: '".$msg."',
                 showConfirmButton: false,
                 timer: 1500
                  })";
  echo '</script>';
  
  
  ?>
    <?php endif; ?>

<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

<div class="card card-success card-outline card-tabs">
    
   

 <div class="card-body">
    
    
     <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table table-striped table-bordered detail-view dataTable'],
        'attributes' => [
            
           // 'id',
            'name',
            'description:ntext',
        
         
          [
                 'label'=>'Pay Group',
                 'value'=>call_user_func(function ($data) {
                   
                   $groupName=isset($data->empGroup)?$data->empGroup->name:''; 
                  
               
        
                    
                return $groupName;
            }, $model)
                ],
                
                   [
                 'label'=>'Active',
                 'format' => 'raw',
                 'value'=>call_user_func(function ($data) {
                    
         
               if($data->active){$fa='<i class="fas text-success fa-check"></i>';}else{$fa='<i class="fas text-red fa-times"></i>';}
        
                    
                return $fa;
            }, $model)
                ],
           
        ],
    ]) ?>
    
    <?php  
     $lineItems =$model->lineItems;
    
   
   
    ?>
        <div class="card-header with-border">
                            <h3 class="card-title"><i class="fas fa-coins"></i>  <b>Applicable Pay Items</b></h3>
            <div class="card-tools">
                
                 <?= Html::a('<i class="fas fa-sort"></i> Sort Order', ['sort','id'=>$model->id], ['class' => 'btn btn-outline-success btn-md ','title'=>'Sort Order']) ?>
                                        
                                    </div>                
                       </div>        
    <div class="table-responsive">
                  <table class="table">
                    <thead>
                    <tr>
                        <th> <i class="fas fa-cog"></i></th>
                      <th>Pay Item</th>
                       <th>Code</th>
                         <th>Category</th>
                <th>Input Type</th>
                  <th>Formula</th>
                   <th>Default Amount</th>
                    <th>Active</th>
                      <th>Editable</th>
                    <th>Visible</th> 
                    <th>Display Order</th>
                  
                    </tr>
                    
                    </thead>
                    <tbody>
                    <?php if(!empty($lineItems)) foreach($lineItems as $lineItem):  ?> 
                    <?php $payItem=$lineItem->payItem;  ?>
                    <tr>
                        <td nowrap>
                            <?=Html::a('<i class="fas fa-times"></i>', Url::to(['pay-template-items/delete','id'=>$lineItem->id]), ['class'=>['text-danger'],
                            'title' => Yii::t('app', 'Delete'),
                             'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this Pay Item ?'),
                             'data-method'  => 'post',
                             'data-pjax'    => '0',
                        ]);?>
                        
                         <?= Html::a('<i class="fas fa-pencil-alt"></i>', Url::to(['pay-template-items/update','id'=>$lineItem->id]), ['class'=>['text-success action-createx'],
                            'title' => Yii::t('app', 'Update')
                        ]);?>
                        </td>
                    <td><?= $payItem->name?></td>
                    <td witdh="3%" class="text-muted"><?= $payItem->code?></td>
                    <td witdh="3%" class="text-muted"><?= $payItem->category0->name?></td>
                    <td><small class="badge badge-info"><?=$lineItem::$inputType[$lineItem->calc_type]?></small></td>
                    
                     <td nowrap><?= $lineItem->formula?></td>
                      
                      <td><?=number_format($lineItem->amount);?></td>
                  <td><?php if($lineItem->active){ echo 'Yes';}else{ echo 'No';} ?></td>
                    <td><?php if($lineItem->editable){ echo 'Yes';}else{ echo 'No';} ?></td>
                  <td><?php if($lineItem->visible){ echo 'Yes';}else{ echo 'No';} ?></td>
                   <td><?= $lineItem->display_order?></td>
                  
                      </tr>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                </div> 
                
          

          
</div>
</div>
</div>
</div>

<?php
$script = <<< JS

$(document).ready(function()
                            {
         $('.action-launch').on('click',function (e) {
         
 var url=$(this).attr('href');

Swal.fire({
  title: 'Are you sure?',
  text: "This auction will be launched !",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, launch it!'
}).then((result) => {
  if (result.value) {
   $.post( url, function( data ) {
    if(data.flag==true){
        
        Swal.fire(
  'Success!',
  data.msg,
  'success'
)
    }else{
        
      Swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: data.msg,

})  
    }
});
  }
})
    
    return false;

});   


  
             
var oTable= $('.tbl').DataTable({
              
              'columnDefs': [{
                    "targets": [0],
                    "orderable": false
                }]
          });          
          
   


                                
                                
                                
                            });
                          


JS;
$this->registerJs($script);

?>
