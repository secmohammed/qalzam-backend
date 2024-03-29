<?php

namespace App\Domain\User\Datatables;

use App\Domain\User\Entities\User;
use Carbon\Carbon;
use Carbon\Traits\Creator;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
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
            ->editColumn('status', function ($model){
                $color = $model->status == 'active' ? 'primary' : 'warning';
                return "<span class='badge badge-$color'>$model->status</span>";
            })
            ->editColumn('name', function ($model){
                $variation_name = $model->name?? '' ;
                return "<span>$variation_name</span>";
            })
            ->editColumn('created_at' ,function ($model) {
                $created_at     = (new Carbon($model->created_at))->format('Y-m-d H:i');
                return "<span>$created_at</span>";
            })
            ->editColumn('type' ,function ($model){
                switch ($model->type) {
                    case 'user':
                        $color = 'primary';
                        break;
                    case 'admin':
                        $color = 'info';
                        break;
                    case 'branch':
                        $color = 'secondary';
                        break;
                    case 'kitchen':
                        $color = 'danger';
                        break;
                    default :
                        $color = 'warning';
                        break;
                }
                return "<span class='badge badge-$color'>$model->type</span>";
            })
            ->editColumn('checkbox', function ($model){
                return "<input type='checkbox' name='users[]' value='$model->id' id='selectResource'/>";
            })
            ->addColumn('actions', function ($model) {
                $btn = "<a href=" . route('users.show', ['user' => $model->id]) . " class='fa fa-eye text-primary mx-1'></a>";
                $btn = $btn . "<a href=" . route('users.edit', ['user' => $model->id]) . " class='fa fa-edit text-primary mx-1'></a>";

                return $btn;
            })
            ->rawColumns(['actions','checkbox','name','type', 'status','created_at']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('user-table')
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
     * @param user $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(user $model)
    {
        return $model->newQuery()->when(request('type') === 'user', function ($query){
            return $query->where('type', 'user');
        })->when(request('type') != 'user', function ($query){
            return $query->whereIn('type', ['admin', 'branch','kitchen']);
        })->select('users.*');
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'user_' . date('YmdHis');
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
//            Column::computed('checkbox'),
            Column::make('id')->title(__('main.id')),
            Column::make('type')->title(__('main.type')),
            Column::make('name')->title(__('main.name')),
            Column::make('email')->title(__('main.email')),
            Column::make('mobile')->title(__('main.mobile')),
            Column::make('title')->title(__('main.title')),
            Column::make('status')->title(__('main.status')),
            Column::make('created_at')->title(__('main.created_at')),
            Column::computed('actions')->title(__('main.actions')),
        ];
    }
}
