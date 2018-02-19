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
                array(
                    "name" => "Настройки",
                    "rewrite" => "orangedata/config",
                    "act" => true,
                ),
            )
        ),
    );

    /**
     * @var array настройки
     */
    
    // Надо будет почистить это говно все отсюда
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

    /**
     * @var array таблицы в базе данных
     */
    public $tables = array(
            /* array(
              "name" => "pm_projects",
              "comment" => "Проекты",
              "fields" => array(
              array(
              "name" => "id",
              "type" => "INT(11) UNSIGNED NOT NULL AUTO_INCREMENT",
              "comment" => "идентификатор",
              ),
              array(
              "name" => "parent_id",
              "type" => "INT(11) UNSIGNED NOT NULL DEFAULT '0'",
              "comment" => "идентификатор родителя из таблицы {site}",
              ),
              array(
              "name" => "count_children",
              "type" => "SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0'",
              "comment" => "количество вложенных страниц",
              ),
              array(
              "name" => "name",
              "type" => "VARCHAR(100) NOT NULL DEFAULT ''",
              "comment" => "название",
              "multilang" => true,
              ),
              array(
              "name" => "text",
              "type" => "TEXT NOT NULL",
              "comment" => "описание",
              "multilang" => true,
              ),
              array(
              "name" => "task",
              "type" => "ENUM('0', '1') NOT NULL DEFAULT '0'",
              "comment" => "нужно выполнить: 0 - нет, 1 - да",
              ),
              array(
              "name" => "question",
              "type" => "ENUM('0', '1') NOT NULL DEFAULT '0'",
              "comment" => "нужно выполнить: 0 - нет, 1 - да",
              ),
              array(
              "name" => "label_id",
              "type" => "INT(11) UNSIGNED NOT NULL DEFAULT '0'",
              "comment" => "идентификатор родителя из таблицы {pm_label}",
              ),
              array(
              "name" => "prior",
              "type" => "ENUM('0', '1') NOT NULL DEFAULT '0'",
              "comment" => "важно, всегда сверху: 0 - нет, 1 - да",
              ),
              array(
              "name" => "attached",
              "type" => "VARCHAR(100) NOT NULL DEFAULT ''",
              "comment" => "прикреплено к",
              ),
              array(
              "name" => "date_start",
              "type" => "INT(10) UNSIGNED NOT NULL DEFAULT '0'",
              "comment" => "дата начала показа",
              ),
              array(
              "name" => "date_finish",
              "type" => "INT(10) UNSIGNED NOT NULL DEFAULT '0'",
              "comment" => "дата окончания показа",
              ),
              array(
              "name" => "created",
              "type" => "INT(10) UNSIGNED NOT NULL DEFAULT '0'",
              "comment" => "дата создания",
              ),
              array(
              "name" => "admin_id",
              "type" => "INT(11) UNSIGNED NOT NULL DEFAULT '0'",
              "comment" => "пользователь из таблицы {users}, добавивший или первый отредктировавший статью в административной части",
              ),
              array(
              "name" => "timeedit",
              "type" => "INT(10) UNSIGNED NOT NULL DEFAULT '0'",
              "comment" => "время последнего изменения в формате UNIXTIME",
              ),
              array(
              "name" => "trash",
              "type" => "ENUM('0', '1') NOT NULL DEFAULT '0'",
              "comment" => "запись удалена в корзину: 0 - нет, 1 - да",
              ),
              ),
              "keys" => array(
              "PRIMARY KEY (id)",
              "KEY parent_id (parent_id)",
              ),
              ),
              array(
              "name" => "pm_projects_parents",
              "comment" => "Родительские связи страниц сайта",
              "fields" => array(
              array(
              "name" => "id",
              "type" => "INT(11) UNSIGNED NOT NULL AUTO_INCREMENT",
              "comment" => "идентификатор",
              ),
              array(
              "name" => "element_id",
              "type" => "INT(11) UNSIGNED NOT NULL DEFAULT '0'",
              "comment" => "идентификатор страницы из таблицы {site}",
              ),
              array(
              "name" => "parent_id",
              "type" => "INT(11) UNSIGNED NOT NULL DEFAULT '0'",
              "comment" => "идентификатор страницы-родителя из таблицы {site}",
              ),
              array(
              "name" => "trash",
              "type" => "ENUM('0', '1') NOT NULL DEFAULT '0'",
              "comment" => "запись удалена в корзину: 0 - нет, 1 - да",
              ),
              ),
              "keys" => array(
              "PRIMARY KEY (id)",
              "KEY parent_id (parent_id)",
              "KEY element_id (element_id)",
              ),
              ),
              array(
              "name" => "pm_implement",
              "comment" => "Участники",
              "fields" => array(
              /* array(
              "name" => "id",
              "type" => "INT(11) UNSIGNED NOT NULL AUTO_INCREMENT",
              "comment" => "идентификатор",
              ),
              array(
              "name" => "type",
              "type" => "ENUM('project', 'task') NOT NULL DEFAULT 'project'",
              "comment" => "",
              ),
              array(
              "name" => "element_id",
              "type" => "INT(11) UNSIGNED NOT NULL DEFAULT '0'",
              "comment" => "",
              ),
              array(
              "name" => "user_id",
              "type" => "INT(11) UNSIGNED NOT NULL DEFAULT '0'",
              "comment" => "",
              ),
              array(
              "name" => "trash",
              "type" => "ENUM('0', '1') NOT NULL DEFAULT '0'",
              "comment" => "запись удалена в корзину: 0 - нет, 1 - да",
              ),
              ),
              "keys" => array(
              //"PRIMARY KEY (id)",
              "KEY element_id (`element_id`)",
              "KEY user_id (`user_id`)",
              ),
              ),
              array(
              "name" => "pm_label",
              "comment" => "Метки",
              "fields" => array(
              array(
              "name" => "id",
              "type" => "INT(11) UNSIGNED NOT NULL AUTO_INCREMENT",
              "comment" => "идентификатор",
              ),
              array(
              "name" => "name",
              "type" => "VARCHAR(100) NOT NULL DEFAULT ''",
              "comment" => "название",
              "multilang" => true,
              ),
              array(
              "name" => "color",
              "type" => "VARCHAR(7) NOT NULL DEFAULT '#F5F3F4'",
              "comment" => "цвет",
              "multilang" => false,
              ),
              array(
              "name" => "state",
              "type" => "ENUM('open','run','closed','ready') NULL",
              "comment" => "статус задачи",
              ),
              ),
              "keys" => array(
              "PRIMARY KEY (id)"),
              ),

              array(
              "name" => "pm_unread",
              "comment" => "Непрочитанные",
              "fields" => array(
              array(
              "name" => "element_id",
              "type" => "INT(11) UNSIGNED NOT NULL DEFAULT '0'",
              "comment" => "",
              ),
              array(
              "name" => "user_id",
              "type" => "INT(11) UNSIGNED NOT NULL DEFAULT '0'",
              "comment" => "",
              ),
              array(
              "name" => "trash",
              "type" => "ENUM('0', '1') NOT NULL DEFAULT '0'",
              "comment" => "запись удалена в корзину: 0 - нет, 1 - да",
              ),
              ),
              "keys" => array("KEY element_id (`element_id`)",
              "KEY user_id (`user_id`)",
              "CONSTRAINT id UNIQUE (element_id, user_id)"),
              ),

              /*array(
              "name" => "pm_feed",
              "comment"=> "Лента новостей",
              "fields" => array(

              array(
              "name" => "created",
              "type" => "INT(10) UNSIGNED NOT NULL DEFAULT '0'",
              "comment" => "дата создания",
              ),
              array(
              "name" => "to_id",
              "type" => "INT(11) UNSIGNED NOT NULL DEFAULT '0'",
              "comment" => "кому отправили сообщение",
              ),
              array(
              "name" => "from_id",
              "type" => "INT(11) UNSIGNED NOT NULL DEFAULT '0'",
              "comment" => "кто отправил сообщение",
              ),
              array(
              "name" => "element_id",
              "type" => "INT(11) UNSIGNED NOT NULL DEFAULT '0'",
              "comment" => "",
              ),
              array(
              "name" => "text",
              "type" => "TINYTEXT NOT NULL",
              "comment" => "описание",
              "multilang" => true,
              ),


              ),
              "keys" => array(
              "KEY to_id (to_id)",
              "KEY from_id (from_id)",
              "KEY element_id (element_id)",
              ),
              ) */
    );

    /**
     * @var array SQL-запросы
     */
    public $sql = array(
            /* "pm_label" => array(
              array(
              "name" => array('Новое', 'New'),
              "state" => 'open',
              "color" => "#fffbbc"
              ),
              array(
              "name" => array('В работе', 'Working'),
              "state"=> 'run',
              "color"=>"#c6f2ff"
              ),
              array(
              "name" => array('Готово', 'Ready'),
              "state"=> 'ready',
              //"color"=>"#c6f2ff"
              ),
              array(
              "name" => array('Отложено', 'Suspended'),
              'state'=> 'suspended'
              ),
              array(
              "name" => array('Выполнено', 'Done'),
              "state" => 'closed',
              "color"=>"#e0f8c4"
              ),
              ) */
    );

}
