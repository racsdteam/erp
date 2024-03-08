<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_org_jobs".
 *
 * @property int $id
 * @property string $name
 * @property int $level
 * @property string $description
 * @property string $code
 */
class ErpOrgJobs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_org_jobs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
           
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['code','pay_grade'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
           
            'description' => 'Description',
            'code' => 'Code',
        ];
    }
}
