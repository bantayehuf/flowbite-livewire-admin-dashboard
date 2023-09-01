<?php

namespace App\Trait;

use Livewire\WithPagination;
use Livewire\Attributes\Url;

trait WithDataTable
{
    use WithPagination;

    #[Url(as: 'q')]
    public $searchQuery = '';

    #[Url(as: 'pp')]
    public $perPage = 10;


    public function paginationView()
    {
        return 'templates.pagination';
    }

    public function updatedSearchQuery()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }
}
