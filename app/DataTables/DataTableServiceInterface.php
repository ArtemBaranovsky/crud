<?php

namespace App\DataTables;

use Illuminate\Http\Request;

interface DataTableServiceInterface
{
    public function getDataTable(Request $request);
}
