<?php

namespace App\Domain\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use Joovlly\DDD\Traits\Responder;
use App\Domain\Dashboard\Entities\Dashboard;
use App\Domain\Order\Repositories\Contracts\OrderRepository;
use App\Domain\Dashboard\Repositories\Contracts\DashboardRepository;
use App\Domain\Reservation\Repositories\Contracts\ReservationRepository;
use App\Domain\Product\Repositories\Contracts\ProductVariationRepository;
use App\Infrastructure\Http\AbstractControllers\BaseController as Controller;

class DashboardController extends Controller
{
    use Responder;

    /**
     * @var DashboardRepository
     */

    /**
     * Domain Alias.
     *
     * @var string
     */
    protected $domainAlias = 'dashboards';

    /**
     * Resource Route.
     *
     * @var string
     */
    protected $resourceRoute = 'dashboards';

    /**
     * View Path
     *
     * @var string
     */
    protected $viewPath = 'dashboard';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, ReservationRepository $reservationRepository, OrderRepository $orderRepository, ProductVariationRepository $productVariationRepository)
    {
        $pendingOrdersCount = $orderRepository->where('status', 'pending')->count();
        $topSellingProducts = $productVariationRepository->withCount('orders')->withCount(['orders AS total_quantity' => function ($query) {
            $query->select(\DB::raw('SUM(product_variation_order.quantity) as total_quantity'));

        }])->orderByRaw('total_quantity + orders_count DESC')->limit(6)->get();
        $recentReservations =  $reservationRepository->latest()->limit(5)->get()->load(['branch']);
        $recentOrders = $orderRepository->latest()->limit(5)->where('status', 'pending')->get()->load(['branch', 'products', 'user', 'deliverers']);
        return view("{$this->domainAlias}::{$this->viewPath}.index")->with(compact('recentReservations', 'recentOrders', 'pendingOrdersCount', 'topSellingProducts'));
    }
}
