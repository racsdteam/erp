<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "pc_report_other".
 *
 * @property int $id
 * @property int $pc_report_id
 * @property string $project_name
 * @property string $project_description
 * @property string $completed_work
 * @property string $status
 * @property string $timestamp
 *
 * @property PcReport $pcReport
 */
class PcReportOther extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pc_report_other';
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
            [['pc_evaluation_id', 'project_name', 'project_description', 'completed_work', 'status'], 'required'],
            [['pc_evaluation_id'], 'integer'],
            [['project_description', 'completed_work', 'status'], 'string'],
            [['project_name'], 'string', 'max' => 1000],
              [['start_date','end_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pc_evaluation_id' => 'Pc Evaluation ID',
            'project_name' => 'Project Name',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'project_description' => 'Project Description',
            'completed_work' => 'Completed Work',
            'status' => 'Status',
            'timestamp' => 'Timestamp',
        ];
    }

}
