<?php

use yii\helpers\Html;
use yii\helpers\Url;
//use yii\widgets\DetailView;
use common\assets\LayoutAsset;
use common\assets\FormsAsset;
use kartik\detail\DetailView;
use common\models\EmptyModel;
use common\models\CaseInvolvedPartyAddress;
use common\models\CaseInvolvedPartyContact;
LayoutAsset::register($this);
FormsAsset::register($this);

/* @var $this yii\web\View */
/* @var $model backend\models\CaseInvolvedParty */


?>

<?php




$attributesIdentity = [
   
 [
            'group'=>true,
            'label'=>' <i class="material-icons">person</i>
            <span>User  Details</span>',
            'rowOptions'=>['class'=>'bg-cyan']
        ],
    
        [
            'attribute'=>'first_name', 
            'label'=>'FirstName',
            'displayOnly'=>true,
            'valueColOptions'=>['style'=>'width:25%']

        ],
        
         [
               
                'attribute'=>'last_name', 
                'label'=>'LastName',
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:25%']
            ],

        [
                
            'attribute'=>'phone', 
            'label'=>'Phone',
            'displayOnly'=>true,
            'valueColOptions'=>['style'=>'width:25%']
        ],
       
   
            [
               
                'attribute'=>'email', 
                'label'=>'Email',
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:25%']
            ],

          [
            'group'=>true,
            'label'=>' <i class="material-icons">lock</i>
            <span>Login Details</span>',
            'rowOptions'=>['class'=>'bg-cyan']
        ],
        
 
        [
                
            'attribute'=>'username', 
            'label'=>'UserName',
            'displayOnly'=>true,
            'valueColOptions'=>['style'=>'width:100%']
        ],

     
            ];
            

      

?>

<?php  if($model->user_image!='')  
{

 $template= '<div style="width:100%;height:100%;"  class="text-center">'.
                       '<img class="media-object" src="'.Yii::$app->request->baseUrl.'/'.$model->user_image.'"  width="190" height="190">'.'</div>';
    
}else{
    
    
 $template= '<div style="width:100%;height:100%;"  class="text-center">'.
                       '<img class="media-object" src="'.Yii::$app->request->baseUrl.'/uploads/profile/blank-profile.png"  width="190" height="190">'.'</div>';   
    
}



?>

<div class="well row clearfix">

    <div class="col-xs-12 ol-sm-12 col-md-12 col-lg-12">

 <div class="card ">
          
  
                        <div class="body">
               
                <?= DetailView::widget([
'model'=>$model,
'condensed'=>false,
//'hideIfEmpty'=>true,
'hover'=>true,

'bootstrap'=>true,
//'striped'=>false,
'mode'=>DetailView::MODE_VIEW,
'attributes'=>$attributesIdentity,
 'panel' => [
                       'heading' => '&nbsp',
                       'type' => DetailView::TYPE_DEFAULT,
                       'headingOptions' => [
                           'template' =>$template
                       ],
                       'footer' =>'&nbsp',
                       
                   ],

])?>
                
  </div> 
 
 </div>               

                                           
                                       

                      
                     
                      </div><!-- end col wraper  -->  
            </div><!-- end row wraper  -->
          



