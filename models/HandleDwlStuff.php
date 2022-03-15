<?php

namespace app\models;

use yii\base\Model;
use app\tools\Films;


class HandleDwlStuff extends Model
{
    public $imgpath;
    public $image;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['image'], 'required'],
            [['image'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }


    public function store_image()
    {
        if ($this->validate()) {
            $this->image->saveAs($this->imgpath);

            return true;
        } else {
            return false;
        }
    }
}
