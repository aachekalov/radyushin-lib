<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "book".
 *
 * @property integer $id
 * @property string $name
 *
 * @property BookGenre[] $bookGenres
 * @property Genre[] $genres
 * @property BookVote[] $bookVotes
 * @property BookWriter[] $bookWriters
 * @property Writer[] $writers
 */
class Book extends \yii\db\ActiveRecord
{
    public $writers;
    public $genres;

    public $votes;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'writers', 'genres'], 'required'],
            [['name'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название книги',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookGenres()
    {
        return $this->hasMany(BookGenre::className(), ['book_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGenres()
    {
        return $this->hasMany(Genre::className(), ['id' => 'genre_id'])->viaTable('book_genre', ['book_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookVotes()
    {
        return $this->hasMany(BookVote::className(), ['book_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookWriters()
    {
        return $this->hasMany(BookWriter::className(), ['book_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWriters()
    {
        return $this->hasMany(Writer::className(), ['id' => 'writer_id'])->viaTable('book_writer', ['book_id' => 'id']);
    }
}
