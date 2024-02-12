<?php

namespace common\models\search;

use common\models\Author;
use common\models\BookAuthor;
use common\models\BookCategory;
use common\models\Category;
use common\models\Status;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Book;
use yii\db\ActiveQuery;

/**
 * BookSearch represents the model behind the search form of `common\models\Book`.
 */
class BookSearch extends Book
{
    public $statusLabel;
    public $authors;
    public $categories;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'page_count', 'status'], 'integer'],
            [
                [
                    'isbn',
                    'title',
                    'published_date',
                    'thumbnail_url',
                    'short_description',
                    'long_description',
                    'statusLabel',
                    'authors',
                    'categories'
                ],
                'safe'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = self::find()
            ->alias('b')
            ->select([
                'b.id',
                'b.isbn',
                'b.title',
                'b.published_date',
                'b.page_count',
                'statusLabel' => 's.name',
                'authors' => "GROUP_CONCAT(DISTINCT a.name SEPARATOR ', ')",
                'categories' => "GROUP_CONCAT(DISTINCT c.name SEPARATOR ', ')"
            ])
            ->leftJoin(["s" => Status::tableName()], 'b.status = s.id')
            ->leftJoin(['ba' => BookAuthor::tableName()], 'ba.book = b.id')
            ->leftJoin(['a' => Author::tableName()], 'a.id = ba.author')
            ->leftJoin(['bc' => BookCategory::tableName()], 'bc.book = b.id')
            ->leftJoin(['c' => Category::tableName()], 'c.id = bc.category')
            ->groupBy([
                'b.id'
            ]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'published_date' => $this->published_date,
            'page_count' => $this->page_count,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'isbn', $this->isbn])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'thumbnail_url', $this->thumbnail_url])
            ->andFilterWhere(['like', 'short_description', $this->short_description])
            ->andFilterWhere(['like', 'long_description', $this->long_description])
            ->andFilterHaving(['like', 'categories', $this->categories])
            ->andFilterHaving(['like', 'authors', $this->authors]);

        return $dataProvider;
    }
}
