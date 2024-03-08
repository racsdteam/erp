<?php
namespace common\components;

use Yii;
use yii\base\Component;
use yii\helpers\Html;



class AlertComponent extends Component {
  
     
   
    public function showSuccess($success){
  
       $showSuccess= '<script type="text/javascript">';
       $showSuccess.= "Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: '".$success."',
                 showConfirmButton: false,
                 timer: 1500
                  })";
       $showSuccess.= '</script>'; 
       
       echo $showSuccess;
    
     }
   
    public function showError($error){
  
     $showError=Html::tag('div',Html::button('x',
    ['class'=>'close',' data-dismiss'=>'alert','aria-hidden'=>true]).
    Html::tag('h5','<i class="icon fas fa-ban"></i> Error!',[]).
    $error,
    ['class'=>'alert alert-danger alert-dismissible']);  
    
    echo  $showError; 
     }
 
}

?>