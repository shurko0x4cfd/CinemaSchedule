<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;

use yii\web\UploadedFile;
use app\models\EditFilmsForm;
use app\models\HandleDwlStuff;
use app\models\EditScheduleForm;
use app\models\Index;


class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            /* 'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ] */
        ];
    }


    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new Index();
        $model->index();

        return $this->render('index', ['model' => $model]);
    }


    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }


    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    public function actionEditSchedule()
    {
        $model = new EditScheduleForm();
        $model->load(Yii::$app->request->post());
        //return $this->refresh();

        $model->editschedule();

        return $this->render('editschedule', [
            'model' => $model,
        ]);
    }


    public function actionEditFilms()
    {
        $model = new EditFilmsForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->is_should_remove()) {
                $model->remove_film();
            } else {
                $img_handler = new HandleDwlStuff;
                $img_handler->image   = $model->image   = $image = UploadedFile::getInstance($model, 'image');
                $img_handler->imgpath = $model->imgpath = 'images/' . $image->baseName . '.' . $image->extension;

                if ($img_handler->validate() and $model->validate()) {
                    $model->editfilms();
                    $img_handler->store_image();
                }
            }
        }
        return $this->render('editfilms', ['model' => $model]);
    }


    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    /*    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    } */

    /**
     * Displays about page.
     *
     * @return string
     */
    /*   public function actionAbout()
    {
        return $this->render('about');
    } */
}
