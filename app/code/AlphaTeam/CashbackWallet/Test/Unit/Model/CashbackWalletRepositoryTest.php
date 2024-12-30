<?php

namespace AlphaTeam\CashbackWallet\Test\Unit\Model;

use AlphaTeam\CashbackWallet\Model\CashbackWallet;
use AlphaTeam\CashbackWallet\Api\Data\CashbackWalletInterfaceFactory;
use AlphaTeam\CashbackWallet\Model\CashbackWalletRepository;
use AlphaTeam\CashbackWallet\Model\ResourceModel\CashbackWallet as ResourceModel;
use AlphaTeam\CashbackWallet\Model\ResourceModel\CashbackWallet\CollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessor;
use Magento\Framework\Api\Search\SearchResultInterfaceFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use PHPUnit\Framework\TestCase;

class CashbackWalletRepositoryTest extends TestCase
{
    /**
     * @var CashbackWalletRepository
     */
    private CashbackWalletRepository $repository;

    /**
     * @var ResourceModel
     */
    private ResourceModel $resourceMock;

    /**
     * @var CashbackWalletInterfaceFactory
     */
    private CashbackWalletInterfaceFactory $cashbackWalletFactoryMock;

    /**
     * @var CollectionFactory
     */
    private CollectionFactory $collectionFactoryMock;

    /**
     * @var CollectionProcessor
     */
    private CollectionProcessor $collectionProcessorMock;

    /**
     * @var SearchResultInterfaceFactory
     */
    private SearchResultInterfaceFactory $searchResultFactoryMock;

    protected function setUp(): void
    {
        $this->resourceMock = $this->createMock(ResourceModel::class);
        $this->cashbackWalletFactoryMock = $this->createMock(CashbackWalletInterfaceFactory::class);
        $this->collectionFactoryMock = $this->createMock(CollectionFactory::class);
        $this->collectionProcessorMock = $this->createMock(CollectionProcessor::class);
        $this->searchResultFactoryMock = $this->createMock(SearchResultInterfaceFactory::class);

        $this->repository = new CashbackWalletRepository(
            $this->resourceMock,
            $this->cashbackWalletFactoryMock,
            $this->collectionFactoryMock,
            $this->collectionProcessorMock,
            $this->searchResultFactoryMock
        );
    }

    public function testSave()
    {
        $walletMock = $this->createMock(CashbackWallet::class);

        $this->resourceMock->expects($this->once())
            ->method('save')
            ->with($walletMock);

        $this->assertEquals($walletMock, $this->repository->save($walletMock));
    }

    public function testGetById()
    {
        $walletId = 1;
        $walletMock = $this->createMock(CashbackWallet::class);

        $this->cashbackWalletFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($walletMock);

        $this->resourceMock->expects($this->once())
            ->method('load')
            ->with($walletMock, $walletId);

        $walletMock->expects($this->once())
            ->method('getEntityId')
            ->willReturn($walletId);

        $this->assertEquals($walletMock, $this->repository->getById($walletId));
    }

    public function testGetByIdThrowsException()
    {
        $walletId = 1;
        $walletMock = $this->createMock(CashbackWallet::class);

        $this->cashbackWalletFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($walletMock);

        $this->resourceMock->expects($this->once())
            ->method('load')
            ->with($walletMock, $walletId);

        $walletMock->expects($this->once())
            ->method('getEntityId')
            ->willReturn(null);

        $this->expectException(NoSuchEntityException::class);
        $this->repository->getById($walletId);
    }

    public function testDelete()
    {
        $walletMock = $this->createMock(CashbackWallet::class);

        $this->resourceMock->expects($this->once())
            ->method('delete')
            ->with($walletMock);

        $this->assertTrue($this->repository->delete($walletMock));
    }

    public function testDeleteById()
    {
        $walletId = 1;
        $walletMock = $this->createMock(CashbackWallet::class);

        $this->cashbackWalletFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($walletMock);

        $this->resourceMock->expects($this->once())
            ->method('load')
            ->with($walletMock, $walletId);

        $walletMock->expects($this->once())
            ->method('getEntityId')
            ->willReturn($walletId);

        $this->resourceMock->expects($this->once())
            ->method('delete')
            ->with($walletMock);

        $this->assertTrue($this->repository->deleteById($walletId));
    }
}
