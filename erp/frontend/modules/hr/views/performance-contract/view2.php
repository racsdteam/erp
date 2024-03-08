<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\helpers\Url;
use common\models\UserHelper;
use common\models\ErpUnitsPositions;
use frontend\modules\hr\models\PcTargetLevelScore;
use frontend\modules\hr\models\PcTargetMillstone;
use frontend\modules\hr\models\PcTarget;
use frontend\modules\hr\models\Employees;
use frontend\modules\hr\models\PcAnnotations;
use frontend\modules\hr\models\EmpUserDetails;



$this->title = "Imihigo ".$model->financial_year;
$this->params['breadcrumbs'][] = ['label' => 'Performance Appraisals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$user=Yii::$app->user->identity->user_id;

$user=UserHelper::getUserInfo($model->user_id) ;
$pos=UserHelper::getPositionInfo($model->user_id);
$unit=UserHelper::getOrgUnitInfo($model->user_id);
$user_emp_detail=EmpUserDetails::find()->where(["user_id"=>$model->user_id])->one();

$employee=Employees::find()->where(["id"=>$user_emp_detail->employee])->one();
 
if($model->position_level!="officer"){
$company_targets=PcTarget::find()->where(["pa_id"=>$model->id, "type"=>PcTarget::companyTargetLevel ])->All();
$department_targets=PcTarget::find()->where(["pa_id"=>$model->id, "type"=>PcTarget::departmentTargetLevel ])->All();
$company_target_score=PcTargetLevelScore::find()->where(["pc_id"=>$model->id, "type"=>PcTargetLevelScore::companyTargetLevel ])->one();
$department_target_score=PcTargetLevelScore::find()->where(["pc_id"=>$model->id, "type"=>PcTargetLevelScore::departmentTargetLevel ])->one();
}

$employee_target_score=PcTargetLevelScore::find()->where(["pc_id"=>$model->id, "type"=>PcTargetLevelScore::employeeTargetLevel ])->one();
$employee_targets=PcTarget::find()->where(["pa_id"=>$model->id, "type"=>PcTarget::employeeTargetLevel ])->All();
?>
<style>


.tbl-report th {
  word-wrap: break-word;
}
.tbl-report th{
     white-space: pre-line;
 }

 .tbl-report tr td, .tbl-report tr th {
  border: 1px solid #dee2e6;
  vertical-align: bottom;
  
}

.tbl-report th.rotate {
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

th.editable > div{
    
   padding-left:30px;
}

.tbl-preview-sum td, .tbl-preview-sum th, .tbl-report td, .tbl-report th {
   padding: .20rem !important;
    
    
}  
.tbl-report tbody{
    
 font-family: Helvetica , Geneva, sans-serif;
 font-size: 14px;
 font-style: normal;
 font-variant: normal; 
 font-weight: 400;

}


</style>
       <table class="table">
    <tbody>
        <tr>
            <td style="padding:20 0px" align="left"><img src="<?= Yii::$app->request->baseUrl."/img/logo.png"?>" height="100px"></td>
           <td style="padding:20 0px" align="right"><img src="<?= Yii::$app->request->baseUrl."/img/rightlogo.png"?>" height="100px"></td>

        </tr>
    </tbody>
</table>
<div class="table-reponsive">

<table style=": none;-collapse: collapse;width:100%;" class="table  table-striped">
                    <tbody>
        <tr>
            <td colspan="9"  style="padding:0px;color:windowtext;font-size:24px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;:24.0pt;width:1088pt;" >PERFORMANCE APPRAISAL FORM <?= $model->financial_year ?></td>
        </tr>
        <tr>
            <td colspan="9"  style="padding:0px;color:windowtext;font-size:18px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;background:#D9D9D9;:24.0pt;width:1088pt;">PERSONAL INFORMATION</td>
        </tr>
       <tr style="margin:3px;">
            <td colspan="9" style="color:windowtext;font-size:12px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:left;vertical-align:middle;background:#D9D999;:23.25pt;width:1088pt;">1.1 PERSONAL DETAILS</td>
        </tr>
        <tr>
            <td style="padding:0px;color:windowtext;font-size:12px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:left;vertical-align:bottom;:18.0pt;">1.1</td>
            <td colspan="2" style="padding:0px;color:windowtext;font-size:12px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:general;vertical-align:bottom;">Family Name <span style="color:windowtext;font-size:12px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;">:<?= $employee->first_name?></span></td>
            <td style="padding:0px;color:windowtext;font-size:12px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:general;vertical-align:bottom;"><br></td>
            <td style="padding:0px;color:windowtext;font-size:12px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:left;vertical-align:bottom;">1.4</td>
            <td colspan="2" style="padding:0px;color:windowtext;font-size:12px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:general;vertical-align:bottom;">First name  <span style="color:windowtext;font-size:12px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;">:<?= $employee->last_name?></span></td>
            <td style="padding:0px;color:windowtext;font-size:12px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:general;vertical-align:bottom;"><br></td>
            <td style="padding:0px;color:windowtext;font-size:12px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:general;vertical-align:bottom;"><br></td>
        </tr>
        <tr>
            <td style="padding:0px;color:windowtext;font-size:12px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:left;vertical-align:bottom;:27.75pt;">1.2</td>
            <td colspan="2" style="padding:0px;color:windowtext;font-size:12px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:general;vertical-align:bottom;">Sexe: <?= $employee->gender ?> </td>
            <td style="padding:0px;color:windowtext;font-size:12px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:general;vertical-align:bottom;"><br></td>
            <td style="padding:0px;color:windowtext;font-size:12px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:left;vertical-align:bottom;">1.5</td>
            <td colspan="2" style="padding:0px;color:windowtext;font-size:12px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:general;vertical-align:bottom;">Date of birth: <?= $employee->birthday ?></td>
            <td style="padding:0px;color:windowtext;font-size:12px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:general;vertical-align:bottom;"><br></td>
            <td style="padding:0px;color:windowtext;font-size:12px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:general;vertical-align:bottom;"><br></td>
        </tr>
        <tr>
            <td style="padding:0px;color:windowtext;font-size:12px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:left;vertical-align:bottom;:28.5pt;">1.3</td>
            <td colspan="2" style="padding:0px;color:windowtext;font-size:12px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:general;vertical-align:bottom;">Marital Status: <?= $employee->marital_status ?></td>
            <td style="padding:0px;color:windowtext;font-size:12px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:general;vertical-align:bottom;"><br></td>
            <td style="padding:0px;color:windowtext;font-size:12px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:left;vertical-align:bottom;"><br></td>
            <td style="padding:0px;color:windowtext;font-size:12px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:general;vertical-align:bottom;"><br></td>
            <td style="padding:0px;color:windowtext;font-size:12px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:general;vertical-align:bottom;"><br></td>
            <td style="padding:0px;color:windowtext;font-size:12px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:general;vertical-align:bottom;"><br></td>
            <td style="padding:0px;color:windowtext;font-size:12px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:general;vertical-align:bottom;"><br></td>
        </tr>
        <tr>
            <td colspan="9" style="padding:0px;color:windowtext;font-size:12px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:left;vertical-align:bottom;:18.75pt;"><br></td>
            </tr>
        <tr>
            <td colspan="9" style="padding:0px;color:windowtext;font-size:12px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:left;vertical-align:middle;background:#D9D999;:23.25pt;width:1088pt;">1.2 ADMINISTRATIVE INFORMATION</td>
        </tr>
        
        <tr>
            <td style="padding:0px;color:windowtext;font-size:12px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:general;vertical-align:bottom;:20.1pt;">1.2.1&nbsp;</td>
            <td colspan="3" style="padding:0px;color:windowtext;font-size:12px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:general;vertical-align:bottom;">Employee number: <?= $employee->employee_no ?></td>
            <td style="padding:0px;color:windowtext;font-size:12px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:general;vertical-align:bottom;">1.2.4</td>
            <td colspan="2" style="padding:0px;color:windowtext;font-size:12px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:general;vertical-align:bottom;">Employement level:</td>
            <td  colspan="2" style="padding:0px;color:windowtext;font-size:12px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:general;vertical-align:bottom;"><br></td>
             /tr>
  
        <tr>
            <td style="padding:0px;color:windowtext;font-size:12px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:left;vertical-align:bottom;:20.1pt;">1.2.2</td>
            <td colspan="3" style="padding:0px;color:windowtext;font-size:12px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:general;vertical-align:bottom;">Current post: <?= $pos['position']?></td>
            <td style="padding:0px;color:windowtext;font-size:12px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:general;vertical-align:bottom;">1.2.5</td>
            <td colspan="2" style="padding:0px;color:windowtext;font-size:12px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:general;vertical-align:bottom;">Department: <?= $unit['unit_name']?></td>
            <td style="padding:0px;color:windowtext;font-size:12px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:general;vertical-align:bottom;"><br></td>
            <td style="padding:0px;color:windowtext;font-size:12px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:general;vertical-align:bottom;"><br></td>
        </tr>
        <tr>
            <td style="padding:0px;color:windowtext;font-size:12px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:left;vertical-align:bottom;:20.1pt;">1.2.3</td>
            <td colspan="2" style="padding:0px;color:windowtext;font-size:12px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:general;vertical-align:bottom;">Recrutement date:<?= $employee->employee_no ?></td>
            <td style="padding:0px;color:windowtext;font-size:12px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:general;vertical-align:bottom;"><br></td>
            <td style="padding:0px;color:windowtext;font-size:12px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:general;vertical-align:bottom;">1.2.6</td>
            <td colspan="2" style="padding:0px;color:windowtext;font-size:12px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:general;vertical-align:bottom;">Unit: <?= $unit['parent_unit']?></td>
            <td style="padding:0px;color:windowtext;font-size:12px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:general;vertical-align:bottom;"><br></td>
            <td style="padding:0px;color:windowtext;font-size:12px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:general;vertical-align:bottom;"><br></td>
        </tr>
          </tbody>
      </table>
      </div>
     
    <?php if($model->position_level!="officer"):?>
     <div class="table-reponsive">
     <table class="table  table-bordered">
           <tbody>
        <tr>
            <td colspan="9" style="padding:0px;color:windowtext;font-size:18px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;background:#D9D9D9;:18.0pt;width:1088pt;" >EXPECTED RESULTS/ TARGETS ON COMPANY PERFORMANCE</td>
        </tr>
        <tr>
            <td rowspan="2" style="padding:0px;color:windowtext;font-size:20px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;background:white;:54.0pt;width:56pt;"></td>
            <td rowspan="2" style="padding:0px;color:windowtext;font-size:20px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;background:white;width:71pt;">Score</td>
            <td rowspan="2" style="padding:0px;color:windowtext;font-size:20px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;background:white;width:176pt;">Outputs/ Deliverables</td>
            <td rowspan="2" style="padding:0px;color:windowtext;font-size:20px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;background:white;width:155pt;">SMART Indicator(s)</td>
            <td rowspan="2" style="padding:0px;color:red;font-size:20px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;background:white;width:73pt;">PI<br>&nbsp;weight</td>
            <td colspan="4" style="padding:0px;color:windowtext;font-size:20px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;background:white;width:557pt;">Mile Stones</td>
        </tr>
        <tr>
            <td style="padding:0px;color:windowtext;font-size:20px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;background:white;:25.5pt;width:134pt;">Q1</td>
            <td style="padding:0px;color:windowtext;font-size:20px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;background:white;width:145pt;">Q2</td>
            <td style="padding:0px;color:windowtext;font-size:20px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;background:white;width:132pt;">Q3</td>
            <td style="padding:0px;color:windowtext;font-size:20px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;background:white;width:146pt;">Q4</td>
        </tr>
      <?php
      $i=0;
        foreach($company_targets as $tagert):
            $i++;
        $q1_targets=PcTargetMillstone::find()->where(["target_id"=>$tagert->id, "quarter"=>"Q1"])->all();    
        $q2_targets=PcTargetMillstone::find()->where(["target_id"=>$tagert->id, "quarter"=>"Q2"])->all();    
        $q3_targets=PcTargetMillstone::find()->where(["target_id"=>$tagert->id, "quarter"=>"Q3"])->all();    
        $q4_targets=PcTargetMillstone::find()->where(["target_id"=>$tagert->id, "quarter"=>"Q4"])->all();    
        
        ?>
        <tr>
        <?php if($i==1): ?>
            <td   rowspan="<?= count($company_targets) ?>"  style="padding:0px;color:windowtext;font-size:20px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;-right:1.5pt solid #D9D9D9;background:white;:184.05pt;width:56pt;" ><p> Company PERFORMANCE </p></td>
            <td  rowspan="<?= count($company_targets) ?>" style="padding:0px;color:windowtext;font-size:20px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;background:white;width:71pt;"><?= $employee_target_score->score_percentage ?>%</td>
         <?php endif; ?>   
            <td style="padding:0px;color:black;font-size:20px;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:left;vertical-align:middle;;"><?= $tagert->output ?></td>
            <td style="padding:0px;color:black;font-size:20px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:left;vertical-align:middle;width:155pt;"><?= $tagert->indicator ?>&nbsp;</td>
            <td style="padding:0px;color:black;font-size:20px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:left;vertical-align:middle;background:#F2F2F2;width:73pt;"><?= $tagert->kpi_weight ?>%</td>
            <td style="padding:0px;color:black;font-size:20px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:left;vertical-align:middle;width:134pt;"> 
            <?php if($q1_targets!=null):?>
                <ul>
                <?php
                                      foreach($q1_targets as $target):
                                      ?>
                                      
                                     <li><?= $target->millstone ?></li>
                                  <?php endforeach;
                                  ?>
                </ul>
                <?php
                                  else:
                                  ?> 
                                  <p> No Milleston </p>
                                  <?php endif; ?>   </td>
            <td style="padding:0px;color:black;font-size:20px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:left;vertical-align:middle;width:145pt;">  
            <?php if($q2_targets!=null):
                ?>
                <ul>
                <?php
                                      foreach($q2_targets as $target):
                                      ?>
                                     <li><?= $target->millstone ?></li>
                                  <?php endforeach;
                                    ?>
                </ul>
                <?php
                                  else:
                                  ?> 
                                  <p> No Milleston </p>
                                  <?php endif; ?>   </td>
            <td style="padding:0px;color:black;font-size:20px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:left;vertical-align:middle;width:132pt;">  
            <?php if($q3_targets!=null):
                ?>
                <ul>
                <?php
                                      foreach($q3_targets as $target):
                                      ?>
                                     <li><?= $target->millstone ?></li>
                                  <?php endforeach;
                                    ?>
                </ul>
                <?php
                                  else:
                                  ?> 
                                  <p> No Milleston </p>
                                  <?php endif; ?>   </td>
            <td style="padding:0px;color:black;font-size:20px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:left;vertical-align:middle;width:146pt;">  
            <?php if($q4_targets!=null):
                ?>
                <ul>
                <?php
                                      foreach($q4_targets as $target):
                                      ?>
                                     <li><?= $target->millstone ?></li>
                                  <?php endforeach;
                                    ?>
                </ul>
                <?php
                                  else:
                                  ?> 
                                  <p> No Milleston </p>
                                  <?php endif; ?>   </td>
        </tr>
       <?php
       endforeach;
       ?>
         </tbody>
       </table>
       </div>
        <div class="table-reponsive">
     <table class="table   table-bordered">
       <tbody>
        <tr>
            <td colspan="9" style="padding:0px;color:windowtext;font-size:18px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;background:#D9D9D9;:18.0pt;width:1088pt;">EXPECTED RESULTS/ TARGETS ON DEPERTMENT/ UNIT PERFORMANCE</td>
        </tr>
        
        
        <tr>
            <td rowspan="2" style="padding:0px;color:windowtext;font-size:20px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;background:white;:45.75pt;width:56pt;"><br></td>
            <td rowspan="2" style="padding:0px;color:windowtext;font-size:20px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;background:white;width:71pt;">Score&nbsp;</td>
            <td rowspan="2" style="padding:0px;color:windowtext;font-size:20px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;background:white;width:176pt;">Outputs/ Deliverables</td>
            <td rowspan="2" style="padding:0px;color:windowtext;font-size:20px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;background:white;width:155pt;">SMART Indicator(s)</td>
            <td rowspan="2" style="padding:0px;color:red;font-size:20px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:top;background:#F2F2F2;width:73pt;">PI<br>&nbsp;weight</td>
            <td colspan="4" style="padding:0px;color:windowtext;font-size:20px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;background:white;width:557pt;">Mile Stones</td>
        </tr>
        <tr>
            <td style="padding:0px;color:windowtext;font-size:20px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;background:white;:24.75pt;width:134pt;">Q1</td>
            <td style="padding:0px;color:windowtext;font-size:20px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;background:white;width:145pt;">Q2</td>
            <td style="padding:0px;color:windowtext;font-size:20px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;background:white;width:132pt;">Q3</td>
            <td style="padding:0px;color:windowtext;font-size:20px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;background:white;width:146pt;">Q4</td>
        </tr>
   <?php
     $i=0;
        foreach($department_targets as $tagert):
             $i++;
        $q1_targets=PcTargetMillstone::find()->where(["target_id"=>$tagert->id, "quarter"=>"Q1"])->all();    
        $q2_targets=PcTargetMillstone::find()->where(["target_id"=>$tagert->id, "quarter"=>"Q2"])->all();    
        $q3_targets=PcTargetMillstone::find()->where(["target_id"=>$tagert->id, "quarter"=>"Q3"])->all();    
        $q4_targets=PcTargetMillstone::find()->where(["target_id"=>$tagert->id, "quarter"=>"Q4"])->all();    
        
        ?>
        <tr>
         <?php if($i==1): ?>
            <td  rowspan="<?= count($department_targets) ?>"  style="padding:0px;color:windowtext;font-size:20px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;-right:1.5pt solid #D9D9D9;background:white;:184.05pt;width:56pt;"> <p>DEPERTMENT/ UNIT PERFORMANCE</p></td>
            <td  rowspan="<?= count($department_targets) ?>"   style="padding:0px;color:windowtext;font-size:20px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;background:white;width:71pt;"><?= $department_target_score->score_percentage ?>%</td>
        <?php endif; ?>   
            <td style="padding:0px;color:black;font-size:20px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:left;vertical-align:middle;width:176pt;"><?= $tagert->output ?></td>
            <td style="padding:0px;color:black;font-size:20px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:left;vertical-align:middle;width:155pt;"><?= $tagert->indicator ?>&nbsp;</td>
            <td style="padding:0px;color:black;font-size:20px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:left;vertical-align:middle;background:#F2F2F2;width:73pt;"><?= $tagert->kpi_weight ?>%</td>
            <td style="padding:0px;color:black;font-size:20px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:left;vertical-align:middle;width:134pt;"> 
            <?php if($q1_targets!=null):?>
                <ul>
                <?php
                                      foreach($q1_targets as $target):
                                      ?>
                                      
                                     <li><?= $target->millstone ?></li>
                                  <?php endforeach;
                                  ?>
                </ul>
                <?php
                                  else:
                                  ?> 
                                  <p> No Milleston </p>
                                  <?php endif; ?>   </td>
            <td style="padding:0px;color:black;font-size:20px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:left;vertical-align:middle;width:145pt;">  
            <?php if($q2_targets!=null):
                ?>
                <ul>
                <?php
                                      foreach($q2_targets as $target):
                                      ?>
                                     <li><?= $target->millstone ?></li>
                                  <?php endforeach;
                                    ?>
                </ul>
                <?php
                                  else:
                                  ?> 
                                  <p> No Milleston </p>
                                  <?php endif; ?>   </td>
            <td style="padding:0px;color:black;font-size:20px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:left;vertical-align:middle;width:132pt;">  
            <?php if($q3_targets!=null):
                ?>
                <ul>
                <?php
                                      foreach($q3_targets as $target):
                                      ?>
                                     <li><?= $target->millstone ?></li>
                                  <?php endforeach;
                                    ?>
                </ul>
                <?php
                                  else:
                                  ?> 
                                  <p> No Milleston </p>
                                  <?php endif; ?>   </td>
            <td style="padding:0px;color:black;font-size:20px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:left;vertical-align:middle;width:146pt;">  
            <?php if($q4_targets!=null):
                ?>
                <ul>
                <?php
                                      foreach($q4_targets as $target):
                                      ?>
                                     <li><?= $target->millstone ?></li>
                                  <?php endforeach;
                                    ?>
                </ul>
                <?php
                                  else:
                                  ?> 
                                  <p> No Milleston </p>
                                  <?php endif; ?>   </td>
        </tr>
       <?php
       endforeach;
       ?>
        </tbody>
        </table>
        </div>
        
    <div class="table-reponsive">    
     <table class="table   table-bordered">
         <tbody>
        <tr>
            <td colspan="9" style="padding:0px;color:windowtext;font-size:18px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;background:#D9D9D9;:18.0pt;width:1088pt;">INDIVIDUAL TARGETS</td>
        </tr>
        <tr>
           <td rowspan="2" style="padding:0px;color:windowtext;font-size:20px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;background:white;:45.75pt;width:56pt;"><br></td>
            <td rowspan="2" style="padding:0px;color:windowtext;font-size:20px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;background:white;width:71pt;">Score&nbsp;</td>
            <td rowspan="2" style="padding:0px;color:windowtext;font-size:20px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;background:white;width:176pt;">Outputs/ Deliverables</td>
            <td rowspan="2" style="padding:0px;color:windowtext;font-size:20px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;background:white;width:155pt;">SMART Indicator(s)</td>
            <td rowspan="2" style="padding:0px;color:red;font-size:20px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:top;background:#F2F2F2;width:73pt;">PI<br>&nbsp;weight</td>
            <td colspan="4" style="padding:0px;color:windowtext;font-size:20px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;background:white;width:557pt;">Mile Stones</td>
        </tr>
        <tr>
            <td style="padding:0px;color:windowtext;font-size:20px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;-right:1.5pt solid #D9D9D9;-bottom:1.5pt solid #D9D9D9;background:white;width:134pt;">Q1</td>
            <td style="padding:0px;color:windowtext;font-size:20px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;:1.5pt solid #D9D9D9;background:white;width:145pt;">Q2</td>
            <td style="padding:0px;color:windowtext;font-size:20px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;:1.5pt solid #D9D9D9;background:white;width:132pt;">Q3</td>
            <td style="padding:0px;color:windowtext;font-size:20px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;-bottom:1.5pt solid #D9D9D9;background:white;width:146pt;">Q4</td>
        </tr>
       <?php
         $i=0;
        foreach($employee_targets as $tagert):
               $i++;
        $q1_targets=PcTargetMillstone::find()->where(["target_id"=>$tagert->id, "quarter"=>"Q1"])->all();    
        $q2_targets=PcTargetMillstone::find()->where(["target_id"=>$tagert->id, "quarter"=>"Q2"])->all();    
        $q3_targets=PcTargetMillstone::find()->where(["target_id"=>$tagert->id, "quarter"=>"Q3"])->all();    
        $q4_targets=PcTargetMillstone::find()->where(["target_id"=>$tagert->id, "quarter"=>"Q4"])->all();    
        
        ?>
        <tr>
             <?php if($i==1): ?>
            <td rowspan="<?= count($employee_targets) ?>"   style="padding:0px;color:windowtext;font-size:20px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;-right:1.5pt solid #D9D9D9;background:white;:184.05pt;width:56pt;"><p>INDIVIDUAL PERFORMANCE</p>	</td>
            <td  rowspan="<?= count($employee_targets) ?>"  style="padding:0px;color:windowtext;font-size:20px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;background:white;width:71pt;"><?= $company_target_score->score_percentage ?>%</td>
             <?php endif; ?>  
            <td style="padding:0px;color:black;font-size:20px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:left;vertical-align:middle;width:176pt;"><?= $tagert->output ?></td>
            <td style="padding:0px;color:black;font-size:20px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:left;vertical-align:middle;width:155pt;"><?= $tagert->indicator ?>&nbsp;</td>
            <td style="padding:0px;color:black;font-size:20px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:left;vertical-align:middle;background:#F2F2F2;width:73pt;"><?= $tagert->kpi_weight ?>%</td>
            <td style="padding:0px;color:black;font-size:20px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:left;vertical-align:middle;width:134pt;"> 
            <?php if($q1_targets!=null):?>
                <ul>
                <?php
                                      foreach($q1_targets as $target):
                                      ?>
                                      
                                     <li><?= $target->millstone ?></li>
                                  <?php endforeach;
                                  ?>
                </ul>
                <?php
                                  else:
                                  ?> 
                                  <p> No Milleston </p>
                                  <?php endif; ?>   </td>
            <td style="padding:0px;color:black;font-size:20px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:left;vertical-align:middle;width:145pt;">  
            <?php if($q2_targets!=null):
                ?>
                <ul>
                <?php
                                      foreach($q2_targets as $target):
                                      ?>
                                     <li><?= $target->millstone ?></li>
                                  <?php endforeach;
                                    ?>
                </ul>
                <?php
                                  else:
                                  ?> 
                                  <p> No Milleston </p>
                                  <?php endif; ?>   </td>
            <td style="padding:0px;color:black;font-size:20px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:left;vertical-align:middle;width:132pt;">  
            <?php if($q3_targets!=null):
                ?>
                <ul>
                <?php
                                      foreach($q3_targets as $target):
                                      ?>
                                     <li><?= $target->millstone ?></li>
                                  <?php endforeach;
                                    ?>
                </ul>
                <?php
                                  else:
                                  ?> 
                                  <p> No Milleston </p>
                                  <?php endif; ?>   </td>
            <td style="padding:0px;color:black;font-size:20px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:left;vertical-align:middle;width:146pt;">  
            <?php if($q4_targets!=null):
                ?>
                <ul>
                <?php
                                      foreach($q4_targets as $target):
                                      ?>
                                     <li><?= $target->millstone ?></li>
                                  <?php endforeach;
                                    ?>
                </ul>
                <?php
                                  else:
                                  ?> 
                                  <p> No Milleston </p>
                                  <?php endif; ?>   </td>
        </tr>
       <?php
       endforeach;
       ?>
       </tbody>
        </table>
        </div>
    <?php else:?>
        <div class="table-reponsive">   
    <table class="table   table-bordered">
         <tbody>
        <tr>
            <td colspan="9" style="padding:0px;color:windowtext;font-size:18px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;background:#D9D9D9;:18.0pt;width:1088pt;">EXPECTED RESULTS/ TARGETS </td>
        </tr>
        <tr>
            <th colspan="5" style="padding:0px;color:windowtext;font-size:20px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;background:white;width:176pt;">Outputs/ Deliverables</th>
            <th colspan="4" style="padding:0px;color:windowtext;font-size:20px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;background:white;width:155pt;"> SMART Indicator(s)</th>
        </tr>
       <?php
         $i=0;
        foreach($employee_targets as $tagert):
               $i++;
        
        ?>
        <tr>
            <td colspan="5" ><?= $tagert->output ?></td>
            <td colspan="4" ><?= $tagert->indicator ?></td>
        </tr>
       <?php
       endforeach;
       ?>
        </tbody>
        </table>
        </div>
     <?php endif ?>
       <div class="table-reponsive">
           
     <table class="table  table-striped">
        <tbody>
        <tr>
            <td rowspan="9" class="rotate" style="text-orientation: upright;padding:0px;color:windowtext;font-size:16px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;background:white;:184.05pt;width:56pt;">Key Competencies</td>
            <td colspan="7" style="padding:0px;color:windowtext;font-size:16px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;-left solid windowtext;background:#D9D9D9;width:630pt;">Measure of Competencies</td>
        </tr>
        <tr>
            <td colspan="7" style="padding:0px;color:black;font-size:16px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:left;vertical-align:top;background:#F2F2F2;:20.45pt;width:961pt;"><strong>Core competences</strong></td>
        </tr>
        <tr>
            <td colspan="7" style="padding:0px;color:black;font-size:16px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:left;vertical-align:top;-bottom:1.5pt solid #D9D9D9;:20.45pt;width:331pt;">Honesty and Integrity</td>
        </tr>
        <tr>
            <td colspan="7" style="padding:0px;color:black;font-size:16px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:left;vertical-align:top;:1.5pt solid #D9D9D9;-bottom:1.5pt solid #D9D9D9;:20.45pt;width:331pt;">Decision making &amp; Communication skills &nbsp;&nbsp;</td>
        </tr>
        <tr>
            <td colspan="7" style="padding:0px;color:black;font-size:16px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:left;vertical-align:top;:1.5pt solid #D9D9D9;:20.45pt;width:331pt;">Planning ability &amp; Time management</td>
        </tr>
        <tr>
            <td colspan="7" style="padding:0px;color:black;font-size:16px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:general;vertical-align:top;background:#F2F2F2;:20.45pt;width:176pt;"><strong>Functional Competences</strong></td>
         </tr>
        <tr>
            <td colspan="7" style="padding:0px;color:black;font-size:16px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:left;vertical-align:top;-bottom:1.5pt solid #D9D9D9;:20.45pt;width:331pt;">Service delivery&nbsp;</td>
       </tr>
        <tr>
            <td colspan="7" style="padding:0px;color:black;font-size:16px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:left;vertical-align:top;:1.5pt solid #D9D9D9;-bottom:1.5pt solid #D9D9D9;:20.45pt;width:331pt;">Initiative and innovation</td>
            
        </tr>
        <tr>
            <td colspan="7" style="padding:0px;color:black;font-size:16px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:left;vertical-align:top;:1.5pt solid #D9D9D9;:20.45pt;width:331pt;">Team work &amp; Attitude</td>
         </tr>
      </tbody>
        </table>
        </div>
        <div class="table-reponsive">
     <table class="table  table-striped">
         <tbody>
        <tr>
            <td colspan="9" style="padding:0px;color:windowtext;font-size:12px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;background:#D9D9D9;:19.5pt;width:1088pt;">APPROVAL OF EXPECTED RESULTS</td>
        </tr>
      
        <tr>
            <td colspan="9" style="padding:0px;color:black;font-size:12px;font-weight:400;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:general;vertical-align:bottom;:18.0pt;">
                We have discussed and agreed on the results and behaviours /competencies that are expected from the employee in the current year
            and the measuring indicators as mentioned above.<br>
            I commit myselft to have accomplished these tasks within <b><?= $model->financial_year ;?> </b> financial year.
        </tr>
        <tr>
            <td colspan="3" style="padding:0px;color:black;font-size:12px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:general;vertical-align:bottom;:23.25pt;">Employee&apos;s name:</td>
            <td colspan="6" style="padding:0px;color:black;font-size:12px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:general;vertical-align:bottom;:23.25pt;"> <?= $employee->first_name?> <?= $employee->last_name?></td>
        </tr>
       
        <tr>
            <td colspan="3" style="padding:0px;color:black;font-size:12px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:general;vertical-align:bottom;:18.0pt;">Function:</td>
            <td  colspan="6" style="padding:0px;color:windowtext;font-size:12px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:general;vertical-align:bottom;"><?= $pos['position']?></td>
        </tr>
     <tr>
         
    <?php 
    $emplyee_signature=PcAnnotations::find()->where(["doc"=>$model->id, "author"=>$model->user_id,"type"=>"Stamp"])->one();
    
    ?>
            <td colspan="4" style="padding:0px;color:black;font-size:12px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:general;vertical-align:bottom;:18.0pt;">Date and Signature: <?php if($emplyee_signature !== null){ $datetime=$emplyee_signature->timestamp;echo Yii::$app->erp->getDate($datetime); }?>  </td>
             <td colspan="5"  style="color:black;font-size:12px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial,sans-serif;text-align:center;vertical-align:center;border:1px solid red;height:100px">Sign Here</td>
     
        </tr>
        
         <tr>
           <td colspan="9"><br></td>
        </tr>

        
      </tbody>
        </table>
        </div>
  
<?php 
if(!empty($model->wfInstance->stepInstances))
        :
    foreach($model->wfInstance->stepInstances as $approval)
        {
         if($approval->task_type=="Approval")
         {
         $approver=UserHelper::getUserInfo($approval->assignedTo);   
         $appover_position=UserHelper::getPosition($approval->assignedTo); 
?>     
      <div class="table-reponsive">
        <table class="table  table-striped">
<tbody> 
 <tr>
             <td colspan="9" style="padding:0px;color:windowtext;font-size:12px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;background:#D9D9D9;:19.5pt;width:1088pt;">Managers, Directors, DMD and MD Signature for apprpval.</td>

        </tr>
   <tr>
            <td colspan="9" style="padding:0px;color:windowtext;font-size:12px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:center;vertical-align:middle;background:#D9D999;:19.5pt;width:1088pt;"><?= $approval->name ?></td>

        </tr>
        <tr>
            <td colspan="9" style="padding:0px;color:black;font-size:12px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:general;vertical-align:bottom; solid windowtext;:18.0pt;">name: <?= $approver['first_name'] ?>  <?= $approver['last_name'] ?> </td>

        </tr>

        <tr>
            <td colspan="9" style="padding:0px;color:black;font-size:12px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:left;vertical-align:bottom;:18.0pt;">Function: <?= $appover_position->position ?></td>

        </tr>
         <?php 
    $approver_signature=PcAnnotations::find()->where(["doc"=>$model->id, "author"=>$approval->assignedTo,"type"=>"Stamp"])->one();
    
    
    ?>
        <tr>
             <td colspan="4" style="padding:0px;color:black;font-size:12px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial, sans-serif;text-align:general;vertical-align:bottom;:18.0pt;">Date and Signature: <?php if($approver_signature !== null){ $datetime=$approver_signature->timestamp;echo Yii::$app->erp->getDate($datetime); }?></td>
             <td colspan="5"  style="color:black;font-size:12px;font-weight:700;font-style:normal;text-decoration:none;font-family:Arial,sans-serif;text-align:center;vertical-align:center;border:1px solid red;height:100px">signature</td>
     </tr>
     </tbody>
        </table>
        </div>
<?php 
}
}
endif;
?>

     
     