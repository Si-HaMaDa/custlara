<?php
/*
if (!function_exists('setting')) {
function setting() {
return \App\Model\Setting::orderBy('id', 'desc')->first();
}
}

if (!function_exists('active_menu')) {
function active_menu($link) {

if (preg_match('/'.$link.'/i', Request::segment(2))) {
return ['menu-open', 'display:block'];
} else {
return ['', ''];
}
}
}
 */

if (!function_exists('aurl')) {
    function aurl($url = null)
    {
        return url('panel/' . $url);
    }
}

if (!function_exists('statu_helper')) {
    /**
     * n = new
     * p = proccess
     * a = attention
     * f = fail
     * s = success
     **/
    function statu_helper($statu_help)
    {
        switch ($statu_help) {
            case 'n':
                return ['name' => trans('admin.new'), 'icon' => 'fa-circle-o', 'color' => 'gray', 'panel' => 'default'];
                break;
            case 'p':
                return ['name' => trans('admin.proccess'), 'icon' => 'fa-refresh', 'color' => 'aqua', 'panel' => 'info'];
                break;
            case 'a':
                return ['name' => trans('admin.attention'), 'icon' => 'fa-warning', 'color' => 'yellow', 'panel' => 'warning'];
                break;
            case 'f':
                return ['name' => trans('admin.fail'), 'icon' => 'fa-times-circle-o', 'color' => 'red', 'panel' => 'danger'];
                break;
            case 's':
                return ['name' => trans('admin.success'), 'icon' => 'fa-check-circle-o', 'color' => 'green', 'panel' => 'success'];
                break;
        }
    }
}

if (!function_exists('gender_helper')) {
    function gender_helper($gender_help)
    {
        switch ($gender_help) {
            case 'male':
                return '<i class="fa fa-2x fa-mars text-blue"></i>';
                break;
            case 'female':
                return '<i class="fa fa-2x fa-venus text-red"></i>';
                break;
            case 'other':
                return '<i class="fa fa-2x fa-neuter text-gray"></i>';
                break;
        }
    }
}

if (!function_exists('contacts_helper')) {
    function contacts_helper($contacts_help)
    {
        $holder = '';
        if (!empty($contacts_help['fb'])) {
            $holder .= '<i class="fa fa-2x fa-facebook-official text-blue"></i> ';
        }
        if (!empty($contacts_help['phone'])) {
            $holder .= '<i class="fa fa-2x fa-whatsapp text-green"></i> ';
        }
        if (!empty($contacts_help['email'])) {
            $holder .= '<i class="fa fa-2x fa-envelope text-gray"></i> ';
        }
        return $holder;
    }
}

if (!function_exists('admin_rules')) {
    function admin_rules($num = null)
    {
        $rules = array(
            1    => 'S Admin',
            2    => 'Admin',
            3    => 'Moderator',
            null => 'User',
        );
        $num = $num > 3 ? NULL : $num;
        return $num == 'r' ? $rules : $rules[$num];
    }
}

if (!function_exists('datatable_lang')) {
    function datatable_lang()
    {
        return ['sProcessing' => trans('admin.sProcessing'),
            'sLengthMenu'         => trans('admin.sLengthMenu'),
            'sZeroRecords'        => trans('admin.sZeroRecords'),
            'sEmptyTable'         => trans('admin.sEmptyTable'),
            'sInfo'               => trans('admin.sInfo'),
            'sInfoEmpty'          => trans('admin.sInfoEmpty'),
            'sInfoFiltered'       => trans('admin.sInfoFiltered'),
            'sInfoPostFix'        => trans('admin.sInfoPostFix'),
            'sSearch'             => trans('admin.sSearch'),
            'sUrl'                => trans('admin.sUrl'),
            'sInfoThousands'      => trans('admin.sInfoThousands'),
            'sLoadingRecords'     => trans('admin.sLoadingRecords'),
            'oPaginate'           => [
                'sFirst'    => trans('admin.sFirst'),
                'sLast'     => trans('admin.sLast'),
                'sNext'     => trans('admin.sNext'),
                'sPrevious' => trans('admin.sPrevious'),
            ],
            'oAria'               => [
                'sSortAscending'  => trans('admin.sSortAscending'),
                'sSortDescending' => trans('admin.sSortDescending'),
            ],
        ];
    }
}
