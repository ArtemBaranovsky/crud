<?php

namespace App\Http\Livewire;

use Illuminate\Support\Collection;
use Livewire\Component;

abstract class DataTable extends Component
{
    protected $headers = [];
    protected $data = [];
    protected $sortField;
    protected $listeners = ['sortBy' => 'sort'];

    protected     $modelClass;
    public string $sortDirection = 'asc';


    public function mount(array $headers)
    {
        $this->headers = $headers;
        $this->data = $this->getData();
    }


    public function render()
    {
        return view('livewire.data-table', [
            'headers' => $this->headers,
            'tableData' => $this->buildTable($this->headers, $this->data),
        ]);
    }

    public function sort($field)
    {
        $this->sortField = $field;
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    protected function getData(): Collection
    {
        $modelClass = $this->modelClass;
        $model = new $modelClass;
        return $model->all();
    }


    abstract protected function buildTable($headers, $data): array;
}
