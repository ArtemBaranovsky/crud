<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;

class PostTable extends DataTable
{
    public $modelClass = Post::class;

    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->sortField = '';
    }

    public function render()
    {
        return view('livewire.post-table', [
            'headers' => $this->headers,
            'sortField' => 'id',
            'tableData' => $this->buildTable($this->headers, $this->data),
        ]);
    }

    protected function buildTable($headers, $data): array
    {
        return array_values(collect($data)->map(function ($post) {
            return [
                'id' => $post['id'],
                'title' => $post['title'],
                'created_at' => $post['created_at'],
                'user_name' => $post->user->name ?? '',
            ];
        })->prepend($headers)->toArray());
    }


    protected function getData(): Collection
    {
        $modelClass = $this->modelClass;
        return $modelClass::all();
    }
}
