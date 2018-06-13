<?php
/**
 * Created by PhpStorm.
 * User: alexey
 * Date: 12.06.18
 * Time: 18:20
 */

namespace PaymasterSdkPHP\Client;


class CommonProtocol
{

    // Идентификатор продавца
    // Идентификатор сайта в системе PayMaster. Идентификатор можно увидеть в Личном Кабинете, на странице
    // "Список сайтов", в первой колонке.
    protected $LMI_MERCHANT_ID = '';

    // Сумма платежа
    // Сумма платежа, которую продавец желает получить от покупателя. Сумма должна быть больше нуля, дробная часть
    // отделяется точкой.
    protected $LMI_PAYMENT_AMOUNT = 0.00;

    // Валюта платежа
    // Идентификатор валюты платежа. Система PayMaster понимает как текстовый 3-буквенный код валюты (RUB),
    // так и ISO-код (643) (см. http://www.currency-iso.org/en/home/tables/table-a1.html)
    protected $LMI_CURRENCY = 'RUB';

    // Внутренний номер счета продавца
    // В этой переменной продавец задает номер счета (идентификатор покупки) в соответствии со своей системой учета.
    // Несмотря на то, что параметр не является обязательным, мы рекомендуем всегда задавать его. Идентификатор должен
    // представлять собой не пустую строку.
    protected $LMI_PAYMENT_NO = '';

    // Назначение платежа
    // Описание товара или услуги. Формируется продавцом. Максимальная длина - 255 символов.
    protected $LMI_PAYMENT_DESC = '';

    // Режим тестирования
    // Дополнительное поле, определяющее режим тестирования. Действует только в режиме тестирования и может
    // принимать одно из следующих значений:
    // 0 или отсутствует: Для всех тестовых платежей сервис будет имитировать успешное выполнение;
    // 1: Для всех тестовых платежей сервис будет имитировать выполнение с ошибкой (платеж не выполнен);
    // 2: Около 80% запросов на платеж будут выполнены успешно, а 20% - не выполнены.
    protected $LMI_SIM_MODE = 0;

    // Замена Invoice Confirmation URL
    // Если присутствует, то запрос Invoice Confirmation будет отправляться по указанному URL
    // (а не установленному в настройках). Этот параметр игнорируется, если в настройках сайта запрещена замена URL.
    protected $LMI_INVOICE_CONFIRMATION_URL;

    // Замена Payment Notification URL
    // Если присутствует, то запрос Payment Notification будет отправляться по указанному URL
    // (а не установленному в настройках).
    //Этот параметр игнорируется, если в настройках сайта запрещена замена URL.
    protected $LMI_PAYMENT_NOTIFICATION_URL;

    // Замена Success URL
    // Если присутствует, то при успешном платеже пользователь будет отправлен по указанному URL
    // (а не установленному в настройках).
    //Этот параметр игнорируется, если в настройках сайта запрещена замена URL.
    protected $LMI_SUCCESS_URL;

    // Замена Failure URL
    // Если присутствует, то при отмене платежа пользователь будет отправлен по указанному
    // URL (а не установленному в настройках).
    //Этот параметр игнорируется, если в настройках сайта запрещена замена URL.
    protected $LMI_FAILURE_URL;

    // Телефон покупателя
    // Номер телефона покупателя в международном формате без ведущих символов + (например, 79031234567).
    // Эти данные используются системой PayMaster для оповещения пользователя о статусе платежа. Кроме того,
    // некоторые платежные системы требуют указания номера телефона.
    protected $LMI_PAYER_PHONE_NUMBER;

    // E-mail покупателя
    // E-mail покупателя. Эти данные используются системой PayMaster для оповещения пользователя о статусе платежа.
    // Кроме того, некоторые платежные системы требуют указания e-mail.
    protected $LMI_PAYER_EMAIL;

    // Срок истечения счета
    // Дата и время, до которого действует выписанный счет. Формат YYYY-MM-DDThh:mm:ss, часовой пояс UTC.
    //Внимание: система PayMaster приложит все усилия, чтобы отклонить платеж при истечении срока, но не
    // может гарантировать этого.
    protected $LMI_EXPIRES;

    // Идентификатор платежного метода
    // Идентификатор платежного метода, выбранный пользователем. Отсутствие означает, что пользователь будет
    // выбирать платежный метод на странице оплаты PayMaster.
    //Платежный метод указан в настройках сайта в квадратных скобках рядом с названием платежной системы
    // (Например: Webmoney [WebMoney]).
    //Рекомендуется поменять параметр LMI_PAYMENT_SYSTEM на LMI_PAYMENT_METHOD.
    //Но LMI_PAYMENT_SYSTEM по-прежнему принимается и обрабатывается системой.
    protected $LMI_PAYMENT_METHOD;

    // Внешний идентификатор магазина в платежной системе
    // Внешний идентификатор магазина, передаваемый интегратором в платежную систему.
    // Указывается только при явном определении платежной системы (Указан параметр LMI_PAYMENT_SYSTEM).
    // Для каждой платежной системы формат согласовывается отдельно.
    // (Только для интеграторов!!!)
    protected $LMI_SHOP_ID;

    // Ключ
    // Самое важно из этого всего ключевая фраза, которая испрользуется для формирования обоих хешей
    // (Подписи и самого хеша)
    protected $KEYPASS;


    // Подпись запроса (SIGN)
    // Этого параметра нет в https://paymaster.ru/Partners/ru/docs/protocol
    // Так он необходим только для идентификации платежа
    protected $SIGN;

