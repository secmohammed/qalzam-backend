<?php

namespace App\Domain\Reservation\Datatables;

use App\Domain\Reservation\Entities\Reservation;
use Carbon\Carbon;
use Carbon\Traits\Creator;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ReservationDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('user.name', function ($model){
                $user = $model->user ? $model->user->name: '' ;
                return "<span>$user</span>";
            })
            ->editColumn('creator.name', function ($model){
                $creator = $model->creator ? $model->creator->name: '' ;
                return "<span>$creator</span>";
            })
            ->editColumn('accommodation.name', function ($model){
                $accommodation = $model->accommodation ? $model->accommodation->name: '' ;
                return "<span>$accommodation</span>";
            })
            ->editColumn('status', function ($model){
                $color = $model->status == 'upcoming' ? 'primary' : ($model->status == 'done'? 'secondary' : 'success');
                return "<span class='badge badge-$color'>$model->status</span>";
            })
            ->editColumn('created_at' ,function ($model) {
                $created_at     = (new Carbon($model->created_at))->format('Y-m-d H:i');
                return "<span>$created_at</span>";
            })
            ->editColumn('start_date' ,function ($model) {
                $start_date     = (new Carbon($model->start_date))->format('Y-m-d H:i');
                return "<span>$start_date</span>";
            })
            ->editColumn('end_date' ,function ($model) {
                $end_date     = (new Carbon($model->end_date))->format('Y-m-d H:i');
                return "<span>$end_date</span>";
            })
            ->editColumn('price', function ($model) {
                $price = $model->price->amount();
                return "<span>$price</span>";
            })
             ->editColumn('checkbox', function ($model){
                return "<input type='checkbox' name='items[]' value='$model->id' id='selectResource'/>";
            })
            ->addColumn('actions', function ($model) {
                $btn = "<a href=" . route('reservations.show', ['reservation' => $model->id]) . " class='fa fa-eye text-primary mx-1'></a>";
                $btn = $btn . "<a href=" . route('reservations.edit', ['reservation' => $model->id]) . " class='fa fa-edit text-primary mx-1'></a>";

                return $btn;
            })
            ->rawColumns(['actions','price','checkbox','status','user.name','creator.name','accommodation.name','start_date','end_date','created_at']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('reservation-table')
            ->columns($this->getColumns())
            ->addCheckbox([],true)
            ->minifiedAjax()
            ->dom("<'row'<'col-3' l><'col-6 text-right' B><'col-3' f>>
                                <'row'<'col-12' tr>>
                                <'row'<'col-5'i><'col-7 dataTables_pager'p>>")
            ->orderBy(1);
    }

    /**
     * Get query source of dataTable.
     *
     * @param Reservation $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Reservation $model)
    {
        return $model->newQuery()->with(['user', 'creator', 'accommodation'])->select('reservations.*');
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Reservation_' . date('YmdHis');
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id')->title(__('main.id')),
            Column::make('price')->title(__('main.price')),
            Column::make('user.name')->title(__('main.user')),
            Column::make('creator.name')->title(__('main.creator')),
            Column::make('accommodation.name')->title(__('main.accommodation')),
            Column::make('start_date')->title(__('main.start_date')),
            Column::make('end_date')->title(__('main.end_date')),
            Column::make('status')->title(__('main.status')),
            Column::make('created_at')->title(__('main.created_at')),
            Column::computed('actions')->title(__('main.actions')),
        ];
    }
}
