<?php
/**
 * (c) phpio
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phpio\Spl;

/**
 */
trait WithPropertiesReadOnlyTrait
{
    use WithPropertiesTrait;

   /**
    * @inheritdoc
    *
    * @throws \LogicException
    */
   public function __set($name, $value)
   {
       throw new \LogicException(get_class($this));
   }

   /**
    * @inheritdoc
    *
    * @throws \LogicException
    */
   public function __unset($name)
   {
       throw new \LogicException(get_class($this));
   }
}