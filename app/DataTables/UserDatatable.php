<?php

namespace App\DataTables;

use App\User;
use Yajra\DataTables\Services\DataTable;

class UserDatatable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
            ->addColumn('action', 'admin.btn.action')
            ->addColumn('level', 'admin.btn.level')
            // ->addColumn('delete', 'admin.btn.delete')
            // ->addColumn('check', '<input type="checkbox" name="checked_item[]" class="checked_item" value="{{ $id }}">')
            // ->rawColumns(['edit', 'delete', 'check']);
            ->rawColumns(['action', 'level']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return User::query();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->parameters([
                'responsive' => true,
                'dom' => 'Blfrtip',
                'lengthMenu' => [[10, 25, 50, 100], [10, 25, 50, trans('admin.all_record')]],
                'buttons' => [
                    [
                        'text' => '<i class="fa fa-plus"></i> ' . trans('admin.add_new'), 'className' => 'btn btn-info', "action" => "function(){

							window.location.href = '" . \URL::current() . "/create';
						}"],

                    ['extend' => 'print', 'className' => 'btn btn-primary', 'text' => '<i class="fa fa-print"></i>'],
                    ['extend' => 'csv', 'className' => 'btn btn-info', 'text' => '<i class="fa fa-file"></i> ' . trans('admin.ex_csv')],
                    ['extend' => 'excel', 'className' => 'btn btn-success', 'text' => '<i class="fa fa-file"></i> ' . trans('admin.ex_excel')],
                    ['extend' => 'reload', 'className' => 'btn btn-default', 'text' => '<i class="fa fa-refresh"></i>'],

                ],
                'initComplete' => " function () {
		            this.api().columns([1]).every(function () {
		                var column = this;
		                var input = document.createElement(\"input\");
		                $(input).appendTo($(column.footer()).empty())
		                .on('keyup', function () {
		                    column.search($(this).val(), false, false, true).draw();
		                });
		            });
		        }",

                'language' => datatable_lang(),

            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            [
                'name' => 'id',
                'data' => 'id',
                'title' => '#',
            ], [
                'name' => 'name',
                'data' => 'name',
                'title' => trans('admin.name'),
            ], [
                'name' => 'level',
                'data' => 'level',
                'title' => trans('admin.level'),
            ], [
                'name' => 'created_at',
                'data' => 'created_at',
                'title' => trans('admin.created_at'),
            ], [
                'name' => 'updated_at',
                'data' => 'updated_at',
                'title' => trans('admin.updated_at'),
            ], [
                'name' => 'action',
                'data' => 'action',
                'title' => trans('admin.action'),
                'exportable' => false,
                'printable' => false,
                'orderable' => false,
                'searchable' => false,
            ],

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'User_' . date('YmdHis');
    }
}
