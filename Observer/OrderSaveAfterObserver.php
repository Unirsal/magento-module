<?php
namespace Unirsal\Whatsappbasic\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;

class OrderSaveAfterObserver implements ObserverInterface
{
    public function execute(Observer $observer)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

       

        $helper = $objectManager->get('\Unirsal\Whatsappbasic\Helper\Apicall');

        $order = $observer->getEvent()->getOrder();
        // Perform actions here based on the order state change
        // Example:
        $orderState = $order->getState();
        $orderStatus = $order->getStatus();
      
        // cancel
        if($orderStatus == 'canceled'){
            if($helper->getOrderCancelEnable()){
                $message = $helper->getOrderOnCancelText();
                $billingAddress = $order->getBillingAddress();
                $mobilenumber = $billingAddress->getTelephone();
                $phoneNumber = '962787330259';
                $messageFinal = $helper->FilterVariableInvoce($message ,$order);

                $res = $helper->sendText($phoneNumber,$messageFinal);

            }
        }
        // hold
        if($orderStatus == 'holded'){
            if($helper->getOrderOnHoldEnable()){
                $message = $helper->getOrderOnHoldText();
                $billingAddress = $order->getBillingAddress();
                $mobilenumber = $billingAddress->getTelephone();
                $phoneNumber = '962787330259';
                $messageFinal = $helper->FilterVariableInvoce($message ,$order);

                $res = $helper->sendText($phoneNumber,$messageFinal);

            }
        }
        //Shippment 
        if($orderStatus == 'processing'){
            if($helper->getOrderprocessingEnable()){
                $message = $helper->getOrderprocessingText();
                $billingAddress = $order->getBillingAddress();
                $mobilenumber = $billingAddress->getTelephone();
                $phoneNumber = '962787330259';
                $messageFinal = $helper->FilterVariableInvoce($message ,$order);

                $res = $helper->sendText($phoneNumber,$messageFinal);

            }
        }



        // complete
        if($orderStatus == 'complete'){
            if($helper->getOrderCompleteEnable()){
                $message = $helper->getOrderCompleteText();
                $billingAddress = $order->getBillingAddress();
                $mobilenumber = $billingAddress->getTelephone();
                $phoneNumber = '962787330259';
                $messageFinal = $helper->FilterVariableInvoce($message ,$order);

                $res = $helper->sendText($phoneNumber,$messageFinal);

            }
        }
    }
}
