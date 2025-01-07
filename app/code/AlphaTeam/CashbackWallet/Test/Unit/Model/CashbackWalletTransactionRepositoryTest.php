<?php

namespace AlphaTeam\CashbackWallet\Test\Unit\Model;

use AlphaTeam\CashbackWallet\Model\CashbackWalletTransaction;
use AlphaTeam\CashbackWallet\Api\Data\CashbackWalletTransactionInterfaceFactory;
use AlphaTeam\CashbackWallet\Model\CashbackWalletTransactionRepository;
use AlphaTeam\CashbackWallet\Model\ResourceModel\CashbackWalletTransaction as ResourceModel;
use AlphaTeam\CashbackWallet\Model\ResourceModel\CashbackWalletTransaction\Collection;
use AlphaTeam\CashbackWallet\Model\ResourceModel\CashbackWalletTransaction\CollectionFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\Search\SearchResultInterfaceFactory;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessor;
use Magento\Framework\Exception\NoSuchEntityException;
use PHPUnit\Framework\TestCase;

class CashbackWalletTransactionRepositoryTest extends TestCase
{
    /**
     * @var ResourceModel|\PHPUnit\Framework\MockObject\MockObject
     */
    private ResourceModel $resource;

    /**
     * @var CashbackWalletTransactionInterfaceFactory|\PHPUnit\Framework\MockObject\MockObject
     */
    private CashbackWalletTransactionInterfaceFactory $transactionFactory;

    /** @var CollectionFactory|\PHPUnit\Framework\MockObject\MockObject */
    private CollectionFactory $collectionFactory;

    /**
     * @var CollectionProcessor|\PHPUnit\Framework\MockObject\MockObject
     */
    private CollectionProcessor $collectionProcessor;

    /**
     * @var SearchResultInterfaceFactory|\PHPUnit\Framework\MockObject\MockObject
     */
    private SearchResultInterfaceFactory $searchResultFactory;

    /**
     * @var CashbackWalletTransactionRepository
     */
    private CashbackWalletTransactionRepository $repository;

    protected function setUp(): void
    {
        $this->resource = $this->createMock(ResourceModel::class);
        $this->transactionFactory = $this->createMock(CashbackWalletTransactionInterfaceFactory::class);
        $this->collectionFactory = $this->createMock(CollectionFactory::class);
        $this->collectionProcessor = $this->createMock(CollectionProcessor::class);
        $this->searchResultFactory = $this->createMock(SearchResultInterfaceFactory::class);

        $this->repository = new CashbackWalletTransactionRepository(
            $this->resource,
            $this->transactionFactory,
            $this->collectionFactory,
            $this->collectionProcessor,
            $this->searchResultFactory
        );
    }

    public function testSave(): void
    {
        $transaction = $this->createMock(CashbackWalletTransaction::class);
        $this->resource->expects($this->once())
            ->method('save')
            ->with($transaction);

        $result = $this->repository->save($transaction);

        $this->assertSame($transaction, $result);
    }

    public function testGetById(): void
    {
        $transactionId = 1;
        $transaction = $this->createMock(CashbackWalletTransaction::class);

        $this->transactionFactory->expects($this->once())
            ->method('create')
            ->willReturn($transaction);

        $this->resource->expects($this->once())
            ->method('load')
            ->with($transaction, $transactionId);

        $transaction->expects($this->once())
            ->method('getId')
            ->willReturn($transactionId);

        $result = $this->repository->getById($transactionId);

        $this->assertSame($transaction, $result);
    }

    public function testGetByIdThrowsException(): void
    {
        $transactionId = 1;
        $transaction = $this->createMock(CashbackWalletTransaction::class);

        $this->transactionFactory->expects($this->once())
            ->method('create')
            ->willReturn($transaction);

        $this->resource->expects($this->once())
            ->method('load')
            ->with($transaction, $transactionId);

        $transaction->expects($this->once())
            ->method('getId')
            ->willReturn(null);

        $this->expectException(NoSuchEntityException::class);

        $this->repository->getById($transactionId);
    }

    public function testGetList(): void
    {
        $searchCriteria = $this->createMock(SearchCriteriaInterface::class);
        $collection = $this->createMock(Collection::class);
        $searchResult = $this->createMock(SearchResultsInterface::class);

        $this->collectionFactory->expects($this->once())
            ->method('create')
            ->willReturn($collection);

        $this->collectionProcessor->expects($this->once())
            ->method('process')
            ->with($searchCriteria, $collection);

        $this->searchResultFactory->expects($this->once())
            ->method('create')
            ->willReturn($searchResult);

        $collection->expects($this->once())
            ->method('getItems')
            ->willReturn(['item1', 'item2']);

        $collection->expects($this->once())
            ->method('getSize')
            ->willReturn(2);

        $searchResult->expects($this->once())
            ->method('setItems')
            ->with(['item1', 'item2']);

        $searchResult->expects($this->once())
            ->method('setTotalCount')
            ->with(2);

        $result = $this->repository->getList($searchCriteria);

        $this->assertSame($searchResult, $result);
    }

    public function testDelete(): void
    {
        $transaction = $this->createMock(CashbackWalletTransaction::class);

        $this->resource->expects($this->once())
            ->method('delete')
            ->with($transaction);

        $result = $this->repository->delete($transaction);

        $this->assertTrue($result);
    }

    public function testDeleteById(): void
    {
        $transactionId = 1;
        $transaction = $this->createMock(CashbackWalletTransaction::class);

        // Mock del repositorio
        $repository = $this->getMockBuilder(CashbackWalletTransactionRepository::class)
            ->setConstructorArgs([
                $this->resource,
                $this->transactionFactory,
                $this->collectionFactory,
                $this->collectionProcessor,
                $this->searchResultFactory,
            ])
            ->onlyMethods(['getById'])
            ->getMock();

        $repository->expects($this->once())
            ->method('getById')
            ->with($transactionId)
            ->willReturn($transaction);

        $this->resource->expects($this->once())
            ->method('delete')
            ->with($transaction);

        $result = $repository->deleteById($transactionId);

        $this->assertTrue($result);
    }
}
