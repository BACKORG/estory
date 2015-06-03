<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $ip
 * @property string $create_time
 * @property string $update_time
 * @property integer $delete
 *
 * @property Twitter[] $twitters
 */
class EzUser extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_time', 'update_time'], 'safe'],
            [['delete'], 'integer'],
            [['username', 'password'], 'string', 'max' => 45],
            [['email'], 'string', 'max' => 100]
        ];
    }


    /**
     * behaviors auto save time
     * @return [type] [description]
     */
    public function behaviors(){
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'create_time',
                'updatedAtAttribute' => 'update_time',
                'value' => new \yii\db\Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'email' => 'Email',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'delete' => 'Delete',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTwitters()
    {
        return $this->hasMany(Twitter::className(), ['uid' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }
    
    /**
     * @inheritdoc
     * not implement this function
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
      * @inheritdoc
      */
     public function getId()
     {
         return $this->id;
     }

     /**
      * @inheritdoc
      * not implement this function
      */
     public function getAuthKey()
     {
         return null;
     }

     /**
      * @inheritdoc
      * not implement this function
      */
     public function validateAuthKey($authKey)
     {
         return null;
     }

    /**
     * find user by email and password
     * @param  [type] $email    [description]
     * @param  [type] $password [description]
     * @return [type]           [description]
     */
    public static function findByEmail($email){
        $user = self::find()
            ->where(['email' => $email])
            ->one();

        return $user;
    }

    /**
     * validate password
     * @param  [type] $password [description]
     * @return [type]           [description]
     */
    public function checkPassword($password){
        if(strcasecmp($this->password, md5($password) ) === 0){
            return true;
        }
        return false;
    }
}
