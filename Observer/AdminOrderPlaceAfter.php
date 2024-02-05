<?php
namespace Unirsal\Whatsappbasic\Observer;

use Magento\Framework\Event\ObserverInterface;

class AdminOrderPlaceAfter implements \Magento\Framework\Event\ObserverInterface
{
    protected $objectManager;
    protected $helperdata;
    protected $helperapi;
    protected $emailfilter;
    protected $customerFactory;
    public $country_list = [
        "AF" => 93,
        "AX" => 358,
        "AL" => 355,
        "DZ" => 213,
        "AS" => 1684,
        "AD" => 376,
        "AO" => 244,
        "AI" => 1264,
        "AQ" => 672,
        "AG" => 1268,
        "AR" => 54,
        "AM" => 374,
        "AW" => 297,
        "AU" => 61,
        "AT" => 43,
        "AZ" => 994,
        "BS" => 1242,
        "BH" => 973,
        "BD" => 880,
        "BB" => 1246,
        "BY" => 375,
        "BE" => 32,
        "BZ" => 501,
        "BJ" => 229,
        "BM" => 1441,
        "BT" => 975,
        "BO" => 591,
        "BQ" => 599,
        "BA" => 387,
        "BW" => 267,
        "BV" => 55,
        "BR" => 55,
        "IO" => 246,
        "BN" => 673,
        "BG" => 359,
        "BF" => 226,
        "BI" => 257,
        "KH" => 855,
        "CM" => 237,
        "CA" => 1,
        "CV" => 238,
        "KY" => 1345,
        "CF" => 236,
        "TD" => 235,
        "CL" => 56,
        "CN" => 86,
        "CX" => 61,
        "CC" => 672,
        "CO" => 57,
        "KM" => 269,
        "CG" => 242,
        "CD" => 242,
        "CK" => 682,
        "CR" => 506,
        "CI" => 225,
        "HR" => 385,
        "CU" => 53,
        "CW" => 599,
        "CY" => 357,
        "CZ" => 420,
        "DK" => 45,
        "DJ" => 253,
        "DM" => 1767,
        "DO" => 1809,
        "EC" => 593,
        "EG" => 20,
        "SV" => 503,
        "GQ" => 240,
        "ER" => 291,
        "EE" => 372,
        "ET" => 251,
        "FK" => 500,
        "FO" => 298,
        "FJ" => 679,
        "FI" => 358,
        "FR" => 33,
        "GF" => 594,
        "PF" => 689,
        "TF" => 262,
        "GA" => 241,
        "GM" => 220,
        "GE" => 995,
        "DE" => 49,
        "GH" => 233,
        "GI" => 350,
        "GR" => 30,
        "GL" => 299,
        "GD" => 1473,
        "GP" => 590,
        "GU" => 1671,
        "GT" => 502,
        "GG" => 44,
        "GN" => 224,
        "GW" => 245,
        "GY" => 592,
        "HT" => 509,
        "HM" => 0,
        "VA" => 39,
        "HN" => 504,
        "HK" => 852,
        "HU" => 36,
        "IS" => 354,
        "IN" => 91,
        "ID" => 62,
        "IR" => 98,
        "IQ" => 964,
        "IE" => 353,
        "IM" => 44,
        "IL" => 972,
        "IT" => 39,
        "JM" => 1876,
        "JP" => 81,
        "JE" => 44,
        "JO" => 962,
        "KZ" => 7,
        "KE" => 254,
        "KI" => 686,
        "KP" => 850,
        "KR" => 82,
        "XK" => 381,
        "KW" => 965,
        "KG" => 996,
        "LA" => 856,
        "LV" => 371,
        "LB" => 961,
        "LS" => 266,
        "LR" => 231,
        "LY" => 218,
        "LI" => 423,
        "LT" => 370,
        "LU" => 352,
        "MO" => 853,
        "MK" => 389,
        "MG" => 261,
        "MW" => 265,
        "MY" => 60,
        "MV" => 960,
        "ML" => 223,
        "MT" => 356,
        "MH" => 692,
        "MQ" => 596,
        "MR" => 222,
        "MU" => 230,
        "YT" => 269,
        "MX" => 52,
        "FM" => 691,
        "MD" => 373,
        "MC" => 377,
        "MN" => 976,
        "ME" => 382,
        "MS" => 1664,
        "MA" => 212,
        "MZ" => 258,
        "MM" => 95,
        "NA" => 264,
        "NR" => 674,
        "NP" => 977,
        "NL" => 31,
        "AN" => 599,
        "NC" => 687,
        "NZ" => 64,
        "NI" => 505,
        "NE" => 227,
        "NG" => 234,
        "NU" => 683,
        "NF" => 672,
        "MP" => 1670,
        "NO" => 47,
        "OM" => 968,
        "PK" => 92,
        "PW" => 680,
        "PS" => 970,
        "PA" => 507,
        "PG" => 675,
        "PY" => 595,
        "PE" => 51,
        "PH" => 63,
        "PN" => 64,
        "PL" => 48,
        "PT" => 351,
        "PR" => 1787,
        "QA" => 974,
        "RE" => 262,
        "RO" => 40,
        "RU" => 70,
        "RW" => 250,
        "BL" => 590,
        "SH" => 290,
        "KN" => 1869,
        "LC" => 1758,
        "MF" => 590,
        "PM" => 508,
        "VC" => 1784,
        "WS" => 684,
        "SM" => 378,
        "ST" => 239,
        "SA" => 966,
        "SN" => 221,
        "RS" => 381,
        "CS" => 381,
        "SC" => 248,
        "SL" => 232,
        "SG" => 65,
        "SX" => 1,
        "SK" => 421,
        "SI" => 386,
        "SB" => 677,
        "SO" => 252,
        "ZA" => 27,
        "GS" => 500,
        "SS" => 211,
        "ES" => 34,
        "LK" => 94,
        "SD" => 249,
        "SR" => 597,
        "SJ" => 47,
        "SZ" => 268,
        "SE" => 46,
        "CH" => 41,
        "SY" => 963,
        "TW" => 886,
        "TJ" => 992,
        "TZ" => 255,
        "TH" => 66,
        "TL" => 670,
        "TG" => 228,
        "TK" => 690,
        "TO" => 676,
        "TT" => 1868,
        "TN" => 216,
        "TR" => 90,
        "TM" => 7370,
        "TC" => 1649,
        "TV" => 688,
        "UG" => 256,
        "UA" => 380,
        "AE" => 971,
        "GB" => 44,
        "US" => 1,
        "UM" => 1,
        "UY" => 598,
        "UZ" => 998,
        "VU" => 678,
        "VE" => 58,
        "VN" => 84,
        "VG" => 1284,
        "VI" => 1340,
        "WF" => 681,
        "EH" => 212,
        "YE" => 967,
        "ZM" => 260,
        "ZW" => 263,
    ];

    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Unirsal\Whatsappbasic\Helper\Data $helperdata,
        \Unirsal\Whatsappbasic\Helper\Apicall $helperapi,
        \Magento\Email\Model\Template\Filter $filter,
        \Magento\Customer\Model\CustomerFactory $customerFactory
    ) {
        $this->objectManager = $objectManager;
        $this->helperdata = $helperdata;
        $this->helperapi = $helperapi;
        $this->emailfilter = $filter;
        $this->customerFactory = $customerFactory;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        try {
            if (
                $this->helperdata->isEnabled() &&
                $this->helperdata->isOrderPlaceForUserEnabled()
            ) {
                $order = $observer->getEvent()->getOrder();

                $billingAddress = $order->getBillingAddress();
                $mobilenumber = $billingAddress->getTelephone();
                if ($order->getCustomerId() > 0) {
                    $customer = $this->customerFactory
                        ->create()
                        ->load($order->getCustomerId());
                    $mobile = $customer->getMobilenumber();
                    if ($mobile != "" && $mobile != null) {
                        $mobilenumber = $mobile;
                    }
                    $this->emailfilter->setVariables([
                        "order" => $order,
                        "customer" => $customer,
                        "order_total" => $order->formatPriceTxt(
                            $order->getGrandTotal()
                        ),
                        "mobilenumber" => $mobilenumber,
                    ]);
                } else {
                    $this->emailfilter->setVariables([
                        "order" => $order,
                        "order_total" => $order->formatPriceTxt(
                            $order->getGrandTotal()
                        ),
                        "mobilenumber" => $mobilenumber,
                    ]);
                }
                //var_dump(strlen($mobilenumber));
                //var_dump(strlen($mobilenumber) == 12);
                //exit;
                if (strlen($mobilenumber) == 12) {
                } else {
                    //TO DO : Check if the first number 0
                    if (substr($mobilenumber, 0, 1) === "0") {
                        $mobilenumber = ltrim($mobilenumber, $mobilenumber[0]);
                    }
                    //$mobilenumber = ltrim($mobilenumber, $mobilenumber[0]);
                    $mobilenumber =
                        $this->country_list[
                            $order->getShippingAddress()->getCountryId()
                        ] . $mobilenumber;
                }
                $message = $this->helperdata->getOrderPlaceTemplateForUser();
                $finalmessage = $this->emailfilter->filter($message);
                $type = "text";
                $this->helperapi->callApiUrl(
                    $mobilenumber,
                    $finalmessage,
                    $type
                );
            }
            return true;
        } catch (\Exception $e) {
            var_dump($e->getMessage());
            exit();
            return true;
        }
    }
}
