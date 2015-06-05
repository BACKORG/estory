<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%instagram}}".
 *
 * @property string $id
 * @property string $uid
 * @property string $username
 * @property string $full_name
 * @property string $profile_picture
 * @property string $access_token
 * @property string $create_time
 * @property string $update_time
 * @property integer $delete
 *
 * @property User $u
 */
class EzInstagram extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%instagram}}';
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
            [['id', 'uid', 'instagram_id', 'delete'], 'integer'],
            [['access_token'], 'string'],
            [['create_time', 'update_time'], 'safe'],
            [['username', 'full_name'], 'string', 'max' => 100],
            [['profile_picture'], 'string', 'max' => 255]
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
            'instagram_id' => 'Instagram User Id',
            'username' => 'Username',
            'full_name' => 'Full Name',
            'profile_picture' => 'Profile Picture',
            'access_token' => 'Access Token',
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
     * find user instagram account
     * @param  [type] $uid [description]
     * @return [type]      [description]
     */
    public static function userInstagram($uid){
        $data = self::findAll([
            'uid' => $uid
        ]);

        return $data;
    }

    /**
     * insert data
     * @param  [type] $parameters [description]
     * @return [type]             [description]
     */
    public static function insertDt($parameters){
        $ezTwitter = new self;
        $ezTwitter->setAttributes($parameters);
        $ezTwitter->save();
    }

    /**
     * update data
     * @param  [type] $parameters [description]
     * @return [type]             [description]
     */
    public static function updateDt($id, $parameters){
        $ezTwitter = self::findOne($id);
        $ezTwitter->setAttributes($parameters);
        $ezTwitter->save();
    }
}
