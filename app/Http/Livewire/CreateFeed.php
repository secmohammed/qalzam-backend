<?php

namespace App\Http\Livewire;

use App\Domain\Child\Entities\Child;
use App\Domain\Competition\Entities\Competition;
use App\Domain\Competition\Repositories\Contracts\CompetitionRepository;
use App\Domain\Feed\Http\Requests\Feed\FeedStoreFormRequest;
use App\Domain\Installment\Entities\Installment;
use App\Domain\Receipts\Entities\Receipt;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class CreateFeed extends Component
{
    public $competition_id;
    public $child_id;
    public $status;
    public $type;

    protected $errors;
    protected $competitionRepository;
    protected $formRequest = FeedStoreFormRequest::class;

    protected $listeners = [
        'selectCompetition',
        'selectChild',
        'selectStatus',
    ];

    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->competitionRepository = app(CompetitionRepository::class);
    }

    public function render()
    {
        $competitions = Competition::all();
        $children = Child::all();
        return view('livewire.create-feed',[
            'action' => 'create',
            'errors' => $this->errors,
            'competitions' => $competitions,
            'children' => $children,
            'type' => $this->type,
        ]);
    }
    public function save()
    {
        $data = [
            'competition_id' => $this->competition_id,
            'child_id' => $this->child_id,
            'status' => $this->status,
        ];

        $this->applyValidation($data);
    }

    protected function applyValidation(&$data)
    {
        $classFormRequest = $this->formRequest;

        $formRequest = new $classFormRequest($this->competitionRepository);

        $validatedData = Validator::make($data, $formRequest->rules(), [], $formRequest->attributes());

        $data = $formRequest->setValidator($validatedData)->validated();
    }

    public function findType()
    {
        return $this->type = $this->competitionRepository->findOrFail($this->competition_id)->type;
    }

    public function selectCompetition($competition)
    {
        $this->competition_id = $competition;
        $this->findType();
    }

    public function selectChild($child)
    {
        $this->child_id = $child;
    }

    public function selectStatus($status)
    {
        $this->status = $status;
    }

}
