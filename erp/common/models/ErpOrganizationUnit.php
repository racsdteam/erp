<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_organization_unit".
 *
 * @property int $id
 * @property string $unit_name
 * @property int $org
 */
class ErpOrganizationUnit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_organization_unit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['unit_name', 'org'], 'required'],
            [['org'], 'integer'],
            [['unit_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'unit_name' => 'Unit Name',
            'org' => 'Org',
        ];
    }
}
