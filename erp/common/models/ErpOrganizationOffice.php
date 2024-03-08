<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_organization_office".
 *
 * @property int $id
 * @property string $office
 */
class ErpOrganizationOffice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_organization_office';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['office'], 'required'],
            [['office'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'office' => 'Office',
        ];
    }
}
