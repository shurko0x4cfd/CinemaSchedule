<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\tools\Schedule;
use app\tools\Films;




class EditscheduleForm extends Model
{
    public $list;
    public $session_list_array;

    public $film_list_array;
    public $film;

    public $datetime;
    public $price;

    public $checkbox_remove;

    public $too_near;


    public function __construct()
    {
        $this->checkbox_remove = 'uncheck';
        $this->list = '0';
        $this->datetime = date('Y-m-d h:m:s');
        $this->session_list_array = $this->fetch_session_list_array();
        $this->film_list_array = Films::fetch_film_list_array();
    }


    private function fetch_session_list_array()
    {
        $res = ['0' => 'Create new session'];
        $f1 = Schedule::find()->select('id, film')->asArray()->all();
        $film_list = Films::fetch_film_list_array();

        foreach ($f1 as $i) {
            $film_id = $i['film'];
            if (array_key_exists($film_id, $film_list)) {
                $res[(string)$i['id']] = $i['id'] . ' - ' . $film_list[$film_id];
            } else {
                $this->remove_schedule_item($i['id']);
            }
        }

        return $res;
    }


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['list', 'film', 'datetime', 'price'], 'required'],
            [['checkbox_remove'], 'string'],
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

    private function check_gap($datetime, $tablename)
    {
        /* $near_count  = (new \yii\db\Query())
            ->select(['id'])
            ->from(['schedule'])
            ->where('abs(time - ' . strtotime("$datetime GMT") . ') < 108000')
            ->groupBy('id')
            ->count('id'); */

        $near_count = Yii::$app
            ->db
            ->createCommand('SELECT distinct COUNT(id) FROM ' . $tablename . ' where abs(time - ' . strtotime("$datetime GMT") . ') < 1800')
            ->queryScalar();

        return $near_count > 0;
    }


    private function remove_schedule_item($primary_key)
    {
        $f2 = Schedule::findOne($primary_key)->delete();
        $this->checkbox_remove = 'uncheck';
        $this->session_list_array = $this->fetch_session_list_array();
        $this->film_list_array = Films::fetch_film_list_array();
        return true;
    }


    public function editschedule()
    {

        if ($this->checkbox_remove != 'uncheck' and $this->list != '0') {
            return $this->remove_schedule_item($this->list);
        }

        // Delete schedule items corresponding to deleted movies
        $this->fetch_session_list_array();

        if ($this->validate()) {
            $datetime = $this->datetime;

            if ($this->list == '0') {
                $too_near = $this->check_gap($datetime, 'schedule');

                if ($too_near) {
                    $this->too_near = 'Too near! Choose a session no closer than 30m to another';
                    return true;
                } else {
                    $this->too_near = '';
                }

                $f2 = new Schedule;
            } else {
                $f2 = Schedule::findOne($this->list);
            }

            if (!$f2) {
                return false;
            }

            $f2->film = $this->film;
            $f2->time = strtotime("$datetime GMT");
            $f2->price = $this->price;

            $f2->save();

            $this->session_list_array = $this->fetch_session_list_array();
            $this->film_list_array = Films::fetch_film_list_array();

            return true;
        } else {
            return false;
        }
    }
}
