<?php

use yii\helpers\Html;
use common\models\Tblacls;
use wbraganca\dynamicform\DynamicFormWidget;

?>

<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_inner',
    'widgetBody' => '.container-rooms',
    'widgetItem' => '.room-item',
    'limit' => 4,
    'min' => 1,
    'insertButton' => '.add-room',
    'deleteButton' => '.remove-room',
    'model' => $modelsAcl1[0],
    'formId' => 'dynamic-form',
    'formFields' => [
        'id',
        'access_mode',
        'group'
    ],
]); 

$modes=[];

$modes[Tblacls::M_NONE]="Restrict";
$modes[Tblacls::M_READ]="Read";
$modes[Tblacls::M_READWRITE]="Read&Write";
$modes[Tblacls::M_ALL]="Full Control";

?>
<h4>Security Groups</h4>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Group</th>
             <th>Mode</th>
            <th class="text-center">
                <button type="button" class="add-room btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span></button>
            </th>
        </tr>
    </thead>
    <tbody class="container-rooms">
    <?php foreach ($modelsAcl1 as $indexAcl => $modelAcl): ?>
        <tr class="room-item">
            <td style="width: 70%;" class="vcenter">
                <?php
                    // necessary for update action.
                    if ($modelAcl->id) {
                        echo Html::activeHiddenInput($modelAcl, "[{$indexAcl}]id");
                    }
                ?>
                <?= $form->field($modelAcl, "[{$indexAcl}]group")->label(false)->textInput(['maxlength' => true]) ?>
                </td>
                <td nowrap>
                    <?= $form->field($modelAcl, "[{$indexAcl}]access_mode")->inline(true)->checkboxList($modes)->label(false) ?>
               
            </td>
            <td class="text-center vcenter" style="width: 10px;">
                <button type="button" class="remove-room btn btn-danger btn-xs"><span class="glyphicon glyphicon-minus"></span></button>
            </td>
        </tr>
     <?php endforeach; ?>
    </tbody>
</table>
<?php DynamicFormWidget::end(); ?>