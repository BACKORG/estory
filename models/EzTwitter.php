<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use Yii;

/**
 * This is the model class for table "ez_twitter".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $screen_name
 * @property string $profile_image_url
 * @property string $auth_token
 * @property string $auth_secret
 * @property string $createtime
 */
class EzTwitter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ez_twitter';
    }

    /**
     * behaviors auto save time
     * @return [type] [description]
     */
    public function behaviors(){
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['create_time', 'update_time'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['update_time'],
                ],
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
            [['uid'], 'integer'],
            [['auth_token', 'auth_secret'], 'string'],
            [['create_time', 'update_time'], 'safe'],
            [['screen_name'], 'string', 'max' => 100],
            [['profile_image_url'], 'string', 'max' => 200]
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
            'screen_name' => 'Screen Name',
            'profile_image_url' => 'Profile Image Url',
            'auth_token' => 'Auth Token',
            'auth_secret' => 'Auth Secret',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time'
        ];
    }
}
