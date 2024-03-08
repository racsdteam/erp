<?php

use yii\helpers\Html;
use yii\grid\GridView;
//use fedemotta\datatables\DataTables;
use yii\bootstrap\Modal;
use kartik\detail\DetailView;
use yii\helpers\Url;
use lo\widgets\modal\ModalAjax;
use yii\db\Query;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MirrorCaseSearchModel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row clearfix">



                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="box box-default color-palette-box">
                        <div class="box-header with-border">
                           
                            <h1><?= Html::encode($this->title) ?></h1>
                           
                        </div>
                        
                        <div class="box-body">

 <?php if (Yii::$app->session->hasFlash('success')): ?>
  
                                  <?php 
                                $msg=  Yii::$app->session->getFlash('success');
                                $code=1;
                                  echo '<script type="text/javascript">';
                                  echo 'showSuccessMessage("'.$msg.'");';
                                  echo '</script>';
                                  
                                  
                                  ?>
                                  
                                   <?php endif ?>
 <?php if (Yii::$app->session->hasFlash('failure')): ?>
  
                                  <?php 
                                $msg=  Yii::$app->session->getFlash('failure');
                                $code=1;
                                  echo '<script type="text/javascript">';
                                  echo 'showSuccessMessage("'.$msg.'");';
                                  echo '</script>';
                                  
                                  
                                  ?>
 <?php endif ?>
   
    <div class="table-responsive">
                                <table id="usersTable" class="table table-bordered table-striped table-hover ">
                                    <thead>
                                        <tr>
                                        <th>#</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>User Level</th>
                                        <th>UserName</th>
                                        <th>Active</th>
                                        <th>Update</th>
                                        <th>View</th>
                                           
                                        </tr>
                                    </thead>
                                    
                                    
                                </table>
</div>
</div>
                    </div>

                   

                </div>
            </div>
 


<?php
           
$url =  Url::to(['user/get-users']);
$url2 = Url::to(['user/change-user-status']) ;
$url3 = Url::to(['user/update']) ;
$url4 = Url::to(['user/view']) ;
$script = <<< JS

$.fn.modal.Constructor.prototype.enforceFocus = $.noop;

var users_table=$('#usersTable').DataTable({
    dom: 'Bfrtip',
        buttons: [
            'print','copy', 'excel', 'pdf'
        ],
    "ajax" : {
        "url" : "$url",
        "dataSrc" : function (json) {
            // manipulate your data (json)
              console.log(json.users);
      
           

var userData = json.users;
        var dataSet = [];
        $.each(userData, function(index, user){
            if(user.status=="10"){  
               // alert('equals') ;
                                     enableDisable ='<div class="switch">'+
                                    '<label>Inactive<input type="checkbox" checked><span class="lever"></span>Active</label>'+
                               ' </div>'
                                        ;
                                } 
                                else{
                                    enableDisable ='<div class="switch">'+
                                    '<label>Inactive<input type="checkbox"><span class="lever"></span>Active</label>'+
                               ' </div>' ;
                                }
                                updatebtn='<button title="Üpdate User" data-id='+user.user_id+' type="button" class="btn btn-success btn-sm waves-effect update-user">'+' <i class="material-icons">mode_edit</i>'+'<span>Update</span>'+'</button>';
                                viewbtn='<button title="View User" data-id='+user.user_id+' type="button" class="btn btn-primary btn-sm waves-effect view-user">'+' <i class="material-icons">visibility</i>'+'<span>View</span>'+'</button>';
            dataSet.push([
                user.user_id,
                user.first_name,
                user.last_name,
               user.phone,
               user.email,
                user.role_name,
                user.username,
                enableDisable,
                updatebtn,
                viewbtn
            ]);
        });






            return  dataSet;

          
            $('#toggle-demo').bootstrapToggle();
        
        }
    }
});

//using delegate events
$('#usersTable').on('click', 'input[type="checkbox"]', function() {
  
     // console.log('best', 'click');
var status= $(this).prop('checked');
var data = users_table.row($(this).closest('tr')).data();
var message;
var success;
var conftext;
var flag;
if(status){
 message='Selected user will be activated!';
 success="Activated";
 conftext='activate';
 flag=1;


}else{
    message='Selected user will be deactivated!';
    success="Deactivated";
    conftext='deactivate';
    flag=0;
}
    swal({
        title: "Are you sure?",
        text: message,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, "+conftext,
        closeOnConfirm: false
    }, function () {
        
        
        
   
     // alert(rows.data()[0]);
      //console.log(data[0]);
      changeUserStatus(data[0],flag);
        
        
        
        swal(success, message, "success");

        
    });
  
  
  
  
  





   /*  var rows = $( users_table.$('input[type="checkbox"]').map(function () {
  return $(this).closest('tr');
} ) );*/



});


           function changeUserStatus(id,status){
    
            $.ajax({
        url:'{$url2}'+'?'+jQuery.param({ id:id,status:status}),  //Server script to process data
      // url: \$form.attr("action"),
        type: 'POST',
       // data: formData,

        // Form data
      //  data:jQuery.param({ id: $('#searchcaseinvolvedparty-globalsearch').val()}),
      //  data:{ id :$('#searchcaseinvolvedparty-globalsearch').val()},

       // beforeSend: beforeSendHandler, // its a function which you have to define

        success: function(response) {
        
       // alert(response);
        },

        error: function(){
            alert('ERROR at PHP side!!');
        },


        //Options to tell jQuery not to process data or worry about content-type.
        cache: false,
        contentType: false,
        processData: false
    });


    
    
           }
           
           
           
 $('#usersTable').on('click', '.update-user', function() {
 
  var id=$(this).attr('data-id'); 
  var url='{$url3}'+'?id='+id;
  
  $('#modal-action').modal('show')
    .find('.modal-body')
    .load(url);
    
   $('#modal-view #defaultModalLabel').text($(this).attr('title'));
    
    return false;
     
 }); 
 
            
 $('#usersTable').on('click', '.view-user', function() {
 
  var id=$(this).attr('data-id'); 
  var url='{$url4}'+'?id='+id;
  
  
    
  $('#modal-action').modal('show')
    .find('.modal-body')
    .load(url);
    
   $('#modal-view #defaultModalLabel').text($(this).attr('title'));
    
    return false;
  
 
   
     
     
 });

 $(function () {
  
    
    $('#modal-action .modal-content').removeAttr('class').addClass('modal-content modal-col-' + 'blue'); 
    
    
   $('#modal-action').on('hidden.bs.modal', function () {
       
       $('#modal-action .modal-body').empty();
       $('#modal-action .modal-body').html('<div style="text-align:center"><img src="/mirror/images/m-loader.gif"></div>'); 
    });
});

JS;
$this->registerJs($script);



?>




