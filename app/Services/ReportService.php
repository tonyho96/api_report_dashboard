<?php

namespace App\Services;


use App\Models\Report;

class ReportService {
	public static function create($data) {
		$report = new Report($data);
		$report->save();
		return $report;
	}
}