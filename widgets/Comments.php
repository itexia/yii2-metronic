<?php

namespace dlds\metronic\widgets;

use yii\helpers\Html;


/**
 * Class Comments
 *
 * Renders comments (see http://keenthemes.com/preview/metronic/theme/admin_4/)
 *
 * @package dlds\metronic\widgets
 */
class Comments extends Widget
{

    /**
     * Array of comments in form:
     * [
     *      'image' => ...,
     *      'author' => (string) '',
     *      'date' => (date) '',
     *      'message' => (string) '',
     *      'status' => (string) '',
     *      'actions' => (array) []
     * ]
     *
     * see also Comment::widget();
     *
     * @var array
     */
    public $comments;

    /**
     * @var (array) helper
     */
    private $html = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @inheritdoc
     *
     * @return string
     */
    public function run()
    {
        $this->renderComments();

        return Html::tag('div', implode('', $this->html),
          ['class' => 'mt-comments']);
    }

    /**
     * Renders all comments
     *
     * @return array
     * @throws \Exception
     */
    protected function renderComments()
    {
        foreach ($this->comments ?? [] as $comment) {
            $this->html[] = Comment::widget($comment);
        }

        return $this->html;
    }
}