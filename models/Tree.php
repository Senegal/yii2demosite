<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tree".
 *
 * @property int $id
 * @property string $title
 * @property string $link
 * @property int $parent_id
 */
class Tree extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tree';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'link'], 'required'],
            [['parent_id'], 'integer'],
            [['title', 'link'], 'string', 'max' => 255],
            [['title', 'link'], 'filter', 'filter' => 'strip_tags'], //XSS
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'link' => 'Link',
            'parent_id' => 'Parent ID',
        ];
    }

    /**
     * recursive delete childs
     * @throws \yii\db\Exception
     */
    public function afterDelete()
    {
        parent::afterDelete();

        $sql = "WITH RECURSIVE subtree(id) AS ( ".
            "VALUES(:id) ".
            "UNION ALL ".
            "SELECT Tree.id ".
            "FROM Tree ".
            "JOIN subtree ON Tree.parent_id = subtree.id ".
        ") ".
        "DELETE FROM Tree WHERE id IN ( SELECT id FROM subtree)";

        Yii::$app->db->createCommand($sql, ['id' => $this->id])->execute();
    }


    /**
     * return grouped tree by parent_id
     * @return []
     */
    public static function prepareTree(){

        $tree = Tree::find()->orderBy(['id' => SORT_ASC])->all();
        return ArrayHelper::index($tree, null, 'parent_id');
    }

}
