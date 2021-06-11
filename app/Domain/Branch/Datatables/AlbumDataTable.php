<?php

namespace App\Domain\Branch\Datatables;

use App\Domain\Branch\Entities\Album;
use Carbon\Carbon;
use Carbon\Traits\Creator;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AlbumDataTable extends DataTable
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
            ->addColumn('actions', function ($model) {
                $btn = "<a href=" . route('albums.show', ['album' => $model->id]) . " class='fa fa-eye text-primary mx-1'></a>";
                $btn = $btn . "<a href=" . route('albums.edit', ['album' => $model->id]) . " class='fa fa-edit text-primary mx-1'></a>";

                return $btn;
            })
            ->editColumn('user.name', function ($model){
                $user = $model->user ? $model->user->name: '' ;
                return "<span>$user</span>";
            })
            ->editColumn('branch.name', function ($model){
                $branch = $model->branch ? $model->branch->name: '' ;
                return "<span>$branch</span>";
            })
            ->editColumn('created_at' ,function ($model) {
                $created_at     = (new Carbon($model->created_at))->format('Y-m-d H:i');
                return "<span>$created_at</span>";
            })
            ->editColumn('checkbox', function ($model){
                return "<input type='checkbox' name='items[]' value='$model->id' id='selectResource'/>";
            })
            ->editColumn('status', function ($model){
                $color = $model->status == 'active' ? 'primary' : 'warning';
                return "<span class='badge badge-$color'>$model->status</span>";
            })
            ->rawColumns(['actions','checkbox', 'branch.name', 'user.name','created_at','status']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('album-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addCheckbox([],true)

            ->dom("<'row'<'col-3' l><'col-6 text-right' B><'col-3' f>>
                                <'row'<'col-12' tr>>
                                <'row'<'col-5'i><'col-7 dataTables_pager'p>>")
            ->orderBy(1);
    }

    /**
     * Get query source of dataTable.
     *
     * @param Album $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Album $model)
    {
        return $model->newQuery()->with(['branch', 'user'])->select('albums.*');
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Album_' . date('YmdHis');
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
            Column::make('name')->title(__('main.name')),
            Column::make('user.name')->title(__('main.user')),
            Column::make('branch.name')->title(__('main.branch')),
            Column::make('status')->title(__('main.status')),
            Column::make('created_at')->title(__('main.created_at')),
            Column::computed('actions')->title(__('main.actions')),
        ];
    }
}
