<?php
/**
 * (c) phpio
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phpio\Spl\Fixtures;
use Phpio\Spl\WithPropertiesTrait;

/**
 * @property mixed  propMixed
 * @property int    propInt
 * @property string propString
 * @property array  propArray
 */
class WithProperties
{
    use WithPropertiesTrait;

    /**
     * @var array
     */
    protected $properties = [
        'propMixed'  => null,
        'propInt'    => 0,
        'propString' => '',
        'propArray'  => [],
    ];
}
