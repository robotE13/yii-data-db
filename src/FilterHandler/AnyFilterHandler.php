<?php

declare(strict_types=1);

namespace Yiisoft\Data\Db\FilterHandler;

use Yiisoft\Data\Reader\Filter\Any;
use Yiisoft\Data\Reader\FilterInterface;

final class AnyFilterHandler implements QueryFilterHandlerInterface
{
    public function getFilterClass(): string
    {
        return Any::class;
    }

    public function getCriteria(FilterInterface $filter, Context $context): ?Criteria
    {
        /** @var Any $filter */
        $criteria = $filter->toCriteriaArray();
        $condition = [
            $criteria[0],
            ...array_filter(
                $criteria[1],
                fn (array $operand) => !empty($operand[2])
            )
        ];
        $params = [];

        return new Criteria($condition, $params);
    }
}
