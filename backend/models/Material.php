<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "material".
 *
 * @property int $id
 * @property string $name
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property ProductMaterial[] $productMaterials
 */
class Material extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'material';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'status'], 'required'],
            [['status'], 'integer'],
            [['name', 'created_at', 'updated_at'], 'string', 'max' => 25],
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
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[ProductMaterials]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductMaterials()
    {
        return $this->hasMany(ProductMaterial::className(), ['material_id' => 'id']);
    }
}
