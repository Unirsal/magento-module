<?php 
namespace Unirsal\Whatsappbasic\Cron;

use Magento\Quote\Model\ResourceModel\Quote\CollectionFactory as QuoteCollectionFactory;
use Psr\Log\LoggerInterface;

class AbandonedCart
{
    protected $quoteCollectionFactory;
    protected $logger;

    public function __construct(
        QuoteCollectionFactory $quoteCollectionFactory,
        LoggerInterface $logger
    ) {
        $this->quoteCollectionFactory = $quoteCollectionFactory;
        $this->logger = $logger;
    }

    public function execute()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        // \Magento\Store\Model\StoreManagerInterface
        $storeManager   = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
        $collection  = $objectManager->get('\Magento\Reports\Model\ResourceModel\Quote\CollectionFactory')->create();

        // \Magento\Reports\Model\ResourceModel\Quote\CollectionFactory
        // $collection = $this->quotesFactory->create();
       // $store_id = $storeManager->getStore()->getId();
       // $collection->prepareForAbandonedReport([$store_id]);
       // $rows = $collection->load();
      //  var_dump($rows->getData());exit;//or foreach($rows as $row){...}
        
        // 
        $quoteCollection = $objectManager->get('\Magento\Quote\Model\ResourceModel\Quote\CollectionFactory')->create();
        $customerFactory = $objectManager->get('\Magento\Customer\Model\CustomerFactory');
        
        $quoteRepository = $objectManager->get('\Magento\Quote\Model\QuoteRepository');

        // $quoteCollection->addFieldToFilter('updated_at', ['lt' => date('Y-m-d H:i:s', strtotime('-1 day'))]);
        //$quoteCollection->addFieldToFilter('IsActive', ['eq' => false]);
        $quoteCollection->addFieldToFilter('is_active', 0);

        $helper = $objectManager->get('\Unirsal\Whatsappbasic\Helper\Apicall');
      
        $imageUrl = $helper->getAbandedCartImage();
         // Fetch the image data from the URL

 
         
      
        $store = $objectManager->get('\Magento\Store\Model\StoreManagerInterface')->getStore();
      
        $imageUrl = $store->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'Image/' . $helper->getAbandedCartImage();
        try {
            $imageData = file_get_contents($imageUrl);
        }
          //catch exception
          catch(Exception $e) {
           
          }
          
    
        
        $userfile_extn = explode(".", strtolower($imageUrl));
        $path = end($userfile_extn);
        $base64 = 'data:image/'.$path.';base64,'. chunk_split(base64_encode($imageData));
       
   

        foreach ($quoteCollection as $quote) {
               
            if($quote->getIsActive() == '0' ){

                $customer = $customerFactory->create()->load($customerId);
                $message = $helper->getAbandedCartText();
                $messageFinal = $helper->FilterVariableCustomer($message ,$customer);
               
                $mobileNumber = $customer->getTelephone();
                $res = $helper->sendImage($mobileNumber,$messageFinal,$base64);
                $res = $helper->sendText($phoneNumber,$messageFinal);

               $quote->setIsActive(1)->setReservedOrderId(null)->save();
               sleep(12);
             } 

           /* $quoteItems = $quote->getAllItems();
            foreach ($quoteItems as $quoteItem) {
                // You can access each item here
                $itemId = $quoteItem->getId();
                $productName = $quoteItem->getName();
                // Perform any actions with the item as needed
               
              //  $quote->setUpdatedAt(date('Y-m-d H:i:s')); // Set updated_at to current time
              //  $quote->save();
               // exit;
            }*/

            /*if ($customerId) {
                // Load customer
                $customer = $this->customerFactory->create()->load($customerId);
                // Update cart to make it not expired
                $quote->setIsActive(1); // Mark the cart as active
                $quote->save();
                // Optionally, you can perform any additional actions with the customer here
            }*/
        
    }


    }
}
