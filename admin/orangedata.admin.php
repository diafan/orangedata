<?php

/**
 * Настройки модуля
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

class Orangedata_admin extends Frame_admin {

    /**
     * @var array поля в базе данных для редактирования
     */
    public $variables = array(
        'config' => array(
            'hr1' => array(
                'type' => 'title',
                'name' => 'Настройки безопасности',
            ),
            'sign_pkey' => array(
                'type' => 'text',
                'name' => 'Приватный ключ для подписи запросов в формате .pem',
            ),
            'client_cert' => array(
                'type' => 'text',
                'name' => 'Клиентский сертификат',
            ),
            'client_key' => array(
                'type' => 'text',
                'name' => 'Приватный ключ SSL',
            ),
            'client_cert_pass' => array(
                'type' => 'password',
                'name' => 'Пароль для приватного ключа SSL',
            ),
            'hr2' => array(
                'type' => 'title',
                'name' => 'Информация об организации',
            ),
            'inn' => array(
                'type' => 'text',
                'name' => 'ИНН',
                'multilang' => false,
            ),
            'tax' => array(
                'type' => 'select',
                'name' => 'Настройки ставок НДС',
                'select' => array(
                    '1' => 'ставка НДС 18%',
                    '2' => 'ставка НДС 10%',
                    '3' => 'ставка НДС расч. 18/118',
                    '4' => 'ставка НДС расч. 10/110',
                    '5' => 'ставка НДС 0%',
                    '6' => 'НДС не облагается'
                ),
            ),
            'taxationSystem' => array(
                'type' => 'select',
                'name' => 'Система налогообложения',
                'select' => array(
                    '0' => 'Общая, ОСН',
                    '1' => 'Упрощенная доход, УСН доход',
                    '2' => 'Упрощенная доход минус расход, УСН доход - расход',
                    '3' => 'Единый налог на вмененный доход, ЕНВД',
                    '4' => 'Единый сельскохозяйственный налог, ЕСН',
                    '5' => 'Патентная система налогообложения, Патент'
                )
            ),
            'hr3' => 'hr',
            'mode' => array(
                'type' => 'select',
                'name' => 'Режим работы кассы',
                'select' => array(
                    'demo' => 'тестовый',
                    'work' => 'боевой'
                )
            ),
        )
    );

    /**
     * @var array настройки модуля
     */
    public $config = array(
        'config', // файл настроек модуля
    );

    /**
     * Подготавливает конфигурацию модуля
     * @return void
     */
    public function prepare_config() {
        
    }

}
