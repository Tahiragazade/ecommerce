<?php

namespace backend\controllers;

use backend\models\Product;
use backend\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use backend\models\Color;
use backend\models\Size;
use backend\models\Category;
use backend\models\Material;
use backend\models\SubCategory;
use backend\models\ProductGender;
use backend\models\ProductSize;
use backend\models\ProductColor;
use backend\models\ProductImage;
use backend\models\ProductCategory;
use backend\models\ProductMaterial;
use backend\models\Gender;
use backend\models\ProductParams;


/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionCreate()
    {
        $model = new Product();

         if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->created_at=date("Y/m/d");
                $model->admin_id=\Yii::$app->user->id;
                $model->save();

                $param = [
                
                'id' => $model->id,
                'image'=>$model->image,
                'gender'=>$model->gender,
                'size'=>$model->size,
                'color'=>$model->color,
                'count'=>$model->count,
                'cost'=>$model->product_cost,
                'category'=>$model->category,
                'material'=>$model->material,
                'discount'=>$model->discount,
                'discount_name'=>$model->discount_name,
                'deadline'=>$model->deadline,


            ];    
                
                \Yii::$app->AddProduct->saveProducts($param);
                    

                return $this->redirect(['view', 'id' => $model->id]);
            
            }
        } else {
            $model->loadDefaultValues();
        }
        
        $data= \Yii::$app->AddProduct->selectData(); 

        return $this->render('create', [
            'model' => $model,
            'data' =>$data,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $productMaterial = ProductMaterial::find()->where(['product_id'=> $id])->all();
        $model->material = ArrayHelper::map($productMaterial, 'id','material_id');

        $productGender = ProductGender::find()->where(['product_id'=> $id])->all();
        $model->gender = ArrayHelper::map($productGender, 'id','gender_id');

        $productImage = ProductImage::findOne(['product_id'=> $id]);
        $model->image = $productImage['image'];

        $productCategory = ProductCategory::findOne(['product_id'=> $id]);
        $model->category = $productCategory['category_id'];

        $productDiscount = Discount::findOne(['product_id'=> $id]);
        $model->discount = $productDiscount['discount_percent'];

        $productParams = ProductParams::find()->where(['product_id'=> $id])->all();

        if ($this->request->isPost && $model->load($this->request->post()) ) {

            $model->save();

            $param = [
                
                'id' => $model->id,
                'image'=>$model->image,
                'gender'=>$model->gender,
                'size'=>$model->size,
                'color'=>$model->color,
                'count'=>$model->count,
                'cost'=>$model->product_cost,
                'category'=>$model->category,
                'material'=>$model->material,
                'discount'=>$model->discount,
                'discount_name'=>$model->discount_name,
                'deadline'=>$model->deadline,


            ];    
                
            \Yii::$app->AddProduct->saveProducts($param);

            return $this->redirect(['view', 'id' => $model->id]);
        }

        $data= \Yii::$app->AddProduct->selectData();        


        return $this->render('update', [
            'model' => $model,
            'data' =>$data,
            'params'=>$productParams,
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    
    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionTest(){
//        $category=Category::find()->all();
        $model=new Product();
        $data=$model->getItems2();
        return $this->asJson($data);
    }
}
