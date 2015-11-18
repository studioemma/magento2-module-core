<?php

namespace StudioEmma\Core\Helper;

class Store extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \Magento\Framework\Locale\Resolver
     */
    protected $_localeResolver;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Store\Model\StoreManagerInterface
     * @param \Magento\Framework\Locale\Resolver
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Locale\Resolver $localeResolver
    ) {
        $this->_storeManager = $storeManager;
        $this->_localeResolver = $localeResolver;
        parent::__construct($context);
    }

    /**
     * Returns the current store
     * @return \Magento\Store\Api\Data\StoreInterface
     */
    public function getCurrentStore()
    {
        return $this->_storeManager->getStore();
    }

    /**
     * Returns the current locale, associated with the current store
     * @return null|string
     */
    public function getLocale()
    {
        return $this->_localeResolver->getLocale();
    }
}