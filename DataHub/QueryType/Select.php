<?php

declare(strict_types=1);

/*
 * CoreShop
 *
 * This source file is available under two different licenses:
 *  - GNU General Public License version 3 (GPLv3)
 *  - CoreShop Commercial License (CCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @copyright  Copyright (c) CoreShop GmbH (https://www.coreshop.org)
 * @license    https://www.coreshop.org/license     GPLv3 and CCL
 *
 */

namespace CoreShop\Bundle\ResourceBundle\DataHub\QueryType;

use CoreShop\Bundle\ResourceBundle\DataHub\Resolver\ResourceResolver;
use GraphQL\Type\Definition\Type;
use Pimcore\Bundle\DataHubBundle\GraphQL\DataObjectQueryFieldConfigGenerator\Input;
use Pimcore\Model\DataObject\ClassDefinition\Data;

class Select extends Input
{
    public function getGraphQlFieldConfig($attribute, Data $fieldDefinition, $class = null, $container = null)
    {
        return $this->enrichConfig(
            $fieldDefinition,
            $class,
            $attribute,
            [
            'name' => $fieldDefinition->getName(),
            'type' => $this->getFieldType($fieldDefinition, $class, $container),
            'resolve' => $this->getResolver($attribute, $fieldDefinition, $class),
        ],
            $container,
        );
    }

    public function getFieldType(Data $fieldDefinition, $class = null, $container = null)
    {
        return Type::int();
    }

    public function getResolver($attribute, $fieldDefinition, $class)
    {
        $resolver = new ResourceResolver($fieldDefinition);

        return [$resolver, 'resolve'];
    }
}
