<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\LogSender;

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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $message = "Привет, мир!";
        // $logSender = new LogSender();
        // $logSender->setType('database');
        // $emailLogger = $logSender->send($message);
        return $this->render('index', [
            // 'message' => $emailLogger,
            'message' => $message,
        ]);
    }
    /**
    *Sends a log message to the default logger.
    */
    public function log()
    {
        $message = 'test';
        $logSender = new LogSender();
        $emailLogger = $logSender->send($message);
        return $this->render('index', [
            'message' => $emailLogger,
        ]);
    }

    /**
    *Sends a log message to a special logger.
    *
    *@param string $type
    */
    public function logTo(string $type)
    {
        $message = "Привет, мир!";
        $logSender = new LogSender();
        $logSender->setType($type);
        $Logger = $logSender->sendByLogger($message, $type);
        return $this->render('index', [
            'message' => $Logger,
        ]);
    }

    /**
    *Sends a log message to all loggers.
    */
    public function logToAll()
    {
        $message = "Привет, мир!";
        $logSender = new LogSender();
        $Logger = '';
        $logSender->setType('database');
        $Logger .= $logSender->send($message);
        $logSender->setType('email');
        $Logger .= $logSender->send($message);
        $logSender->setType('file');
        $Logger .= $logSender->send($message);
        return $this->render('index', [
            'message' => $Logger,
        ]);
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

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
