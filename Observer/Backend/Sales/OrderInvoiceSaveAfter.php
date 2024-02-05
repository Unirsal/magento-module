<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types = 1);

namespace Unirsal\Whatsappbasic\Observer\Backend\Sales;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Store\Model\ScopeInterface;

class OrderInvoiceSaveAfter implements \Magento\Framework\Event\ObserverInterface
{

    protected $scopeConfig;

    /**
     * @var \Magento\Framework\App\Response\Http\FileFactory
     */
    public $fileFactory;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    public $dateTime;

    /**
     * @var \Magetrend\PdfTemplates\Helper\Data
     */
    public $moduleHelper;

    /**
     * @var \Magento\Backend\Model\View\Result\ForwardFactory
     */
    public $resultForwardFactory;

    /**
     * @var \Magento\Sales\Api\InvoiceRepositoryInterface
     */
    public $invoiceRepository;

    /**
     * @var \Magento\Sales\Model\Order\Pdf\Invoice
     */
    public $invoice;

    /**
     * @var \Magento\Framework\Filesystem
     */
    public $filesystem;

    protected $_storeManager;

    public $country_list = array(
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
        "ZW" => 263
    );
    const XML_PATH_KEY = 'whatsappbasic/keyG/apikey';
    const XML_PATH_INVOCETXT = 'whatsappbasic/invocecreate/template';
    const XML_PATH_SESSION = 'whatsappbasic/session/id';

    public function __construct(\Magento\Framework\Stdlib\DateTime\DateTime $dateTime, \Magento\Framework\App\Response\Http\FileFactory $fileFactory, \Magetrend\PdfTemplates\Helper\Data $moduleHelper, \Magento\Backend\Model\View\Result\ForwardFactory $forwardFactory, \Magento\Sales\Api\InvoiceRepositoryInterface $invoiceRepository, \Magento\Sales\Model\Order\Pdf\Invoice $invoice, \Magento\Framework\Filesystem $filesystem, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig)
    {
        $this->fileFactory = $fileFactory;
        $this->dateTime = $dateTime;
        $this->moduleHelper = $moduleHelper;
        $this->resultForwardFactory = $forwardFactory;
        $this->invoice = $invoice;
        $this->invoiceRepository = $invoiceRepository;
        $this->filesystem = $filesystem;
        $this->_storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;

    }

