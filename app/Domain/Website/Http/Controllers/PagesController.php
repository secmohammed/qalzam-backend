<?php


namespace App\Domain\Website\Http\Controllers;

use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;
use Joovlly\DDD\Traits\Responder;

class PagesController extends Controller
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

    public function __construct()
    {

    }

    public function home()
    {
        $this->setData('alias', $this->domainAlias, 'web');
        $this->addView("{$this->domainAlias}::{$this->viewPath}.home");
        return $this->response();
    }
}
