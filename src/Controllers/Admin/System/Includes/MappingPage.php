<?php
namespace Incodiy\Codiy\Controllers\Admin\System\Includes;

/**
 * Created on Sep 6, 2022
 * 
 * Time Created : 1:52:26 PM
 *
 * @filesource	MappingPage.php
 *
 * @author     wisnuwidi@gmail.com - 2022
 * @copyright  wisnuwidi
 * @email      wisnuwidi@gmail.com
 */

trait MappingPage {
		
	private $mapRoute;
	private $mapTable;
	
	public $mapping_page = [];
	public function mapping() {
		$title_id                         = 'page_privileges_' . diy_random_strings(50, false);
		$headerData                       = [];
		$headerData['module_id']          = [diy_table_row_attr('Module Name' , ['style' => 'text-align:center'])];
		$headerData['target_table']       = [diy_table_row_attr('Table Name'  , ['style' => 'text-align:center'])];
		$headerData['target_field_name']  = [diy_table_row_attr('Field Name'  , ['style' => 'text-align:center'])];
		$headerData['target_field_value'] = [diy_table_row_attr('Field Value' , ['style' => 'text-align:center', 'colspan' => 2])];
		$header                           = array_merge_recursive($headerData['module_id'], $headerData['target_table'], $headerData['target_field_name'], $headerData['target_field_value']);
		
		$row_table = $this->mapping_box();
		
		return $this->form->draw(diy_generate_table('Set Role Module Page', $title_id, $header, $row_table, false, false, false));
	}
	
	public function renderMap($data, $usein) {
		$this->getFieldName($data, $usein);
	}
	
	private function getFieldName($data, $usein) {
		if ('table_name' === $usein) {
			$fields = [];
			foreach (diy_get_table_columns($data['table_name']) as $fieldname) {
				$fields[$fieldname] = $fieldname;
			}
			
			$data = json_encode($fields);
		}
		
		if ('field_name' === $usein) {
			$rows  = [];
			$query = [];
			if (is_array($data['field_name'])) {
				
				$fieldset = [];
				foreach ($data['field_name'] as $value) {
					$explode = explode('::', $value);
					
					$rows['table_name'] = explode($this->nodeID, $explode[0])[0];
					$rows['field_name'] = $explode[1];
					
					$fieldset = $rows['field_name'];
					$query    = diy_query("SELECT `{$rows['field_name']}` FROM {$rows['table_name']} GROUP BY `{$rows['field_name']}`;", 'SELECT');
				}
				
				$rows  = [];
				foreach ($query as $row) {
					$rows[$row->{$fieldset}] = $row->{$fieldset};
				}
				
				$data = json_encode($rows);
			}
		}
		
		echo $data;
	}
	
	private $model_class_info;
	private function get_data_map() {
		$this->model_class_info = diy_get_model_controllers_info();
	}
	
	private $nodeID = '__node__';
	private function setID($string, $node = null) {
		if (empty($node))	$node = $this->nodeID;
		return diy_random_strings(8, false, $string, '__node__');
	}
	
