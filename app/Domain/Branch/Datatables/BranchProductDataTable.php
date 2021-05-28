<?php

namespace App\Domain\Branch\Datatables;

use App\Domain\Branch\Entities\BranchProduct;
use Carbon\Carbon;
use Carbon\Traits\Creator;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BranchProductDataTable extends DataTable
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
                $btn = "<form method='post' action=". route('branch.products.delete', ['branch' => $model->branch_id, 'product' => $model->product_id, 'product_variation' => $model->product_variation_id]). ">" .csrf_field() . method_field('DELETE')."<button type='submit' class='fa fa-user text-primary mx-1'></button></form>";
//                $btn = $btn . "<a href=" . route('branches.edit', ['branch' => $model->branch->id]) . " class='fa fa-edit text-primary mx-1'></a>";

                return $btn;
            })
            ->editColumn('branch.name', function ($model){
                $branch = $model->branch ? $model->branch->name: '' ;
                return "<span>$branch</span>";
            })
            ->editColumn('product.name', function ($model){
                $product = $model->product ? $model->product->name: '' ;
                return "<span>$product</span>";
            })
            ->editColumn('productVariation.name', function ($model){
                $productVariation = $model->productVariation ? $model->productVariation->name: '' ;
                return "<span>$productVariation</span>";
            })
            ->rawColumns(['actions', 'product.name','productVariation.name','branch.name']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('branch-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'row'<'col-3' l><'col-6 text-right' B><'col-3' f>>
                                <'row'<'col-12' tr>>
                                <'row'<'col-5'i><'col-7 dataTables_pager'p>>")
            ->orderBy(1);
    }

    /**
     * Get query source of dataTable.
     *
     * @param BranchProduct $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(BranchProduct $model)
    {
        return $model->newQuery()->with(['branch', 'product', 'productVariation'])->select('branch_product.*');
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Branch_Product_' . date('YmdHis');
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('branch.name')->title(__('main.branch')),
            Column::make('product.name')->title(__('main.product')),
            Column::make('productVariation.name')->title(__('main.variation')),
            Column::make('price')->title(__('main.price')),
            Column::computed('actions')->title(__('main.actions')),
        ];
    }
}
