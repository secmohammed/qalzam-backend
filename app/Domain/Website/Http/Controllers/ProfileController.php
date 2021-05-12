<?php


namespace App\Domain\Website\Http\Controllers;


use App\Domain\User\Repositories\Contracts\UserRepository;
use App\Infrastructure\Http\AbstractControllers\BaseController;
use Joovlly\DDD\Traits\Responder;

class ProfileController extends BaseController
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
    protected $viewPath = 'profile';


    public function myCart()
    {
        $this->setData('alias', $this->domainAlias, 'web');
        $this->addView("{$this->domainAlias}::{$this->viewPath}.my-cart");
        return $this->response();
    }
    public function profile(UserRepository $repository)
    {
        $authUser = $repository->with(['addresses.location.parent', 'orders.products'])->find(auth()->id());
        $this->setData('user', $authUser,'web');
        $this->setData('alias', $this->domainAlias, 'web');
        $this->addView("{$this->domainAlias}::{$this->viewPath}.index");
        return $this->response();
    }

    public function finishOrder()
    {
        $this->setData('alias', $this->domainAlias, 'web');
        $this->addView("{$this->domainAlias}::{$this->viewPath}.finish-order");
        return $this->response();
    }
}
