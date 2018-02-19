<?php

/**
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

class Orangedata_inc extends Model {

    private $byer;

    const CA_CERT = 'cacert.pem';
    const MODULE_NAME = 'orangedata';

    // Получаем по красоте данные из конфига
    public function __get($name) {
        return $this->diafan->configmodules($name, self::MODULE_NAME);
    }

    public function __construct(&$diafan) {
        parent::__construct($diafan);

        $path = array('current' => dirname(__FILE__) . DIRECTORY_SEPARATOR);
        $path['keys'] = $path['current'] . 'keys' . DIRECTORY_SEPARATOR;
        $path['lib'] = $path['current'] . 'lib' . DIRECTORY_SEPARATOR;

        // TODO: костыль
        if (!defined('JSON_PRESERVE_ZERO_FRACTION')) {
            define('JSON_PRESERVE_ZERO_FRACTION', 1024);
        }

        include_once $path['lib'] . 'orangedata_client.php';

        $this->byer = new orangedata\orangedata_client(
                $this->inn, ('demo' == $this->mode ? 2443 : 12003), //number of the port
                $path['keys'] . $this->sign_pkey, //path to private key for signing
                $path['keys'] . $this->client_key, //path to client private key for ssl
                $path['keys'] . $this->client_cert, //path to client certificate for ssl
                $path['keys'] . self::CA_CERT, //path to cacert for ssl
                $this->client_cert_pass //password for client certificate for ssl
        );
    }

    public function test() {
        // try {
        /* //create client new order, add positions , add payment, send request
          $this->byer->create_order('23423423434', 1, 'example@example.com', 1)
          ->add_position_to_order(6.123456, '10.', 1, 'matches', 1, 10)
          ->add_position_to_order(7, 10, 1, 'matches2', null, 10)
          ->add_position_to_order(345., 10.76, 1, 'matches3', 3, null)
          ->add_payment_to_order(1, 131.23)
          ->add_payment_to_order(2, 3712.2)
          ->add_agent_to_order(127, ['+79998887766', '+76667778899'], 'Operation', ['+79998887766'], ['+79998887766'], 'Name', 'ulitsa Adress, dom 7', 3123011520, ['+79998887766', '+76667778899'])
          ->add_user_attribute('Любимая цитата', 'В здоровом теле здоровый дух, этот лозунг еще не потух!');
          //view response
          $result = $this->byer->send_order();
          if (TRUE === $result) { */
        //view status of order
        $order_status = $this->byer->get_order_status(23423423434);
        var_dump($order_status);
        // }
        //} catch (Exception $ex) {
        //     echo 'Ошибка:' . PHP_EOL . $ex->getMessage();
        //}
    }
    
    public function create_order($order_id) {
        
    }

}
