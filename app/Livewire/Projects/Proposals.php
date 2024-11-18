<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Proposals extends Component
{
    public Project $project;

    public int $qty = 10;

    #[Computed]
    public function proposals(): LengthAwarePaginator
    {
        return $this->project->proposals()
            ->orderByDesc('hours')
            ->paginate($this->qty);
    }

    /**
     * @Livewire
     * @return void
     */
    public function loadMore(): void
    {
        $this->qty += 10;
    }

    public function render(): View|Factory|Application
    {
        return view('livewire.projects.proposals');
    }
}
