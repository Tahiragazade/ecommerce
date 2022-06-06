<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $cost
 * @property int $admin_id
 * @property int $status
 * @property string $created_at
 * @property string|null $updated_at
 *
 * @property ProductCategory[] $productCategories
 * @property ProductColor[] $productColors
 * @property ProductGender[] $productGenders
 * @property ProductImage[] $productImages
 * @property ProductMaterial[] $productMaterials
 * @property ProductParams[] $productParams
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
    public function rules()
    {
        return [
            [['name', 'description', 'cost', 'admin_id', 'status', 'created_at'], 'required'],
            [['description'], 'string'],
            [['cost', 'admin_id', 'status'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['created_at', 'updated_at'], 'string', 'max' => 25],
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

    /**
     * Gets query for [[ProductParams]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductParams()
    {
        return $this->hasMany(ProductParams::className(), ['product_id' => 'id']);
    }
}
