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

namespace Xloit\Bridge\Zend\Form\View\Helper;

use Zend\Form\ElementInterface;

/**
 * A {@link HelperTrait} trait.
 *
 * @package Xloit\Bridge\Zend\Form\View\Helper
 */
trait HelperTrait
{
    /**
     *
     *
     * @param ElementInterface $element
     * @param array            $classList
     *
     * @return ElementInterface
     */
    protected function addElementClass(ElementInterface $element, $classList)
    {
        $attributes = $element->getAttributes();

        /** @noinspection UnSafeIsSetOverArrayInspection */
        if (isset($attributes['class'])) {
            $attributes['class'] = implode(
                ' ', array_unique(array_merge(explode(' ', $attributes['class']), $classList))
            );
        } else {
            $attributes['class'] = implode(' ', $classList);
        }

        $element->setAttributes($attributes);

        return $element;
    }
} 
