<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use frontend\modules\hr\models\PayItemCategories;
use frontend\modules\hr\models\PayItems;
use frontend\modules\hr\models\Employees;
use yii\bootstrap\ActiveForm;
use frontend\modules\hr\models\PayGroups;
/*use frontend\assets\XeditableAsset;
XeditableAsset::register($this);*/
use frontend\assets\ TableEditAsset;
 TableEditAsset::register($this);


/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PayComponents */
/* @var $form yii\widgets\ActiveForm */
?>
<style>

.tbl-preview-detail tbody{
    
 font-family: Helvetica , Geneva, sans-serif;
 font-size: 14px;
 font-style: normal;
 font-variant: normal; 
 font-weight: 400;

}

.tbl-preview-detail th {
  word-wrap: break-word;
}
 .tbl-preview-detail tr td, .tbl-preview-detail tr th {
  border: 1px solid #dee2e6;
  vertical-align: bottom;
  
}

.tbl-preview-detail th.rotate {
  height: 200px;
 font-family: "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif; 
 font-size: 16px; 
 font-style: normal; 
 font-variant: normal; 
 font-weight: 700;
  
  
 
}

th.rotate > div {
  writing-mode: vertical-rl;
  transform: rotate(-180deg);
 
 color:#000000;
}
.textH {
  height: 230px;
  padding-left:15px;
 
}

th.editable > div{
    
   padding-left:30px;
}

.tbl-preview-sum td, .tbl-preview-sum th, .tbl-preview-detail td, .tbl-preview-detail th {
   padding: .20rem !important;
    
    
}  


</style>

      
      <?php
     
      $payTmpl=$model->payGroup0->payTemplate;
     
      $cols=$payTmpl->lineItems;
      $editables=[];
      foreach($cols as $col){
          if($col->calc_type=='open'){
             
              $editables[$col->id]=$col;
          }
      }
      
      $colsTotals=[];
      
      $colsBold=[];
      foreach($cols as $col){
          if(in_array($col->category,['BASE','G','N'])){
             
               $colsBold[$col->id]=$col;
          }
      }
      $colsBase=[];
      
     $period_start=date('d/m/Y', strtotime($model->pay_period_start));
     $period_end=date('d/m/Y', strtotime($model->pay_period_end)); 
      ?>
   <div class="invoice p-3 mb-3">
   
    <div class="card-header pl-0 mb-1">
                <h3 class="card-title"><i class="fas fa-coins"></i> <?php echo $model->name ?></h3>

                <div class="card-tools">
                  <h6>Pay Period : <?php echo $period_start.'-'.$period_end ?></h6>
                   
                 
                </div>
              </div>           
              
   <?php if($model->status=='draft') : ?>
    
    <div class="d-flex  flex-sm-row flex-column mb-3">
       
         <?= Html::a(' <i class="fas fa-chevron-left"></i> Payroll List', Url::to(['payrolls/index']), ['class'=>['btn mr-auto btn-sm  bg-gradient-info btn-flat'],
                            'title' => Yii::t('app', 'Back')
                        ]); ?>
      <div class="btn  bg-gradient-primary btn-sm btn-flat  btn-rerun" data-id=<?php echo $model->id?>>
                 <i class="fas fa-cloud-upload-alt"></i> Import Earnings/Deductions   
                        
                    </div>
         <div class="btn  bg-gradient-danger btn-sm btn-flat  btn-delete ml-1">
                    <i class="fas  fa-times"></i> Delete Pay Item    
                        
                    </div>            
                    
       <div class="btn  bg-gradient-danger btn-sm btn-flat  btn-delete ml-1">
                    <i class="fas  fa-times"></i> Delete Payslip    
                        
                    </div>               
                    
      <div class="btn  bg-gradient-warning btn-sm btn-flat  btn-refresh ml-1">
                    <i class="fas fa-sync"></i> Refresh Payslip   
                        
                    </div>
                   
                    
        <div class="btn  bg-gradient-primary btn-sm btn-flat  btn-rerun ml-1" data-id=<?php echo $model->id?>>
                   <i class="fas fa-calculator"></i> ReRun Payroll   
                        
                    </div>
                    
                    
                    
      <div class="btn  bg-gradient-success btn-sm btn-flat  btn-finilise ml-1">
                    <i class="fas fa-thumbs-up"></i> Finalise Payroll    
                        <?php  
                          
