<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_organization_contact".
 *
 * @property int $id
 * @property int $org
 * @property string $phone
 * @property string $website
 */
class ErpOrganizationContact extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_organization_contact';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['org', 'phone', 'website'], 'required'],
            [['org'], 'integer'],
            [['phone', 'website'], 'string', 'max' => 255],
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
            'phone' => 'Phone',
            'website' => 'Website',
        ];
    }
}
