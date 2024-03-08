<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\db\Query;
use yii\helpers\Url;
use yii\base\View;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

use common\models\User;
use common\models\UserHelper;
use common\models\UnitHelper;
use common\models\ErpOrgUnits;
use common\models\UserRoles;

use common\models\GroupsAccessList;
use common\models\UsersAccessList;
use common\models\RolesAccessList;
use common\models\Tblacls;
use common\models\Tblgroups;


?>


 
 <style>
     
     .folder-meta{color: #6c757d;
   }
   
  div.access-type{
      
      display:none;
  }
 </style>
 
 <!---- ----------------------------------------------------------------------------------------------------->
 
   <?php $form = ActiveForm::begin() ?>
   
   <?= $form->field($folder, 'inheritAccess')->inline()->radioList([ '1' => 'Inherit from parent','0' => 'Custom'])->label(false) ?>                          
                               
  <?php ActiveForm::end(); ?>
                               
                               
 
 
 
   <div class="access-type" id="access-form1">

   <?php  
   
   if($folder->inheritAccess){
       
     echo $this->render('inherit-access',['folder'=>$folder]);  
   }else{
       
      echo $this->render('non-inherit-access',['folder'=>$folder]);   
       
   }
       
   
     
    ?>
   </div>
   
   
    <div class="access-type" id="access-form0">
       
       
        <div  class="card-footer pb-0">          
            
        <?php $form = ActiveForm::begin([
                               'options' => ['class'=>'access-form'],
                               'id'=>'def-access-form', 
                               'enableClientValidation'=>true,
                               'action' => ['tblfolders/add-access'],
                               'enableAjaxValidation' => false,
                               'method' => 'post',
                               'layout' => 'horizontal',
                                'class' => 'form-horizontal', 
                                 
                               ]) ?>
                             
             <?= Html::hiddenInput('folderid', $folder->id); ?>
             <?= Html::hiddenInput('action', 'setdefault'); ?>
    
     <div class="row">
        
       
             <div class="col-10">
            
             <?php $items=[Tblacls::M_NONE=>"No Access",Tblacls::M_READ=>"Read",Tblacls::M_READWRITE=>"ReadWrite",Tblacls::M_ALL=>"Full Control"]; ?>
                   
                   <?= $form->field($folder, 'defaultAccess')->widget(Select2::classname(), [
    'data' =>$items,
    'options' => ['placeholder' => 'Select Default Access ...','id'=>'df-access-select',
    
   ],
    'pluginOptions' => [
        'allowClear' => true,
        'multiple'=>false
       
       
    ]
    
])->label("Default Access")?> 
           
 </div>
  
  <div class="col-2">
         <div class="form-group">     
             
        <?= Html::submitButton('Add', ['class' => 'btn btn-success']) ?>
    </div>
              </div>       
           
           
            </div>
                           
                                 
         <?php ActiveForm::end(); ?>
           
            </div>     
       
       
       
        <!-------------------------------------------groups------------------------------------------------------------------------------>   
        <div class="table-responsive">
              <table id="group-access-list" class="table  accessTable">
                <thead>
                <tr>
                  <th>Securitys Group</th>
                  <th>Restrict</th>
                  <th>Read</th>
                  <th>Read & Write</th>
                  <th>Full Control</th>
                  <th>Remove</th>
                 
                </tr>
                </thead>
                
             
              </table>
            </div>
            
          <?php  
       
      $groupModel=new GroupsAccessList();
     
                  ?> 
       
          <div  class="card-footer pb-0">          
            
        <?php $form = ActiveForm::begin([
                               'options' => ['class'=>'access-form'],
                               'id'=>'group-access-form', 
                               'enableClientValidation'=>true,
                               'action' => ['tblfolders/add-access'],
                               'enableAjaxValidation' => false,
                               'method' => 'post',
                               
                                 
                               ]) ?>
    <?= Html::hiddenInput('action', 'setaccess'); ?>                         
    <?= $form->field($groupModel, 'target')->hiddenInput(['value'=>$folder->id])->label(false); ?>
    
     <div class="row">
        
        <div class="col-6">  
           
            <?php $items=ArrayHelper::map(Tblgroups::find()->all(), 'id',function($group){
           
             if($group->type==Tblgroups::UNIT_GROUP){
                 
                 $unitInfo=UnitHelper::getOrgUnitInfoByCode($group->name);
                 
                 if(!empty($unitInfo))
                 
                    return $unitInfo['unit_name']." ".$unitInfo['unit_level'];
                
             }else{
             
              return $group->name;    
                 
             }
             
             
      
      }); ?>
                   <?= $form->field($groupModel, 'group')->widget(Select2::classname(), [
    'data' =>$items,
    'options' => ['placeholder' => 'Select Group(s) ...','id'=>'group-select',
    
   ],
    'pluginOptions' => [
        'allowClear' => true,
        'multiple'=>false
       
       
    ]
    
])->label(false)?> 

             </div>
            
            <div class="col-4">  
             <?php $items=[Tblacls::M_NONE=>"No Access",Tblacls::M_READ=>"Read",Tblacls::M_READWRITE=>"ReadWrite",Tblacls::M_ALL=>"Full Control"]; ?>
                   <?= $form->field($groupModel, 'access_mode')->widget(Select2::classname(), [
    'data' =>$items,
    'options' => ['placeholder' => 'Select Access Level ...','id'=>'access-select',
    
   ],
    'pluginOptions' => [
        'allowClear' => true,
        'multiple'=>false
       
       
    ]
    
])->label(false)?> 
            </div>
    
    <div class="col-2"> 
            
             <div class="form-group">
        <?= Html::submitButton('Add', ['class' => 'btn btn-success','title'=>'Add new group']) ?>
    </div>
                </div>
            </div>
                           
                                 
         <?php ActiveForm::end(); ?>
           
            </div>     
     
 <!-------------------------------------------users------------------------------------------------------------------------------>   
              
              
                 <div class="table-responsive">
              <table id="user-access-list" class="table accessTable">
                <thead>
                <tr>
                  <th>Users</th>
                  <th>Restrict</th>
                  <th>Read</th>
                  <th>Read & Write</th>
                  <th>Full Control</th>
                  <th>Remove</th>
                 
                </tr>
                </thead>
                
             
              </table>
            </div>
            
          <?php  
       
      $userModel=new UsersAccessList();
     
                  ?> 
       
          <div  class="card-footer pb-0">          
            
        <?php $form = ActiveForm::begin([
                               'options' => ['class'=>'access-form'],
                               'id'=>'user-access-form', 
                               'enableClientValidation'=>true,
                               'action' => ['tblfolders/add-access'],
                               'enableAjaxValidation' => false,
                               'method' => 'post',
                               
                                 
                               ]) ?>
    <?= Html::hiddenInput('action', 'setaccess'); ?>                          
    <?= $form->field($userModel, 'target')->hiddenInput(['value'=>$folder->id])->label(false); ?>
    
     <div class="row">
        
        <div class="col-6">  
           
           <?php $items=ArrayHelper::map(User::find()->all(), 'user_id',function($user){
      
         $pos=UserHelper::getPositionInfo($user->user_id);
         
         if(!$pos)
          return $user->first_name." ".$user->last_name; 
         
          return $user->first_name." ".$user->last_name." / ".$pos['position']; 
      
      }); ?>
                   <?= $form->field($userModel, 'user[]')->widget(Select2::classname(), [
    'data' =>$items,
    'options' => ['placeholder' => 'Select User(s) ...','id'=>'user-select',
    
   ],
    'pluginOptions' => [
        'allowClear' => true,
        'multiple'=>true
       
       
    ]
    
])->label(false)?> 

             </div>
            
            <div class="col-4">  
             
             <?php $items=[Tblacls::M_NONE=>"No Access",Tblacls::M_READ=>"Read",Tblacls::M_READWRITE=>"ReadWrite",Tblacls::M_ALL=>"Full Control"]; ?>
                   <?= $form->field($userModel, 'access_mode')->widget(Select2::classname(), [
    'data' =>$items,
    'options' => ['placeholder' => 'Select Access Level ...','id'=>'level-select',
    
   ],
    'pluginOptions' => [
        'allowClear' => true,
        'multiple'=>false
       
       
    ]
    
])->label(false)?> 
            </div>
    
    <div class="col-2"> 
            
             <div class="form-group">
        <?= Html::submitButton('Add', ['class' => 'btn btn-success','title'=>'Add new user']) ?>
    </div>
                </div>
            </div>
                           
                                 
         <?php ActiveForm::end(); ?>
           
            </div>     
               
      </div>
           
                 
                 
                 
                

 
 <?php
