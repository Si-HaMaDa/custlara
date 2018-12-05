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
	function aurl($url = null) {
		return url('panel/'.$url);
	}
}

if (!function_exists('datatable_lang')) {
	function datatable_lang() {
		return ['sProcessing' => trans('admin.sProcessing'),
			'sLengthMenu'        => trans('admin.sLengthMenu'),
			'sZeroRecords'       => trans('admin.sZeroRecords'),
			'sEmptyTable'        => trans('admin.sEmptyTable'),
			'sInfo'              => trans('admin.sInfo'),
			'sInfoEmpty'         => trans('admin.sInfoEmpty'),
			'sInfoFiltered'      => trans('admin.sInfoFiltered'),
			'sInfoPostFix'       => trans('admin.sInfoPostFix'),
			'sSearch'            => trans('admin.sSearch'),
			'sUrl'               => trans('admin.sUrl'),
			'sInfoThousands'     => trans('admin.sInfoThousands'),
			'sLoadingRecords'    => trans('admin.sLoadingRecords'),
			'oPaginate'          => [
				'sFirst'            => trans('admin.sFirst'),
				'sLast'             => trans('admin.sLast'),
				'sNext'             => trans('admin.sNext'),
				'sPrevious'         => trans('admin.sPrevious'),
			],
			'oAria'            => [
				'sSortAscending'  => trans('admin.sSortAscending'),
				'sSortDescending' => trans('admin.sSortDescending'),
			],
		];
	}
}
