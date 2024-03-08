<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "leave_annotations".
 *
 * @property int $id
 * @property int $doc
 * @property string $annotation
 * @property string $annotation_id
 * @property int $author
 * @property string $timestamp
 */
class PCAnnotations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pc_annotations';
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
            [['doc', 'annotation'], 'required'],
            [['doc', 'author'], 'integer'],
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
            'timestamp' => 'Timestamp',
        ];
    }
}
