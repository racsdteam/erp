<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_memo_annotations".
 *
 * @property int $id
 * @property int $doc
 * @property string $annotation
 * @property int $author
 * @property string $timestamp
 */
class ErpMemoAnnotations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_memo_annotations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['memo', 'annotation'], 'required'],
            [['memo', 'author'], 'integer'],
            [['annotation'], 'string'],
            [['timestamp'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'memo' => 'Memo',
            'annotation' => 'Annotation',
            'author' => 'Author',
            'timestamp' => 'Timestamp',
        ];
    }
}