$form = ActiveForm::begin([
    'id' => 'payroll-finilise-form',
    'action'=>['payrolls/finilise'],
    'options' => ['class' => 'form-horizontal'],
]) ?>
  <?= Html::hiddenInput('id', $model->id);?>
  <?php ActiveForm::end() ?> 
                        
                    </div>

</div>


  <?php endif;?>
                   <div class="table-responsive">
    <table id="tbl-data"   class="table  dataTable tbl-preview-detail compact "  cellspacing="0" width="100%">
   <thead>
      <tr>
          <th>ID</th>
         
          <th  class="rotate"><div><div class="textH">Employee No.</div> </div></th>
         <th class="rotate"><div><div class="textH">Employee Name</div> </div></th>
         <?php foreach( $cols as $key=>$col)  : ?>
         
         <th class="rotate <?php echo isset($editables[$col->id]) && $model->status!='completed'?'editable':''; echo isset($colsBold[$col->id]) ?'strong':''; ?>"  
         <?php  echo isset($editables[$col->id]) && $model->status!='completed' ? "data-col=".$col->id.' '." data-item=".$col->item : '';?>>
             <div><div class="textH"><?php echo $col->payItem->name ?></div> </div></th>
       
          <?php endforeach;?>
          <th><i class="fas fa-cog"></i></th>
   
          
         
          
         
        
         
      </tr>
   </thead>
<tbody>
          
               
                    </tbody>
                    
                     <tfoot>
                         <tr>
                              
                              <th></th>
                               <th colspan="2">G.TOTAL</th>
                               
                               
                          <?php foreach( $cols as $key=>$col)  :?>
                          <th></th>
                          <?php endforeach ?>
                          <th>Action</th>
</tr>
</tfoot>
                 
</table>
</div>

 </div>
  


<?php
$dataUrl=Url::to(['payrolls/payslips']);
$adjustUrl=Url::to(['payslips/adjust']);
$refreshUrl=Url::to(['payslips/refresh']);
$deleteUrl=Url::to(['payslips/delete-api']);
$reRunUrl=Url::to(['payrolls/re-generate']);

$encModel=json_encode($model->attributes);
$columns=[];


$columns[]=['data'=>'id'];
$columns[]=['data'=>'employee_no'];
$columns[]=['data'=>'full_name'];

foreach($cols as $col){
   $data['data']=$col->payItem->code; 
   $columns[]=$data; 
}
$columns[]=['data'=>null];
$lastIndex=count($columns)-1;


$encCols=json_encode($columns);

