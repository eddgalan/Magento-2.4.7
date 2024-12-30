<?php

namespace AlphaTeam\CashbackWallet\Model;

use AlphaTeam\CashbackWallet\Api\Data\CashbackWalletInterface;
use AlphaTeam\CashbackWallet\Api\Data\CashbackWalletInterfaceFactory;
use AlphaTeam\CashbackWallet\Api\CashbackWalletRepositoryInterface;
use AlphaTeam\CashbackWallet\Model\ResourceModel\CashbackWallet as ResourceModel;
use AlphaTeam\CashbackWallet\Model\ResourceModel\CashbackWallet\CollectionFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessor;
use Magento\Framework\Api\Search\SearchResultInterfaceFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\CouldNotDeleteException;

class CashbackWalletRepository implements CashbackWalletRepositoryInterface
{
    /**
     * @var ResourceModel
     */
    private ResourceModel $resource;
    /**
     * @var CashbackWalletInterfaceFactory
     */
    private CashbackWalletInterfaceFactory $cashbackWalletFactory;
    /**
     * @var CollectionFactory
     */
    private CollectionFactory $collectionFactory;

    /**
     * @var CollectionProcessor
     */
    private CollectionProcessor $collectionProcessor;

    /**
     * @var SearchResultInterfaceFactory
     */
    private SearchResultInterfaceFactory $searchResultFactory;

    /**
     * @param ResourceModel $resource
     * @param CashbackWalletInterfaceFactory $cashbackWalletFactory
     * @param CollectionFactory $collectionFactory
     * @param CollectionProcessor $collectionProcessor
     * @param SearchResultInterfaceFactory $searchResultFactory
     */
    public function __construct(
        ResourceModel $resource,
        CashbackWalletInterfaceFactory $cashbackWalletFactory,
        CollectionFactory $collectionFactory,
        CollectionProcessor $collectionProcessor,
        SearchResultInterfaceFactory $searchResultFactory
    ) {
        $this->resource = $resource;
        $this->cashbackWalletFactory = $cashbackWalletFactory;
        $this->collectionFactory = $collectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultFactory = $searchResultFactory;
    }

    /**
     * Save method. Insert/Update a cashback wallet
     *
     * @param CashbackWalletInterface $cashbackWallet
     * @return CashbackWalletInterface
     * @throws CouldNotSaveException
     */
    public function save(CashbackWalletInterface $cashbackWallet): CashbackWalletInterface
    {
        try {
            $this->resource->save($cashbackWallet);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__('Could not save the wallet: %1', $exception->getMessage()));
        }
        return $cashbackWallet;
    }

    /**
     * Get a Cashback Wallet by Id
     *
     * @param int $id
     * @return CashbackWalletInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): CashbackWalletInterface
    {
        $cashbackWallet = $this->cashbackWalletFactory->create();
        $this->resource->load($cashbackWallet, $id);
        if (!$cashbackWallet->getEntityId()) {
            throw new NoSuchEntityException(__('The wallet with the "%1" ID doesn\'t exist.', $id));
        }
        return $cashbackWallet;
    }

    /**
     * Get multiple records using SearchCriteria
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface
    {
        $searchResult = $this->searchResultFactory->create();
        $collection = $this->collectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());

        return $searchResult;
    }

    /**
     * Delete a Cashback Wallet
     *
     * @param CashbackWalletInterface $cashbackWallet
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(CashbackWalletInterface $cashbackWallet): bool
    {
        try {
            $this->resource->delete($cashbackWallet);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__('Could not delete the wallet: %1', $exception->getMessage()));
        }
        return true;
    }

    /**
     * Delete a Cashback Wallet using id
     *
     * @param int $id
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $id): bool
    {
        $cashbackWallet = $this->getById($id);
        return $this->delete($cashbackWallet);
    }
}
