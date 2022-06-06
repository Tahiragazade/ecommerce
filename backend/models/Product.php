<?php

namespace backend\models;


use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $cost
 * @property int $admin_id
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property ProductCategory[] $productCategories
 * @property ProductColor[] $productColors
 * @property ProductGender[] $productGenders
 * @property ProductImage[] $productImages
 * @property ProductMaterial[] $productMaterials
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public $image1=array();
    public $image;
    public $category;
    public $gender;
    public $sub_category;
    public $color;
    public $material;
    public $size;
    public $count;
    public $product_cost;
    public $discount;
    public $discount_name;
    public $deadline;

    public function rules()
    {
        return [
            [['name', 'description', 'cost', 'image',  'status','category','gender','color','material','size','product_cost','count'], 'required'],
            [['description','discount_name','deadline'], 'string'],
            [['cost', 'admin_id','discount', 'status'], 'integer'],
            [['name'], 'string',  'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'cost' => 'Cost',
            'admin_id' => 'Admin ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[ProductCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductCategories()
    {
        return $this->hasMany(ProductCategory::className(), ['product_id' => 'id']);
    }

    /**
     * Gets query for [[ProductColors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductColors()
    {
        return $this->hasMany(ProductColor::className(), ['product_id' => 'id']);
    }

    /**
     * Gets query for [[ProductGenders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductGenders()
    {
        return $this->hasMany(ProductGender::className(), ['product_id' => 'id']);
    }

    /**
     * Gets query for [[ProductImages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductImages()
    {
        return $this->hasMany(ProductImage::className(), ['product_id' => 'id']);
    }

    /**
     * Gets query for [[ProductMaterials]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductMaterials()
    {
        return $this->hasMany(ProductMaterial::className(), ['product_id' => 'id']);
    }


   public static function getItems($indent = ' ', $parent_group = null)
{
    $items = [];
    // for all childs of $parent_group (roots if $parent_group == null)
    $groups = Category::find()->where(['parent_group'=>$parent_group])->all();
    foreach($groups as $group)
    {
        // add group to items list 
        $items[$group->id] =  $indent.$group->name;

        // recursively add children to the list with indent
        $items = array_replace($items, self::getItems($indent.' --', $group->id));
    }
    return $items;
}
    public static function getItems2($indent = ' ', $parent_group = null)
    {
        $items = [];
        // for all childs of $parent_group (roots if $parent_group == null)
        $groups = Category::find()->where(['parent_group'=>$parent_group])->all();
        foreach($groups as $group)
        {
            // add group to items list
            $items[] = array(
                'key' => $group->id,
                'value' => $group->id,
                'title' => $indent.$group->name,

            );
            // recursively add children to the list with indent
            $items = array_replace($items, self::getItems($indent.' -', $group->id));

        }
        return $items;
    }

}
