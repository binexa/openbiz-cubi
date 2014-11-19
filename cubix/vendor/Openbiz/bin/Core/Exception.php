<?php
/**
 * Openbiz Framework
 *
 * LICENSE
 *
 * This source file is subject to the BSD license that is bundled
 * with this package in the file LICENSE.txt.
 *
 * @package   Openbiz\Core
 * @copyright Copyright (c) 2005-2014, Openbiz technology LLC
 * @license   http://www.opensource.org/licenses/bsd-license.php
 * @link      http://www.phpopenbiz.org/
 * @version   $Id$
 */

namespace Openbiz\Core;

/**
 * Exception represents a generic exception for all purposes.
 *
 * @author Agus Suhartono <agus.suhartono@gmail.com>
 * @since 1.0
 */
class Exception extends \Exception implements Arrayable
{

	/**
     * Get name of this exception.
     * NOTE: this method adapted from yii\base\Exception
     * 
	 * @return string the user-friendly name of this exception
     *
	 */
	public function getName()
	{
		return 'Exception';
	}
	/**
	 * Returns the array representation of this object.
	 * @return array the array representation of this object.
	 */
	public function toArray()
	{
		return $this->toArrayRecursive($this);
	}

	/**
	 * Returns the array representation of the exception and all previous exceptions recursively.
	 * @param \Exception exception object
	 * @return array the array representation of the exception.
	 */
	protected function toArrayRecursive($exception)
	{
		$array = [
			'type' => get_class($exception),
			'name' => ($exception instanceof self) ? $exception->getName() : 'Exception',
			'message' => $exception->getMessage(),
			'code' => $exception->getCode(),
		];
		if (($prev = $exception->getPrevious()) !== null) {
			$array['previous'] = $this->toArrayRecursive($prev);
		}
		return $array;
	}
}