    /**
     * Execute observer
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function getStoreid()
    {
        return $this
            ->_storeManager
            ->getStore()
            ->getId();
    }
    public function getKey()
    {
        return $this
            ->scopeConfig
            ->getValue(self::XML_PATH_KEY, ScopeInterface::SCOPE_STORE, $this->getStoreid());
    }
    public function getInvoceTxt()
    {
        return $this
            ->scopeConfig
            ->getValue(self::XML_PATH_INVOCETXT, ScopeInterface::SCOPE_STORE, $this->getStoreid());
    }

    public function getsession()
    {
        return $this
            ->scopeConfig
            ->getValue(self::XML_PATH_SESSION, ScopeInterface::SCOPE_STORE, $this->getStoreid());

    }
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        //var_dump($this->getKey());
        //exit();
        return $this;
        $url = "https://api.prod.unirsal.com/backend-service/v3/whatsapp-session"

        $invoice = $observer->getEvent()
            ->getInvoice();
        $order = $invoice->getOrder();
        //        var_dump($invoice->getId());
        //        exit;
        if ($invoiceId = $invoice->getId())
        {
            //echo 'adsf';
            //exit;
            $invoice = $this
                ->invoiceRepository
                ->get($invoiceId);
            if ($invoice)
            {
                //echo 'dddd';
                //exit;
                $pdf = $this
                    ->invoice
                    ->getPdf([$invoice]);
                //echo 'dasf';
                //exit;
                $fileName = $this
                    ->moduleHelper
                    ->getFileName(\Magetrend\PdfTemplates\Helper\Data::FILENAME_INVOICE, ['increment_id' => $this
                    ->moduleHelper
                    ->prepareFileName($invoice->getIncrementId()) , 'date' => $this
                    ->dateTime
                    ->date('Y-m-d_H-i-s') , ], $invoice->getStoreId());
                //var_dump($fileName);
                //      var_dump($fileName);
                //                  exit;
                $path = $this
                    ->filesystem
                    ->getDirectoryRead(DirectoryList::TMP)
                    ->getAbsolutePath($fileName);
                $pdf->save($path);

                //var_dump($this->invoice->getIncrementId());
                //var_dump($this->invoice->getIncrementId());
                //var_dump($order->getShippingAddress()->getTelephone());
                //var_dump($order->getShippingAddress()->getCountryId());
                

                //exit;
                //var_dump($order->getShippingAddress()->getCountryId());
                //chunk_split
                $b64Doc = base64_encode(file_get_contents($path));
                $phone = '';
                $count = '';
                //echo base64_encode(file_get_contents($path));
                //var_dump($path);
                //exit;
                if (strlen($order->getShippingAddress()
                    ->getTelephone()) == 12)
                {

                    $phone = $order->getShippingAddress()
                        ->getTelephone();

                }
                else
                {

                    $phone = $order->getShippingAddress()
                        ->getTelephone();
                    $phone = ltrim($phone, $phone[0]);
                    $phone = $this->country_list[$order->getShippingAddress()
                        ->getCountryId() ] . $phone;
                }
                //var_dump($phone);
                //exit;
                

                $store_code = $order->getStore()
                    ->getCode(); // Store code of order.
                $numOrder = $order->getIncrementId();

                $message = $this->getInvoceTxt();
                $session = $this->getsession();

                $data = array(
                    "sessionId" => $session,
                    "recipientPhone" => $phone,
                    "text" => $message,
                    "caption" => "",
                    "base64Data" => "",
                    "locationLat" => "",
                    "locationLong" => "",
                    "type" => "text",
                    "fileName" => "",
                    "api_key" => $this->getKey()

                );
                /*
                 $data = {
                  sessionId: selectedInstance?.value,
                   recipientPhone: recipientPhone,
                  text: text,
                  caption: caption,
                   base64Data: base64Data,
                  locationLat: position?.lat,
                  locationLong: position?.lng,
                  type: messageType?.value,
                  fileName: fileName,
                };
                */
                $data_string = json_encode($data);
                //     var_dump($data_string);
                //exit;
                $curl = curl_init();
                //              $response = curl_exec($curl);
                //var_dump($response);
                //exit;
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => $data_string,
                    CURLOPT_HTTPHEADER => array(
                        "cache-control: no-cache",
                        "content-type: application/json",
                    ) ,
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);
                //var_dump($url);
                //print_r($response);
                //exit;
                curl_close($curl);

                $data = array(
                    "sessionId" => $session,
                    "recipientPhone" => $phone,
                    "text" => '',
                    "caption" => "",
                    "base64Data" => 'data:application/pdf;base64,' . $b64Doc,
                    "locationLat" => "",
                    "locationLong" => "",
                    "type" => "file",
                    "fileName" => $fileName,
                    "api_key" => $this->getKey()
                );
                $data_string = json_encode($data);

                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => $data_string,
                    CURLOPT_HTTPHEADER => array(
                        "cache-control: no-cache",
                        "content-type: application/json"
                    ) ,
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);
                //var_dump($response);
                curl_close($curl);
                //var_dump($err);
                //exit;
                if ($err)
                {
                    echo "cURL Error #:" . $err;
                }
                else
                {
                    echo $response;
                }
                //var_dump($b64Doc);
                //$logger->info($b64Doc);
                //var_dump($path);
                //exit();
                // $content = ['value'=> $fileName, 'type' => 'filename', 'rm' => true];
                //  return $this->fileFactory->create($fileName, $content, DirectoryList::TMP);
                
            }
        }

        // $order = $invoice->getOrder();
        // $orderId = $order->getId();
        // $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        // $order = $objectManager->create('\Magento\Sales\Model\OrderRepository')
        //     ->get($orderId);
        // $numOrder = $order->getIncrementId();
        // $dateOrder = date('d-m-Y', strtotime($order->getCreatedAt()));
        // $invoiceId = $invoice->getIncrementId();
        // $logger->info($invoiceId);
        

        
    }
}

