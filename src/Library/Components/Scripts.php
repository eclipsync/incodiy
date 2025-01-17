<?php
namespace Incodiy\Codiy\Library\Components;

/**
 * Created on 12 Mar 2021
 * Time Created : 09:18:04
 *
 * @filesource Scripts.php
 *
 * @author     wisnuwidi@incodiy.com - 2021
 * @copyright  wisnuwidi
 * @email      wisnuwidi@incodiy.com
 */
 
class Scripts {
	
	public $baseURL;
	public $assetPath;
	public $currentURL;
	public $scripts = [];
	
	public function __construct() {
		$this->baseURL    = diy_config('baseURL');
		$this->currentURL = diy_url('current');
		$this->assetPath  = diy_script_asset_path();
	}
	
	/**
	 * Render Javascript HTML
	 *
	 * @param string $scripts
	 * @param string $position
	 * 		: default [general script located in top],
	 * 		top [by default, position set in top],
	 * 		bottom
	 */
	public function js($scripts, $position = 'bottom', $as_script_code = false) {
		if (!is_array($scripts)) {
			if (!empty($this->check_js_strings($scripts, $as_script_code))) {
				$this->scripts [__FUNCTION__] [$position] [] = $this->check_js_strings($scripts, $as_script_code);
			}
		}
		
		if (is_array($scripts)) {
			foreach($scripts as $script) {
				if (!empty($this->check_js_strings($script, $as_script_code))) {
					$this->scripts [__FUNCTION__] [$position] [] = $this->check_js_strings($script, $as_script_code);
				}
			}
		}
	}
	
	/**
	 * Render CSS HTML
	 *
	 * @param string $scripts
	 * @param string $position
	 * 		: default [general script located in top],
	 * 		top [by default, position set in top],
	 * 		bottom
	 */
	public function css($scripts, $position = 'top', $as_script_code = false) {
		if (!is_array($scripts)) {
			$this->scripts [__FUNCTION__] [$position] [] = $this->check_css_strings($scripts, $as_script_code);
		}
		
		if (is_array($scripts)) {
			foreach($scripts as $script) {
				$this->scripts [__FUNCTION__] [$position] [] = $this->check_css_strings($script, $as_script_code);
			}
		}
	}
	private function check_js_strings($string, $as_script_code = false) {
		$containedType = 'type="text/javascript"';
		$containedTag  = '<script';
		$containedSrc  = 'src=';
		
		$scriptsText = [ ];
		$scriptsHTML = [ ];
		
		if (true === $as_script_code) {
			return diy_array_to_object_recursive([
				'url'  => false,
				'html' => '<script type="text/javascript">' . $string . '</script>'
			]);
		}
		
		if ((str_contains($string, $containedType) || str_contains($string, $containedTag)) || (str_contains($string, $containedSrc))) {
			// Get script in HTML
			$scriptsText = diy_script_html_element_value($string, 'script', 'src', false);
			$scriptsHTML = str_replace('</script>', '', diy_script_html_element_value($string, 'script', 'src')) . '</script>';
		} else {
			// Get script in text
			$scriptsText = diy_script_check_string_path($string);
			$scriptsHTML = '<script type="text/javascript" src="' . diy_script_check_string_path($string) . '"></script>';
		}
		
		if (!empty($scriptsText)) {
			return diy_array_to_object_recursive([
				'url' => $scriptsText,
				'html' => $scriptsHTML
			]);
		}
	}
	private function check_css_strings($string, $as_script_code = false) {
		$containedType = 'rel="stylesheet"';
		$containedTag  = '<link';
		$containedSrc  = 'href=';
		
		$scriptsText   = [];
		$scriptsHTML   = [];
		
		if (true === $as_script_code) {
			return diy_array_to_object_recursive([
				'url'  => false,
				'html' => '<style>' . $string . '</style>'
			]);
		}
		
		if ((str_contains($string, $containedType) || str_contains($string, $containedTag)) || (str_contains($string, $containedSrc))) {
			// Get script in HTML
			$scriptsText = diy_script_html_element_value($string, 'link', 'href', false);
			$scriptsHTML = diy_script_html_element_value($string, 'link', 'href');
		} else {
			// Get script in text
			$scriptsText = $string;
			$scriptsHTML = '<link rel="stylesheet" href="' . diy_script_check_string_path($string) . '" />';
		}
		
		return diy_array_to_object_recursive([
			'url'  => $scriptsText,
			'html' => $scriptsHTML
		]);
	}
}