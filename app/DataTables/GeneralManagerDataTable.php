<?php

namespace App\DataTables;

use App\Models\GeneralManager;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class GeneralManagerDataTable extends DataTable
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
            ->addColumn('action', 'generalmanager.action');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\GeneralManager $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(GeneralManager $model)
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
        return [
            Column::make(''),
            Column::make('#'),
            Column::make('name'),
            Column::make('email'),
            Column::make('national_id'),
            Column::make('gender'),
            Column::make('birth_date'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'GeneralManager_' . date('YmdHis');
    }
}
