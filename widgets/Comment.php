<?php

namespace dlds\metronic\widgets;


use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Class Comment
 *
 * Renders one comment (see
 * http://keenthemes.com/preview/metronic/theme/admin_4/)
 *
 * @package dlds\metronic\widgets
 */
class Comment extends Widget
{

    /**
     * @var string url to get image from
     */
    public $image;

    /**
     * @var string class if no image is given. (show default image)
     */
    public $defaultImageClass;

    /**
     * @var string
     */
    public $author;

    /**
     * @var date formated
     */
    public $date;

    /**
     * @var string
     */
    public $message;

    /**
     * @var string
     */
    public $status = '';

    /**
     * @var array
     */
    public $actions = [];

    /**
     * @var array helper
     */
    protected $html = [];

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
        $this->renderImage();

        $this->renderBody();

        return Html::tag('div', implode('', $this->html),
          ['class' => 'mt-comment']);
    }

    /**
     * Renders image.
     *
     * @return array|void
     */
    protected function renderImage()
    {
        if (!$this->image && !$this->defaultImageClass) {
            return;
        }

        if (!$this->image){
            $this->html[] = Html::tag('div', Html::tag('i', '',
              ['class' => $this->defaultImageClass]),
              ['class' => 'mt-comment-img']);
            return $this->html;
        }

        $this->html[] = Html::tag('div', Html::img(Url::toRoute([$this->image]), ['height' => '45px']),
          ['class' => 'mt-comment-img']);

        return $this->html;
    }

    /**
     * Renders comments' body
     *
     * @return array
     */
    protected function renderBody()
    {
        $body = [];

        $info = $this->renderInfo();

        $body[] = Html::tag('div', implode('', $info),
          ['class' => 'mt-comment-info']);

        $body[] = Html::tag('div', $this->message,
          ['class' => 'mt-comment-text']);

        $details = $this->renderDetails();
        $body[] = Html::tag('div', implode('', $details),
          ['class' => 'mt-comment-details']);

        $this->html[] = Html::tag('div', implode('', $body),
          ['class' => 'mt-comment-body']);

        return $this->html;
    }

    /**
     * Renders info of comment body.
     *
     * @return array
     */
    private function renderInfo()
    {
        return [
          Html::tag('span', $this->author, ['class' => 'mt-comment-author']),
          Html::tag('span', $this->date, ['class' => 'mt-comment-date']),
        ];
    }

    /**
     * Renders details of comment body.
     *
     * @return array
     */
    private function renderDetails()
    {
        $details = [];
        $details[] = Html::tag('span', $this->status,
          ['class' => 'mt-comment-status']);

        return $details;
    }

}