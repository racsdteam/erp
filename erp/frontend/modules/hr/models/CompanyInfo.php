<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "company_info".
 *
 * @property int $id
 * @property string $comp_name
 * @property string $comp_reg_number
 * @property int $user
 * @property string $timestamp
 */
class CompanyInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company_info';
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
            [['comp_name', 'comp_reg_number', 'user'], 'required'],
            [['user'], 'integer'],
            [['timestamp'], 'safe'],
            [['comp_name', 'comp_reg_number'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'comp_name' => 'Comp Name',
            'comp_reg_number' => 'Comp Reg Number',
            'user' => 'User',
            'timestamp' => 'Timestamp',
        ];
    }
}
