<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "book_writer".
 *
 * @property integer $book_id
 * @property integer $writer_id
 *
 * @property Book $book
 * @property Writer $writer
 */
class BookWriter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'book_writer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['book_id', 'writer_id'], 'required'],
            [['book_id', 'writer_id'], 'integer'],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::className(), 'targetAttribute' => ['book_id' => 'id']],
            [['writer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Writer::className(), 'targetAttribute' => ['writer_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'book_id' => 'Book ID',
            'writer_id' => 'Writer ID',
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
    public function getWriter()
    {
        return $this->hasOne(Writer::className(), ['id' => 'writer_id']);
    }
}
