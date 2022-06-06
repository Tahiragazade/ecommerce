<?php
namespace backend\components;

use yii\base\Component;
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
use backend\models\Discount;


class AddProduct extends Component{

  public function saveProducts($param)
  {
    ProductImage::deleteAll(['product_id'=>$param['id']]);
    ProductGender::deleteAll(['product_id'=>$param['id']]);
    ProductCategory::deleteAll(['product_id'=>$param['id']]);
    ProductMaterial::deleteAll(['product_id'=>$param['id']]);
    ProductParams::deleteAll(['product_id'=>$param['id']]);
    Discount::deleteAll(['product_id'=>$param['id']]);

    $productImage = new ProductImage();
    $productImage->image = $param['image'];
    $productImage->product_id = $param['id'];
    $productImage->created_at=date("Y/m/d");
    $productImage->status='1';
    $productImage->save();

    

    foreach($param['gender'] as $value) {
    $productGender = new ProductGender();
    $productGender->gender_id = $value;
    $productGender->product_id = $param['id'];
    $productGender->created_at=date("Y/m/d");
    $productGender->status='1';
    $productGender->save();
    }


    foreach($param['size'] as $key => $value) {
    $productParams = new ProductParams();
    $productParams->size_id = $param['size'][$key];
    $productParams->count = $param['count'][$key];
    $productParams->color_id = $param['color'][$key];
    $productParams->cost=$param['cost'][$key];
    $productParams->product_id = $param['id'];
    $productParams->created_at= date("Y/m/d");
    $productParams->status='1';
    $productParams->save();
    }

    $productCategory = new ProductCategory();
    $productCategory->category_id = $param['category'];
    $productCategory->product_id = $param['id'];
    $productCategory->created_at=date("Y/m/d");
    $productCategory->status='1';
    $productCategory->save();

    $productDiscount = new Discount();
    $productDiscount->discount_percent = $param['discount'];
    $productDiscount->name = $param['discount_name'];
    $productDiscount->deadline = $param['deadline'];
    $productDiscount->product_id = $param['id'];
    $productDiscount->created_at=date("Y/m/d");
    $productDiscount->status='1';
    $productDiscount->save();

    foreach($param['material'] as $value) {
    $productMaterial = new ProductMaterial();
    $productMaterial->material_id = $value;
    $productMaterial->product_id = $param['id'];
    $productMaterial->created_at=date("Y/m/d");
    $productMaterial->status='1';
    $productMaterial->save();
   } 


}
  public function selectData(){

        $categoryList = Category::find()->all();
        $category = ArrayHelper::map($categoryList, 'id', 'name');


        $sizeList = Size::find()->all();
        $size = ArrayHelper::map($sizeList, 'id', 'name');

        $materialList = Material::find()->all();
        $material = ArrayHelper::map($materialList, 'id', 'name');

        $genderList = Gender::find()->all();
        $gender = ArrayHelper::map($genderList, 'id', 'name');

        $colorList = Color::find()->all();
        $color = ArrayHelper::map($colorList, 'id', 'name');

        $discountList = Discount::find()->all();
        $discount = ArrayHelper::map($discountList, 'id', 'name');

        $data = [
            'category' => $category,
            'size' => $size,
            'material' => $material,
            'gender' => $gender,
            'color' => $color,

        ];
        return $data;

  }

  
  

  
}
?>