<?php
use yii\helpers\Url;
use  common\models\User;


/* @var $this yii\web\View */

$this->title = 'Home';
$this->context->layout='app-menu';
if (Yii::$app->session->hasFlash('success')){

$msg=  Yii::$app->session->getFlash('success');

  echo '<script type="text/javascript">';
  echo 'showSuccessMessage("'.$msg.'");';
  echo '</script>';
  

   }
  

if (Yii::$app->session->hasFlash('failure')){

$msg=  Yii::$app->session->getFlash('failure');

  echo '<script type="text/javascript">';
  echo 'showErrorMessage("'.$msg.'");';
  echo '</script>';
  

   }
$role=Yii::$app->user->identity->user_level;


    
  

?>

<style>
    
    a.div-clickable{ display: block;
       height: 100%;
       width: 100%;
       text-decoration: none;}   
       
    .thumbnail{
        
       
    } 
    
   
.row .btn:not(.btn-block) {padding:30px; }
.btn{
    
   
}
       
   </style>
   
  
       
        
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-xs-12">
                          <a href="#" class="btn btn-primary btn-lg bg-olive" role="button"><i class="fa fa-folder-open-o"></i><br/>Documents Sharing</a>
                          
                        </div>
                      <div class="col-md-12 col-sm-12 col-xs-12">
                       <a href="http://www.jquery2dotnet.com/" class="btn btn-success btn-lg btn-block" role="button"><i class="fa fa-file-text-o"></i> User Guidance</a>    
                          
                      </div>  
                    </div>
                    
                
       
    
