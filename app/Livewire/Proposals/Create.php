<?php

namespace App\Livewire\Proposals;

use App\Actions\ArrangePositions;
use App\Models\Project;
use App\Models\Proposal;
use App\Notifications\NewProposal;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Create extends Component
{

    public Project $project;
    public bool $modal = false;

    #[Rule(['required', 'email'], as: 'e-mail')]
    public string $email = '';

    #[Rule(['required', 'numeric', 'min:1'], as: 'horas')]
    public int $hours = 0;

    public bool $agree = false;

    public function save(): void
    {
        $this->validate();

        if (!$this->agree) {
            $this->addError('agree', 'Você precisa concordar com os termos de uso');
            return;
        }

        DB::transaction(function () {
            $proposal = $this->project->proposals()
                ->updateOrCreate(
                    ['email' => $this->email],
                    ['hours' => $this->hours]
                );

            $this->arrangePositions($proposal);
        });

        $this->project->author->notify(new NewProposal($this->project));

        $this->dispatch('proposal::created');

        $this->modal = false;
    }

    public function render(): View|Factory|Application
    {
        return view('livewire.proposals.create');
    }

    private function arrangePositions(Proposal $proposal): void
    {
        $query = DB::select('
            select *, row_number() over (order by hours) as newPosition
            from proposals
            where project_id = :project
        ',
            ['project' => $proposal->project_id]);

        $position = collect($query)->where('id', '=', $proposal->id)->first();

        $belowProposals = collect($query)
            ->where('position', '>=', $position->newPosition)
            ->where('id', '!=', $proposal->id);

        $aboveProposals = collect($query)
            ->where('position', '<', $position->newPosition);


        if ($belowProposals) {
            $proposal->update(['position_status' => 'up']);

            foreach ($belowProposals as $otherProposal) {
                Proposal::query()->where('id', '=', $otherProposal->id)->update(['position_status' => 'down']);
            }
        }

        if($aboveProposals){
            foreach ($aboveProposals as $otherProposal) {
                Proposal::query()->where('id', '=', $otherProposal->id)->update(['position_status' => 'null']);
            }
        }

        ArrangePositions::run($proposal->project_id);
    }
}
