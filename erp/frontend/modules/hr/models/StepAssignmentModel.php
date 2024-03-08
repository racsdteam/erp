<?php
namespace frontend\modules\hr\models;

use Yii;
use yii\base\Model;
use yii\db\Expression;

/**
 * Login form
 */
class StepAssignmentModel extends Model implements \JsonSerializable
{
    public $type;
    public $value;
    public $hrchy_stop;
    public $hrchy_start;
  


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           
            [['type'], 'required'],
            [['type','hrchy_start'],'string'],
            [['hrchy_stop'],'number'],
            ['value','safe'],
                   
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
           
            'type' => 'Assignment Type',
             'value' => 'value',
        ];
    }
    
  
  public function jsonSerialize() {
        
        return array_filter($this->attributes);
    }

}
