<?php

namespace Cobweb\ExternalImport\Domain\Model\Dto;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Extbase\Persistence\QueryInterface;

/**
 * Data Transfer Object model for AJAX query parameters coming from DataTables.
 *
 * @package Cobweb\ExternalImport\Domain\Model\Dto
 */
class QueryParameters
{
    /**
     * @var int Identifier of the DataTables draw request
     */
    protected $draw = 0;

    /**
     * @var string Search string
     */
    protected $search = '';

    /**
     * @var array List of columns in which the search is performed
     */
    protected $searchColumns = [];

    /**
     * @var int Maximum number of records to return
     */
    protected $limit = 0;

    /**
     * @var int Offset to apply (pagination)
     */
    protected $offset = 0;

    /**
     * @var string Name of the column to use for ordering
     */
    protected $order = '';

    /**
     * @var string Direction of ordering
     */
    protected $direction = QueryInterface::ORDER_DESCENDING;

    /**
     * Constructor.
     *
     * @param array $parameters Query parameters from the AJAX query
     */
    public function __construct($parameters = null)
    {
        if ($parameters !== null) {
            $this->setAllParameters($parameters);
        }
    }

    public function __toString()
    {
        return self::class;
    }

    /**
     * Receives the raw parameters and set the various member variables after validation and sanitation.
     *
     * @param array $parameters Query parameters from the AJAX query
     */
    public function setAllParameters($parameters)
    {
        // Set simple parameters
        $this->setDraw((int)$parameters['draw']);
        $this->setLimit((int)$parameters['length']);
        $this->setOffset((int)$parameters['start']);
        $this->setSearch((string)$parameters['search']['value']);
        // Assemble list of search columns
        $this->setSearchColumns($parameters['columns']);
        // Ordering column name must match existing column
        $column = (int)$parameters['order'][0]['column'];
        if (array_key_exists($column, $parameters['columns'])) {
            $columnName = $parameters['columns'][$column]['name'];
        } else {
            $columnName = '';
        }
        $this->setOrder($columnName);
        $direction = strtoupper($parameters['order'][0]['dir']);
        $this->setDirection($direction);
    }

    /**
     * @return int
     */
    public function getDraw()
    {
        return $this->draw;
    }

    /**
     * @param int $draw
     */
    public function setDraw(int $draw)
    {
        $this->draw = $draw;
    }

    /**
     * @return string
     */
    public function getSearch()
    {
        return $this->search;
    }

    /**
     * @param string $search
     */
    public function setSearch(string $search)
    {
        $this->search = $search;
    }

    /**
     * @return array
     */
    public function getSearchColumns()
    {
        return $this->searchColumns;
    }

    /**
     * @param array $searchColumns
     */
    public function setSearchColumns(array $searchColumns)
    {
        $this->searchColumns = [];
        foreach ($searchColumns as $columnData) {
            if ($columnData['searchable'] === 'true') {
                $this->searchColumns[] = $columnData['name'];
            }
        }
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     */
    public function setLimit(int $limit)
    {
        $this->limit = $limit;
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @param int $offset
     */
    public function setOffset(int $offset)
    {
        $this->offset = $offset;
    }

    /**
     * @return string
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param string $order
     */
    public function setOrder(string $order)
    {
        $this->order = $order;
    }

    /**
     * @return string
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * @param string $direction
     */
    public function setDirection(string $direction)
    {
        // Ordering direction is either explicitly "asc", or "desc" by default
        if ($direction !== QueryInterface::ORDER_ASCENDING) {
            $direction = QueryInterface::ORDER_DESCENDING;
        }
        $this->direction = $direction;
    }
}