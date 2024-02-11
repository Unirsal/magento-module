<?php
namespace Unirsal\Whatsappbasic\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Sales\Model\Order\Invoice;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Email\Model\TemplateFactory;
use Magento\Framework\View\DesignInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Sales\Model\Order\Email\Sender\InvoiceSender;

class InvoiceSaveAfterObserver implements ObserverInterface
{
    public function execute(Observer $observer)
    {
        $invoice = $observer->getEvent()->getInvoice();
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $helper = $objectManager->get('\Unirsal\Whatsappbasic\Helper\Apicall');
        // \Magento\Framework\Module\FullModuleList
        $fullModuleList  = $objectManager->get('\Magento\Framework\Module\FullModuleList')->getAll();;
        //TO DO ENABLE CHECK
        if($helper->getInvoceEnable()){
            if(array_key_exists("Magetrend_PdfTemplates",$fullModuleList)){
                $this->MageTrendFlow($observer->getEvent()->getInvoice(), $helper,$objectManager);
     
              }else{
                 $this->LumaPdf($observer->getEvent()->getInvoice(), $helper,$objectManager);
     
              }
        }

     }
    public function LumaPdf($invoice, $helper,$objectManager){

        // \Magento\Framework\Filesystem
        $filesystem = $objectManager->get('\Magento\Framework\Filesystem');
        // sales_email_invoice_template/Magento/luma [label] => New Invoice (Magento/luma) 
        $templateId = 'sales_email_invoice_template'; // Template ID for invoice email
        $invocePdf = $objectManager->create('\Magento\Sales\Model\Order\Pdf\Invoice');
        $orderId = $invoice->getOrderId();
        $orderRepository = $objectManager->get(OrderRepositoryInterface::class);
        $order = $orderRepository->get($orderId);
        // Load the invoice email template \Magento\Email\Model\BackendTemplate
        $pdf = $invocePdf->getPdf([$invoice]);
        $fileContent = ['type' => 'string', 'value' => $pdf->render(), 'rm' => true];
        $billingAddress = $order->getBillingAddress();
        $mobilenumber = $billingAddress->getTelephone();

        $base64 = 'data:application/pdf;base64,' . chunk_split(base64_encode($pdf->render()));
        $message = $helper->getInvoceText();
        $messageFinal = $helper->FilterVariableInvoce($message ,$order,$invoce);

        $res = $helper->sendText($mobilenumber,$messageFinal);
        $res = $helper->sendFile($mobilenumber,$messageFinal,$base64);

        

    }

    public function MageTrendFlow($invoice, $helper,$objectManager){
        // \Magento\Framework\Filesystem
        $filesystem = $objectManager->get('\Magento\Framework\Filesystem');

        $templateId = $helper->getTempleteId();// $this->getRequest()->getParam('id');
        // $sourceId = $this->getRequest()->getParam('invoice_id') ;
        $sourceId = $invoice->getId();
        $orderId = $invoice->getOrderId();
        $orderRepository = $objectManager->get(OrderRepositoryInterface::class);
        $order = $orderRepository->get($orderId);
        // Get the customer associated with the order
 
        // Retrieve the phone number from the customer
        $billingAddress = $order->getBillingAddress();
        $mobilenumber = $billingAddress->getTelephone();

 
        $Mte = $objectManager->get('\Magetrend\PdfTemplates\Model\MtEditorManager');
        $template = $Mte->initTemplate($templateId);

        // Unirsal\Whatsappbasic\Helper
        
        $sourceObject = $Mte->typeManager
            ->setTemplateType($template->getType())
            ->getAdapter()
            ->getObjectById($sourceId);

        if (!$sourceObject) {
            throw new \Exception(__('Ops'));
        }
        
         
        $fileName = sprintf('preview_%s.pdf', time());
        // Magetrend\PdfTemplates\Model\Adapter\TcPdf
        $TcpDf = $objectManager->get('\Magetrend\PdfTemplates\Model\Adapter\TcPdf');
        //To DO: tempid to xml
        // $tmpDirectory = $filesystem->getDirectoryRead(DirectoryList::TMP);
        $filePath = $filesystem->getDirectoryRead(DirectoryList::TMP)->getAbsolutePath($fileName);

        // $path = $TcpDf->createPdf([$sourceObject], DirectoryList::TMP, $fileName, $templateId);
         $path = $template->createPdf([$invoice], DirectoryList::TMP, $fileName, $templateId);
         $pdfFile = file_get_contents($filePath);
         $base64 = 'data:application/pdf;base64,' . chunk_split(base64_encode($pdfFile));
         $message = $helper->getInvoceText();
         $messageFinal = $helper->FilterVariableInvoce($message ,$order,$invoice);
         $res = $helper->sendText($mobilenumber,$messageFinal);
         $res = $helper->sendFile($mobilenumber,$messageFinal,$base64);
         return true;

    }
}