$script = <<< JS
var colsEditable=[];

 $(document).ready(function(){
 var payroll=$encModel;
 
 const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });


 var table = $('#tbl-data').DataTable({
         destroy:true,
         ajax: {
               url: '{$dataUrl}',
               type: 'POST',
               data: {'id':payroll.id}
         },
         "columns":$encCols,
         pageLength: 50,
         autoWidth: false,
        columnDefs: [ 
        //{ 'visible': false, 'targets': [0] },
        {
            'targets': $lastIndex,
            'render': function(data, type, row, meta){
           
               
               data = '<input type="checkbox" class="dt-checkboxes" >'
               
               return data;
            },
                      
            'checkboxes': {
               'selectRow': true
            }
         },
        { targets: 3, type: 'num-fmt' },
        
        
        ],
          select: true,
        	  select: {
            style: 'multi'
        },
        order: [[ 3, "desc" ]],
         dom: '<"d-flex justify-content-between mt-3" Blf>'+
       'tr' +
       '<"d-flex justify-content-between"ip>', 
       fixedHeader: {
        header: false
      },
     buttons: {
        buttons: [{
          extend: 'print',
          text: '<i class="fas fa-print"></i> Print',
          title: $('h1').text(),
          exportOptions: {
            columns: ':not(.no-print)'
          },
          footer: true,
          autoPrint: true
        }, {
          extend: 'pdf',
          text: '<i class="far fa-file-pdf"></i> PDF',
          title: $('h1').text(),
          exportOptions: {
            columns: ':not(.no-print)'
          },
          footer: true
        }
        ,{
          extend: 'excel',
          text: '<i class="far fa-file-excel"></i> Excel',
          title: $('h1').text(),
          exportOptions: {
            columns: ':not(.no-print)'
          },
          footer: true
        }
        
        
        ],
        
        
        dom: {
          container: {
            className: 'dt-buttons'
          },
          button: {
            className: 'btn btn-default dt-button'
          }
        }
      },
      
	//--------------------totaling cells for each col-------------------------------------	
	footerCallback:totalsCallback,
	
	//------------------formatting td values----------------------------------------------
	rowCallback: function( row, data ) {
	   
	    $.each($('td', row), function(colIndex){
	
		     $(this).attr('nowrap','nowrap');
		    if(colIndex>2 && colIndex !=$lastIndex)
		     $(this).number(true);
			});
			
    
  }
	 
    });
 table.columns( '.editable' ).every( function ( index) {
     var column = table.column( index );
            
     var editable={};
         editable.index=index;
         editable.col=column.header().getAttribute('data-col');
         editable.item=column.header().getAttribute('data-item');
         colsEditable.push(editable);
        
 
        } );  
 
  var editableArr=[];
  var editableIndexes=[];
  $.each( colsEditable, function( key, col) {
      
          var  row=[];
          row.push(col.index);
          row.push(col.item);
          editableArr.push(row);
          editableIndexes.push(col.index);
  })
 table.on('draw.dt', function(event, settings){

   $('#tbl-data').Tabledit({
   url:'{$adjustUrl}',
   dataType:'json',
   columns:{
    identifier : [0, 'slipId'],
    editable:editableArr
   },
    editButton: false,
    deleteButton: false,
    hideIdentifier: true,
    eventType: 'dblclick',
    inputClass:'form-control form-control-sm',
    buttons: {
    edit: {
        class: 'btn btn-block   btn-outline-secondary btn-flat btn-xs',
        html: '<i class="fas fa-pencil-alt"></i>',
        action: 'edit'
    },
   
    save: {
        class: 'btn btn-block btn-success btn-flat btn-xs',
        html: '<i class="far fa-save"></i>'
    },
  
},
  onDraw: function() {
        console.log('onDraw()');
    },
    onSuccess: function(data, textStatus, jqXHR) {
       console.log(data);
       var res=data;
       if(res.success){
          
          toastr.success(res.data.msg)  
          table.ajax.reload();
           
         }else{
           
            $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Error',
        subtitle: 'Fail',
         body: res.data.msg
      })  
         }
       
        
       
    },
    onFail: function(jqXHR, textStatus, errorThrown) {
       
      $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Error',
        subtitle: 'Fail',
         body: errorThrown
      })
    },
    onAlways: function() {
        console.log('onAlways()');
    },
    onAjax: function(action, serialize) {
        console.log('onAjax(action, serialize)');
        console.log(action);
        console.log(serialize);
    }
  });   

 
     
      
 


  
 });
     
 function totalsCallback ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var floatVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
            
         api.columns().every( function (i) {
         
         if(i===0 || i===1 || i===2)
         return true; 
           
             // Total over all pages
            total = api
                .column(i)
                .data()
                .reduce( function (a, b) {
                    return floatVal(a) + floatVal(b);
                }, 0 );
              
            
            
                
               $( api.column(i).footer() ).html(
                $.number(total)
            );   
             
                 // Update footer
           
       
        
           
            
    });     
       
        }    
 
   

 $('.btn-finilise').on('click',function () {   
      
      
Swal.fire({
  title: 'Are you sure?',
  text: "Payroll we be locked from being edited in the future!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, finalise it!'
}).then((result) => {
  if (result.value) {
   
   $("#payroll-finilise-form").submit();
  
  }
})  
       
       

}); 

 //----------------------------refresh payslip--------------------------------
  $('.btn-refresh').on('click',function () {   
   
     if(table.rows('.selected').data().length==0){
        
        Swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: 'No payslips(s) selected!',
 
})

   return false;
    }
  

