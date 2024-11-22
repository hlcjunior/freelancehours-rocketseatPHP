<?php

namespace App\Livewire\Proposals;

use App\Models\Project;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Create extends Component
{

    public Project $project;
    public bool $modal = false;

    #[Rule(['required', 'email'], as: 'e-mail')]
    public string $email = '';

    #[Rule(['required', 'numeric', 'min:1'],as: 'horas')]
    public int $hours = 0;

    public bool $agree = false;

    public function save(): void
    {

        $this->validate();

        if(!$this->agree){
            $this->addError('agree', 'Você precisa concordar com os termos de uso');
            return;
        }

        $this->project->proposals()->updateOrCreate([
            'email' => $this->email],
            ['hours' => $this->hours]
        );

        $this->dispatch('proposal::created');

        $this->modal = false;
    }

    public function render(): View|Factory|Application
    {
        return view('livewire.proposals.create');
    }
}
