<?php

namespace app\models;

use yii\base\Model;
use app\tools\Films;


class EditFilmsForm extends Model
{
    public $list;
    public $film_list_array;
    public $name;
    public $image;
    public $description;
    public $duration;
    public $limits;
    public $checkbox_remove;

    public function __construct()
    {
        $this->checkbox_remove = 'uncheck';
        $this->film_list_array = Films::fetch_film_list_array(['0' => 'Create new film item']);
    }


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['list', 'name', 'image', 'description', 'duration', 'limits'], 'required'],
            [['image'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            [['checkbox_remove'], 'string']
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'as' => 'df',
        ];
    }

    public function editfilms()
    {

        if ($this->checkbox_remove != 'uncheck' and $this->list != '0') {
            Films::findOne($this->list)->delete();
            $this->checkbox_remove = false;
            $this->film_list_array = Films::fetch_film_list_array(['0' => 'Create a new film item']);
            return true;
        }

        if ($this->validate()) {
            $imgpath = 'images/' . $this->image->baseName . '.' . $this->image->extension;

            if ($this->list == '0') {
                $this->image->saveAs($imgpath);

                $f2 = new Films;
            } else {
                $f2 = Films::findOne($this->list);
            }

            $f2->name = $this->name;
            $f2->photo = $imgpath;
            $f2->description = $this->description;
            $f2->duration = $this->duration;
            $f2->limits = $this->limits;

            $f2->save();


            $this->film_list_array = Films::fetch_film_list_array(['0' => 'Create new film item']);
            return true;
        } else {
            return false;
        }
    }
}