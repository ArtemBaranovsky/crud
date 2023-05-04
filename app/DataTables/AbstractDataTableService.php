<?php

namespace App\DataTables;

use Illuminate\Http\Request;

abstract class AbstractDataTableService
{
    protected $model;
    protected $columns;
    protected $searchableColumns;

    public function __construct($model, $columns, $searchableColumns)
    {
        $this->model = $model;
        $this->columns = $columns;
        $this->searchableColumns = $searchableColumns;
    }

    abstract public function getDataTable(Request $request);
    abstract public function countFilteredData(Request $request);
    abstract protected function getQuery(Request $request);
    abstract protected function filterData(Request $request, $query);
    abstract protected function sortData(Request $request, $query);
    abstract protected function paginateData(Request $request, $query);
    abstract protected function formatData($data);
    abstract protected function mapColumns($columns);

    protected function getSearchableColumns()
    {
        return $this->searchableColumns;
    }
}
