<?php

namespace Paginator\SeoPaginator;

/**
 * This class aims at calculating the pagination links given the current and the last page.
 * To get those pages, the following concepts are defined:
 *  - last: last page
 *  - current : current page
 *  - ceilCurrent : the current page is rounded up i.e
 *      0 => 10,
 *      1 => 11,
 *      16 => 20
 *  - floorCurrent : the current page is rounded down i.e
 *      0 => 0,
 *      1 => 10
 *  - ByHundred : when a variable has a suffix by Hundred, the variable is rounded to the nearest hundred
 *  - STEP_BY_TEN : for seo concerns, it is advised that pages go by 10-fold-steps after a certain threshold
 *  - STEP_BY_HUNDRED : for seo concerns, it is advised that pages go by 100-fold-steps after a certain threshold
 *  - RANGE_BY_TEN : for seo concerns, it is advised that the last ten should be equal to floorCurrent + 60 in maximum
 */

class PaginatorCalculus
{
    const STEP_BY_TEN = 10;

    const STEP_BY_HUNDRED = 100;
    
    const RANGE_BY_TEN = 60;
    
    /**
     * @var int
     */
    private $last;
    
    /**
     * @var int
     */
    private $current;
    
    /**
     * @var int
     */
    private $ceilCurrent;

    /**
     * @var int
     */
    private $ceiLCurrentByHundred;

    /**
     * @var int
     */
    private $ceilLast;

    /**
     * @var int
     */
    private $ceilLastByHundred;

    /**
     * @var int
     */
    private $floorCurrent;

    /**
     * @var int
     */
    private $floorCurrentByHundred;

    /**
     * @var int
     */
    private $floorLast;

    /**
     * @var int
     */
    private $floorLastByHundred;
    
    public function __construct(array $data)
    {
        $this->current = $data['current'] ?? 0;
        $this->last = min($data['last'], 499) ?? 0;
        $this->setCeilCurrent();
        $this->setCeiLCurrentByHundred();
        $this->setCeilLast();
        $this->setCeilLastByHundred();
        $this->setFloorCurrent();
        $this->setfloorCurrentByHundred();
        $this->setFloorLast();
        $this->setFloorLastByHundred();
    }

    /**
     * @return array
     */
    public function getHundredBeforeCurrent() : array
    {
        $firstByHundredPaginationBeforeCurrent = max(
            self::STEP_BY_HUNDRED,
            $this->ceiLCurrentByHundred - $this->ceilLastByHundred + self::STEP_BY_HUNDRED
        );
        $lastByHundredPaginationBeforeCurrent = $this->floorCurrentByHundred + self::STEP_BY_HUNDRED;
        return $this->generateRange(
            $firstByHundredPaginationBeforeCurrent,
            $lastByHundredPaginationBeforeCurrent,
            self::STEP_BY_HUNDRED
        );
    }
    
    /**
     * @return array
     */
    public function getTenBeforeCurrent() : array
    {
        $firstByTenPaginationBeforeCurrent = max(
            $this->floorCurrent + min(- $this->ceilCurrent + $this->ceilLast - self::RANGE_BY_TEN, 0),
            self::STEP_BY_TEN
        );
        $lastByTenPaginationBeforeCurrent = $this->floorCurrent;
        return $this->generateRange(
            $firstByTenPaginationBeforeCurrent,
            $lastByTenPaginationBeforeCurrent,
            self::STEP_BY_TEN
        );
    }

    /**
     * @return array
     */
    public function getCurrentPagination() : array
    {
        $firstCurrentPagination = $this->floorCurrent;
        $lastCurrentPagination = min($this->ceilCurrent, $this->last + 1);
        return $this->generateRange($firstCurrentPagination, $lastCurrentPagination, 1);
    }

    /**
     * @return array
     */
    public function getTenAfterCurrent() : array
    {
        $firstByTenPaginationAfterCurrent = $this->ceilCurrent;
        $lastByTenPaginationAfterCurrent = min(
            $this->ceilCurrent + self::RANGE_BY_TEN,
            $this->floorLast + self::STEP_BY_TEN
        );
        return $this->generateRange(
            $firstByTenPaginationAfterCurrent,
            $lastByTenPaginationAfterCurrent,
            self::STEP_BY_TEN
        );
    }

    /**
     * @return array
     */
    public function getHundredAfterCurrent() : array
    {
        $firstByHundredPaginationAfterCurrent = $this->ceiLCurrentByHundred;
        $lastByHundredPaginationAfterCurrent = min(
            $this->ceiLCurrentByHundred + 500,
            $this->floorLastByHundred + self::STEP_BY_HUNDRED
        );
        return $this->generateRange(
            $firstByHundredPaginationAfterCurrent,
            $lastByHundredPaginationAfterCurrent,
            self::STEP_BY_HUNDRED
        );
    }

    /**
     * @param int $first
     * @param int $last
     * @param int $step
     *
     * @return array
     */
    private function generateRange(int $first, int $last, int $step) : array
    {
        if ($first < $last) {
            return range($first, $last - $step, $step);
        }
        return [];
    }

    /**
     * @return array
     */
    public function getLastLinks() : array
    {
        if ($this->last < 10) {
            return [];
        }

        return [
            min($this->current + 1, $this->last),
            $this->last
        ];
    }

    /**
     * @return int|null
     */
    public function getFirstLinks()
    {
        if ($this->current == 0) {
            return $this->current;
        }
        
        return $this->current -1 !== 0 ? $this->current -1 : null;
    }

    /**
     * @return PaginatorCalculus
     */
    public function setCeilCurrent()
    {
        $this->ceilCurrent = floor($this->current/self::STEP_BY_TEN + 1) * self::STEP_BY_TEN;

        return $this;
    }

    /**
     * @return PaginatorCalculus
     */
    public function setCeiLCurrentByHundred()
    {
        $this->ceiLCurrentByHundred = floor($this->current/self::STEP_BY_HUNDRED + 1) * self::STEP_BY_HUNDRED;

        return $this;
    }

    /**
     * @return PaginatorCalculus
     */
    public function setCeilLast()
    {
        $this->ceilLast = floor($this->last / self::STEP_BY_TEN + 1) * self::STEP_BY_TEN;

        return $this;
    }

    /**
     * @return PaginatorCalculus
     */
    public function setCeilLastByHundred()
    {
        $this->ceilLastByHundred = ceil($this->last / self::STEP_BY_HUNDRED) * self::STEP_BY_HUNDRED;

        return $this;
    }

    /**
     * @return PaginatorCalculus
     */
    public function setFloorCurrent()
    {
        $this->floorCurrent = floor($this->current/self::STEP_BY_TEN) * self::STEP_BY_TEN;

        return $this;
    }

    /**
     * @return PaginatorCalculus
     */
    public function setFloorCurrentByHundred()
    {
        $this->floorCurrentByHundred = floor($this->current / self::STEP_BY_HUNDRED) * self::STEP_BY_HUNDRED;

        return $this;
    }

    /**
     * @return PaginatorCalculus
     */
    public function setFloorLast()
    {
        $this->floorLast = floor($this->last / self::STEP_BY_TEN) * self::STEP_BY_TEN;

        return $this;
    }

    /**
     * @return PaginatorCalculus
     */
    public function setFloorLastByHundred()
    {
        $this->floorLastByHundred = floor($this->last / self::STEP_BY_HUNDRED) * self::STEP_BY_HUNDRED;

        return $this;
    }
}