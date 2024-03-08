<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use frontend\modules\hr\models\EmployeeDocsCategories;

$category= EmployeeDocsCategories::findOne(["code"=>$code]);
$this->title = 'My '.$category->name." Documents";
//$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    
    .grid-view td {
     white-space: nowrap;
}
</style>

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

                 <div class="card card-default ">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-database"></i><?= Html::encode($this->title) ?> </h3>
                       </div>
               
           <div class="card-body">

<div class="d-flex  flex-sm-row flex-column  justify-content-between">
     <h1><?= Html::encode($this->title) ?></h1>
  </div>

   <div class="table-responsive">
                  <table id="tbl-payroll"  class=" table table-bordered">
                    <thead>
                    <tr>
                        <th width="25%"><i class="fas fa-cog"></i> </th>
                        <th>Name</th>
                        <th>File Name</th>
                        <th>Status</th>
                      </tr>
                    
                    </thead>
                    <tbody>
                      
                    <?php foreach($dataProvider->getModels() as $model):  ?> 
                   
                    <tr>
                    
                    <td>
                    <div class="margin">
                      <div class="btn-group">
                       <?= Html::a('<i class="fas fa-binoculars"></i> Open',Url::to(['emp-documents/pdf','id'=>$model->id]), [
                             'class'=>['btn btn-primary btn-flat text-light action-view'],
                             'title' => Yii::t('app', $model->file_name)
                        ]); ?>
                      </div>
                  </div> 
                    </div>
                  </td>   
                    <td><?=$model->document ?></td>
                    <td><?=$model->file_name ?></td>
                     <td><?php
                       switch($model->status){
                        case 'draft' :{
                            $class="badge bg-danger";
                            break;
                        }
                       case 'completed' :{
                            $class="badge bg-success";
                            break;
                        }
                        case 'approved' :{
                            $class="badge bg-success";
                            break;
                        }
                        case 'rejected' :{
                            $class="badge bg-danger";
                            break;
                        }
                        
                        default:
                             $class="badge bg-secondary";
                       }
                    
                     
                     $badge='<small class="'.$class.'" >'. $model->status.'</small> ';
                    
                echo $badge;
                       ?></td>
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
         

$adjustUrl=Url::to(['payrolls/adjust']);

$script = <<< JS

$(document).ready(function()
  
                         {
    $('.table  tbody').on('click','.btn-action-generate',function () {   
        
        $("#payroll-generate-form").submit();
       

}); 

 $("#payroll-generate-form").on('beforeSubmit',function(event) {
             Swal.showLoading(); 
            event.preventDefault(); // stopping submitting
            var data = $(this).serializeArray();
            var url = $(this).attr('action');
            
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                 data: data,
                 beforeSend: function( xhr ) {
     var swal=Swal.fire({
                title: 'Please Wait !',
                html: 'Payroll generating...',// add html attribute if you want or remove
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
            });  
  }
            })
            .done(function(res) {
                   console.log(res);
     swal.close();
   
     if(res.success){
         
         toastr.success(res.data.msg)  
         
        window.location.href="{$adjustUrl}?id="+res.data.id;
            
        }else{
           
             $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Error',
        subtitle: 'Unable to generate payroll !',
         body: res.data.msg
      })
            
          }
            })
            .fail(function(jqXHR, textStatus, error) {
   console.log(error);
  });
      return false;  
        });
   

  
  
                             
                                
});

JS;
$this->registerJs($script);

?>


