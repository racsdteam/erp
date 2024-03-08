<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_memo_supporting_doc_annotations".
 *
 * @property int $id
 * @property int $memo
 * @property string $annotation
 * @property int $author
 * @property string $timestamp
 */
class ErpMemoSupportingDocAnnotations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_memo_supporting_doc_annotations';
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
            'memo' => 'Doc',
            'annotation' => 'Annotation',
            'author' => 'Author',
            'timestamp' => 'Timestamp',
        ];
    }
}
