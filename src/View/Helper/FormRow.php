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
use Zend\Form\View\Helper\FormRow as ZendFormRow;

/**
 * A {@link FormRow} class.
 *
 * @package Xloit\Bridge\Zend\Form\View\Helper
 */
class FormRow extends ZendFormRow
{
    /**
     *
     *
     * @var string
     */
    protected $horizontalWrap = '<div class="form-group %s">%s<div class="%s">%s%s</div></div>';

    /**
     *
     *
     * @var string
     */
    protected $inputWrapClass = 'col-sm-9 col-md-6';

    /**
     *
     *
     * @var string
     */
    protected $inputWrapNoLabelClass = 'col-sm-12';

    /**
     *
     *
     * @var array
     */
    protected $hiddenClass = 'hidden';

    /**
     *
     *
     * @var array
     */
    protected $errorClass = 'has-error';

    /**
     *
     *
     * @param ElementInterface $element
     * @param null|string      $labelPosition
     *
     * @return string
     */
    public function render(ElementInterface $element, $labelPosition = null)
    {
        $wrapClass = '';

        if ($element->getAttribute('type') === $this->hiddenClass) {
            $wrapClass .= $this->hiddenClass;
        }

        $helperElementError = $this->getElementErrorsHelper();
        $helperLabel        = $this->getLabelHelper();
        $helperElement      = $this->getElementHelper();

        $errorHtml = $helperElementError($element);
        $label     = $element->getLabel();

        /** @noinspection IsEmptyFunctionUsageInspection */
        if (!empty($errorHtml)) {
            $wrapClass .= ' ' . $this->errorClass;
        }

        if ($label) {
            $label          = $helperLabel($element);
            $inputWrapClass = $this->inputWrapClass;
        } else {
            $label          = '';
            $inputWrapClass = $this->inputWrapNoLabelClass;
        }

        return sprintf(
            $this->horizontalWrap,
            $wrapClass,
            $label,
            $inputWrapClass,
            $helperElement($element),
            $errorHtml
        );
    }
} 
