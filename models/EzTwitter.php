<?php
namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%twitter}}".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $id_str
 * @property string $screen_name
 * @property string $profile_image_url
 * @property string $auth_token
 * @property string $auth_secret
 * @property string $create_time
 * @property string $update_time
 * @property integer $delete
 *
 * @property User $u
 */
class EzTwitter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%twitter}}';
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
            [['auth_token', 'auth_secret'], 'string'],
            [['create_time', 'update_time'], 'safe'],
            [['id_str'], 'string', 'max' => 30],
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
            'id_str' => 'Id Str',
            'screen_name' => 'Screen Name',
            'profile_image_url' => 'Profile Image Url',
            'auth_token' => 'Auth Token',
            'auth_secret' => 'Auth Secret',
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

    /**
     * find user twitter account
     * @param  [type] $uid [description]
     * @return [type]      [description]
     */
    public static function userTwitter($uid = null){
        $uid = $uid ? $uid : \Yii::$app->user->identity->id;
        
        $data = self::findAll([
            'uid' => $uid
        ]);

        return $data;
    }
}
