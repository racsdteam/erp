<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "payroll_report_categories".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $code
 */
class PayrollReportCategories extends \yii\db\ActiveRecord
{
    
     const CATEG_PAY_DED_CONT='DED';
     const CATEG_PAY_DET='PD';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payroll_report_categories';
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
            [['name',  'code'], 'required'],
            [['name', 'description'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 11],
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
