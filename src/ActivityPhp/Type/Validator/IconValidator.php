<?php

declare(strict_types=1);

/*
 * This file is part of the ActivityPhp package.
 *
 * Copyright (c) landrok at github.com/landrok
 *
 * For the full copyright and license information, please see
 * <https://github.com/landrok/activitypub/blob/master/LICENSE>.
 */

namespace ActivityPhp\Type\Validator;

use ActivityPhp\Type\Core\ObjectType;
use ActivityPhp\Type\Util;
use ActivityPhp\Type\ValidatorInterface;
use Exception;

/**
 * \ActivityPhp\Type\Validator\IconValidator is a dedicated
 * validator for icon attribute.
 */
class IconValidator implements ValidatorInterface
{
    /**
     * Validate icon item
     *
     * @param string $value
     * @param mixed $container An object
     * @throws Exception
     * @todo Implement size checks
     * @todo Support Image objects and Link objects
     */
    public function validate($value, $container): bool
    {
        // Validate that container is a ObjectType
        Util::subclassOf($container, ObjectType::class, true);

        if (is_string($value)) {
            return Util::validateUrl($value);
        }

        if (is_array($value)) {
            $value = Util::arrayToType($value);
        }

        if (is_array($value)) {
            foreach ($value as $element) {
                if (is_array($element)) {
                    $element = Util::arrayToType($element);
                }

                if (is_string($element) && Util::validateUrl($element)) {
                    continue;
                }

                if (! $this->validateObject($element)) {
                    return false;
                }
            }

            return true;
        }

        // Must be an Image or a Link
        return $this->validateObject($value);
    }

    /**
     * Validate an object format
     *
     * @param object $item
     */
    protected function validateObject($item): bool
    {
        return Util::validateLink($item)
            || Util::isType($item, 'Image');
    }
}
