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

namespace Xloit\Bridge\Zend\Form\Element;

use InvalidArgumentException;
use Traversable;
use Zend\Form\Element\Textarea;
use Zend\Stdlib\ArrayUtils;

/**
 * A {@link CkEditor} class.
 *
 * @package Xloit\Bridge\Zend\Form\Element
 */
class CkEditor extends Textarea
{
    /**
     *
     *
     * @var string
     */
    const OPTION_CONFIG = 'ckeditor_config';

    /**
     * Seed attributes.
     *
     * @var array
     */
    protected $attributes = [
        'type' => 'ckeditor'
    ];

    /**
     * CKEditor config.
     *
     * @var array
     */
    protected $editorConfig = [];

    /**
     * Accepted options for CKEditor:
     * - config: an array used in the CKEditor.config
     *
     * @param array|Traversable $options
     *
     * @throws InvalidArgumentException
     * @throws \Zend\Stdlib\Exception\InvalidArgumentException
     * @throws \Zend\Form\Exception\InvalidArgumentException
     * @return static
     */
    public function setOptions($options)
    {
        /** @noinspection UnSafeIsSetOverArrayInspection */
        if (isset($options[static::OPTION_CONFIG])) {
            $this->setEditorConfig($options[static::OPTION_CONFIG]);

            unset($options[static::OPTION_CONFIG]);
        }

        parent::setOptions($options);

        return $this;
    }

    /**
     * Set config for Namespace CKEDITOR.config.
     *
     * @param array|Traversable $config
     *
     * @throws InvalidArgumentException
     * @throws \Zend\Stdlib\Exception\InvalidArgumentException
     * @return static
     */
    public function setEditorConfig($config)
    {
        if ($config instanceof Traversable) {
            $config = ArrayUtils::iteratorToArray($config);
        }

        if (!is_array($config)) {
            throw new InvalidArgumentException(
                'The options parameter must be an array or a Traversable'
            );
        }

        $this->editorConfig = $config;

        return $this;
    }

    /**
     * Returns config for Namespace CKEDITOR.config.
     *
     * @return array
     */
    public function getEditorConfig()
    {
        return $this->editorConfig;
    }
}
