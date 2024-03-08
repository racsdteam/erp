<?php
/**
 * Created by PhpStorm.
 * User: Fahmy
 * Date: 11/20/15
 * Time: 7:29 PM
 */

/* @var $this yii\web\View */

use drsdre\wizardwidget\WizardWidget;
use yii\widgets\ActiveForm;

$this->title = 'Create Organization Profile';
$this->params['breadcrumbs'][] = ['label' => 'Organization(s)', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<style>
    .tab-content .tab-pane {
        padding-left: 20px;
        padding-right: 20px;
    }

    .wizard .nav-tabs {
        margin-top: 0;
    }
/*---to be able to center wizard buttons----*/
    .wizard ul.list-inline{
        width: 100%;
    margin: auto;

    }
    /*---to be able to display inline wizard buttons----*/
    .wizard ul.list-inline li{
      display:inline;

    }

  .list-inline  .next-step,.list-inline  .prev-step  {
        visibility: hidden;
      

    }
    .wizard .prev-step  {
    /* visibility: hidden;*/
   

    }

    .wizard .save-step  {
         visibility: hidden;

    }



/* centering col withing row  */
.row.text-center > div {
  padding-left:0;
  padding-right:0;
  float:none;
  margin:auto;
  text-align:left;
}
</style>




<div class="row text-center clearfix">
<?php if(!$isAjax){$size=11;$offset=0;}else{$size=12;$offset=0;}   ?>


                <div class="col-lg-<?php echo $size;?> col-md-<?php echo $size;?> col-sm-12 col-xs-12  ">
                    <div class="card">
                        
                        <div class="body">
                        <?php


$wizard_config = [
    'id' => 'stepwizard',
    'steps' => [
        1 => [
            'title' => 'About Person',
            'icon' => 'fa fa-institution',
            'content' => Yii::$app->controller->renderPartial('_form',['model'=>$model,
            'isAjax'=>$isAjax]),
          
                
        ],
        
        2 => [
            'title' => 'Address Info',
            'icon' => 'glyphicon glyphicon glyphicon-home',
            'content' => Yii::$app->controller->renderPartial('//erp-organization-address/_form',['model'=>$address,'isAjax'=>$isAjax]),
            
        ],

        3=> [
            'title' => 'Contact Info',
            'icon' => 'glyphicon glyphicon-phone-alt',
            'content' => Yii::$app->controller->renderPartial('//erp-organization-contact/_form',['model'=>$contact,'isAjax'=>$isAjax]),
           'buttons' => [
           
           'next' => [
                    'title' => 'Proceed To Risk Indicators',
                    'options' => [ 'class'=> 'btn bg-cyan']
                ],
                'prev' => [
                    'title' => 'Back To Occupation',
                    'options' => [ 'class'=> 'btn btn-primary']
                ]
               
            ]
            
        ],
        4=>[
            'title' => 'Ok',
            'icon' => 'glyphicon  glyphicon-ok',
            'content' => Yii::$app->controller->renderPartial('_finish-step'),
           'buttons' => [
           
           'next' => [
                    'title' => 'Proceed To Risk Indicators',
                    'options' => [ 'class'=> 'btn bg-cyan']
                ],
                'prev' => [
                    'title' => 'Back To Occupation',
                    'options' => [ 'class'=> 'btn btn-primary']
                ]
               
            ]
            
        ]
            
      
       
    ],
   
 

//    'complete_content' => "You are done!", // Optional final screen
    'start_step' => $step, // Optional, start with a specific step
];


echo WizardWidget::widget($wizard_config);





?>
                      
                        </div>


                        


                        </div>

                        </div>

                        </div>

<?php  
$script = <<< JS


JS;
$this->registerJs($script);


?>




