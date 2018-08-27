<?php

namespace app\widgets;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;


class Tree extends \yii\bootstrap\Widget
{


    public $tree;

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        echo isset($this->tree['']) ? $this->renderBranch('', $this->tree) : 'Tree is empty';
    }

    /**
     * render branch
     *
     * @param $parent_id
     * @param $tree
     * @return string
     */
    private function renderBranch($parent_id, $tree)
    {

        return Html::ul($tree[$parent_id], [
            'item' => function ($item, $index) use ($tree) {
                $result = "<li>"
                    ."<span class='lead'>"
                        .Html::a($item['title'], $item['link'])
                    ."</span> "
                    .Html::a('edit', ['site/index', 'id'=>$item->id])." "
                    .Html::a('append', ['site/index', 'parent_id'=>$item->id])." "
                    .Html::a('delete', ['site/delete', 'id'=>$item->id], ['data' => ['confirm' => 'Are you sure?']]);
                if (isset($tree[$item['id']])) {
                    $result .= $this->renderBranch($item['id'], $tree);
                }
                return $result . "</li>";
            }
        ]);

    }


}