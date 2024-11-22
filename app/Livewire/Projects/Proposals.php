<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class Proposals extends Component
{
    public Project $project;

    public int $qty = 10;

    #[Computed]
    public function proposals(): Paginator
    {
        return $this->project->proposals()
            ->orderBy('hours')
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

    #[Computed]
    /**
     * @Livewire
     */
    public function lastProposalTime()
    {
        return $this->project->proposals()->latest()->first()->created_at->diffForHumans();
    }

    #[On('proposal::created')]
    public function render(): View|Factory|Application
    {
        return view('livewire.projects.proposals');
    }
}
