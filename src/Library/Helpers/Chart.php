<?php
/**
 * Created on Oct 19, 2022
 * 
 * Time Created : 5:33:34 PM
 *
 * @filesource	Chart.php
 *
 * @author     wisnuwidi@incodiy.com - 2022
 * @copyright  wisnuwidi
 * @email      wisnuwidi@incodiy.com
 */

if (!function_exists('diy_script_chart')) {
	
	function diy_script_chart($type = 'line', $identity = null, $title = null, $subtitle = null, $xAxis = null, $yAxis = null, $tooltips = null, $legends = null, $series = null) {
		$chartType = "chart: {type: '{$type}'},";
		return "<script type=\"text/javascript\">$(function () { $('#{$identity}').highcharts({ {$chartType}{$title}{$subtitle}{$xAxis}{$yAxis}{$tooltips}{$legends}{$series} }); });</script>";
	}
}
