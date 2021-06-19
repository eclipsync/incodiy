<?php
namespace App\Models\Admin\Modules;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Created on 24 Mar 2021
 * Time Created	: 10:39:03
 *
 * @filesource	Form.php
 *
 * @author		wisnuwidi@gmail.com - 2021
 * @copyright	wisnuwidi
 * @email		wisnuwidi@gmail.com
 */
 
class Form extends Model {
	
	protected $table	= 'test_inputform';
	protected $guarded	= [];
}