<?php

namespace app\tools;

use yii\db\ActiveRecord;


class Films extends ActiveRecord
{
    public static function tableName()
    {
        return 'films';
    }

    public static function fetch_film_list_array()
    {
        $arr = [];
        $f1 = Films::find()->select('id, name')->asArray()->all();

        foreach ($f1 as $i) {
            $arr[(string)$i['id']] = $i['name'];
        }

        return $arr;
    }
}
