<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_requisition_items".
 *
 * @property int $id
 * @property string $designation
 * @property string $specs
 * @property int $quantity
 * @property string $badget_code
 * @property int $requisition_id
 */
class ErpRequisitionItems extends \yii\db\ActiveRecord
{
    public $excel_file;
    public $choice;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_requisition_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['designation', 'quantity','requisition_id','unit_price'], 'required','when' => function ($model) { 
              return $model->choice == 1; 
          }, 
          'whenClient' => "function (attribute, value) { 
              return $('div.choice input:radio:checked').val() == '1'; 
          }"],
            [['specs','uom'], 'string'],
            [['unit_price','total_amount'],'string','max' => 255],
            [['requisition_id','user'], 'integer'],
            [['designation', 'badget_code'], 'string', 'max' => 255],
            [['quantity'], 'number'],
            [['excel_file'], 'file','skipOnEmpty' => false, 'extensions' => 'xls, xlsx', 'maxSize'=>1024*1024*20],//validating inputfile
            
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'designation' => 'Designation',
            'specs' => 'Specs',
            'quantity' => 'Qty',
            'badget_code' => 'Badget Code',
            'requisition_id' => 'Requisition ID',
            'uom'=>'uom'
        ];
    }
}
