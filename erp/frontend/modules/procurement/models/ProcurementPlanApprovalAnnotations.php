<?php

namespace frontend\modules\procurement\models;

use Yii;

/**
 * This is the model class for table "procurement_plan_approval_annotations".
 *
 * @property int $id
 * @property int $doc
 * @property string $type
 * @property string $annotation
 * @property string $annotation_id
 * @property int $author
 * @property string $timestamp
 */
class ProcurementPlanApprovalAnnotations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'procurement_plan_approval_annotations';
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
            [['doc', 'type', 'annotation'], 'required'],
            [['doc', 'author'], 'integer'],
            [['annotation'], 'string'],
            [['timestamp'], 'safe'],
            [['type'], 'string', 'max' => 256],
            [['annotation_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'doc' => 'Doc',
            'type' => 'Type',
            'annotation' => 'Annotation',
            'annotation_id' => 'Annotation ID',
            'author' => 'Author',
            'timestamp' => 'Timestamp',
        ];
    }
}
