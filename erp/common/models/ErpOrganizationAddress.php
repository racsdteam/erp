<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_organization_address".
 *
 * @property int $id
 * @property int $org
 * @property int $country
 * @property int $province
 * @property int $city
 * @property string $postal_code
 */
class ErpOrganizationAddress extends \yii\db\ActiveRecord
{

    public $country_code;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_organization_address';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['org', 'country'], 'required'],
            [[ 'province'], 'required', 'whenClient' => "function(attribute, value) {
                return $('#erporganizationaddress-country_code option:selected').val()=='RW';
            }"],
            [['org', 'country', 'province', ], 'integer'],
            [['postal_code','country_code','city'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'org' => 'Org',
            'country_code' => 'Country',
            'province' => 'Province',
            'city' => 'City',
            'postal_code' => 'Postal Code',
        ];
    }
}
