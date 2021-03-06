<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
// use app\widgets\Alert;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="w-100 h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column w-100 h-100">

    <?php $this->beginBody() ?>

    <header>
        <?php
        $is_admin = !(Yii::$app->user->isGuest);
        NavBar::begin([
            'brandLabel' => Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
            ],
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'items' => [
                $is_admin ? (['label' => 'Edit films', 'url' => ['/site/edit-films']]) : (''),
                $is_admin ? (['label' => 'Edit schedule', 'url' => ['/site/edit-schedule']]) : (''),
                $is_admin ? (['label' => 'View result', 'url' => ['/site/index']]) : (''),

                $is_admin ? ('<li>'
                    . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
                    . Html::submitButton(
                        'Logout (' . Yii::$app->user->identity->username . ')',
                        ['class' => 'btn btn-link logout']
                    )
                    . Html::endForm()
                    . '</li>'
                ) : ('')
            ],
        ]);
        NavBar::end();
        ?>
    </header>

    <main role="main">
        <div class="container">
            <?= $content ?>
        </div>
    </main>

    <footer class="footer mt-auto py-3 text-muted">
        <div class="container">
            <p class="float-left">&copy; Cinema <?= date('Y') ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>