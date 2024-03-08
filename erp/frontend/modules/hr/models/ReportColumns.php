<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "report_columns".
 *
 * @property int $id
 * @property int $report
 * @property string $dataset
 * @property string $field
 * @property string $display_name
 * @property int $display_order
 *
 * @property ReportTemplates $report0
 */
class ReportColumns extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'report_columns';
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
            [['report', 'dataset', 'field', 'display_name', 'display_order'], 'required'],
            [['report', 'display_order'], 'integer'],
            [['dataset', 'field', 'display_name'], 'string', 'max' => 255],
            [['report'], 'exist', 'skipOnError' => true, 'targetClass' => ReportTemplates::className(), 'targetAttribute' => ['report' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'report' => 'Report',
            'dataset' => 'Dataset',
            'field' => 'Field',
            'display_name' => 'Display Name',
            'display_order' => 'Display Order',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReport0()
    {
        return $this->hasOne(ReportTemplates::className(), ['id' => 'report']);
    }
}
