<?php


namespace App\Domain\Website\Http\Controllers;

use App\Common\Criteria\StatusIsCriteria;
use App\Domain\Branch\Criteria\BranchHasGalleriesCriteria;
use App\Domain\Branch\Repositories\Contracts\AlbumRepository;
use App\Domain\Branch\Repositories\Contracts\BranchRepository;
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

    protected $branchRepository;
    protected $galleryRepository;

    public function __construct(BranchRepository $branchRepository, AlbumRepository $galleryRepository)
    {
        $this->branchRepository = $branchRepository;
        $this->galleryRepository = $galleryRepository;
    }

    public function home()
    {
        $this->setData('alias', $this->domainAlias, 'web');
        $this->addView("{$this->domainAlias}::{$this->viewPath}.home");
        return $this->response();
    }

    public function branches()
    {
        $index = $this->branchRepository->spatie()->paginate(
            $request->per_page ?? config('qalzam.pagination')
        );

        $this->setData('branches', $index, 'web');

        $this->setData('alias', $this->domainAlias, 'web');
        $this->addView("{$this->domainAlias}::{$this->viewPath}.branches");
        return $this->response();
    }

    public function galleries()
    {
        $this->branchRepository->pushCriteria(BranchHasGalleriesCriteria::class);
        $index = $this->branchRepository->with('albums.media')->orderBy('created_at','desc')->all();

        $this->setData('branches', $index, 'web');

        $this->setData('alias', $this->domainAlias, 'web');
        $this->addView("{$this->domainAlias}::{$this->viewPath}.galleries");
        return $this->response();
    }

    /**
     * @param $gallery
     */
    public function gallery($gallery)
    {
        $show = $this->galleryRepository->find($gallery);

        $this->setData('album', $show, 'web');

        $this->setData('alias', $this->domainAlias, 'web');
        $this->addView("{$this->domainAlias}::{$this->viewPath}.gallery");
        return $this->response();
    }

    public function reservation()
    {
        $this->branchRepository->pushCriteria(new StatusIsCriteria(true));
        $index = $this->branchRepository->orderBy('created_at', 'desc')->all();

        $this->setData('branches', $index, 'web');

        $this->setData('alias', $this->domainAlias, 'web');
        $this->addView("{$this->domainAlias}::{$this->viewPath}.reservation");
        return $this->response();
    }
}
