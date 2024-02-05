<?php 
namespace Unirsal\Whatsappbasic\Helper;
use Magento\Store\Model\ScopeInterface;

class Apicall extends \Magento\Framework\App\Helper\AbstractHelper
{

    const XML_WHATSAPP_API_CLIENT_ID = 'whatsappbasic/smsgatways/whatsappapiclientid';
    const XML_WHATSAPP_API_INSTANCE = 'whatsappbasic/smsgatways/whatsappapiinstance';
	const XML_WHATSAPP_API_URL = 'whatsappbasic/smsgatways/whatsappapiurl';
    const XML_PATH_KEY = 'whatsappbasic/keyG/apikey';
    const XML_PATH_SESSION = 'whatsappbasic/session/id';

    protected $_storeManager;

	public function __construct(
    \Magento\Framework\App\Helper\Context $context,
    \Magento\Store\Model\StoreManagerInterface $storeManager)
	{
        $this->_storeManager = $storeManager;

		parent::__construct($context);
	}
    public function getSmsgatewaylist(){
        return [];
    }
    public function getTitle() {
        return __("WhatsApp API");
    }

    public function getClientId()
    {
        return $this->scopeConfig->getValue(
            self::XML_WHATSAPP_API_CLIENT_ID,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    public function getStoreid() {
        return $this->_storeManager->getStore()->getId();
    }
    public function getInstanceId()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_SESSION,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function getApiUrl()	{
		return $this->scopeConfig->getValue(
            self::XML_WHATSAPP_API_URL,
			 \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
	}

	public function validateSmsConfig()
    {
        return $this->getApiUrl() && $this->getClientId() && $this->getInstanceId();
    }
	public function getKey() {
        return $this->scopeConfig->getValue(self::XML_PATH_KEY,
        ScopeInterface::SCOPE_STORE,$this->getStoreid());
    }
	public function callApiUrl($mobilenumbers,$message,$type)
	{
		$url = "https://api.prod.unirsal.com/backend-service/v3/whatsapp-session=" . $this->getKey();
        $instance = $this->getInstanceId();
        $clientId = $this->getClientId();
		$data = array(
			"sessionId" => $instance,
			"recipientPhone" => $mobilenumbers,
			"text" => $message,
			"caption" => "",
			"base64Data" => "",
			"locationLat" => "",
			"locationLong" => "",
			"type" => "text",
			"fileName"=> "",
			"api_key"=>$this->getKey()

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
				  "content-type: application/json",
			  ) ,
		  ));
		  $response = curl_exec($curl);
        
		  $err = curl_error($curl);
		  curl_close($curl);
 
		return $response;
	}
}
