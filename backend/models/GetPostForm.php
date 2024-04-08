<?php

namespace backend\models;

use yii\base\Model;

/**
 * PostForm form
 */
class GetPostForm extends Model
{
    public $limit;
    public $offset;
    public $sortType;
    public $dateFrom;
    public $dateTo;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['limit', 'offset'], 'integer'],
            [['limit', 'offset'], 'string', 'min' => 1],
            [['dateFrom', 'dateTo'], 'date', 'format' => 'php:Y-m-d'],
            ['sortType', 'in', 'range' => ['date']]
        ];
    }
}
