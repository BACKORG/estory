<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%post_twitter}}".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $content
 * @property string $create_time
 * @property string $update_time
 * @property integer $delete
 *
 * @property User $u
 */
class EzPostTwitter extends \yii\db\ActiveRecord
{

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
    public static function tableName()
    {
        return '{{%post_twitter}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'delete'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['content'], 'string', 'max' => 255]
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
            'content' => 'Content',
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
}
