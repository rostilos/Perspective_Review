<?php

namespace Perspective\Review\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

class ConfigManager
{

    public const GROUP_GENERAL = 'general';


    private ScopeConfigInterface $scopeConfig;

    public function __construct(
        ScopeConfigInterface $scopeConfig
    )
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function getConfig(string $group, string $key): ?string
    {
        return $this->scopeConfig->getValue("perspective_review/$group/$key");
    }

    public function isEnabled(): bool
    {
        return (bool)$this->getConfig(self::GROUP_GENERAL, 'enable');
    }

    public function isGuestReviewsAllowed(): bool
    {
        return (bool)$this->getConfig(self::GROUP_GENERAL, 'allow_guest');
    }
}
