<?php

namespace StudioEmma\Core\Helper;

class Customer extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Customer\Helper\Session\CurrentCustomer
     */
    protected $_currentCustomer;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer
    ) {
        $this->_currentCustomer = $currentCustomer;
        parent::__construct($context);
    }

    /**
     * Check if the user is logged in
     * @return bool
     */
    public function isLoggedIn()
    {
        if ($this->_currentCustomer->getCustomerId()) {
            return true;
        }

        return false;
    }

    /**
     * If logged in, will return the current customer object
     * @return null|\Magento\Customer\Api\Data\CustomerInterface
     */
    public function getCurrentCustomer()
    {
        if ($this->isLoggedIn()) {
            return $this->_currentCustomer->getCustomer();
        }

        return null;
    }

    public function getCurrentCustomerGroup()
    {
        $currentCustomer = $this->getCurrentCustomer();
        if (null !== $currentCustomer) {
            return $currentCustomer->getGroupId();
        }

        return null;
    }
}
