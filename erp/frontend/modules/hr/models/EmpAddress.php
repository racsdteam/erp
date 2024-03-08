<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "emp_address".
 *
 * @property int $id
 * @property int $employee
 * @property int $country
 * @property int $province
 * @property int $district
 * @property int $sector
 * @property string $village
 * @property string $city
 * @property string $address_line1 street number
 * @property string $address_line2 house number
 * @property string $address_line_3 house name
 * @property string $address_type
 */
class EmpAddress extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_address';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db4');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
          
            [['employee', 'country'], 'required', 'on'=>['create','update']],
            [['employee', 'province', 'district', 'sector'], 'integer'],
            [['address_type', 'country'], 'string'],
            [['cell', 'village', 'city', 'address_line1', 'address_line2', 'address_line_3'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employee' => 'Employee',
            'country' => 'Country',
            'province' => 'Province',
            'district' => 'District',
            'sector' => 'Sector',
            'cell' => 'Cell',
            'village' => 'Village',
            'city' => 'City',
            'address_line1' => 'Address Line1',
            'address_line2' => 'Address Line2',
            'address_line_3' => 'Address Line 3',
            'address_type' => 'Address Type',
        ];
    }

    /**
     * {@inheritdoc}
     * @return EmpAddressQuery the active query used by this AR class.
     */
    /*public static function find()
    {
        return new EmpAddressQuery(get_called_class());
    }*/
    
    public static function instantiate($row)
{
    switch ($row['address_type']) {
        case EmpAddressPermanent::TYPE:
            return new EmpAddressPermanent();
        case EmpAddressCurrent::TYPE:
            return new EmpAddressCurrent();
        default:
           return new self;
    }
}
}
