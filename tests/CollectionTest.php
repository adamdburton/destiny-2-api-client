<?php

use AdamDBurton\Destiny2ApiClient\Collection;
use PHPUnit\Framework\TestCase;

final class CollectionTest extends TestCase
{
    public function testSimpleGet()
	{
		$collection = new Collection([
		    'one' => [
		        'two' => [
		            'three' => 123
                ]
            ]
        ]);

		$this->assertSame(['two' => ['three' => 123]], $collection->get('one'));
		$this->assertSame(['three' => 123], $collection->get('one.two'));
		$this->assertSame(123, $collection->get('one.two.three'));
	}

    public function testWildcardGet()
    {
        $collection = new Collection([
            'name' => 'Test',
            'email' => 'test@test.com'
        ]);

        $this->assertSame(['name' => 'Test', 'email' => 'test@test.com'], $collection->get('*'));
    }

	public function testTopLevelWildcardGet()
    {
        $collection = new Collection([
            [
                'name' => 'Test 1',
                'otherKey' => 1
            ],
            [
                'name' => 'Test 2',
                'otherKey' => 2
            ],
            [
                'name' => 'Test 3',
                'otherKey' => 3
            ]
        ]);

        $this->assertSame(['Test 1', 'Test 2', 'Test 3'], $collection->get('*.name'));
    }

    public function testDeepTopLevelWildcardGet()
    {
        $collection = new Collection([
            [
                'name' => 'Test 1',
                'otherKey' => [
                    'name' => 'Testing 1'
                ]
            ],
            [
                'name' => 'Test 2',
                'otherKey' => [
                    'name' => 'Testing 2'
                ]
            ],
            [
                'name' => 'Test 3',
                'otherKey' => [
                    'name' => 'Testing 3'
                ]
            ]
        ]);

        $this->assertSame(['Testing 1', 'Testing 2', 'Testing 3'], $collection->get('*.otherKey.name'));
    }

    public function testNestedWildcardGet()
    {
        $collection = new Collection([
            'one' => [
                [
                    'name' => 'Test 1'
                ],
                [
                    'name' => 'Test 2'
                ],
                [
                    'name' => 'Test 3'
                ]
            ]
        ]);

        $this->assertSame(['Test 1', 'Test 2', 'Test 3'], $collection->get('one.*.name'));
    }

    public function testDeepNestedWildcardGet()
    {
        $collection = new Collection([
            'one' => [
                [
                    'name' => 'Test 1',
                    'otherKey' => [
                        [
                            'name' => 'Testing 1'
                        ]
                    ]
                ],
                [
                    'name' => 'Test 2',
                    'otherKey' => [
                        [
                            'name' => 'Testing 2'
                        ]
                    ]
                ],
                [
                    'name' => 'Test 3',
                    'otherKey' => [
                        [
                            'name' => 'Testing 3'
                        ]
                    ]
                ]
            ]
        ]);

        $this->assertSame([['Testing 1'], ['Testing 2'], ['Testing 3']], $collection->get('one.*.otherKey.*.name'));
    }

    public function testDoubleWildcardGet()
    {
        $collection = new Collection([
            'one' => [
                [
                    'name' => 'Test 1',
                    'otherKey' => 'Test 1 2'
                ],
                [
                    'name' => 'Test 2',
                    'otherKey' => 'Test 2 2'
                ]
            ],
            'two' => [
                [
                    'name' => 'Test 4'
                ],
            ]
        ]);

//        print_r($collection->get('one.*.*'));die();

        $this->assertSame([['name' => 'Test 1', 'otherKey' => 'Test 1 2'], ['name' => 'Test 2', 'otherKey' => 'Test 2 2']], $collection->get('one.*.*'));
    }

    public function testFlatten()
    {
        $collection = new Collection([1, [2, 3], [4, [5, 6]]]);

        $this->assertSame([1, 2, 3, 4, 5, 6], $collection->flatten()->all());
    }
}
