<?php

namespace NumaxLab\Icaa\Tests\Records;

use NumaxLab\Icaa\Exceptions\RecordsCollectionException;
use NumaxLab\Icaa\Records\Collection;
use NumaxLab\Icaa\Records\RecordInterface;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase implements RecordInterface
{
    /**
     * @var \NumaxLab\Icaa\Records\Collection
     */
    protected $sut;

    /**
     * @var string
     */
    protected $line = '';

    protected function setUp()
    {
        parent::setUp();

        $this->sut = new Collection();
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->sut = null;
    }

    public function testThrowsExceptionWhenInvalidCollectionItems()
    {
        $this->expectException(RecordsCollectionException::class);

        new Collection(['foo', 'bar']);
    }

    public function testEach()
    {
        $original = [
            new self(),
            new self()
        ];

        $collection = new Collection($original);

        $result = [];
        $collection->each(function ($item, $key) use (&$result) {
            $result[$key] = $item;
        });
        $this->assertEquals($original, $result);

        $result = [];
        $collection->each(function ($item, $key) use (&$result) {
            $item->setLine('test');
            $result[$key] = $item;

            return false;
        });

        $this->assertEquals('test', $result[0]->toLine());
        $this->assertEquals(1, count($result));
    }

    public function testForgetSingleKey()
    {
        $collection = new Collection([new self(), new self()]);
        $collection->forget(0);
        $this->assertFalse(isset($collection['foo']));

        $collection = new Collection(['foo' => new self(), 'bar' => new self()]);
        $collection->forget('foo');
        $this->assertFalse(isset($collection['foo']));
    }

    public function testForgetArrayOfKeys()
    {
        $collection = new Collection([new self(), new self(), new self()]);
        $collection->forget([0, 2]);
        $this->assertFalse(isset($collection[0]));
        $this->assertFalse(isset($collection[2]));
        $this->assertTrue(isset($collection[1]));

        $collection = new Collection(['bar' => new self(), 'foo' => new self(), 'baz' => new self()]);
        $collection->forget(['foo', 'baz']);
        $this->assertFalse(isset($collection['foo']));
        $this->assertFalse(isset($collection['baz']));
        $this->assertTrue(isset($collection['bar']));
    }

    public function testCountable()
    {
        $collection = new Collection([new self(), new self()]);
        $this->assertCount(2, $collection);
    }

    public function testIterable()
    {
        $mock = new self();

        $collection = new Collection([$mock]);

        $this->assertInstanceOf('ArrayIterator', $collection->getIterator());
        $this->assertEquals([$mock], $collection->getIterator()->getArrayCopy());
    }

    public function testEmptyCollectionIsEmpty()
    {
        $collection = new Collection();

        $this->assertTrue($collection->isEmpty());
    }

    public function testEmptyCollectionIsNotEmpty()
    {
        $collection = new Collection([new self(), new self()]);

        $this->assertFalse($collection->isEmpty());
        $this->assertTrue($collection->isNotEmpty());
    }

    public function setLine($line)
    {
        $this->line = $line;
    }

    public function toLine()
    {
        return $this->line;
    }
}
