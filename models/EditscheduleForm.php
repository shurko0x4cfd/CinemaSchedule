<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;



class Schedule extends ActiveRecord
{
    public static function tableName()
    {
        return 'schedule';
    }
}

class Films extends ActiveRecord
{
    public static function tableName()
    {
        return 'films';
    }
}

class FFLA extends Model
{
    public function fetch_film_list_array()
    {
        $arr = [];
        $f1 = Films::find()->select('id, name')->asArray()->all();
        $cnt = count($f1);

        foreach ($f1 as $i) {
            $arr[(string)$i['id']] = $i['name'];
        }

        return $arr;
    }
}


/**
 * ContactForm is the model behind the contact form.
 */
class EditscheduleForm extends Model
{
    public $list;
    public $session_list_array;

    public $film_list_array;
    public $film;

    public $datetime;
    public $price;

    public $chckbox;

    public $formatter;

    public $too_near;

    function __construct()
    {
        $this->chckbox = 'uncheck';
        $this->formatter = \Yii::$app->formatter;
        $this->session_list_array = $this->fetch_session_list_array();
        $this->film_list_array = $this->fetch_film_list_array();
        // $this->datetime = $this->formatter->asDatetime(4567, 'yyyy-mm-dd hh:mm:ss'); // 2022-03-04 00:00:00
    }

    function fetch_session_list_array()
    {
        $res = ['0' => 'Create new session'];
        $f1 = Schedule::find()->select('id, film')->asArray()->all();
        $film_list = $this->fetch_film_list_array();

        foreach ($f1 as $i) {
            $film_id = $i['film'];
            $res[(string)$i['id']] = $i['id'] . ' - ' . $film_list[$film_id];
        }

        return $res;
    }

    function fetch_film_list_array()
    {
        return (new FFLA)->fetch_film_list_array();
    }


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['list', 'film', 'datetime', 'price'], 'required'],
            [['chckbox'], 'string'],
            [['datetime'], 'string']
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

    private function check_gap($datetime)
    {
        $near_count  = (new \yii\db\Query())
            ->select(['id'])
            ->from(['schedule'])
            ->where('abs(time - ' . strtotime("$datetime GMT") . ') < 108000')
            ->groupBy('id')
            ->count('id');

        $near_count = Yii::$app->db->createCommand('SELECT distinct COUNT(id) FROM schedule where abs(time - ' . strtotime("$datetime GMT") . ') < 1800')
            ->queryScalar();

        return $near_count > 0;
    }

    public function editschedule()
    {

        if ($this->chckbox != 'uncheck' and $this->list != '0') {
            $f2 = Schedule::findOne($this->list)->delete();
            $this->chckbox = false;
            $this->session_list_array = $this->fetch_session_list_array();
            $this->film_list_array = $this->fetch_film_list_array();
            return true;
        }

        if ($this->validate()) {
            $datetime = $this->datetime;

            if ($this->list == '0') {
                $too_near = $this->check_gap($datetime);

                if ($too_near) {
                    $this->too_near = 'Too near! Choose a session no closer than 30m to another';
                    return true;
                } else {
                    $this->too_near = '';
                }


                $f2 = new Schedule;

                $f2->film = $this->film;

                $f2->time = strtotime("$datetime GMT");
                $f2->price = $this->price;

                $f2->save();
            } else {
                $f2 = Schedule::findOne($this->list);

                $f2->film = $this->film;

                $f2->time = strtotime("$datetime GMT");
                $f2->price = $this->price;

                $f2->save();
            }

            $this->session_list_array = $this->fetch_session_list_array();
            $this->film_list_array = $this->fetch_film_list_array();

            return true;
        } else {
            return false;
        }
    }
}
