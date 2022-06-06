<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "gender".
 *
 * @property int $id
 * @property string $name
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property ProductGender[] $productGenders
 */
class Gender extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gender';
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
     * Gets query for [[ProductGenders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductGenders()
    {
        return $this->hasMany(ProductGender::className(), ['gender_id' => 'id']);
    }
}
