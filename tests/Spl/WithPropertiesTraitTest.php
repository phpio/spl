<?php
/**
 * (c) phpio
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phpio\Spl;

/**
 * @covers WithPropertiesTrait
 */
class WithPropertiesTraitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    protected static $defaults = [
        'propMixed'  => null,
        'propInt'    => 0,
        'propString' => '',
        'propArray'  => [],
    ];

    /**
     * @return array
     */
    public function providerConstruct()
    {
        return [
            'default'                        => [
                'expected'   => static::$defaults,
                'properties' => null
            ],
            'default with empty array'       => [
                'expected'   => static::$defaults,
                'properties' => []
            ],
            'with defined properties'        => [
                'expected'   => array_merge(static::$defaults, ['propMixed' => 'propMixed']),
                'properties' => ['propMixed' => 'propMixed']
            ],
            \UnexpectedValueException::class => [
                'expected'   => new \UnexpectedValueException('0, bar, baz, 1'),
                'properties' => ['foo', 'bar' => null, 'baz' => null, 'qux']
            ],
        ];
    }

    /**
     * @param array|null $properties
     *
     * @return Fixtures\WithProperties
     */
    protected function createClass(array $properties = null)
    {
        return new Fixtures\WithProperties($properties);
    }

    /**
     * @covers       WithPropertiesTrait::__construct
     * @dataProvider providerConstruct
     *
     * @param array|\Exception $expected
     * @param array|null       $properties
     */
    public function testConstruct($expected, array $properties = null)
    {
        if ($expected instanceof \Exception) {
            $this->expectException(get_class($expected));
            $this->expectExceptionMessage($expected->getMessage());
        }

        $current = $this->createClass($properties);

        $this->assertSame($expected['propMixed'], $current->propMixed);
        $this->assertSame($expected['propInt'], $current->propInt);
        $this->assertSame($expected['propString'], $current->propString);
        $this->assertSame($expected['propArray'], $current->propArray);
    }

    /**
     * @covers WithPropertiesTrait::__get
     * @covers WithPropertiesTrait::__set
     * @covers WithPropertiesTrait::__isset
     * @covers WithPropertiesTrait::__unset
     */
    public function testMagicMethods()
    {
        $current = $this->createClass();
        $this->assertFalse(isset($current->propMixed));
        $this->assertFalse(isset($current->propInt));
        $this->assertFalse(isset($current->propString));
        $this->assertFalse(isset($current->propArray));

        $this->assertSame(null, $current->propMixed);
        $this->assertSame(0, $current->propInt);
        $this->assertSame('', $current->propString);
        $this->assertSame([], $current->propArray);

        unset($current->propMixed);
        unset($current->propInt);
        unset($current->propString);
        unset($current->propArray);

        $this->assertSame(null, $current->propMixed);
        $this->assertSame(null, $current->propInt);
        $this->assertSame(null, $current->propString);
        $this->assertSame(null, $current->propArray);

        $object = new \ArrayObject();

        $current->propMixed  = $object;
        $current->propInt    = 1;
        $current->propString = ' ';
        $current->propArray  = [''];

        $this->assertTrue(isset($current->propMixed));
        $this->assertTrue(isset($current->propInt));
        $this->assertTrue(isset($current->propString));
        $this->assertTrue(isset($current->propArray));

        $this->assertSame($object, $current->propMixed);
        $this->assertSame(1, $current->propInt);
        $this->assertSame(' ', $current->propString);
        $this->assertSame([''], $current->propArray);

        $this->assertFalse(isset($current->unknown));
        unset($current->unknown);

        try {
            $current->unknown;
            $this->fail('expects exception');
        } catch (\InvalidArgumentException $e) {
            $this->assertEquals('unknown', $e->getMessage());
        }

        try {
            $current->unknown = null;
            $this->fail('expects exception');
        } catch (\InvalidArgumentException $e) {
            $this->assertEquals('unknown', $e->getMessage());
        }
    }
}