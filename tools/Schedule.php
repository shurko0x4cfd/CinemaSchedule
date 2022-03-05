<?php

namespace app\tools;

use yii\db\ActiveRecord;


class Schedule extends ActiveRecord
{
    public static function tableName()
    {
        return 'schedule';
    }
}

?>