function getIconByType($type){
    
 $fileTypes=array("pdf"=>"far fa-file-pdf","folder"=>"far fa-file-word","folderx"=>"far fa-file-word","ppt"=>"far fa-file-powerpoint","pptx"=>"far fa-file-powerpoint");  
 $fa_icon=null;
 
 foreach($fileTypes as $key=>$ficon){
     
     if($key==$type){
         
        $fa_icon=$ficon;
        break;
     }
     
    if(!$fa_icon){
        
       $fa_icon="far fa-file"  ;
    }
    
    
 }
   
   return $fa_icon; 
}

?>
 
 
   <?php



$ajaxUrl=Url::to(['tblfolders/access-list']);
$removeUrl=Url::to(['tblfolders/remove-access']);

$folder=$folder->id;

$script = <<< JS

$(function() {

//------------------get default selected radio-------------------------
   var radioValue = $("input[name='Tblfolders[inheritAccess]']:checked").val();
   //-----------------show corresponding view-------------------------
   $('#access-form'+radioValue).show();
   //----------------------disable not checked-------------------------------------------
   $("input[name='Tblfolders[inheritAccess]']").prop('disabled', function(){ return !this.checked; });

   
 $('input[name="Tblfolders[inheritAccess]"]').click(function(){
    
  /*  if ($(this).is(':checked'))
    {
          
          $("div.access-type").hide();
          
          $("#access-form"+$(this).val()).show();
     
    }
 */
 
  var value=$(this).val();
  var msg='';
  if(value==1){
     msg+="You want to inherit access from parent !";
      
  }else if(value==0){
      
      msg+="You want to define custom access !";  
  }
 
   Swal.fire({
 title: "Are you sure?",
  text: msg,
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, do it!'
}).then((result) => {
  
  console.log(result)
  
  if (!result.value) {
  
   $(this).removeAttr('checked');  

  }else{
      
      
  }
})
 
 
  });




//-----------------------------Modal------------------------------------------------------

 $('.action-add-file').click(function () {
        var url = $(this).attr('href');
$('.modal-action').modal('show')
    .find('.modal-body')
    .load(url);
    
   $('.modal-action #defaultModalLabel').text($(this).attr('title'));
return false;
                        
 
        }); 
   
   
    
  var tableGroups=$('#group-access-list').DataTable({
     "paging":false,
     "lengthChange":false,
      "searching":false,
      "ordering": true,
      "info":false,
      "autoWidth": false,
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      'ajax': {
          'url':'{$ajaxUrl}',
           data: {action: 'groups',id:'{$folder}'},
      },
      'columns': [
         { data: 'group_name' },
         { data: 'restrict' },
         { data: 'read' },
         { data: 'readwrite' },
         { data: 'fullaccess' },
          {
      "data": null,
      "defaultContent":""
    }
      ],
       columnDefs: [
        { 
            targets: [1,2,3,4],
            searchable: false,
            orderable: false,
            render: function(data, type, full, meta){
              
             
              
               if(type === 'display'){
                  
                  checked=data?'checked':'';
                  
                  id='groupMode'+meta.row +""+ meta.col;
                  name='groupRadio'+full.group_id;
                
                  data='<div class="custom-control custom-radio">'+
                      '<input class="custom-control-input"  type="radio" id="'+id+'" name="'+name+'" value="' + data + '"'+ checked + '>'+
                      '<label for="'+id+'" class="custom-control-label"></label>'+
                      '</div>';
                        
                  //data = '<input type="radio" name="'+full.group_id+'" value="' + data + '"'+ checked + '>';      
               }

               return data;
            }
        },
        { 
            targets: [5],
            searchable: false,
            orderable: false,
            render: function(data, type, full, meta){
              
               
              var action;
               if(type === 'display'){
              
               var url='{$removeUrl}';
               var group_id=full.group_id; 
               var target='{$folder}';
               
               action = '<a class="action-remove-access" href="'+url+'" data-target="'+target+'" data-grouporuserid="'+group_id+'"  data-is-user=0  title="Remove Permission" >'+
               '<i class="far fa-trash-alt">'+'</i></a>';      
               }

               return  action;
            }
        }
    ]
    });
    
 
 //---------------------------------------------------------------------------------------------------------------
 
    
  var tableUsers=$('#user-access-list').DataTable({
     "paging":false,
     "lengthChange":false,
      "searching":false,
      "ordering": true,
      "info":false,
      "autoWidth": false,
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      'ajax': {
          'url':'{$ajaxUrl}',
           data: {action: 'users',id:'{$folder}'},
      },
      'columns': [
         { data: 'user' },
         { data: 'restrict' },
         { data: 'read' },
         { data: 'readwrite' },
         { data: 'fullaccess' },
          {
      "data": null,
      "defaultContent":""
    }
      ],
       columnDefs: [
        { 
            targets: [1,2,3,4],
            searchable: false,
            orderable: false,
            render: function(data, type, full, meta){
              
            
              
               if(type === 'display'){
                  
                  checked=data?'checked':'';
                  id='UserMode'+meta.row+""+ meta.col;
                  name='UserRadio'+full.user_id;
                
                  data='<div class="custom-control custom-radio">'+
                      '<input class="custom-control-input"  type="radio" id="'+id+'" name="'+name+'" value="' + data + '"'+ checked + '>'+
                      '<label for="'+id+'" class="custom-control-label"></label>'+
                      '</div>';
                    
               }

               return data;
            }
        },
        { 
            targets: [5],
            searchable: false,
            orderable: false,
            render: function(data, type, full, meta){
              
               var url='{$removeUrl}';
               var user_id=full.user_id; 
               var target='{$folder}';
               
              
              var action;
               if(type === 'display'){
              
               action = '<a class="action-remove-access" href="'+url+'" data-target="'+target+'" data-grouporuserid="'+user_id+'"  data-is-user=1  title="Remove Permission" >'+
               '<i class="far fa-trash-alt">'+'</i></a>';     
               }

               return  action;
            }
        }
    ]
    });
 
  //--------------------custom access form submit-------------------------------------------
  
  $('.access-form').on('beforeSubmit', function(e) {


   Swal.fire({
 title: "Are you sure?",
  text:'You want to peform this action ',
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, do it!'
}).then((result) => {
  
 
  
  if (!result.value) {
   e.preventDefault();
   return false; 

  }else{
      
    var \$form = $(this);
    var formData = new FormData(\$form [0]);// to be able to send file
   
    $.ajax({
        url: \$form.attr("action"),  //Server script to process data
        type: 'POST',

        // Form data
        data: formData,

       // beforeSend: beforeSendHandler, // its a function which you have to define

        success: function(response) {
           
            response=JSON.parse(response);
           
          
          
           if(response.data.flag==true){
        
           Swal.fire(
      'Success!',
     response.data.message,
      'success'
    )
         
          
          if(response.data.target==='users'){
              
             tableUsers.ajax.reload( null, false);  
          }
          else if(response.data.target==='groups'){
              
             tableGroups.ajax.reload( null, false);    
          }else{
              
               tableUsers.ajax.reload( null, false); 
               tableGroups.ajax.reload( null, false); 
          }
         
            
           }else{
Swal.fire(
      'Error!',
    response.data.error,
      'error'
    )
           // toastr.error(response.data.error);

           }
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
});
  
   

  
return false;//prevent the modal from exiting
});


//------------------------------inherited access------------------------------------


  
  $('.inherit-access-form').on('beforeSubmit', function(e) {


   Swal.fire({
 title: "Are you sure?",
  text:'You want to peform this action ',
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, do it!'
}).then((result) => {
  
 
  
  if (!result.value) {
   e.preventDefault();
   return false; 

  }else{
      
    var \$form = $(this);
    var formData = new FormData(\$form [0]);// to be able to send file
   
    $.ajax({
        url: \$form.attr("action"),  //Server script to process data
        type: 'POST',

        // Form data
        data: formData,

       // beforeSend: beforeSendHandler, // its a function which you have to define

        success: function(response) {
           
            response=JSON.parse(response);
           
          
          
           if(response.data.flag==true){
    
           }else{
Swal.fire(
      'Error!',
    response.data.error,
      'error'
    )
           // toastr.error(response.data.error);

           }
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
});
  
   

  
return false;//prevent the modal from exiting
});



$('.accessTable').on('click', '.action-remove-access', function (e) {
 
   e.preventDefault();
   var url=$(this).attr('href');
   var target=$(this).attr('data-target');
   var grouporuserid=$(this).attr('data-grouporuserid');
   var isuser=$(this).attr('data-is-user');
   
   var grouporuser=isuser==1?"user":"group"
  
   Swal.fire({
 title: "Are you sure?",
  text: "You want to remove this "+grouporuser+"!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, remove it!'
}).then((result) => {
  if (result.value) {
    
      $.post(url,{ 
                    target:target,
                    grouporuserid:grouporuserid,
                    isuser:isuser
                }, ).done(function(response){
                     console.log(response)
                   response=JSON.parse(response);
      
      if(response.data.flag==true){
          
          Swal.fire(
      'Deleted!',
      isuser==1? 'user has been deleted!' :' group has been deleted !',
      'success'
    )
    
    if(response.data.target==='users'){
       
       tableUsers.ajax.reload( null, false);    
        
    }else{
        
         tableGroups.ajax.reload( null, false);  
    }
          
      }else{
       
       Swal.fire(
      'Error!',
       response.data.error,
      'error'
    )
      }
     
});
  }
})
   
   return false;
   
    
});

   
});



JS;
$this->registerJs($script);
?>




