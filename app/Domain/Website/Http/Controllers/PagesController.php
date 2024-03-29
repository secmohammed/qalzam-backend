<?php


namespace App\Domain\Website\Http\Controllers;

use App\Common\Criteria\StatusIsCriteria;
use App\Criteria\BranchProductsCriteriaCriteria;
use App\Domain\Branch\Criteria\BranchHasAccommodationsCriteria;
use App\Domain\Branch\Entities\Branch ;
use App\Common\Facades\Branch as BranchFacade;
use App\Domain\Accommodation\Repositories\Contracts\AccommodationRepository;
use App\Domain\Branch\Criteria\BranchHasGalleriesCriteria;
use App\Domain\Branch\Repositories\Contracts\AlbumRepository;
use App\Domain\Branch\Repositories\Contracts\BranchRepository;
use App\Domain\Product\Entities\Product;
use App\Domain\Product\Entities\ProductVariation;
use App\Domain\Product\Repositories\Contracts\ProductRepository;
use App\Domain\Reservation\Repositories\Contracts\ReservationRepository;
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
    protected $accommodationRepository;

    public function __construct(BranchRepository $branchRepository, AlbumRepository $galleryRepository,AccommodationRepository $accommodationRepository)
    {
        // todo implement every repo in required function, or better make Invoke Controllers
        $this->branchRepository = $branchRepository;
        $this->galleryRepository = $galleryRepository;
        $this->accommodationRepository = $accommodationRepository;
    }

    public function home()
    {
        $this->setData('alias', $this->domainAlias, 'web');
        $this->addView("{$this->domainAlias}::{$this->viewPath}.home");
        return $this->response();
    }

    public function branches()
    {
        $index = $this->branchRepository->orderBy('created_at', 'desc')->spatie()->paginate(
            $request->per_page ?? config('qalzam.pagination')
        );

        $this->setData('branches', $index, 'web');

        $this->setData('alias', $this->domainAlias, 'web');
        $this->addView("{$this->domainAlias}::{$this->viewPath}.branches");
        return $this->response();
    }

    public function ourBranches()
    {
        $this->setData('alias', $this->domainAlias, 'web');
        $this->addView("{$this->domainAlias}::{$this->viewPath}.our_branches");
        return $this->response();
    }
    /**
     * @param $branch
     */
    public function branch($branch)
    {
        $this->branchRepository->pushCriteria(new StatusIsCriteria(true));
        $show = $this->branchRepository->with(['mainProducts' => function($product){ return $product->where('status', 'active');}])->find($branch);
        BranchFacade::setBranch($show);
        $this->setData('alias', $this->domainAlias, 'web');
        $this->setData('branch', $show, 'web');
        $filters =  [['id' => 1, 'name' => 'hamada'], ['id' => 2, 'name' => 'mahmoud']];
        $this->setData('filters',$filters, 'web');

        $this->addView("{$this->domainAlias}::{$this->viewPath}.branch");
        return $this->response();
    }
    public function showProduct(Product $product)
    {
        $branch = \App\Common\Facades\Branch::getChangeableBranch();
        $variations = $product->variations()->whereHas('branches', function ($query) use($branch){
            return $query->where('branches.id', $branch->id);
        })->with('type')->get();

//        dd($variations->);

        $this->setData('alias', $this->domainAlias, 'web');
        $this->setData('product', $product, 'web');
        $this->setData('variations', $variations, 'web');
        $this->addView("{$this->domainAlias}::{$this->viewPath}.product_details");
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

    public function createReservation()
    {
        $this->branchRepository->pushCriteria(new StatusIsCriteria(true));
        $this->branchRepository->pushCriteria(new BranchHasAccommodationsCriteria(true));
//       $accommodations= $this->accommodationRepository->orderBy('created_at', 'desc')->all();
        $index = $this->branchRepository->orderBy('created_at', 'desc')->with('accommodations')->all();
        $this->setData('branches', $index, 'web');
//        $this->setData('accommodations', $accommodations, 'web');

        $this->setData('alias', $this->domainAlias, 'web');
        $this->addView("{$this->domainAlias}::{$this->viewPath}.reservation");
        return $this->response();
    }


    public function about()
    {
        $this->setData('alias', $this->domainAlias, 'web');
        $this->addView("{$this->domainAlias}::{$this->viewPath}.about");
        return $this->response();
    }

    public function contact()
    {
        $this->setData('alias', $this->domainAlias, 'web');
        $this->addView("{$this->domainAlias}::{$this->viewPath}.contact");
        return $this->response();
    }

    public function termsAndConditions()
    {
        $this->setData('alias', $this->domainAlias, 'web');
        $this->addView("{$this->domainAlias}::{$this->viewPath}.terms-and-conditions");
        return $this->response();
    }

    public function policy()
    {
        $this->setData('alias', $this->domainAlias, 'web');
        $this->addView("{$this->domainAlias}::{$this->viewPath}.policy");
        return $this->response();

    }
}
