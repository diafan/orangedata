<?php

/**
 * Установка модуля
 *
 * @package    DIAFAN.CMS
 * @author     diafan.ru
 * @version    6.0
 * @license    http://www.diafan.ru/license.html
 * @copyright  Copyright (c) 2003-2016 OOO «Диафан» (http://www.diafan.ru/)
 */
if (!defined('DIAFAN')) {
    $path = __FILE__;
    $i = 0;
    while (!file_exists($path . '/includes/404.php')) {
        if ($i == 10)
            exit;
        $i++;
        $path = dirname($path);
    }
    include $path . '/includes/404.php';
}

class Orangedata_install extends Install {

    /**
     * @var string название
     */
    public $title = "OrangeData";

    /**
     * @var array записи в таблице {modules}
     */
    public $modules = array(
        array(
            "name" => "orangedata",
            "admin" => true,
            "site" => false,
            "site_page" => false,
        ),
    );

    /**
     * @var array меню административной части
     */
    public $admin = array(
        array(
            "name" => "OrangeData",
            "rewrite" => "orangedata",
            "group_id" => "2",
            "act" => true,
            "children" => array(
                array(
                    "name" => "OrangeData",
                    "rewrite" => "orangedata",
                    "act" => true,
                ),
            )
        ),
    );

    /**
     * @var array настройки
     */
    public $config = array(
        array(
            "name" => "sign_pkey",
            "value" => "private_key.pem",
        ),
        array(
            "name" => "client_cert",
            "value" => "client.crt",
        ),
        array(
            "name" => "client_key",
            "value" => "client.key",
        ),
        array(
            "name" => "client_cert_pass",
            "value" => "1234",
        ),
        array(
            "name" => "inn",
            "value" => "0123456789",
        ),
        array(
            "name" => "tax",
            "value" => '1',
        ),
        array(
            "name" => "taxationSystem",
            "value" => "0",
        ),
        array(
            "name" => "mode",
            "value" => "demo",
        ),
       
    );

}
