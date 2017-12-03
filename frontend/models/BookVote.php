<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "book_vote".
 *
 * @property integer $id
 * @property integer $value
 * @property integer $book_id
 * @property integer $user_id
 *
 * @property Book $book
 * @property User $user
 */
class BookVote extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'book_vote';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value', 'book_id', 'user_id'], 'required'],
            [['value', 'book_id', 'user_id'], 'integer'],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::className(), 'targetAttribute' => ['book_id' => 'id']],
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
            'book_id' => 'Book ID',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBook()
    {
        return $this->hasOne(Book::className(), ['id' => 'book_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
