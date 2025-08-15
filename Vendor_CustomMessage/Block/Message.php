<?php
declare(strict_types=1);

namespace Vendor\CustomMessage\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Message extends Template
{
    private ScopeConfigInterface $scopeConfig;

    public function __construct(
        Template\Context $context,
        ScopeConfigInterface $scopeConfig,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->scopeConfig = $scopeConfig;
    }

    public function isEnabled(): bool
    {
        return (bool)$this->scopeConfig->getValue('custommessage/general/enabled', ScopeInterface::SCOPE_STORE);
    }

    public function getCustomMessage(): string
    {
        return (string)($this->scopeConfig->getValue('custommessage/general/message', ScopeInterface::SCOPE_STORE) ?? '');
    }
}
