<?php
/**
 * This source file is part of Xloit project.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License that is bundled with this package in the file LICENSE.
 * It is also available through the world-wide-web at this URL:
 * <http://www.opensource.org/licenses/mit-license.php>
 * If you did not receive a copy of the license and are unable to obtain it through the world-wide-web,
 * please send an email to <license@xloit.com> so we can send you a copy immediately.
 *
 * @license   MIT
 * @link      http://xloit.com
 * @copyright Copyright (c) 2016, Xloit. All rights reserved.
 */

namespace Xloit\Bridge\Zend\Form;

use Xloit\Std\ArrayUtils;
use Zend\Form\Element;
use Zend\Validator\NotEmpty;

/**
 * An {@link ElementRequireAttributesProviderTrait} trait.
 *
 * @package Xloit\Bridge\Zend\Form
 *
 * @method Element get($elementOrFieldset)
 */
trait ElementRequireAttributesProviderTrait
{
    /**
     * Add attributes to required fields.
     *
     * @param array $specifications
     *
     * @return static
     * @throws \Xloit\Std\Exception\RuntimeException
     */
    final protected function addRequiredAttributeToFields(array $specifications)
    {
        /** @var array $data */
        foreach ($specifications as $field => $data) {
            if (!$this->has($field)) {
                continue;
            }

            $validators = ArrayUtils::get($data, 'validators', []);
            $isRequired = (bool) ArrayUtils::get(
                $data,
                'required',
                ArrayUtils::get($validators, NotEmpty::class, ArrayUtils::get($validators, 'NotEmpty'))
            );

            if ($isRequired) {
                $this->get($field)->setAttribute('required', 'required');
            }
        }

        return $this;
    }
}
