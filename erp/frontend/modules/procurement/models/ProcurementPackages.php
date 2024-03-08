<?php

namespace frontend\modules\procurement\models;

use Yii;

/**
 * This is the model class for table "procurement_packages".
 *
 * @property int $id
 * @property int $planId
 * @property int $end_user_org_unit
 * @property string $code
 * @property string $description
 * @property string $procurement_category
 * @property string $procurement_method
 * @property string $funding_sources
 * @property string $status
 * @property int $user
 * @property string $created
 * @property string $updated
 */
class ProcurementPackages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'procurement_packages';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db8');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['planId', 'end_user_org_unit', 'code', 'description', 'procurement_category', 'procurement_method', 'funding_sources', 'user'], 'required'],
            [['planId', 'end_user_org_unit', 'user'], 'integer'],
            [['description', 'status'], 'string'],
            [['created', 'updated'], 'safe'],
            [['code', 'funding_sources'], 'string', 'max' => 255],
            [['procurement_category', 'procurement_method'], 'string', 'max' => 11],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'planId' => 'Plan ID',
            'end_user_org_unit' => 'End User Org Unit',
            'code' => 'Code',
            'description' => 'Description',
            'procurement_category' => 'Procurement Category',
            'procurement_method' => 'Procurement Method',
            'funding_sources' => 'Funding Sources',
            'status' => 'Status',
            'user' => 'User',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }
}
