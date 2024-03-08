<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_travel_request".
 *
 * @property int $id
 * @property int $type
 * @property string $request_code
 * @property string $purpose
 * @property string $departure_date
 * @property string $return_date
 * @property string $destination
 * @property int $memo
 * @property string $created
 * @property int $created_by
 * @property string $status
 * @property int $is_new
 */
class ErpEmployeeTravels extends \yii\db\ActiveRecord
{
    
   
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_employee_travels';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'tr_id'], 'required'],
            [['tr_id'], 'integer'],
           
            [['timestamp'], 'safe'],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            
           
        ];
    }
}
