<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "report_datasets".
 *
 * @property int $id
 * @property int $report
 * @property string $dataset
 * @property string $type
 * @property string $datasource
 *
 * @property ReportTemplates $report0
 */
class ReportDatasets extends \yii\db\ActiveRecord
{
    
    public $type='SPROC';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'report_datasets';
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
            [['report', 'dataset', 'type', 'datasource'], 'required'],
            [['report'], 'integer'],
            [['dataset', 'datasource'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 11],
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
            'type' => 'Type',
            'datasource' => 'Datasource',
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
