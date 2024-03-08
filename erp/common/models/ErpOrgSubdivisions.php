<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_org_subdivisions".
 *
 * @property int $id
 * @property string $subdiv_name
 * @property int $subdiv_level
 * @property int $parent_subdiv
 */
class ErpOrgSubdivisions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_org_subdivisions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subdiv_name', 'subdiv_level'], 'required'],
            [['subdiv_level', 'parent_subdiv'], 'integer'],
            [['subdiv_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subdiv_name' => 'Subdivision Name',
            'subdiv_level' => 'Subdivision Level',
            'parent_subdiv' => ' Parent Subdivision',
        ];
    }
}
