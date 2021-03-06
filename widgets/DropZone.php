<?php

namespace dlds\metronic\widgets;

use yii\helpers\Html;
use yii\helpers\Json;
use dlds\metronic\bundles\DropZoneAsset;

class DropZone extends Widget
{

    /**
     * @var array An array of options that are supported by Dropzone
     */
    public $options = [];

    /**
     * @var array An array of client events that are supported by Dropzone
     */
    public $clientEvents = [];

    /**
     * @var array An array of previously uploaded files
     */
    public $existingFiles = [];

    //Default Values
    public $id = 'myDropzone';

    public $uploadUrl = 'site/upload';

    public $dropzoneContainer = 'myDropzone';

    public $previewsContainer = 'previews';

    public $autoDiscover = false;

    public $model = null;

    public $attribute = [];

    /**
     * Initializes the widget
     *
     * @throw InvalidConfigException
     */
    public function init()
    {
        parent::init();
        //set defaults
        if (!isset($this->options['url'])) {
            $this->options['url'] = $this->uploadUrl;   // Set the url
        }

        // Define the element that will contain the uploaded files
        if (!isset($this->options['previewsContainer'])) {
            $this->options['previewsContainer'] = '#' . $this->previewsContainer;
        }

        // Define the element that should be used as click trigger to select files.
        if (!isset($this->options['clickable'])) {
            $this->options['clickable'] = true;
        }

        if (!isset($this->options['cssClasses'])) {
            $this->options['cssClasses'] = 'dropzone';
        }

        $this->autoDiscover = $this->autoDiscover === false ? 'false' : 'true';

        if (\Yii::$app->getRequest()->enableCsrfValidation) {
            $this->options['headers'][\yii\web\Request::CSRF_HEADER] = \Yii::$app->getRequest()
              ->getCsrfToken();
            $this->options['params'][\Yii::$app->getRequest()->csrfParam] = \Yii::$app->getRequest()
              ->getCsrfToken();
        }
        $this->registerAssets();
    }

    public function run()
    {
        return Html::tag('div', $this->renderDropzone(), [
          'id'    => $this->dropzoneContainer,
          'class' => $this->options['cssClasses'],
        ]);
    }

    private function renderDropzone()
    {
        $data = Html::tag('div', '',
          ['id' => $this->previewsContainer, 'class' => 'dropzone-previews']);
        return $data;
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        $js = 'Dropzone.autoDiscover = ' . $this->autoDiscover . '; var ' . $this->id . ' = new Dropzone("div#' . $this->dropzoneContainer . '", ' . Json::encode($this->options) . ');';
        if (!empty($this->clientEvents)) {
            foreach ($this->clientEvents as $event => $handler) {
                $js .= "$this->id.on('$event', $handler);";
            }
        }

        // add JS for existing files
        if (count($this->existingFiles) > 0) {
            foreach ($this->existingFiles as $fileArray) {
                $filename = $fileArray['filename'];
                $filenameServer = $fileArray['filenameOnServer'];
                $filesize = $fileArray['filesize'] ? $fileArray['filesize'] : 1;

                $url = $fileArray['url'];

                if ($url) {
                    $js .= '
                    // Create the mock file:
                    var mockFile = { name: "' . $filename . '", servername: "' . $filenameServer . '", size: ' . $filesize . ' };
                    
                    // add mockFile
                    ' . $this->id . '.files.push(mockFile); // TODO: needed?
                    ' . $this->id . '.emit("addedfile", mockFile);
                    
                    // TODO: create thumbnail?
//                    ' . $this->id . '.options.thumbnail.call(' . $this->id . ', mockFile, "' . addslashes($url) . '");
    
                    // or use existing as thumb?
                    ' . $this->id . '.emit("thumbnail", mockFile, "' . addslashes($url) . '");
    
                    // Make sure that there is no progress bar, etc...
                    ' . $this->id . '.emit("complete", mockFile);
                ';
                }
            }
        }

        $view->registerJs($js);
        DropZoneAsset::register($view);
    }
}