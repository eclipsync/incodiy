<?php
namespace Incodiy\Codiy\Controllers\Admin\System;

use Incodiy\Codiy\Controllers\Core\Controller;
use Incodiy\Codiy\Library\Components\Table\Craft\Datatables;
use Incodiy\Codiy\Library\Components\Table\Craft\Export;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Created on Sep 23, 2022
 * 
 * Time Created : 7:51:52 PM
 *
 * @filesource	AjaxController.php
 *
 * @author     wisnuwidi@incodiy.com - 2022
 * @copyright  wisnuwidi
 * @email      wisnuwidi@incodiy.com
 */

class AjaxController extends Controller {
	
	private $ajaxConnection = null;
	
	public function __construct($connection = null) {
		if (!empty($connection)) $this->ajaxConnection = $connection;
	}
		
	public static $ajaxUrli;
	/**
	 * Ajax Post URL Address
	 * 
	 * @param string $init_post
	 * 	: Initialize Post Key
	 * 	  ['AjaxPosF'         : by default]
	 * 	  ['filterDataTables' : for datatables filtering]
	 * @param boolean $return_data
	 * @return string
	 */
	public static function urli($init_post = 'AjaxPosF', $return_data = false) {
		$current_url  = route('ajax.post');
		if ('filterDataTables' === $init_post) {
			$urlset = [$init_post => 'true'];
		} else {
			$urlset = [$init_post => 'true' ,'_token'  => csrf_token()];
		}
		
		$uri = [];
		foreach ($urlset as $fieldurl => $urlvalue) {
			$uri[] = "{$fieldurl}={$urlvalue}";
		}
		
		self::$ajaxUrli = $current_url . '?' . implode('&', $uri);
		if (true === $return_data) {
			return self::$ajaxUrli;
		}
	}
	
	public function post() {
		if (!empty($_GET)) {
			if (!empty($_GET['AjaxPosF'])) {
				return $this->post_filters();
			} elseif (!empty($_GET['diyHostConn'])) {
				return $this->getHostConnections();
			} elseif (!empty($_GET['diyHostProcess'])) {
				return $this->getHostProcess();
			} elseif (!empty($_GET['filterDataTables'])) {
				return $this->initFilterDatatables($_GET, $_POST);
			}
		}
	}
	
	private function getHostProcess() {
		$token           = $_POST['_token'];
		unset($_POST['_token']);
		
		$sconnect        = $_POST['source_connection_name'];
		$stable          = $_POST['source_table_name'];
		$tconnect        = $_POST['target_connection_name'];
		$ttable          = $_POST['target_table_name'];
		
		$datasource      = DB::connection($sconnect)->select("SELECT * FROM {$stable}");
		$sourceData      = [];
		foreach ($datasource as $datasources) {
			$sourceData[] = (array) $datasources;
		}
		$sourceCounts    = count($sourceData);
		$limitCounts     = 100;
		$rowCountProcess = round($sourceCounts/$limitCounts);
		
		$result = [];
		if (!empty($datasource)) {
			$transfers    = DB::connection($tconnect);
			$transfers->beginTransaction();
			$transfers->delete("TRUNCATE {$ttable}");
			
			$datahandler  = array_chunk($sourceData, $limitCounts);
			$stillHandled = true;
			$countData    = 0;
			foreach($datahandler as $row) {
				$countData++;
				if (!$transfers->table($ttable)->insert($row)) $stillHandled = false;
			}
			
			if ($stillHandled) {
				if ($countData < $rowCountProcess) $transfers->commit();
			} else {
				$transfers->rollBack();
			}
					
			$result['counts']['source'] = $sourceCounts;
			$result['counts']['target'] = count($transfers->select("SELECT * FROM {$ttable}"));
		}
		
		return json_encode($result);
	}
	
	private function getHostConnections() {
		$connection_sources = diy_config('sources', 'connections');
		
		unset($_GET['diyHostConn']);
		unset($_GET['_token']);
		
		$info             = [];
		$info['selected'] = null;
		foreach ($_GET as $key => $data) {
			if ('s' === $key) $info['selected'] = decrypt($data);
		}
		
		$allTables = [];
		foreach ($_POST as $value) {
			$allTables = diy_get_all_tables($connection_sources[$value]['connection_name']);
		}
		
		$result = [];
		if (!empty($allTables)) {
			foreach ($allTables as $tablename) {
				$label = ucwords(str_replace('_', ' ', $tablename));
				$result['data'][$tablename] = $label;
			}
		}
		
		if (!empty($info['selected'])) {
			$result['selected'] = $info['selected'];
		}
		
		return json_encode($result);
	}
	
	private function post_filters() {
		unset($_GET['AjaxPosF']);
		unset($_GET['_token']);
		
		$info             = [];
		$info['label']    = null;
		$info['value']    = null;
		$info['selected'] = null;
		$info['query']    = null;
		
		foreach ($_GET as $key => $data) {
			if ('l' === $key) {
				$info['label']    = decrypt($data);
			} elseif ('v' === $key) {
				$info['value']    = decrypt($data);
			} elseif ('s' === $key) {
				$info['selected'] = decrypt($data);
			} else {
				$info['query']    = decrypt($data);
			}
		}
		
		$postKEY   = array_keys($_POST)[0];
		$postValue = array_values($_POST)[0];
		
		$queryData     = [];
		if (!empty($info['query'])) {
			$sql       = "{$info['query']} WHERE `{$postKEY}` = '{$postValue}' ORDER BY `{$postKEY}` DESC";
			$queryData = diy_query($sql, 'SELECT', $this->ajaxConnection);
		}
		
		$result = [];
		if (!empty($queryData)) {
			foreach ($queryData as $rowData) {
				$result['data'][$rowData->{$info['value']}] = $rowData->{$info['label']};
			}
		}
		
		if (!empty($info['selected'])) {
			$result['selected'] = $info['selected'];
		}
		$results = $result;
		
		return json_encode($results);
	}
	
	private $datatables = [];
	private function datatableClass() {
		$this->datatables = new Datatables();
	}
	
	public $filter_datatables = [];
	protected function filterDataTable(Request $request) {
		$this->datatableClass();
		$this->filter_datatables = $this->datatables->filter_datatable($request);
		
		return $this;
	}
	
	private function initFilterDatatables() {
		if (!empty($_GET['filterDataTables'])) {
			$this->datatableClass();
			return $this->datatables->init_filter_datatables($_GET, $_POST, $this->ajaxConnection);
		}
	}
	
	public function export() {
		$export = new Export();
		return $export->csv('assets/resources/exports');
	}
}