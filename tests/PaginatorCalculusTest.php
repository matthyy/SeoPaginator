<?php

use Paginator\SeoPaginator\PaginatorCalculus;

class PaginationCalculusTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return array
     */
    public function dataProviderGetHundredBeforeCurrent() : array
    {
        return [
            [
                [
                    'current' => 100,
                    'last' => 499
                ],
                [
                    100
                ]
            ],
            [
                [
                    'current' => 150,
                    'last' => 499
                ],
                [
                    100
                ]
            ],
            [
                [
                    'current' => 250,
                    'last' => 499
                ],
                [
                    100,
                    200
                ]
            ],
            [
                [
                    'current' => 150,
                    'last' => 300
                ],
                [
                    100
                ]
            ],
            [
                [
                    'current' => 231,
                    'last' => 480
                ],
                [
                    100,
                    200
                ]
            ]
        ];
    }
    /**
     * @dataProvider dataProviderGetHundredBeforeCurrent
     */
    public function testGetHundredBeforeCurrent(array $data, array $expected)
    {
        $calculus = new PaginatorCalculus($data);

        $result = $calculus->getHundredBeforeCurrent();
        $this->assertEquals($expected, $result);
    }

    /**
     * @return array
     */
    public function dataProviderGetTenBeforeCurrent() : array
    {
        return [
            [
                [
                    'current' => 0,
                    'last' => 1
                ],
                [
                ]
            ],
            [
                [
                    'current' => 9,
                    'last' => 11
                ],
                [
                ]
            ],
            [
                [
                    'current' => 30,
                    'last' => 60
                ],
                [
                    10,
                    20
                ]
            ],
            [
                [
                    'current' => 51,
                    'last' => 250
                ],
                [
                ]
            ],
            [
                [
                    'current' => 110,
                    'last' => 150
                ],
                [
                    90,
                    100,
                ]
            ],
            [
                [
                    'current' => 491,
                    'last' => 499
                ],
                [
                    430,
                    440,
                    450,
                    460,
                    470,
                    480,
                ]
            ],
        ];
    }

    /**
     * @dataProvider dataProviderGetTenBeforeCurrent
     */
    public function testGetTenBeforeCurrent(array $data, array $expected)
    {
        $calculus = new PaginatorCalculus($data);

        $result = $calculus->getTenBeforeCurrent();
        $this->assertEquals($expected, $result);
    }

    public function dataProviderTestGetCurrentPagination()
    {
        return [
            [
                [
                    'current' => 0,
                    'last' => 2
                ],
                [
                    0,
                    1,
                    2
                ]
            ],
            [
                [
                    'current' => 10,
                    'last' => 35
                ],
                [
                    10,
                    11,
                    12,
                    13,
                    14,
                    15,
                    16,
                    17,
                    18,
                    19,
                ]
            ],
            [
                [
                    'current' => 10,
                    'last' => 18
                ],
                [
                    10,
                    11,
                    12,
                    13,
                    14,
                    15,
                    16,
                    17,
                    18,
                ]
            ]
        ];
    }

    /**
     * @dataProvider dataProviderTestGetCurrentPagination
     */
    public function testGetCurrentPagination(array $data, array $expected)
    {
        $calculus = new PaginatorCalculus($data);

        $result = $calculus->getCurrentPagination();
        $this->assertEquals($expected, $result);
    }

    /**
     * @return array
     */
    public function dataProviderTestGetTenAfterCurrent() : array
    {
        return [
            [
                [
                    'current' => 0,
                    'last' => 2
                ],
                [
                ]
            ],
            [
                [
                    'current' => 10,
                    'last' => 35
                ],
                [
                    20,
                    30,
                ]
            ],
            [
                [
                    'current' => 5,
                    'last' => 90
                ],
                [
                    10,
                    20,
                    30,
                    40,
                    50,
                    60,
                ]
            ],
        ];
    }

    /**
     * @dataProvider dataProviderTestGetTenAfterCurrent
     */
    public function testGetTenAfterCurrent(array $data, array $expected)
    {
        $calculus = new PaginatorCalculus($data);

        $result = $calculus->getTenAfterCurrent();
        $this->assertEquals($expected, $result);
    }

    /**
     * @return array
     */
    public function dataProviderGetHundredAfterCurrent() : array
    {
        return [
            [
                [
                    'current' => 0,
                    'last' => 2
                ],
                [
                ]
            ],
            [
                [
                    'current' => 10,
                    'last' => 35
                ],
                [
                ]
            ],
            [
                [
                    'current' => 5,
                    'last' => 105
                ],
                [
                    100,
                ]
            ],
            [
                [
                    'current' => 5,
                    'last' => 600
                ],
                [
                    100,
                    200,
                    300,
                    400,
                ]
            ],

            [
                [
                    'current' => 105,
                    'last' => 600
                ],
                [
                    200,
                    300,
                    400,
                ]
            ],
        ];
    }

    /**
     * @dataProvider dataProviderGetHundredAfterCurrent
     */
    public function testGetHundredAfterCurrent(array $data, array $expected)
    {
        $calculus = new PaginatorCalculus($data);

        $result = $calculus->getHundredAfterCurrent();
        $this->assertEquals($expected, $result);
    }

    /**
     * @return array
     */
    public function dataProviderGetLastLinks() : array
    {
        return [
            [
                [
                    'current' => 0,
                    'last' => 9
                ],
                [
                ]
            ],

            [
                [
                    'current' => 0,
                    'last' => 14
                ],
                [
                    1,
                    14
                ]
            ],
        ];
    }

    /**
     * @dataProvider dataProviderGetLastLinks
     */
    public function testGetLastLinks(array $data, array $expected)
    {
        $calculus = new PaginatorCalculus($data);

        $result = $calculus->getLastLinks();
        $this->assertEquals($expected, $result);
    }

    /**
     * @return array
     */
    public function dataProviderGetFirstLinks() : array
    {
        return [
            [
                [
                    'current' => 0,
                    'last' => 9
                ],
               0
            ],
            [
                [
                    'current' => 1,
                    'last' => 9
                ],
               null
            ],
            [
                [
                    'current' => 3,
                    'last' => 14
                ],
                2
            ],
        ];
    }

    /**
     * @dataProvider dataProviderGetFirstLinks
     */
    public function testGetFirstLinks(array $data, $expected)
    {
        $calculus = new PaginatorCalculus($data);

        $result = $calculus->getFirstLinks();
        $this->assertEquals($expected, $result);
    }
}
