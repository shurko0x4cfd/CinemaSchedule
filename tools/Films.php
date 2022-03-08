<?php

namespace app\tools;

use yii\db\ActiveRecord;


class Films extends ActiveRecord
{
    public static function tableName()
    {
        return 'films';
    }

    public static function fetch_film_list_array($result = [])
    {
        $films = Films::find()->select('id, name')->asArray()->all();

        foreach ($films as $i) {
            $result[(string)$i['id']] = (string)$i['id'] . ' - ' . $i['name'];
        }

        return $result;
    }
}
