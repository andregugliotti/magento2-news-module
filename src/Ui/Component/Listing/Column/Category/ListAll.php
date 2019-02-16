<?php
/**
 * Gugliotti News
 */
namespace Gugliotti\News\Ui\Component\Listing\Column\Category;

use Gugliotti\News\Api\CategoryRepositoryInterface;
use Gugliotti\News\Model\Category;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class ListAll
 *
 * Gugliotti News Category Select Block.
 * @author Andre Gugliotti <andre@gugliotti.com.br>
 * @version 0.1.0
 * @license GNU General Public License, version 3
 * @package Gugliotti\News\Ui\Component\Listing\Column\Category
 */
class ListAll implements OptionSourceInterface
{
    /**
     * @var array
     */
    protected $options;

    /**
     * @var CategoryRepositoryInterface
     */
    protected $categoryRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * ListAll constructor.
     * @param CategoryRepositoryInterface $categoryRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * toOptionArray
     * @return array
     */
    public function toOptionArray()
    {
        if ($this->options !== null) {
            return $this->options;
        }

        try {
            $searchCriteria = $this->searchCriteriaBuilder->create();
            $categories = $this->categoryRepository->getList($searchCriteria);
        } catch (\Exception $e) {
            return [];
        }

        /** @var Category $ca */
        foreach ($categories->getItems() as $ca) {
            $this->options[] = [
                'label' => $ca->getLabel(),
                'value' => $ca->getId()
            ];
        }
        return $this->options;
    }
}
