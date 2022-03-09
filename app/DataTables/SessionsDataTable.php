<?php

namespace App\DataTables;

use App\Models\TrainingSession;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SessionsDataTable extends DataTable
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
            ->addColumn('action', 'sessions.action');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\TrainingSession $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(TrainingSession $model)
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
                    ->dom('Bfrtip')
                    ->orderBy(1);
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
            Column::make('starts_at'),
            Column::make('finishes_at'),
        ];

        if (Auth::user()->can('show_gym_data')) {
            $columnsArray[] = Column::make('gym');
        }
        if (Auth::user()->can('show_city_data')) {
            $columnsArray[] = Column::make('city');
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
        return 'Sessions_' . date('YmdHis');
    }
}
