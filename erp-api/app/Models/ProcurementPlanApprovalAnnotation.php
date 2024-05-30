<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $doc
 * @property string $type
 * @property string $annotation
 * @property string $annotation_id
 * @property integer $author
 * @property string $timestamp
 */
class ProcurementPlanApprovalAnnotation extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['doc', 'type', 'annotation', 'annotation_id', 'author', 'timestamp'];
}
