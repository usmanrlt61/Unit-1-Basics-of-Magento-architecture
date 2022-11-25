<?php

namespace RLTSquare\CustomEmail\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\Escaper;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Email\Model\BackendTemplate;


class Email extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $inlineTranslation;
    protected $escaper;
    protected $transportBuilder;
    protected $logger;
    protected $emailTemplate;


    public function __construct(
        Context          $context,
        StateInterface   $inlineTranslation,
        Escaper          $escaper,
        TransportBuilder $transportBuilder,
        BackendTemplate  $emailTemplate


    )
    {
        parent::__construct($context);
        $this->inlineTranslation = $inlineTranslation;
        $this->escaper = $escaper;
        $this->transportBuilder = $transportBuilder;
        $this->logger = $context->getLogger();
        $this->emailTemplate = $emailTemplate;


    }

    public function sendEmail()
    {
        try {
            $email_template = $this->emailTemplate->load('email_demo_template', 'orig_template_code');
            $this->inlineTranslation->suspend();
            $sender = [
                'name' => $this->escaper->escapeHtml('Test'),
                'email' => $this->escaper->escapeHtml('usman.ali@rltsquare.com'),

            ];
            $transport = $this->transportBuilder
                ->setTemplateIdentifier($email_template->getId())
                ->setTemplateOptions(
                    [
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                    ]
                )
                ->setTemplateVars([
                    'templateVar' => 'My Topic',
                ])
                ->setFrom($sender)
                ->addTo('usman.ali@rltsquare.com')
                ->getTransport();
            $transport->sendMessage();
            $this->inlineTranslation->resume();
        } catch (\Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }
}
