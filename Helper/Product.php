<?php

namespace StudioEmma\Core\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Registry;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Catalog\Api\CategoryRepositoryInterface;

class Product extends AbstractHelper
{
    /**
     * Core registry
     *
     * @var Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var Magento\Catalog\Api\CategoryRepositoryInterface
     */
    protected $_categoryRepository;

    /**
     * @param Magento\Framework\App\Helper\Context $context
     * @param Magento\Framework\Registry $registry
     * @param Magento\Store\Model\StoreManagerInterface
     * @param Magento\Catalog\Api\CategoryRepositoryInterface
     */
    public function __construct(
        Context $context,
        Registry $registry,
        StoreManagerInterface $storeManager,
        CategoryRepositoryInterface $categoryRepository
    ) {
        $this->_coreRegistry = $registry;
        $this->_storeManager = $storeManager;
        $this->_categoryRepository = $categoryRepository;
        parent::__construct($context);
    }

    /**
     * get the current category from the registry or from the first
     * category of a product (first current_category then try if there is a
     * product)
     *
     * @return Magento\Catalog\Model\Category
     *         | Magento\Catalog\Model\Category\Interceptor
     *         | null
     */
    public function getCurrentCategory()
    {
        $currentCategory = $this->_coreRegistry->registry('current_category');
        if (null === $currentCategory) {
            // try if there is a product
            $currentProduct = $this->_coreRegistry->registry('product');
            if (null !== $currentProduct) {
                $productCatIds = $currentProduct->getCategoryIds();
                $firstCatId = reset($productCatIds);
                $currentCategory = $this->_categoryRepository->get(
                    $firstCatId,
                    $this->_storeManager->getStore()->getId()
                );
            }
        }
        return $currentCategory;
    }

    /**
     * get the parent category of the current category
     *
     * @return Magento\Catalog\Model\Category
     *         | Magento\Catalog\Model\Category\Interceptor
     *         | null
     */
    public function getParentCategory()
    {
        $parentCategory = null;
        $currentCategory = $this->getCurrentCategory();
        if (null !== $currentCategory) {
            $parentCategoryId = $currentCategory->getParentId();
            $parentCategory = $this->_categoryRepository->get(
                $parentCategoryId,
                $this->_storeManager->getStore()->getId()
            );
            if (null !== $parentCategory && 1 >= $parentCategory->getLevel()) {
                $parentCategory = null;
            }
        }
        return $parentCategory;
    }

    /**
     * get a back url when browsing products/categories
     *
     * return the shop url as fallback
     *
     * @return string
     */
    public function getBackUrl()
    {
        $url = null;
        if (null !== $this->_coreRegistry->registry('product')) {
            // we are on a product page
            $currentCategory = $this->getCurrentCategory();
            $url = $currentCategory->getUrl();
        } else {
            // we are on a category page, or somewhere else
            $parentCategory = $this->getParentCategory();
            if (null !== $parentCategory) {
                $url = $parentCategory->getUrl();
            }
        }

        if (null === $url) {
            $url = $this->_storeManager->getStore()->getBaseUrl();
        }

        return $url;
    }

    /**
     * Return the current product, if available
     * @return \Magento\Catalog\Model\Product | null
     */
    public function getCurrentProduct()
    {
        return $this->_coreRegistry->registry('product');
    }
}
