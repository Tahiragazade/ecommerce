<?php

namespace frontend\models;

use Yii;
use backend\models\ProductParams;


/**
 * This is the model class for table "cart".
 *
 * @property int $id
 * @property int $user_id
 * @property int $param_id
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property ProductParams $param
 * @property User $user
 */
class Cart extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cart';
    }

    /**
     * {@inheritdoc}
     */
    public $size_id;
    public $color_id;
    public function rules()
    {
        return [
            [['user_id', 'param_id', 'status','count'], 'required'],
            [['user_id', 'param_id','count', 'status', 'size_id','color_id'], 'integer'],
            [['param_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductParams::className(), 'targetAttribute' => ['param_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'param_id' => 'Param ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Param]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParam()
    {
        return $this->hasOne(ProductParams::className(), ['id' => 'param_id']);
        $cart->params->product->name;
    }



    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    
}
