<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "genre_vote".
 *
 * @property integer $id
 * @property integer $value
 * @property integer $genre_id
 * @property integer $user_id
 *
 * @property Genre $genre
 * @property User $user
 */
class GenreVote extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'genre_vote';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value', 'genre_id', 'user_id'], 'required'],
            [['value', 'genre_id', 'user_id'], 'integer'],
            [['genre_id'], 'exist', 'skipOnError' => true, 'targetClass' => Genre::className(), 'targetAttribute' => ['genre_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'оценка',
            'genre_id' => 'Genre ID',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGenre()
    {
        return $this->hasOne(Genre::className(), ['id' => 'genre_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
