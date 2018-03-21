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

   /**
    * @var orangedata\orangedata_client
    */       
    private $byer;

    const CA_CERT = 'cacert.pem';
    const MODULE_NAME = 'orangedata';

    /**
     * Признак расчета (Число от 1 до 4):
     *      1 - Приход
     *      2 - Возврат прихода
     *      3 - Расход
     *      4 - Возврат расхода
     */
    const ORDER_TYPE = 1;

    /**
     * Тип оплаты (Число от 1 до 16):
     *      1 – сумма по чеку наличными, 1031
     *      2 – сумма по чеку электронными, 1081
     *      14 – сумма по чеку предоплатой (зачетом аванса и (или) предыдущих платежей), 1215
     *      15 – сумма по чеку постоплатой (в кредит), 1216
     *      16 – сумма по чеку (БСО) встречным предоставлением, 1217
     */
    const PAYMENT_TYPE = 2;

    public function __get($name) {
        return $this->diafan->configmodules($name, self::MODULE_NAME);
    }

    public function __construct(&$diafan) {
        parent::__construct($diafan);

        $path = array('current' => dirname(__FILE__) . DIRECTORY_SEPARATOR);
        $path['keys'] = $path['current'] . 'keys' . DIRECTORY_SEPARATOR;
        $path['lib'] = $path['current'] . 'lib' . DIRECTORY_SEPARATOR;

        // TODO: для старых версий PHP
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


    /**
     * Конвертирует в float результат работы функции number_format
     * @param string $number
     * @return float
     */
    private function parse_number($number) {
        $dec_point = $this->diafan->configmodules("format_price_2", "shop");
        return floatval(str_replace($dec_point, '.', preg_replace('/[^\d' . preg_quote($dec_point) . ']/', '', $number)));
    }

    /**
     * Получает e-mail пользователя, оформившего заказ
     * копия функции из shop/inc/shop.inc.order.php потому что она private
     * 
     * @param  integer $order_id
     * @return string
     */
    private function get_email($order_id) {
        $mail = DB::query_result("SELECT e.value FROM {shop_order_param_element} AS e INNER JOIN 
			{shop_order_param} AS p ON e.param_id=p.id AND p.trash='0' AND e.trash='0' 
			WHERE p.type='email' AND e.element_id=%d", $order_id);

        if (!$mail && $user_id = DB::query_result("SELECT user_id FROM {shop_order} WHERE id=%d AND trash='0' LIMIT 1", $order_id)) {
            $mail = DB::query_result("SELECT mail FROM {users} WHERE id=%d  AND trash='0' LIMIT 1", $user_id);
        }

        return $mail;
    }

    /**
     * Создать чек
     * @param int $order_id - ид заказа
     * @return bool
     */
    public function create_order($order_id) {

        $user_email = $this->get_email($order_id);
        $info = $this->diafan->_shop->order_get($order_id);


        $order = $this->byer->create_order($order_id, self::ORDER_TYPE, $user_email, $this->taxationSystem);
        foreach ($info['rows'] as $row) {
            $order->add_position_to_order($row['count'], $this->parse_number($row['price']), $this->tax, $row['name'], null, null);
        }

        $order->add_payment_to_order(self::PAYMENT_TYPE, $this->parse_number($info['summ']));

        $result = $this->byer->send_order();
        return (TRUE === $result); // в result может возвратиться HTTP страница целиком...
        
    }

}
