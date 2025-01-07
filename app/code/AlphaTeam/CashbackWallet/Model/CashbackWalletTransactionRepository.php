<?php

declare(strict_types=1);

namespace AlphaTeam\CashbackWallet\Model;

use AlphaTeam\CashbackWallet\Api\Data\CashbackWalletTransactionInterface;
use AlphaTeam\CashbackWallet\Api\Data\CashbackWalletTransactionInterfaceFactory;
use AlphaTeam\CashbackWallet\Api\CashbackWalletTransactionRepositoryInterface;
use AlphaTeam\CashbackWallet\Model\ResourceModel\CashbackWalletTransaction as ResourceModel;
use AlphaTeam\CashbackWallet\Model\ResourceModel\CashbackWalletTransaction\CollectionFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessor;
use Magento\Framework\Api\Search\SearchResultInterfaceFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\CouldNotDeleteException;

class CashbackWalletTransactionRepository implements CashbackWalletTransactionRepositoryInterface
{
    /**
     * @var ResourceModel
     */
    private ResourceModel $resource;

    /**
     * @var CashbackWalletTransactionInterfaceFactory
     */
    private CashbackWalletTransactionInterfaceFactory $cashbackWalletTransactionFactory;

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

    public function __construct(
        ResourceModel $resource,
        CashbackWalletTransactionInterfaceFactory $cashbackWalletTransactionFactory,
        CollectionFactory $collectionFactory,
        CollectionProcessor $collectionProcessor,
        SearchResultInterfaceFactory $searchResultFactory
    ) {
        $this->resource = $resource;
        $this->cashbackWalletTransactionFactory = $cashbackWalletTransactionFactory;
        $this->collectionFactory = $collectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultFactory = $searchResultFactory;
    }

    /**
     * Save method. Insert/Update a cashback wallet
     *
     * @param CashbackWalletTransactionInterface $transaction
     * @return CashbackWalletTransactionInterface
     * @throws CouldNotSaveException
     */
    public function save(CashbackWalletTransactionInterface $transaction): CashbackWalletTransactionInterface
    {
        try {
            $this->resource->save($transaction);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__('Could not save the wallet transaction: %1', $exception->getMessage()));
        }
        return $transaction;
    }

    /**
     * Get a Cashback Wallet by ID
     *
     * @param int $id
     * @return CashbackWalletTransactionInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): CashbackWalletTransactionInterface
    {
        $cashbackWalletTransaction = $this->cashbackWalletTransactionFactory->create();
        $this->resource->load($cashbackWalletTransaction, $id);
        if (!$cashbackWalletTransaction->getId()) {
            throw new NoSuchEntityException(__('The wallet transaction with the "%1" ID doesn\'t exist.', $id));
        }
        return $cashbackWalletTransaction;
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
     * @param CashbackWalletTransactionInterface $transaction
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(CashbackWalletTransactionInterface $transaction): bool
    {
        try {
            $this->resource->delete($transaction);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__('Could not delete the wallet transaction: %1', $exception->getMessage()));
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
