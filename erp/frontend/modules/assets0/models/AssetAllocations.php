<?php

namespace frontend\modules\assets0\models;

use Yii;
use frontend\modules\hr\models\Employees;
use common\models\ErpOrgUnits;
use common\models\User;
/**
 * This is the model class for table "asset_allocations".
 *
 * @property int $id
 * @property int $asset
 * @property string $ass_cond
 * @property int $org_unit
 * @property int $employee
 * @property string $allocation_date
 * @property int $user
 * @property string $timestamp
 */
class AssetAllocations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'asset_allocations';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db7');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['asset', 'allocation_type', 'user'], 'required','on'=>['create','update']],
            [['asset', 'org_unit', 'employee', 'user','active'], 'integer'],
            [['allocation_type'], 'string'],
            [['allocation_date', 'timestamp'], 'safe'],
            [['employee',], 'required', 
        
        'when' => function ($model)//----------validation on server side
        {
        return $model->allocation_type =='E';
        }, 
        'whenClient' => "isEmpOptionChecked" //-----------valiadtion function on client side
    
    ],
            [['org_unit',], 'required', 
        
        'when' => function ($model)//----------validation on server side
        {
        return $model->allocation_type =='OU';
        }, 
        'whenClient' => "isOUOptionChecked" //-----------valiadtion function on client side
    
    ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'asset' => 'Asset',
            'org_unit' => 'Org Unit',
            'employee' => 'employee',
            'allocation_date' => 'Allocation Date',
            'allocation_type'=>'Allocation Type',
            'user' => 'User',
            'timestamp' => 'Timestamp',
        ];
    }
    
    public function getEmployee0()
    {
        return $this->hasOne(Employees::className(), ['id' => 'employee']);
    } 
    
    public function getOrgUnit0()
    {
        return $this->hasOne(ErpOrgUnits::className(), ['id' => 'org_unit']);
    }
     public function getAsset0()
    {
        return $this->hasOne(Assets::className(), ['id' => 'asset']);
    }
    
   
    
    public function getUser0()
    {
        return $this->hasOne(User::className(), ['user_id' => 'user']);
    }
}
