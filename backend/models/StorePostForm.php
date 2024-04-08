<?php

namespace backend\models;

use yii\base\Model;

/**
 * PostForm form
 */
class StorePostForm extends Model
{
    public $title;
    public $text;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['title', 'required'],
            ['text', 'required'],
        ];
    }
}
