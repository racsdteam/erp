<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "request_annotations".
 *
 * @property int $id
 * @property int $memo
 * @property string $annotation
 * @property string $annotation_id
 * @property int $author
 * @property string $timestamp
 */
class RequestAnnotations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'request_annotations';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db1');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['doc', 'annotation'], 'required'],
            [['doc', 'author'], 'integer'],
            [['annotation'], 'string'],
            [['timestamp'], 'safe'],
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
            'doc' => 'doc',
            'annotation' => 'Annotation',
            'annotation_id' => 'Annotation ID',
            'author' => 'Author',
            'timestamp' => 'Timestamp',
        ];
    }
}
