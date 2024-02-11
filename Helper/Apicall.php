<?php 
namespace Unirsal\Whatsappbasic\Helper;
use Magento\Store\Model\ScopeInterface;

class Apicall extends \Magento\Framework\App\Helper\AbstractHelper
{


	const XML_WHATSAPP_API_URL = 'whatsappbasic/moduleoption/baseurl';
    const XML_PATH_KEY = 'whatsappbasic/moduleoption/apikey';
    const XML_PATH_SESSION = 'whatsappbasic/session/id';
    const XML_PATH_INVOCE_ENABLE = 'whatsappbasic/invocecreate/enable';
    const XML_PATH_INVOCE_TEXT = 'whatsappbasic/invocecreate/template';


    const XML_PATH_INVOCE_ORDERPLACE_ENABLE = 'whatsappbasic/order/orderplace/enable';
    const XML_PATH_INVOCE_ORDERPLACE_TEXT = 'whatsappbasic/order/orderplace/template';

 
	
	const XML_PATH_INVOCE_orderonhold_ENABLE = 'whatsappbasic/order/orderonhold/enable';
    const XML_PATH_INVOCE_orderonhold_TEXT = 'whatsappbasic/order/orderonhold/template';

	const XML_PATH_INVOCE_orderorderprocessing_ENABLE = 'whatsappbasic/order/orderprocessing/enable';
    const XML_PATH_INVOCE_orderorderprocessing_TEXT = 'whatsappbasic/order/orderprocessing/template';


	const XML_PATH_INVOCE_ordercancel_ENABLE = 'whatsappbasic/order/ordercancel/enable';
    const XML_PATH_INVOCE_ordercancel_TEXT = 'whatsappbasic/order/ordercancel/template';


	const XML_PATH_INVOCE_orderconmplete_ENABLE = 'whatsappbasic/order/orderconmplete/enable';
    const XML_PATH_INVOCE_orderconmplete_TEXT = 'whatsappbasic/order/orderconmplete/template';

	

    const XML_PATH_TMP_MAGETRED_INVOCE = 'pdftemplates/pdf/invoice_template';

    const XML_PATH_TMP_ABAN_CART_EN = 'abandedcart/moduleoption/enable';
    const XML_PATH_TMP_ABAN_CART_TEXT = 'abandedcart/moduleoption/text';
    const XML_PATH_TMP_ABAN_CART_IMAGE = 'abandedcart/moduleoption/custom_file_upload';

    protected $_storeManager;

	public function __construct(
    \Magento\Framework\App\Helper\Context $context,
    \Magento\Store\Model\StoreManagerInterface $storeManager)
	{
        $this->_storeManager = $storeManager;

		parent::__construct($context);
	}
     
	public function getOrderprocessingEnable() {
        return $this->scopeConfig->getValue(self::XML_PATH_INVOCE_orderorderprocessing_ENABLE,
        ScopeInterface::SCOPE_STORE,$this->getStoreid());
    }

	public function getOrderprocessingText() {
        return  $this->scopeConfig->getValue(self::XML_PATH_INVOCE_orderorderprocessing_TEXT,
        ScopeInterface::SCOPE_STORE,$this->getStoreid());
    }

	public function getOrderCompleteEnable() {
        return $this->scopeConfig->getValue(self::XML_PATH_INVOCE_orderconmplete_ENABLE,
        ScopeInterface::SCOPE_STORE,$this->getStoreid());
    }

	public function getOrderCompleteText() {
        return  $this->scopeConfig->getValue(self::XML_PATH_INVOCE_orderconmplete_TEXT,
        ScopeInterface::SCOPE_STORE,$this->getStoreid());
    }


	public function getOrderCancelEnable() {
        return $this->scopeConfig->getValue(self::XML_PATH_INVOCE_ordercancel_ENABLE,
        ScopeInterface::SCOPE_STORE,$this->getStoreid());
    }

	public function getOrderOnCancelText() {
        return  $this->scopeConfig->getValue(self::XML_PATH_INVOCE_ordercancel_TEXT,
        ScopeInterface::SCOPE_STORE,$this->getStoreid());
    }


	


	public function getOrderOnHoldEnable() {
        return $this->scopeConfig->getValue(self::XML_PATH_INVOCE_orderonhold_ENABLE,
        ScopeInterface::SCOPE_STORE,$this->getStoreid());
    }

	public function getOrderOnHoldText() {
        return  $this->scopeConfig->getValue(self::XML_PATH_INVOCE_orderonhold_TEXT,
        ScopeInterface::SCOPE_STORE,$this->getStoreid());
    }


 


	public function getOrderPlaceEnable() {
        return $this->scopeConfig->getValue(self::XML_PATH_INVOCE_ORDERPLACE_ENABLE,
        ScopeInterface::SCOPE_STORE,$this->getStoreid());
    }

