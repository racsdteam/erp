<?php
namespace frontend\modules\hr\models;

use Yii;
use yii\base\Model;
use yii\db\Expression;

/**
 * Login form
 */
class ApprovalCondModel extends Model implements \JsonSerializable
{
    public $type;
    public $value;
    
    public $field;
    public $operator;
    public $fieldVal;
  
   


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           
          
            [['type','field','operator','fieldVal'],'string'],
          
            [['value'],'safe'],
            
               [['type'], 'required', 
        
        'when' => function ($model)//----------validation on server side
        {
        return $model->type ==null;
        }, 
        'whenClient' => 'isConditionEnabled' //-----------valiadtion function on client side
    
    ],
                   
         [['value'], 'required', 
        
        'when' => function ($model)//----------validation on server side
        {
        return $model->value ==null;
        }, 
        'whenClient' => 'isContainerVisible' //-----------valiadtion function on client side
    
    ],
            
          
     
        ];
    }

     public function attributeLabels()
    {
        return [
           
            'type' => 'Condition Type',
             'value' => 'Condition',
        ];
    }
    
     public function jsonSerialize() {
        
        return array_filter($this->attributes);
    }

}