	private function mapping_box() {
		$this->get_data_map();
		$row_table = [];
		$icon      = '<i class="fa fa-caret-right"></i> &nbsp; ';
		$roleData  = null;
		
		foreach ($this->menu_privileges as $parent => $childs) {
			$parent_title	= ucwords(str_replace('_', ' ', $parent));
			if (!empty($childs->name)) $parent_title = $childs->name;
			$row_table[]	= [diy_table_row_attr($icon . "<b>{$parent_title}</b>", ['style' => 'font-weight:500;text-indent:5pt', 'colspan' => 5])];
			
			foreach ($childs as $child_name => $data_module) {
				if (!isset($data_module->id)) {
					$child_title	= ucwords(str_replace('_', ' ', $child_name));
					if (!empty($data_module->name)) $child_title = $data_module->name;
					
					$row_table[]	= [diy_table_row_attr($icon . $child_title, ['style' => 'font-weight:500;text-indent:15pt', 'colspan' => 5])];
					foreach ($data_module as $module_name => $module_data) {
						if (!empty($this->model_class_info[$module_data->route])) {
							$roleData = $this->model_class_info[$module_data->route];
						}
						
						if (!empty($module_data->id)) {
							
							$routeNameAttribute            = str_replace('.', '-', $module_data->route);
							$routeToAttribute              = 'role__' . $routeNameAttribute . '__' . $roleData['model']['table_map'];
							
							$roleAttributes                = [];
							$roleAttributes['table_name']  = "table_name";
							$roleAttributes['field_name']  = "field_name[]";
							$roleAttributes['field_value'] = "field_value[]";
							
							$roleValues                    = [];
							$roleValues['field_name']      = [];
							$roleValues['field_value']     = [];
							
							$roleColumns                   = [];
							
							$tableID                       = $this->setID($roleData['model']['table_map']);
							$roleColumns['table_name']     = diy_form_checkList($roleAttributes['table_name'] , $roleData['model']['table_map'], $roleData['model']['table_map'], false, 'success read-select full-width text-left', $tableID);
							
							$fieldID                       = $this->setID($roleData['model']['table_map']);
							$roleColumns['field_name']     = '<div class="' . $routeToAttribute . ' relative-box" id="role-filter-query role-filter-query-field-table">';
							$roleColumns['field_name']    .= diy_form_selectbox($roleAttributes['field_name'] , $roleValues['field_name'] , false, ['id' => $fieldID, 'class' => $routeToAttribute], false);
							$roleColumns['field_name']    .= '</div>';
							
							$valueID                       = $this->setID($roleData['model']['table_map']);
							$roleColumns['field_value']    = '<div class="' . $routeToAttribute . ' relative-box" id="role-filter-query role-filter-query-field-value-table">';
							$roleColumns['field_value']   .= diy_form_selectbox($roleAttributes['field_value'], $roleValues['field_value'], false, ['id' => $valueID, 'class' => $routeToAttribute], false);
							$roleColumns['field_value']   .= '</div>';
							
							$opt                  = ['align' => 'center', 'id' => strtolower($module_name) . '-row'];
							$resultBox            = [];
							$resultBox['head']    = [diy_table_row_attr($icon . $module_name, ['style' => 'text-indent:25pt', 'id' => strtolower($module_name) . '-row'])];
							$resultBox['body']    = [
								diy_table_row_attr($roleColumns['table_name'] , ['align' => 'left', 'id' => strtolower($module_name) . '-row']),
								diy_table_row_attr($roleColumns['field_name'] , $opt),
								diy_table_row_attr($roleColumns['field_value'], $opt)
							];
							$resultBox['scripts']['table'] = [
								diy_table_row_attr (
									$this->js_rolemap_table($tableID, $fieldID, $valueID) . 
									$this->js_rolemap_fieldname($fieldID, $valueID), 
									['align' => 'center', 'id' => strtolower($module_name) . '-row']
								)								
							];
							
							$o  = array_merge_recursive($resultBox['head'], $resultBox['body'], $resultBox['scripts']['table']);
							
							$row_table[] = $o;
						} else {
							/*
							 $module_title = ucwords(str_replace('_', ' ', $module_name));
							 if (!empty($module_data->name)) $module_title = $module_data->name;
							 
							 $row_table[] = [diy_table_row_attr($icon . $module_title, ['style' => 'font-weight:500;text-indent:25pt', 'colspan' => 4])];
							 foreach ($module_data as $third_name => $third_data) {
							 $third_title = ucwords(str_replace('_', ' ', $third_name));
							 if (!empty($third_data->name)) $third_title = $third_data->name;
							 
							 $row_table[] = $this->_checkboxes($third_title, $third_data, $icon, 'text-indent:35pt');
							 } */
						}
					}
				} else {
					$child_title = ucwords(str_replace('_', ' ', $child_name));
					if (!empty($data_module->name)) $child_title = $data_module->name;
					
					//	$row_table[] = $this->_checkboxes($child_title, $data_module, $icon, 'text-indent:15pt');
				}
			}
			
		}		
		
		return $row_table;
	}
	
	private $ajaxUrli = null;
	private function ajax_urli($usein) {
		$current_url  = url('system/config/group');
		$urlset       = [
			'rolemapage' => 'true',
			'usein'      => $usein,
			'_token'     => csrf_token()
		];
		
		$uri      = [];
		foreach ($urlset as $fieldurl => $urlvalue) {
			$uri[] = "{$fieldurl}={$urlvalue}";
		}
		
		$this->ajaxUrli = $current_url . '?' . implode('&', $uri);
	}
	
	private function js_rolemap_table($id, $target_id, $second_target) {
		$this->ajax_urli('table_name');
		return "<script type='text/javascript'>$(document).ready(function() { mappingPageTableFieldname('{$id}', '{$target_id}', '{$this->ajaxUrli}', '{$second_target}'); });</script>";
	}
	
	private function js_rolemap_fieldname($id, $target_id) {
		$this->ajax_urli('field_name');
		return "<script type='text/javascript'>$(document).ready(function() { mappingPageFieldnameValues('{$id}', '{$target_id}', '{$this->ajaxUrli}'); });</script>";
	}
}