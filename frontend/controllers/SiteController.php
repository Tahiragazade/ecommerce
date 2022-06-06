<?php

namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\models\ProductSearch;
use common\models\Product;
use frontend\models\Cart;
use yii\helpers\Json;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public $enableCsrfValidation = false;
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                     [
                        'actions' => ['shop'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['cart'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['wishlist'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['cart-status'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
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
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
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
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

    public function actionShop()
    {

        $model=new Product;
        $products = Product::findAll(['status'=>1]);
        

        return $this->render('shop', [
            'products' => $products,
        ]);
    }

    public function actionView($id)
    {   
       $data = \Yii::$app->shopDetails->showProducts($id);
       $model= new Cart;
        return $this->render('view', [
            'data' => $data,
            'model'=>$model,
        ]);

    }

    public function actionCreate()
    {
        $model = new Cart();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->user_id=\Yii::$app->user->id;
                $model->param_id=$model->color_id;
                $model->status=1;
                $model->created_at=date("Y/m/d");
                $model->save();
                
                if($model->save(false)){
                print_r($model->getErrors());

                }
                return $this->redirect(['cart']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('cart');
}
    public function actionLists($id)
    {   
        
        $session = Yii::$app->session;
        $product_id = $session->get('product_id');
        
        //$request = Yii::$app->request;
        //id=$request->post('id');
        

        $colors = \backend\models\ProductParams::find()
                ->where(['product_id'=>$product_id])
                ->andWhere(['size_id' => $id])                
                ->orderBy('id DESC')
                ->all();

        $size=array();
        if($colors){
            foreach($colors as $color){

                $color_name = \backend\models\Color::find()->where(['id' => $color->color_id])->one();
                $name=$color_name->name;
                array_push($size,'<option value="'.$color->id.'">'.$name.'</option>');
                //echo '<option value="'.$color->id.'">'.$color->color_id.'</option>';
            }
            return implode($size);
        }
        else{
           // echo '<option><option>';
        }
       
    }

    public function actionCart()
    {
        $model = new Cart();
        $params = \Yii::$app->shopDetails->viewCart();
        return $this->render('cart',[
             'model' => $model,
            'params' => $params
        ]);
    }

    public function actionWishlist()
    {
        $model = new Cart();
        $params = \Yii::$app->shopDetails->viewWishlist();
        return $this->render('wishlist',[
             'model' => $model,
            'params' => $params
        ]);
    }
   public function actionUpdate()
    {
        $model=new Cart();
        $request = Yii::$app->request;
        
        if (!empty($request->post('count'))) 
        {
            
            $count=filter_var($request->post('count'), FILTER_SANITIZE_NUMBER_INT);
            $id=filter_var($request->post('basket_id'), FILTER_SANITIZE_NUMBER_INT);
            
            //die($id);
            
            $cart = Cart::findOne($id);
            $cart->count = $count;
            $cart->save();
            
                return Json::encode(['success' => true]);
            
            
            // return $this->render('cart',[
            //  'model' => $model,
            // 'carts' => $carts]);
        } 
        else {  
            echo "error";
        }
            
        
        $carts = \Yii::$app->shopDetails->viewCart();
        return $this->render('cart',[
             'model' => $model,
            'carts' => $carts]);
    }

    public function actionDelete($id)
    {
        $model=new Cart();
        $cart = Cart::findOne($id);
        $cart->status=3;
        $cart->save();

        $params = \Yii::$app->shopDetails->viewCart();
        return $this->render('cart',[
             'model' => $model,
            'params' => $params
        ]);
    }
    public function actionBuy()
    {
        $model=new Cart;
        $user_id=\Yii::$app->user->id;
        Cart::updateAll(['status' => 2], ['=', 'status', '1']&& ['=','user_id',$user_id]);

    }
    
}
