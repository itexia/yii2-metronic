<?php
/**
 * @copyright Copyright (c) 2014 Digital Deals s.r.o.
 * @license http://www.digitaldeals.cz/license/
 */

namespace dlds\metronic\bundles;

/**
 * ModalAsset for modal widget.
 */
class ModalAsset extends BaseAssetBundle
{

    public $css = [
      'global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css',
      'global/plugins/bootstrap-modal/css/bootstrap-modal.css',
    ];

    public $depends = [
      'dlds\metronic\bundles\CoreAsset',
    ];
}
