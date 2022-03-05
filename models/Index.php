<?php

namespace app\models;

use yii\base\Model;


/**
 * ContactForm is the model behind the contact form.
 */
class Index extends Model
{
    public $session_items;


    public function fetch_sessions()
    {
        $result  = (new \yii\db\Query())
            ->select(['name', 'photo', 'description', 'duration', 'limits', 'time', 'price'])
            ->from(['films', 'schedule'])
            ->where('films.id = schedule.film')
            ->orderBy(['time' => SORT_DESC])
            ->all();

        return $result;
    }


    public function index()
    {
        $this->session_items = $this->fetch_sessions();

        return true;
    }
}
