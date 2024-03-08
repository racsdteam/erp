
    <?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\db\Query;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $model frontend\modules\auction\models\Auctions */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Emp Terminations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>

<?php 

 if (Yii::$app->session->hasFlash('success')){

         Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
   }
  
 
   if (Yii::$app->session->hasFlash('error')){

         Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));
   } 
  ?>
  

<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

<div class="card card-success card-outline card-tabs">
    
   

 <div class="card-body">
    
    
     <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table table-striped table-bordered detail-view dataTable'],
        'attributes' => [
            
       
          [
                 'label'=>'Employee',
                 'value'=>call_user_func(function ($data) {
                   
                  $emp=$data->employee0;
                  return  $emp!==null? $emp->first_name.' '.$emp->last_name: '';
            }, $model)
                ],
                
            [
                 'label'=>'Termination Date',
                 'value'=>call_user_func(function ($data) {
                   
                  
               return  !empty($data->term_date) ?  date('d/m/Y',strtotime($data->term_date)): '';  
            }, $model)
                ],    
              [
                 'label'=>'Last Date Of Work',
                 'value'=>call_user_func(function ($data) {
                   
                  
                return  !empty($data->last_date) ?  date('d/m/Y',strtotime($data->last_date)): '';  
            }, $model)
                ],
                
            [
                 'label'=>'Termination Reason',
                 'value'=>call_user_func(function ($data) {
                $r=$data->termReason;
                     
                    
                return  $r!==null? $r->name.' ': '';
            }, $model)
                ],    
                
             'term_note:ntext'    
           
           
        ],
    ]) ?>
    
    <?php  
    $attachments =$model->attachments;
    
   
   
    ?>
        <div class="card-header with-border">
                            <h3 class="card-title"><i class="fas fa-book"></i> File Attachments</h3>
                     
                       </div>        
    <div class="table-responsive">
                  <table class="table">
                    <thead>
                    <tr>
                        <th>Attached File(s)</th>
                          <th>Title</th>
                          <th>Category</th>
                     
                       
                 </tr>
                    
                    </thead>
                    <tbody>
                    <?php if(!empty($attachments)) foreach($attachments as $attachment):  ?> 
                  
                    <tr>
                        
                        <td>
                            
                         <?php
                         
                          $icon =Html::tag('i',null,
           ['class'=>"far fa-fw fa-file-pdf text-red "]);       
            
          echo $icon.Html::a( $attachment->fileName,['emp-term-attachments/pdf','id'=>$attachment->id],
           ['class'=>'text-dark action-modal']);
            
                         ?>
                            
                            
                        </td>
                     
                   
                     <td nowrap><?= $attachment->title?></td>
                <td><?= $attachment->category0->name?></td>
                
                  
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


</div>
