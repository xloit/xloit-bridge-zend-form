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

/**
 * A {@link FormDataMultiPart} class.
 *
 * @package Xloit\Bridge\Zend\Form
 */
class FormDataMultiPart extends Form
{
    /**
     * Constructor to prevent {@link FormDataMultiPart} from being loaded more than once.
     *
     * @param string|null $name
     * @param array       $options
     *
     * @throws \Zend\Form\Exception\InvalidArgumentException
     */
    public function __construct($name = null, $options = [])
    {
        $this->setAttribute('enctype', 'multipart/form-data');

        parent:: __construct($name, $options);
    }

    /**
     * Set a single element attribute.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     */
    public function setAttribute($key, $value)
    {
        // Force to multipart
        if ($key === 'enctype') {
            $value = 'multipart/form-data';
        }

        parent::setAttribute($key, $value);

        return $this;
    }

    /**
     * Determine is form multipart.
     *
     * @return bool
     */
    public function isMultipart()
    {
        return true;
    }
}
