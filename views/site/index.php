<?php

/** @var yii\web\View $this */

$this->title = 'Session list';
?>

<div class="">

    <div class="">
        <div class="row">
            <div class="col-lg-12">

                <?php
                $items = $model->session_items;
                $formatter = Yii::$app->formatter;

                foreach ($items as $item) {
                    print '<div style="margin-top: 100px">';

                    print '<img src="images/gs.png"></img>';

                    print '<h3>' . $item['name'] . '</h3>';

                    print '<p>Duration: ' . $item['duration'] . 'm</p>';

                    print '<p> ' . $item['description'] . ' </p>';

                    print '<p>Time: ' . $formatter->asDatetime($item['time'], 'yyyy-mm-dd hh:mm:ss') . '</p>';

                    print '<p>Age: ' . $item['limits'] . '+</p>';

                    print '<p>Price: ' . $item['price'] . '</p>';
                    
                    print '<div>';
                }
                ?>

            </div>
        </div>
    </div>

</div>