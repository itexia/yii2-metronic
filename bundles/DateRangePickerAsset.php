<?php

/**
 * @copyright Copyright (c) 2014 Digital Deals s.r.o.
 * @license http://www.digitaldeals.cz/license/
 */

namespace dlds\metronic\bundles;

/**
 * DateRangePickerAsset for dateRangePicker widget.
 */
class DateRangePickerAsset extends BaseAssetBundle
{


    public $js = [
      'global/plugins/moment.min.js',
      'global/plugins/bootstrap-daterangepicker/daterangepicker.js',
    ];

    public $css = [
      'global/plugins/bootstrap-daterangepicker/daterangepicker.css',
      'global/plugins/bootstrap-datetimepicker/css/datetimepicker.css',
    ];

    public $depends = [
      'dlds\metronic\bundles\CoreAsset',
    ];

}
