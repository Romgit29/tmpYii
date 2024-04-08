<?php

namespace backend\models;

use yii\base\Model;

/**
 * PostForm form
 */
class GetOwnPostForm extends Model
{
    public $limit;
    public $offset;
    public $dateFrom;
    public $dateTo;
    public $sortType;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['limit', 'offset'], 'integer'],
            [['limit', 'offset'], 'string', 'min' => 1],
            [['dateFrom', 'dateTo'], 'date', 'format' => 'php:Y-m-d'],
            ['sortType', 'in', 'range' => ['date', 'title']]
        ];
    }
}
