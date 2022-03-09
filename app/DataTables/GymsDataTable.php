<?php

namespace App\DataTables;

use App\Models\Gym;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class GymsDataTable extends DataTable
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
            ->addColumn('action', 'gyms.action');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Gym $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Gym $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('datatable')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip');
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $columnsArray = [
            Column::make(''),
            Column::make('#'),
            Column::make('name'),
            Column::make('created_at'),
            Column::make('cover_image'),
        ];
        if (Auth::user()->can('show_city_data')) {
            $columnsArray[] =  Column::make('city_manager_name');
        }
        return $columnsArray;
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Gyms_' . date('YmdHis');
    }
}
