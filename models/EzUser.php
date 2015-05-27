<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ez_user".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $createtime
 * @property string $ip
 */
class EzUser extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ez_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['createtime'], 'safe'],
            [['username', 'password', 'ip'], 'string', 'max' => 45],
            [['email'], 'string', 'max' => 100]
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
            'createtime' => 'Createtime',
            'ip' => 'Ip',
        ];
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
