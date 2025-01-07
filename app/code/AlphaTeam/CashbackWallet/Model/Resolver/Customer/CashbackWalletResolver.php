<?php

namespace AlphaTeam\CashbackWallet\Model\Resolver\Customer;

use Magento\CustomerGraphQl\Model\Customer\GetCustomer;
use AlphaTeam\CashbackWallet\Model\CashbackWalletRepository;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\Exception\NoSuchEntityException;

class CashbackWalletResolver implements ResolverInterface
{
    /**
     * @var GetCustomer
     */
    private GetCustomer $getCustomer;

    /**
     * @var CashbackWalletRepository
     */
    private CashbackWalletRepository $cashbackWalletRepository;

    /**
     * @param GetCustomer $getCustomer
     * @param CashbackWalletRepository $cashbackWalletRepository
     */
    public function __construct(
        GetCustomer $getCustomer,
        CashbackWalletRepository $cashbackWalletRepository
    ) {
        $this->getCustomer = $getCustomer;
        $this->cashbackWalletRepository = $cashbackWalletRepository;
    }

    /**
     * Resolve method
     *
     * @param Field $field
     * @param mixed $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array
     * @throws \Magento\Framework\GraphQl\Exception\GraphQlAuthenticationException
     * @throws \Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException
     * @throws \Magento\Framework\GraphQl\Exception\GraphQlInputException
     * @throws \Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException
     */
    public function resolve(
        Field $field,
              $context,
        ResolveInfo $info,
        ?array $value = null,
        ?array $args = null
    ): array {
        $customer = $this->getCustomer->execute($context);

        try {
            $cashbackWallet = $this->cashbackWalletRepository->getByCustomerId($customer->getId());
            return [
                'balance' => $cashbackWallet->getBalance(),
                'totalEarned' => $cashbackWallet->getTotalEarned(),
                'totalUsed' => $cashbackWallet->getTotalUsed(),
                'status' => $cashbackWallet->getStatus() ? 'Active' : 'Inactive'
            ];
        } catch (NoSuchEntityException $e) {
            return [
                'balance' => 0,
                'totalEarned' => 0,
                'totalUsed' => 0,
                'status' => 'Inactive'
            ];
        }
    }
}
