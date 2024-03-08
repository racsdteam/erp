<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "erp_org_jobs".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $code
 * @property string $pay_grade
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
            [['code'], 'string', 'max' => 20],
            [['pay_grade'], 'string', 'max' => 11],
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
            'pay_grade' => 'Pay Grade',
        ];
    }
}
