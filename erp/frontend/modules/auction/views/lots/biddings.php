<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\db\Query;
use  frontend\modules\auction\models\Bids;
use yii\bootstrap4\ActiveForm;


/* @var $this yii\web\View */
/* @var $model frontend\modules\auction\models\Bids */

$this->title ='LOT '. $model->lot;
$this->params['breadcrumbs'][] = ['label' => 'Biddings Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>


<div class="card">
        <div class="card-header">
          <h3 class="card-title"><span class="text-blue"><i class="fas fa-gavel"></i> <?php echo $data['description'] ?></span> </h3>

        </div>
        <div class="card-body">
          <div class="row">
          
                <div class="col-12 col-sm-3 ">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Total Bidders</span>
                      <span class="info-box-number text-center text-blue mb-0"><?= isset($data['tot_bidders'])?$data['tot_bidders'] : 0 ?></span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-3">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Total Bids</span>
                      <span class="info-box-number text-center text-blue mb-0"><?= isset($data['tot_bid'])?$data['tot_bid'] : 0 ?></span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-3">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Highest Bid</span>
                      <span class="info-box-number text-center text-blue mb-0"><?= number_format($data['highest_bid']) ?><span>
                    </div>
                  </div>
                </div>
                
                 <div class="col-12 col-sm-3">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                        <?php
                       
       
        $count = Bids::find()->alias('b')
    ->where(['b.item'=>$model->id,'b.selected'=>1])
    ->count();
                        ?>
                      <span class="info-box-text text-center text-muted">Selected Bidders</span>
                      <span class="info-box-number text-center text-blue mb-0"><?=  $count?><span>
                    </div>
                  </div>
                </div>
              </div>
              
                <div class="row mt-5">
          
                <div class="col-12 col-sm-12 ">
                    
                 <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="custom-content-below-home-tab" 
                data-toggle="pill" href="#custom-content-below-home" 
                role="tab" aria-controls="custom-content-below-home" aria-selected="true"><i class="fas fa-users"></i> Bidders List</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#custom-content-below-profile"
                role="tab" aria-controls="custom-content-below-profile" aria-selected="false"><i class="fas fa-clipboard-check"></i> Selected  List</a>
              </li>
             
            </ul>  
            
              <div class="tab-content" id="custom-content-below-tabContent">
              
              <div class="tab-pane fade show active " id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
              
              <div class="table-responsive mt-5">
                <?php $form = ActiveForm::begin([
                                
                                'id'=>'frm-bidders', 
                              
                                'action' => ['selected-bidders-notification/notify'],
                               
                               'method' => 'post',
                               ]); ?>
                
                 <table id="tbl-bidders"  class="table display"  cellspacing="0" width="100%">
   <thead>
      <tr>
         <th></th>
         <th>First Name</th>
         <th>Last Name</th>
         <th>ID Type</th>
         <th>ID No.</th>
         <th>Phone</th>
         <th>Email</th>
         <th>Bid Amount</th>
         <th>Selected</th>
         <th>Bid Time</th>
      </tr>
   </thead>
   
     
      <tfoot>
      <tr>
       
       <td colspan="9">
        
                       
        <?= Html::submitButton('<i class="far fa-bell"></i> Notify Selected', ['class' => 'btn btn-success ']) ?>
   

       </td>
    

      </tr>
   </tfoot>
</table>

         <?php ActiveForm::end(); ?>       
              </div>
              
              </div>
              <div class="tab-pane fade" id="custom-content-below-profile" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">
                  
              <div class="table-responsive mt-5">
                <?php $form = ActiveForm::begin([
                                
                                'id'=>'frm-selected', 
                              
                                'action' => ['selected-bidders-notification/notify'],
                               
                               'method' => 'post',
                               ]); ?>
                
                 <table id="tbl-selected"   class="table"  cellspacing="0" width="100%">
   <thead>
      <tr>
      
         <th>First Name</th>
         <th>Last Name</th>
         <th>ID Type</th>
         <th>ID No.</th>
         <th>Phone</th>
         <th>Email</th>
         <th>Bid Amount</th>
         <th>Bid Time</th>
      </tr>
   </thead>

</table>

         <?php ActiveForm::end(); ?>       
              </div>  
              </div>
              
            </div>
                </div>
                </div>
            
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
      
      <?php

$lot=$model->lot;
$ajaxUrl=Url::to(['lots/bidders', 'lot' =>$lot]);
$ajaxUrl1=Url::to(['lots/selected-bidders', 'lot' =>$lot]);
$script = <<< JS

$(document).ready(function (){

var dTable=$('#tbl-bidders').DataTable( {
     destroy: true,
    ajax: '{$ajaxUrl}',
    "columns": [
            {"data":null},
            { "data": "first_name" },
            { "data": "last_name" },
            { "data": "doc_type" },
            { "data": "doc_id" },
            { "data": "phone" },
            { "data": "email" },
            { "data": "amount",
            render: function ( data, type, row ) {
               
                return  '<span style="font-family:sans-serif;font-weight:bold;font-size:16px;" class="badge badge-danger">'+data+'</span>'
                }},
           { "data": "selected",
            render: function ( data, type, row ) {
               if(data==1){
                return  '<span style="font-family:sans-serif;font-weight:bold;font-size:16px;" ><i class="far fa-check-circle text-success"></i></span>'
               
                   
               }else{
                   
                return  '<span style="font-family:sans-serif;font-weight:bold;font-size:16px;" > <i class="fas fa-times text-danger"></i> </span>'
               }
              
                }},
            { "data": "timestamp" }
        ],
   
     select: true,
   columnDefs: [
         {
            'targets': 0,
            'render': function(data, type, row, meta){
           
               var checked=data.selected==='1'?'checked':'';
               data = '<input type="checkbox" class="dt-checkboxes" '+checked+ '>'
               if(row.selected === '1'){
                 data= ''
               }
               return data;
            },
            'createdCell':  function (td, cellData, rowData, row, col){
           
               if(rowData.selected ==='1'){
                 
               //this.api().cell(td).checkboxes.disable();
               }
            },            
            'checkboxes': {
               'selectRow': true
            }
         },
      ],
      select: {
         style: 'multi'
      },
     // order: [[1, 'asc']]
  
} );

//----------------------------selected bidders-----------------------------------------
var dTable1=$('#tbl-selected').DataTable({
    destroy: true,
    ajax: '{$ajaxUrl1}',
    "columns": [
            
            { "data": "first_name" },
            { "data": "last_name" },
            { "data": "doc_type" },
            { "data": "doc_id" },
            { "data": "phone" },
            { "data": "email" },
            { "data": "amount",
            render: function ( data, type, row ) {
               
                return  '<span style="font-family:sans-serif;font-weight:bold;font-size:16px;" class="badge badge-danger">'+data+'</span>'
                }},
            { "data": "timestamp" }
           
        ], dom: 'Bfrtip',
      buttons: [ 'copy', 'excel', 'pdf','print' ],
  
     order: [[6, 'desc']]
  
} );


$('#frm-bidders').on('beforeSubmit', function(event) {
    
    var \$form = $(this);
    if(dTable.rows('.selected').data().length==0){
        
        Swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: 'No Bidder(s) selected!',
 
})

   return false;
    }
  
var count=dTable.rows('.selected').count();
var data=dTable.rows('.selected').data();
var bidders=[];  

   
  for (var i=0; i < count ;i++){
          
           bidders[i]=data[i];
        }
  
//  return false;
    
    /*var \$form = $(this);

     var selectedRowInputs = $('.selected input');
     
     var bidders ={};
$.each(selectedRowInputs .serializeArray(), function(index) {
       
         bidders[index] = this.value;
});*/
     
Swal.fire({
  title: 'Are you sure?',
  text: "Selected bidders will be notied!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, nofify them!'
}).then((result) => {
  if (result.value) {

   $.ajax({
      
        url: \$form.attr("action"),  //Server script to process data
        type: 'POST',
        

        // Form data
        data:{ selected: JSON.stringify(bidders),lot:$lot},

       // beforeSend: beforeSendHandler, // its a function which you have to define

        success: function(res) {
      
            if(res.flag==true){
                
                Swal.fire({
  position: 'center',
  icon: 'success',
  title: res.msg,
  showConfirmButton: false,
  timer: 1500
})

 dTable.ajax.reload( null, false );
            }else{
           
    var msg= typeof res.msg !=='undefined' ? res.msg : "Unable to notify selected bidders";            
             Swal.fire({
  icon: 'error',
  title: 'Oops...',
  text:msg,
  footer: 'Please try Again !'
})   
            }
        },

        error: function(){
            alert('ERROR at PHP side!!');
        },


        //Options to tell jQuery not to process data or worry about content-type.
        cache: false
       
       
    });
  }
})
   


  
return false;//prevent the modal from exiting
  
    
});


});

JS;
$this->registerJs($script);

?>