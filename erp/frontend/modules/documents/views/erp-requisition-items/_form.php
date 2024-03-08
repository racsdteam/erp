  
  <?php
  
use wbraganca\dynamicform\DynamicFormWidget;

  ?>
 

  
 <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper2', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items2', // required: css class selector
        'widgetItem' => '.item', // required: css class
        'limit' => 500, // the maximum times, an element can be added (default 999)
        'min' => 1, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $modelsRequisitionItems[0],
        'formId' => 'dynamic-form',
        'formFields' => [
           'designation',
            'specs',
           'uom',
            'quantity',
            'unit_price',
            'total_amount',
            'badget_code'
           // 'attach_description'
           
        ],
    ]); ?>
    
    <div class="table-responsive">
     <table id="items" style="width:100%" class="table table-bordered table-striped">
        <thead>
            <tr>
               
    <th  style="text-align:center;color:#2196f3;font-weight:bold;" colspan="8">
        
   <h4 style="display:inline;" class="box-title"><i class="fa fa-cart-arrow-down"></i> Add Purchase Requisition Items</h4>
    
   
    </th>
    
   
                
            </tr>
            <tr style="padding:5px 5px">
               
                <th>Item Description</th>
                <th>Specs</th>
                 <th>UoM(unit of measurement)</th>
                  <th>Quantity</th>
                   <th>Badget Code</th>
                   <th>Unit Price</th>
                   <th>Total Price</th>
                    
                <th  class="text-center" style="width:10%;">
                   Add/Remove Item
                </th>
            </tr>
        </thead>
        <tbody class="container-items2">
       <?php foreach ($modelsRequisitionItems as $i => $modelRequisitionitem): ?>
            <tr class="item">
                
                
                <td style="width:30%;">
                    
                     <?php
                            // necessary for update action.
                            if (! $modelRequisitionitem->isNewRecord) {
                                echo Html::activeHiddenInput($modelRequisitionitem, "[{$i}]id");
                            }
                        ?> 
                 
                 <?= $form->field($modelRequisitionitem, "[{$i}]designation")->textarea(['rows' => '1'])->label('Item Description') ?>
                
                 
                    
                  
                </td>
                <td style="width:15%">
                 <?=  
                 $form->field($modelRequisitionitem, "[{$i}]specs")->textInput(['autofocus' => true])
                              
                 
                 ?> 
                </td>
                
                 <td style="width:5%">
                    
                    <?=  
                 $form->field($modelRequisitionitem, "[{$i}]uom")->textInput(['autofocus' => true])
                              
                 
                 ?> 
                </td>
                
                <td  style="width:5%" >
                    
                    <?=  
                 $form->field($modelRequisitionitem, "[{$i}]quantity")->textInput(['onchange' => 'getTotal($(this))','onkeyup' => 'getTotal($(this))'])
                              
                 
                 ?> 
                </td>
                
                <td nowrap style="width:10%">
                   <?=  
                 $form->field($modelRequisitionitem, "[{$i}]badget_code")->textInput(['autofocus' => true])
                              
                 
                 ?>  
                    
                </td>
                
                 <td nowrap style="width:5%">
                    
                    <?=  
                 $form->field($modelRequisitionitem, "[{$i}]unit_price")->textInput(['onchange' => 'getTotal($(this))','onkeyup' => 'getTotal($(this))','class'=>'form-control unit_price '])
                              
                 
                 ?> 
                 </td>
                 
                  <td  nowrap style="width:10%" >
                    
                    <?=  
                 $form->field($modelRequisitionitem, "[{$i}]total_amount")->textInput(['autofocus' => true,'class'=>'form-control total_one '])
                              
                 
                 ?> 
                </td>
              
                <td class="text-center vcenter" style="width:10%; verti">
                    <button type="button" class="remove-item btn btn-danger btn-xs bg-red btn-circle"><span style="font-size:16px;" class="fa fa-minus-circle "></span></button>
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
        
        <tfoot>
    <tr>
       <td style="font-size:18px" align="right" colspan="6"><b>Total Price :</b></td>
      <td  class="TotalCell">0</td>
      <td  class="text-center"><button type="button" class="add-item btn btn-success btn-xs bg-green btn-circle"><span style="font-size:16px;" class="fa fa-plus-circle"></span></button></td>
    </tr>
  </tfoot>
    </table>
   </div> 
    
    <?php DynamicFormWidget::end(); ?>       
          
 