    // Как работаем с хешем, по какому алгоритму его шифруем для проверки подлинности запроса
    protected $HASH_METHOD = 'md5';

    // Какие параметры обязательные
    protected $required = array('LMI_MERCHANT_ID', 'LMI_PAYMENT_AMOUNT', 'LMI_CURRENCY', 'LMI_PAYMENT_DESC', 'KEYPASS');

    // Начинаем работать с онлайн-кассой
    // Для начала забиваем корзину товара
    protected $LMI_SHOPPINGCART = array();

    // Массив с обязательными параметрами для онлайн позиции (товара) онлайн кассы
    protected $cart_required = array('NAME', 'QTY', 'PRICE', 'TAX');

    // Переменная для хранения запроса
    protected $request = array();

    /**
     * CommonProtocol constructor.
     */
    public function __construct()
    {
        $this->request = (object) $_REQUEST;

        // Здесь прописываем все переменные если они конечно есть в POST или GET запросе

        if (isset($this->request->LMI_MERCHANT_ID))
            $this->LMI_MERCHANT_ID = $this->request->LMI_MERCHANT_ID;

        if (isset($this->request->LMI_PAYMENT_NO))
            $this->LMI_PAYMENT_NO = $this->request->LMI_PAYMENT_NO;

        if (isset($this->request->LMI_SYS_PAYMENT_ID))
            $this->LMI_SYS_PAYMENT_ID = $this->request->LMI_SYS_PAYMENT_ID;

        if (isset($this->request->LMI_SYS_PAYMENT_DATE))
            $this->LMI_SYS_PAYMENT_DATE = $this->request->LMI_SYS_PAYMENT_DATE;

        if (isset($this->request->LMI_PAYMENT_AMOUNT))
            $this->LMI_PAYMENT_AMOUNT = $this->request->LMI_PAYMENT_AMOUNT;

        if (isset($this->request->LMI_CURRENCY))
            $this->LMI_CURRENCY = $this->request->LMI_CURRENCY;

        if (isset($this->request->LMI_PAID_AMOUNT))
            $this->LMI_PAID_AMOUNT = $this->request->LMI_PAID_AMOUNT;

        if (isset($this->request->LMI_PAID_CURRENCY))
            $this->LMI_PAID_CURRENCY = $this->request->LMI_PAID_CURRENCY;

        if (isset($this->request->LMI_PAYMENT_SYSTEM))
            $this->LMI_PAYMENT_SYSTEM = $this->request->LMI_PAYMENT_SYSTEM;

        if (isset($this->request->LMI_SIM_MODE))
            $this->LMI_SIM_MODE = $this->request->LMI_SIM_MODE;

    }

    /**
     * Setter
     * @param $variable
     * @param $value
     */
    public function set($variable, $value) {
        $this->$variable = $variable;
    }

    /**
     * Getter
     * @param $variable
     * @param $value
     */
    public function get($variable, $default = null) {
        if (isset($variable))
            return $variable;
        else
            return $default;
    }



    /**
     * Получение подписи
     * Просто делаем ее по MD5
     */
    public function getSIGN() {
        $sign = $this->LMI_MERCHANT_ID . ':' . $this->LMI_PAYMENT_AMOUNT . ':' . $this->LMI_PAYMENT_DESC . ':' . $this->KEYPASS;
        return md5($sign);
    }


    /**
     * Получение проверочного хэша
     */
    public function getLMI_HASH() {
        // Подготавливаем строчку для хеша
        $stringToHash = $this->LMI_MERCHANT_ID . ";" . $this->LMI_PAYMENT_NO . ";" . $this->LMI_SYS_PAYMENT_ID . ";"
            . $this->LMI_SYS_PAYMENT_DATE . ";" . $this->LMI_PAYMENT_AMOUNT . ";" . $this->LMI_CURRENCY . ";"
            . $this->LMI_PAID_AMOUNT . ";" . $this->LMI_PAID_CURRENCY . ";" . $this->LMI_PAYMENT_SYSTEM . ";"
            . $this->LMI_SIM_MODE . ";" . $this->KEYPASS;
        // И кодируем хеш в соответствии с установленным алгоритмом для шифорования
        $hash = base64_encode(hash($this->HASH_METHOD, $stringToHash, true));
        return $hash;
    }

    /**
     * Получение формы оплаты
     */
    public function getForm() {
        $this->__checkForm1();
        $html = "<input type='hidden' name='LMI_MERCHANT_ID' value='{$this->LMI_MERCHANT_ID}'/>";
        $html .= "<input type='hidden' name='LMI_PAYMENT_AMOUNT' value='{$this->LMI_PAYMENT_AMOUNT}'/>";
        $html .= "<input type='hidden' name='LMI_PAYMENT_AMOUNT' value='{$this->LMI_PAYMENT_AMOUNT}'/>";

        // protected $required = array('LMI_MERCHANT_ID', 'LMI_PAYMENT_AMOUNT', 'LMI_CURRENCY', 'LMI_PAYMENT_DESC', 'KEYPASS');
    }


    /**
     * Проверка основных переменных формы
     */
    private function __checkForm1() {
        foreach ($this->required as $var) {
            if (!isset($this->$var))
                throw new Exception('Не хватает переменных для получения формы оплаты. Не задана переменная '.$var);
        }
    }

    /**
     *  Проверка переменных формы для онлайн кассы (товарных позиций)
     */
    private function __checkForm2() {

    }

}