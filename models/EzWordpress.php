<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%wordpress}}".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $username
 * @property string $password
 * @property string $link
 * @property string $create_time
 * @property string $update_time
 * @property integer $delete
 *
 * @property User $u
 */
class EzWordpress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wordpress}}';
    }

    /**
     * behaviors auto save time
     * @return [type] [description]
     */
    public function behaviors(){
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'create_time',
                'updatedAtAttribute' => 'update_time',
                'value' => new \yii\db\Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'delete'], 'integer'],
            [['uid', 'username', 'password', 'title', 'link'], 'required'],
            [['create_time', 'update_time'], 'safe'],
            [['username', 'link', 'title'], 'string', 'max' => 255],
            [['password'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'username' => 'Username',
            'password' => 'Password',
            'link' => 'Link',
            'title' => 'Blog Title',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'delete' => 'Delete',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getU()
    {
        return $this->hasOne(User::className(), ['id' => 'uid']);
    }

    /**
     * find user's account
     * @param  [type] $uid [description]
     * @return [type]      [description]
     */
    public static function accounts($uid = null){
        $uid = $uid ? $uid : \Yii::$app->user->identity->id;
        $data = self::findAll([
            'uid' => $uid
        ]);

        return $data;
    }
}