var data=table.rows('.selected').data();
var slips=[];  

$.each( data, function( index, elem ){
slips.push(elem.id);
});

      
Swal.fire({
  title: 'Are you sure?',
  text: "You want to refresh this payslip(s)!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes'
}).then((result) => {
  if (result.value) {
      
  Swal.showLoading();      
      
  
   $.ajax({
      
        url: '{$refreshUrl}',  
        type: 'POST',
     // Form data
        data:{ ids: JSON.stringify(slips)},

                  beforeSend: function( xhr ) {
     var swal=Swal.fire({
                title: 'Please Wait !',
                html: 'Payroll refreshing...',// add html attribute if you want or remove
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
            });  
  },

        success: function(res) {
      
            if(res.success){
      swal.close();           
     toastr.success(res.data.msg)  

 table.ajax.reload( null, false );
            }else{
           
    var msg= typeof res.data.msg !=='undefined' ? res.data.msg : "Unable to refresh selected payslip(s)";            
    $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Error',
        subtitle: 'error!',
        body:'Unable to refresh selected payslip(s) : ' +msg
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
       
return false;       

});

 
 
  //---------------------------delete payslip--------------------------------
  $('.btn-delete').on('click',function () {   
   
     if(table.rows('.selected').data().length==0){
        
        Swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: 'No payslips(s) selected!',
 
})

   return false;
    }
  

var data=table.rows('.selected').data();
var slips=[];  

$.each( data, function( index, elem ){
slips.push(elem.id);
});

      
Swal.fire({
  title: 'Are you sure?',
  text: "You want to delete this payslip(s)!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes'
}).then((result) => {
  if (result.value) {
      
  Swal.showLoading();      
      
  
   $.ajax({
      
        url: '{$deleteUrl}',  
        type: 'POST',
     // Form data
        data:{ ids: JSON.stringify(slips)},

                  beforeSend: function( xhr ) {
     var swal=Swal.fire({
                title: 'Please Wait !',
                html: 'Payslip(s) deleting...',// add html attribute if you want or remove
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
            });  
  },

        success: function(res) {
      
            if(res.success){
      swal.close();           
     toastr.success(res.data.msg)  

 table.ajax.reload( null, false );
            }else{
           
    var msg= typeof res.data.msg !=='undefined' ? res.data.msg : "Unable to delete selected payslip(s)";            
    $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Error',
        subtitle: 'error!',
        body:'Unable to delete selected payslip(s) : ' +msg
      })   
            }
        },

        error: function(){
            swal.close(); 
            alert('ERROR at sever side!!');
        },


        //Options to tell jQuery not to process data or worry about content-type.
        cache: false
       
       
    });
  
  }
})  
       
return false;       

});

//-----------------rerun payroll---------------------------------------------------------------------


  $('.btn-rerun').on('click',function () {   
   
var id=$(this).attr('data-id');
      
Swal.fire({
  title: 'Are you sure?',
  text: "You want to rerun this payroll!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes'
}).then((result) => {
  if (result.value) {
      
  Swal.showLoading();      
      
  
   $.ajax({
      
        url: '{$reRunUrl}',  
        type: 'POST',
     // Form data
        data:{ id: JSON.stringify(id)},

                  beforeSend: function( xhr ) {
     var swal=Swal.fire({
                title: 'Please Wait !',
                html: 'Payroll Regenerating...',// add html attribute if you want or remove
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
            });  
  },

        success: function(res) {
      
            if(res.success){
      swal.close();           
     toastr.success(res.data.msg)  

 table.ajax.reload( null, false );
            }else{
           
    var msg= typeof res.data.msg !=='undefined' ? res.data.msg : "Unable to regenerate this payroll !";            
    $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Error',
        subtitle: 'error!',
        body:'Unable to regenerate this payroll : ' +msg
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
       
return false;       

});

});
		

 

JS;
$this->registerJs($script);

?>




