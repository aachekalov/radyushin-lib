<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "writer".
 *
 * @property integer $id
 * @property string $surname
 * @property string $name
 *
 * @property BookWriter[] $bookWriters
 * @property Book[] $books
 */
class Writer extends \yii\db\ActiveRecord
{
    public $bookCount;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'writer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['surname', 'name'], 'required'],
            [['surname', 'name'], 'string', 'max' => 128],
        ];
    }

    public function getFullName(): string {
        return $this->surname . ' ' . $this->name;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'surname' => 'Фамилия',
            'name' => 'Имя',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookWriters()
    {
        return $this->hasMany(BookWriter::className(), ['writer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBooks()
    {
        return $this->hasMany(Book::className(), ['id' => 'book_id'])->viaTable('book_writer', ['writer_id' => 'id']);
    }

    /**
     * Finds writers by writers IDs
     *
     * @param array $writersIds
     * @return array
     */
    public static function findByIds(array $writersIds): array
    {
        $writers = static::findAll($writersIds);
        if (count($writers) != count($writersIds)) {
            throw new \Exception('Some writer is gone...');
        }
        return $writers;
    }
}
