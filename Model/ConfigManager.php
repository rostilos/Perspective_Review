<?php

namespace Perspective\Review\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

class ConfigManager
{
    public const GROUP_GENERAL = 'general';

    /**
     * @var ScopeConfigInterface
     */
    private ScopeConfigInterface $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Retrieve config data
     *
     * @param string $group
     * @param string $key
     * @return string|null
     */
    public function getConfig(string $group, string $key): ?string
    {
        return $this->scopeConfig->getValue("perspective_review/$group/$key");
    }

    /**
     * Is enabled flag
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return (bool)$this->getConfig(self::GROUP_GENERAL, 'enable');
    }

}
