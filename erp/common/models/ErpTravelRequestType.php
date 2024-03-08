<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_travel_request_type".
 *
 * @property int $id
 * @property string $type
 */
class ErpTravelRequestType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_travel_request_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type','code'], 'required'],
            [['type','code'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
        ];
    }
}
