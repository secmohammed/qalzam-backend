<?php

namespace App\Domain\Post\Datatables;

use App\Domain\Post\Entities\Post;
use Carbon\Carbon;
use Carbon\Traits\Creator;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PostDataTable extends DataTable
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
            ->editColumn('type', function ($model){
                $color = $model->type == 'normal' ? 'primary' : 'warning';
                return "<span class='badge badge-$color'>$model->type</span>";
            })
            ->editColumn('status', function ($model){
                $color = $model->status == 'approved' ? 'primary' : 'danger';
                return "<span class='badge badge-$color'>$model->status</span>";
            })
            ->editColumn('checkbox', function ($model){
                return "<input type='checkbox' name='items[]' value='$model->id' id='selectResource'/>";
            })
            ->editColumn('created_at' ,function ($model) {
                $created_at     = (new Carbon($model->created_at))->format('Y-m-d H:i');
                return "<span>$created_at</span>";
            })
            ->addColumn('actions', function ($model) {
                $btn = "<a href=" . route('posts.show', ['post' => $model->id]) . " class='fa fa-eye text-primary mx-1'></a>";
                $btn = $btn . "<a href=" . route('posts.edit', ['post' => $model->id]) . " class='fa fa-edit text-primary mx-1'></a>";

                return $btn;
            })
            ->rawColumns(['actions','checkbox', 'status','type','user.name','created_at']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('post-table')
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
     * @param Post $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Post $model)
    {
        return $model->newQuery()->with(['user'])->select('posts.*');
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Post_' . date('YmdHis');
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
            Column::make('title')->title(__('main.title')),
            Column::make('slug')->title(__('main.slug')),
            Column::make('user.name')->title(__('main.user')),
            Column::make('description')->title(__('main.description')),
            Column::make('status')->title(__('main.status')),
            Column::make('type')->title(__('main.type')),
            Column::make('created_at')->title(__('main.created_at')),
            Column::computed('actions')->title(__('main.actions')),
        ];
    }
}
