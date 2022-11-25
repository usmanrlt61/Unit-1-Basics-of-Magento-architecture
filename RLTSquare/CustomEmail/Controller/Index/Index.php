<?php

namespace RLTSquare\CustomEmail\Controller\Index;

use RLTSquare\CustomEmail\Logger\Logger;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\View\Result\PageFactory;
use RLTSquare\CustomEmail\Helper\Email;


class Index implements ActionInterface
{
    protected PageFactory $_pageFactory;

    protected Logger $logger;
    protected Email $email;

    public function __construct(
        Context     $context,
        PageFactory $pageFactory,
        Logger      $logger,
        Email       $email
    ) {
        $this->logger = $logger;
        $this->_pageFactory = $pageFactory;
        $this->email=$email;
    }

    public function execute()
    {
        $this->logger->info('Page is visited... ');
        $this->email->sendEmail();
       $result = $this->_pageFactory->create();
       $result->getConfig()->getTitle()->set("Test");
       return $result;
    }
}
