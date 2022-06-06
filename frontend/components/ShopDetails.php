<?php
namespace frontend\components;

use yii\base\Component;
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
use backend\models\Discount;
use backend\models\Product;
use frontend\models\Cart;



class ShopDetails extends Component{

  public function showProducts($id)
  {
        $productMaterial = ProductMaterial::find()->where(['product_id'=> $id])->all();
        $material = ArrayHelper::map($productMaterial, 'id','material_id');

        $product = Product::findOne(['id'=>$id]);
       

        $productGender = ProductGender::find()->where(['product_id'=> $id])->all();
        $gender = ArrayHelper::map($productGender, 'id','gender_id');

        $productImage = ProductImage::findOne(['product_id'=> $id]);
        $image = $productImage['image'];

        $productCategory = ProductCategory::findOne(['product_id'=> $id]);
        $category = $productCategory['category_id'];

        $productDiscount = Discount::findOne(['product_id'=> $id]);
        $discount = $productDiscount['discount_percent'];

        $productParams = ProductParams::find()->where(['product_id'=> $id])->all();


        $data = [
            'category' => $category,
            'material' => $material,
            'gender' => $gender,
            'image' => $image,
            'productParams'=>$productParams,
            'discount'=>$discount,
            'product'=>$product,

        ];
        return $data;
  }
  public function selectColor($id)
    {

        $colorId = ProductParams::findAll(['id'=>$id]);
        

        return $this->render('view', [
            'colorId' => $colorId,
        ]);
    }

    public function viewCart()
    {

      $params=array();

      $carts=Cart::find()->where(['user_id'=> \Yii::$app->user->id])->andWhere(['status'=>1])->all();

      foreach ($carts as $cart)
      {
        $param_id=$cart['param_id'];
        $param=ProductParams::find()->where(['id'=> $param_id])->one();
     
        $product=Product::find()->where(['id'=> $param->product_id])->one();
        
        $discount=Discount::find()->where(['product_id'=> $param->product_id])->one();

        $data=[
          'cart_id'=>$cart['id'],
          'count'=>$cart['count'],
          'param_id'=>$cart['param_id'],
          'product_id'=>$param['product_id'],
          'product_name'=>$product->name,
          'cost'=>$product->cost,
          'discount'=>$discount->discount_percent,
        ];
        array_push($params,$data);

        //array_push($params['product_name'], $product->name);
        
      }
      return $params;
    }
    public function viewWishlist()
    {

      $params=array();

      $carts=Cart::find()->where(['user_id'=> \Yii::$app->user->id])->andWhere(['status'=>3])->all();

      foreach ($carts as $cart)
      {
        $param_id=$cart['param_id'];
        $param=ProductParams::find()->where(['id'=> $param_id])->one();
     
        $product=Product::find()->where(['id'=> $param->product_id])->one();
        
        $discount=Discount::find()->where(['product_id'=> $param->product_id])->one();

        $data=[
          'cart_id'=>$cart['id'],
          'count'=>$cart['count'],
          'param_id'=>$cart['param_id'],
          'product_id'=>$param['product_id'],
          'product_name'=>$product->name,
          'cost'=>$product->cost,
          'discount'=>$discount->discount_percent,
        ];
        array_push($params,$data);

        //array_push($params['product_name'], $product->name);
        
      }
      return $params;
    }
}