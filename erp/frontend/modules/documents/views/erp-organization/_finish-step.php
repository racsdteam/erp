<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use backend\models\Province;
use backend\models\District;
use backend\models\Sector;
use backend\models\Countries;
use borales\extensions\phoneInput\PhoneInput;

/* @var $this yii\web\View */
/* @var $model backend\models\CaseInvolvedPartyAddress */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="row clearfix">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                       

                        <?php $form = ActiveForm::begin(['enableClientValidation'=>true,
                        
                        
                           
                        'id'=>'contact-form', 
                        'enableClientValidation'=>true,
                        //'action' => ['case-involved-party/person-contact'],
                        'enableAjaxValidation' => false,
                        'method' => 'post'
                        
                        
                        
                        ]); ?>

   

    <div class="form-group" style="text-align:center;">

       <div  class="row">
     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

      
         
     <?= Html::a('Done' , '', ['class' => 'btn btn-lg bg-green btn-sub',
        'data' => [
            'method' => 'post',
            'params' => [
                'step' =>'submit'
            ]
        ]
    ])?>  
 
    
    </div>
   
    
     </div>
      
           
    </div>

    

    <?php ActiveForm::end(); ?>
                           
                        </div>
                    </div>
                


          <?php
         



$script = <<< JS


 
$('.btn-sub').on('click', function(e) {
    if ($(this).attr('disabled')) {
       e.preventDefault();
     return false
    }
});


JS;
$this->registerJs($script);
?>
           