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

use Zend\Form\FieldsetInterface;
use Zend\Form\FormInterface;
use Zend\Form\View\Helper\Form as ZendForm;

/**
 * A {@link Form} class.
 *
 * @package Xloit\Bridge\Zend\Form\View\Helper
 */
class Form extends ZendForm
{
    /**
     * Render a form from the provided form.
     *
     * @param FormInterface $form
     *
     * @return string
     */
    public function render(FormInterface $form)
    {
        if (method_exists($form, 'prepare')) {
            $form->prepare();
        }

        // Set form role
        if (!$form->getAttribute('role')) {
            $form->setAttribute('role', 'form');
        }

        $formContent = '';

        foreach ($form as $element) {
            /** @var $element \Zend\Form\Form */
            if ($element instanceof FieldsetInterface) {
                /** @noinspection PhpUndefinedMethodInspection */
                $formContent .= $this->getView()->formCollection($element);
            } else {
                $element->setOption('_form', $form);

                /** @noinspection PhpUndefinedMethodInspection */
                $formContent .= $this->getView()->formRow($element);
            }
        }

        return $this->openTag($form) . $formContent . $this->closeTag();
    }
} 
