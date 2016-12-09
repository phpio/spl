<?php
/**
 * (c) phpio
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phpio\Spl;

/**
 * @covers WithPropertiesReadOnlyTrait
 */
class WithPropertiesReadOnlyTraitTest extends WithPropertiesTraitTest
{
    /**
     * @inheritdoc
     *
     * @return Fixtures\WithPropertiesReadOnly
     */
    protected function createClass(array $properties = null)
    {
        return new Fixtures\WithPropertiesReadOnly($properties);
    }

    /**
     * @covers WithPropertiesReadOnlyTrait::__set
     * @covers WithPropertiesReadOnlyTrait::__unset
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

        try {
            unset($current->propMixed);
            $this->fail('expects exception');
        } catch (\LogicException $e) {
            $this->assertEquals(Fixtures\WithPropertiesReadOnly::class, $e->getMessage());
        }

        try {
            unset($current->unknown);
            $this->fail('expects exception');
        } catch (\LogicException $e) {
            $this->assertEquals(Fixtures\WithPropertiesReadOnly::class, $e->getMessage());
        }

        try {
            $current->propMixed = 'anything';
            $this->fail('expects exception');
        } catch (\LogicException $e) {
            $this->assertEquals(Fixtures\WithPropertiesReadOnly::class, $e->getMessage());
        }

        try {
            $current->unknown = 'anything';
            $this->fail('expects exception');
        } catch (\LogicException $e) {
            $this->assertEquals(Fixtures\WithPropertiesReadOnly::class, $e->getMessage());
        }
   }
}