<?php

class Payment_inc extends Diafan {

    after public function success($pay, $type = 'all') {
        switch ($type) {
            case 'all':
            case 'pay':
                if ('cart' == $pay['module_name']) {
                    $this->diafan->_orangedata->create_order($pay['element_id']);
                }
                break;
        }
    }

}
