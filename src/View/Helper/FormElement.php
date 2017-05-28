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

use Xloit\Bridge\Zend\Form\Element\CkEditor;
use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\FormElement as ZendFormElement;

/**
 * A {@link FormElement} class.
 *
 * @package Xloit\Bridge\Zend\Form\View\Helper
 */
class FormElement extends ZendFormElement
{
    use HelperTrait;

    /**
     *
     *
     * @var array
     */
    protected $skippedElement = [
        'button',
        'submit'
    ];

    /**
     * Invoke helper as function. Proxies to {@link render()}.
     *
     * @param ElementInterface $element
     *
     * @return string|$this
     */
    public function __invoke(ElementInterface $element = null)
    {
        if (!$element) {
            return $this;
        }

        if (!in_array($element->getAttribute('type'), $this->skippedElement, true)) {
            $element = $this->addElementClass($element, ['form-control']);
        }

        return $this->render($element);
    }

    /**
     * Render an element.
     * Introspects the element type and attributes to determine which helper to utilize when rendering.
     *
     * @param ElementInterface $element
     *
     * @return string
     */
    public function render(ElementInterface $element)
    {
        $renderer = $this->getView();

        if ($element instanceof CkEditor) {
            /** @noinspection PhpUndefinedMethodInspection */
            $plugin = $renderer->plugin('form_ckeditor');

            return $plugin($element);
        }

        return parent::render($element);
    }
} 
