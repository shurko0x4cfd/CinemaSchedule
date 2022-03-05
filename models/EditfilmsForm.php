<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;


class Films extends ActiveRecord
{
    public static function tableName()
    {
        return 'films';
    }
}


/**
 * ContactForm is the model behind the contact form.
 */
class EditfilmsForm extends Model
{
    public $list;
    public $film_list_array;
    public $name;
    public $image;
    public $description;
    public $duration;
    public $limits;
    public $chckbox;

    function __construct()
    {
        $this->film_list_array = $this->fetch_film_list_array();
    }

    function fetch_film_list_array()
    {
        $arr = ['0' => 'Create new'];
        $f1 = Films::find()->select('id, name')->asArray()->all();
        $cnt = count($f1);

        foreach ($f1 as $i) {
            $arr[(string)$i['id']] = $i['name'];
        }

        return $arr;
    }


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['list', 'name', 'image', 'description', 'duration', 'limits'], 'required'],
            [['image'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            [['chckbox'], 'string']
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

        if ($this->chckbox != 'uncheck' and $this->list != '0') {
            $f2 = Films::findOne($this->list)->delete();
            $this->chckbox = false;
            $this->film_list_array = $this->fetch_film_list_array();
            return true;
        }

        if ($this->validate()) {
            $imgpath = 'images/' . $this->image->baseName . '.' . $this->image->extension;

            if ($this->list == '0') {
                //$this->current = $this->list;
                $this->image->saveAs($imgpath);

                $f2 = new Films;

                $f2->name = $this->name;
                $f2->photo = $imgpath;
                $f2->description = $this->description;
                $f2->duration = $this->duration;
                $f2->limits = $this->limits;

                $f2->save();
            } else {
                $f2 = Films::findOne($this->list);

                $f2->name = $this->name;
                $f2->photo = $imgpath;
                $f2->description = $this->description;
                $f2->duration = $this->duration;
                $f2->limits = $this->limits;

                $f2->save();
            }

            $this->film_list_array = $this->fetch_film_list_array();
            return true;
        } else {
            return false;
        }
    }
}
