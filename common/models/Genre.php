<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "genre".
 *
 * @property integer $id
 * @property string $name
 *
 * @property BookGenre[] $bookGenres
 * @property Book[] $books
 * @property GenreVote[] $genreVotes
 */
class Genre extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'genre';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название жанра',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookGenres()
    {
        return $this->hasMany(BookGenre::className(), ['genre_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBooks()
    {
        return $this->hasMany(Book::className(), ['id' => 'book_id'])->viaTable('book_genre', ['genre_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGenreVotes()
    {
        return $this->hasMany(GenreVote::className(), ['genre_id' => 'id']);
    }

    /**
     * Finds genres by genres IDs
     *
     * @param array $genresIds
     * @return array
     */
    public static function findByIds(array $genresIds): array
    {
        $genres = static::findAll($genresIds);
        if (count($genres) != count($genresIds)) {
            throw new \Exception('Some genre is gone...');
        }
        return $genres;
    }
}