	public function getOrderPlaceText() {
        return  $this->scopeConfig->getValue(self::XML_PATH_INVOCE_ORDERPLACE_TEXT,
        ScopeInterface::SCOPE_STORE,$this->getStoreid());
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

	public function getKey() {
        return $this->scopeConfig->getValue(self::XML_PATH_KEY,
        ScopeInterface::SCOPE_STORE,$this->getStoreid());
    }

	public function getTempleteId() {
        return $this->scopeConfig->getValue(self::XML_PATH_TMP_MAGETRED_INVOCE,
        ScopeInterface::SCOPE_STORE,$this->getStoreid());
    }

	public function getBaseuRL() {
        return $this->scopeConfig->getValue(self::XML_WHATSAPP_API_URL,
        ScopeInterface::SCOPE_STORE,$this->getStoreid());
    }
  
	public function getInvoceEnable() {
        return $this->scopeConfig->getValue(self::XML_PATH_INVOCE_ENABLE,
        ScopeInterface::SCOPE_STORE,$this->getStoreid());
    }

	public function getInvoceText() {
        return  $this->scopeConfig->getValue(self::XML_PATH_INVOCE_TEXT,
        ScopeInterface::SCOPE_STORE,$this->getStoreid());
    }
	public function getAbandedCartEnable() {
        return  $this->scopeConfig->getValue(self::XML_PATH_TMP_ABAN_CART_EN,
        ScopeInterface::SCOPE_STORE,$this->getStoreid());
    }
	public function getAbandedCartText() {
        return  $this->scopeConfig->getValue(self::XML_PATH_TMP_ABAN_CART_TEXT,
        ScopeInterface::SCOPE_STORE,$this->getStoreid());
    }
	public function getAbandedCartImage() {
        return  $this->scopeConfig->getValue(self::XML_PATH_TMP_ABAN_CART_IMAGE,
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

	public function sendText($recipientPhone,$message)
	{
		$url = $this->getBaseuRL();
        $instance = $this->getInstanceId();
		$data = array(
			"type" => "text",
			"sessionId" => $instance,
			"recipientPhone" => $recipientPhone,
			"text" => array(
				"message" => $message
			)
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
				  "Authorization:". $this->getKey()
			  ) ,
		  ));
		  $response = curl_exec($curl);
		  $err = curl_error($curl);
		  curl_close($curl);
 
		return $response;
	}

	public function sendFile($recipientPhone,$message,$base64)
	{
		$url = $this->getBaseuRL();
        $instance = $this->getInstanceId();
		$data = array(
			"type" => "file",
			"sessionId" => $instance,
			"recipientPhone" => $recipientPhone,
			"file" => array(
				"message" => $message,
				"fileName"=> "Invoce.pdf",
				"base64" => $base64
			)
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
				  "Authorization:". $this->getKey()
			  ) ,
		  ));
		  $response = curl_exec($curl);
 		  $err = curl_error($curl);
		  curl_close($curl);
 
		return $response;

	}

	public function sendImage($recipientPhone,$message,$base64)
	{
		$url = $this->getBaseuRL();
        $instance = $this->getInstanceId();
		$data = array(
			"type" => "image",
			"sessionId" => $instance,
			"recipientPhone" => $recipientPhone,
			"image" => array(
				"message" => $message,
				"base64" => $base64
			)
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
				  "Authorization:". $this->getKey()
			  ) ,
		  ));
		  $response = curl_exec($curl);
 		  $err = curl_error($curl);
		  curl_close($curl);
 
		return $response;

	}

	public function FilterVariableAbandendCart($message,$order,$invoce){
		// invoce id 
		$message = str_replace("#orderIncrementId",$order->getIncrementId(),$message);

		// invoce date 
		$message = str_replace("#ordergetCreatedAt",$order->getCreatedAt(), $message);

		// customer name 
		$message = str_replace("#customerName ",$order->getCustomerName(), $message);
		$shippingAddress = $order->getShippingAddress();
		$billingAddress = $order->getBillingAddress();
		$mobilenumber = $billingAddress->getTelephone();
		$street = $shippingAddress->getStreet();
		// street  
		$message = str_replace("#street",$street[0], $message);



		// mobilePhone 
		$message = str_replace("#mobilenumber",$billingAddress->getTelephone(), $message);

		// orderStatus
		$message = str_replace("#orderStatus",$order->getStatus(), $message);
		return $message;
	}

	// Variable Filter
	public function FilterVariableInvoce($message,$order){
			// invoce id 
			$message = str_replace("#orderIncrementId",$order->getIncrementId(),$message);

			// invoce date 
			$message = str_replace("#ordergetCreatedAt",$order->getCreatedAt(), $message);

			// customer name 
			$message = str_replace("#customerName ",$order->getCustomerName(), $message);
			$shippingAddress = $order->getShippingAddress();
			$billingAddress = $order->getBillingAddress();
			$mobilenumber = $billingAddress->getTelephone();
			$street = $shippingAddress->getStreet();
			// street  
			$message = str_replace("#street",$street[0], $message);

 

			// mobilePhone 
			$message = str_replace("#mobilenumber",$billingAddress->getTelephone(), $message);

			// orderStatus
			$message = str_replace("#orderStatus",$order->getStatus(), $message);
			return $message;
		}
		public function FilterVariableCustomer($message,$customer){

			try {
			$message = str_replace("#customerFirstName",$customer->getFirstname(),$message);
			$message = str_replace("#customerLasttName",$customer->getLastname(),$message);

		 
			$message = str_replace("#customerTelephone",$customer->getTelephone(),$message);
			} catch (\Exception $e) {
				// $this->logger->error($e->getMessage());
			//	var_dump($e->getMessage());
			//	exit;
			}
		

			
			return $message;
		}
}
