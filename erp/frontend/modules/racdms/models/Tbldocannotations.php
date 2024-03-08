<?php

namespace frontend\modules\racdms\models;

use Yii;

/**
 * This is the model class for table "tbldocannotations".
 *
 * @property int $id
 * @property int $doc
 * @property string $annotation
 * @property string $annotation_id
 * @property int $author
 * @property int $author_type
 * @property string $timestamp
 */
class Tbldocannotations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbldocannotations';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db3');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['doc', 'annotation', 'annotation_id', 'author', 'author_type'], 'required'],
            [['doc', 'author', 'author_type'], 'integer'],
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
            'doc' => 'Doc',
            'annotation' => 'Annotation',
            'annotation_id' => 'Annotation ID',
            'author' => 'Author',
            'author_type' => 'Author Type',
            'timestamp' => 'Timestamp',
        ];
    }
}
