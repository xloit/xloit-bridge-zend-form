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
use Zend\Form\View\Helper\FormTextarea;
use Zend\Json\Json;

/**
 * A {@link FormCkEditor} class.
 *
 * @package Xloit\Bridge\Zend\Form\View\Helper
 */
class FormCkEditor extends FormTextarea
{
    use HelperTrait;

    /**
     *
     *
     * @var string
     */
    protected $wrapper = '<div id="content-editor-container" class="editor-container">%s</div>';

    /**
     * Invoke helper. Proxies to {@link render()}.
     *
     * @param ElementInterface $element
     * @param array            $options
     *
     * @return string|$this
     * @throws \Zend\Form\Exception\DomainException
     */
    public function __invoke(ElementInterface $element = null, $options = [])
    {
        if (!$element) {
            return $this;
        }

        /** @noinspection CallableParameterUseCaseInTypeContextInspection */
        $options = Json::encode(
            array_merge(
                [
                    'filebrowserBrowseUrl'    => '/quelfinder/ckeditor',
                    'filebrowserWindowWidth'  => '1000',
                    'filebrowserWindowHeight' => '600',
                    'Width'                   => '100%',
                    'Height'                  => '340',
                    'language'                => 'ca',
                    'uiColor'                 => '#F6F6F6',
                    //Producing HTML Compliant Output
                    'coreStyles_bold'         => ['element' => 'b'],
                    'coreStyles_italic'       => ['element' => 'i'],
                    'fontSize_style'          => [
                        'element'    => 'font',
                        'attributes' => ['size' => '100px']
                    ],
                    //MagiCline plugin
                    'magicline_color'         => 'blue',
                    //Full Page Editing
                    'fullPage'                => false,
                    'allowedContent'          => false
                ],
                $options
            ), true
        );

        /** @noinspection PhpUndefinedMethodInspection */
        $this->getView()->inlineScript('CKEDITOR.replace( ' . $element->getName() . ', ' . $options . ');');

        $this->addElementClass($element, ['ckeditor']);

        return sprintf($this->wrapper, $this->render($element));
    }
}
