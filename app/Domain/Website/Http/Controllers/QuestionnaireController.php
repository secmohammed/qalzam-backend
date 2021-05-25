<?php


namespace App\Domain\Website\Http\Controllers;
use \App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use Joovlly\DDD\Traits\Responder;

class QuestionnaireController extends Controller
{
    use Responder;

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'websites';

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'pages';

    public function show()
    {
        $this->setData('alias', $this->domainAlias, 'web');
        $this->addView("{$this->domainAlias}::{$this->viewPath}.questionnaire");
        return $this->response();
    }

    public function store()
    {
        //todo implement this func
        toastr()->success('thanks, For Your questionnaire');
        return redirect()->route('website.home');
    }
}
