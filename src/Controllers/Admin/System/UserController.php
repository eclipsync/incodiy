<?php
namespace Incodiy\Codiy\Controllers\Admin\System;

use Incodiy\Codiy\Controllers\Core\Controller;
use Incodiy\Codiy\Models\Admin\System\User as User;
use Incodiy\Codiy\Models\Admin\System\Group;
use Incodiy\Codiy\Models\Admin\System\Usergroup;
use Incodiy\Codiy\Models\Admin\System\Language;
use Incodiy\Codiy\Models\Admin\System\Timezone;
use Illuminate\Http\Request;
/**
 * Created on Jul 26, 2017
 * 
 * Time Created : 10:49:43 AM
 * Filename     : UserController.php
 *
 * @filesource UserController.php
 *
 * @author     wisnuwidi @Expresscode - 2017
 * @copyright  wisnuwidi
 * @email      wisnuwidi@gmail.com
 */
class UserController extends Controller {
	
	private $user_groups;
	
	public $group_id;
	public $validations	= [];
	public $importPage  = false;
	
	public function __construct($import = false) {
		parent::__construct(User::class, 'system.accounts.user');
		
		$this->setValidations (
			[
				'username' => 'required|unique:users',
				'fullname' => 'required|min:1',
				'email'    => 'required|unique:users',
				'password' => 'required',
				'group_id' => 'required_if:base_group,0|not_in:0',
				'photo'    => diy_image_validations(2000)
			], [
				'username' => 'required',
				'fullname' => 'required|min:1',
				'email'    => 'required',
				'group_id' => 'required_if:base_group,0|not_in:0',
				'photo'    => diy_image_validations(2000)
			]
		);
	}
	
	private static function key_relations() {
		return [
			'base_user_group.user_id' => 'users.id',
			'base_group.id'           => 'base_user_group.group_id'
		];
	}
	
	public function index() {
		$this->setPage();
		
		if (!$this->is_root && !diy_string_contained($this->session['user_group'], 'admin')) {
			return self::redirect("{$this->session['id']}/edit");
		}
		
		$this->table->searchable();
		$this->table->clickable();
		$this->table->sortable();
		
		$this->table->relations($this->model, 'group', 'group_info', self::key_relations());
		$this->table->relations($this->model, 'group', 'group_name', self::key_relations());
		
		$this->table->filterGroups('username', 'selectbox', true);
		$this->table->filterGroups('group_info', 'selectbox', true);
		
		$this->table->lists($this->model_table, ['username:User', 'email', 'group_info', 'group_name', 'address', 'phone', 'expire_date', 'active']);
		
		return $this->render();
	}
	
	public function create() {
		$this->setPage();
		
		$this->form->modelWithFile();
		
		$this->form->text('username', null);
		$this->form->text('fullname', null);
		$this->form->text('email', null);
		$this->form->password('password');
		$this->form->selectbox('active', active_box(), false);
		
		if ($this->is_root || diy_string_contained($this->session['user_group'], 'admin')) {
			$this->form->openTab('User Group');
			if (true === is_multiplatform()) {
				$this->form->selectbox($this->platform_key, $this->input_platform(), false, [], $this->platform_label);
			}
			$this->form->selectbox('group_id', $this->input_group(), false, [], 'User Group');
			$this->form->selectbox('first_route', [], false, [], 'First Redirect');
			$this->form->sync('group_id', 'first_route', 'route_path', 'module_name', User::sqlFirstRoute());
			$this->form->text('alias', null, ['placeholder' => diy_config('user.alias_placeholder')], diy_config('user.alias_label'));
		}
		
		$this->form->openTab('User Info');
		$this->form->file('photo', ['imagepreview']);
		$this->form->textarea('address', null, ['class' => 'form-control ckeditor']);
		$this->form->text('phone');
		$this->form->selectbox('language', $this->input_language(), 'id_ID');
		$this->form->selectbox('timezone', $this->input_timezone(), 218);
		
		$this->form->openTab('User Status');
		$this->form->date('expire_date');
		$this->form->selectbox('change_password', active_box(), false, []);
		$this->form->closeTab();
		
		$this->form->close('Submit');
		
		return $this->render();
	}
	
	public function store(Request $request) {
		$this->get_session();
		if (!empty($request->diyImportProcess)) return $this->storeFromImports($request);
		
		$this->set_data_before_post($request);
		$this->insert_data($request, false);
		$this->set_data_after_post($this->group_id);
		
		return self::redirect("{$this->stored_id}/edit", $request);
	}
	
	public function storeFromImports($request) {
		$user  = $request->user;
		$group = $request->group;
		
		$this->set_data_before_post($group);
		$this->insert_data(new Request($user), false);
		$this->set_data_after_post($group);
		
		return $request;
	}
	
	public function edit($id) {
		$this->setPage();
		
		$selected_group = false;
		foreach ($this->model_data->group as $group) {
			$selected_group = $group->id;
			if (true === is_multiplatform()) $platform_platforms = $group->{$this->platform_key};
		}
		
		if (intval($this->model_data->id) === intval($this->session['id'])) {
			if (true === is_multiplatform()) $this->form->setHiddenFields([$this->platform_key, 'group_id']);
		}
		
		$this->form->modelWithFile();
		$this->form->text('username', $this->model_data->name, ['required', 'readonly']);
		$this->form->text('fullname', $this->model_data->fullname, ['required']);
		$this->form->text('email', $this->model_data->email, ['required', 'readonly']);
		$this->form->password('password', ['placeholder' => '********']);
		$this->form->selectbox('active', active_box(), $this->model_data->active);
		
		$this->form->openTab('User Info');
		$this->form->file('photo', ['imagepreview']);
		$this->form->textarea('address', $this->model_data->address, ['class' => 'form-control ckeditor']);
		$this->form->text('phone', $this->model_data->phone);
		$this->form->selectbox('language', $this->input_language(), 'id_ID');
		$this->form->selectbox('timezone', $this->input_timezone(), 218);
		
		if ($this->is_root || diy_string_contained($this->session['user_group'], 'admin')) {
			if (intval($this->model_data->id) !== intval($this->session['id'])) {
				$this->form->openTab('User Group');
			}
			
			if (true === is_multiplatform()) {
				$this->form->selectbox($this->platform_key, $this->input_platform(), $platform_platforms, ['required'], $this->platform_label);
			}
			
			$this->form->selectbox('group_id', $this->input_group(), $selected_group, ['required'], 'User Group');
			$this->form->selectbox('first_route', [], false, [], 'First Redirect');
			$this->form->sync('group_id', 'first_route', 'route_path', 'module_name', User::sqlFirstRoute(), $this->model_data->first_route);
			$this->form->text('alias', $this->model_data->alias, [], diy_config('user.alias_label'));
		}
		
		$this->form->openTab('User Status');
		$this->form->date('expire_date', $this->model_data->expire_date);
		$this->form->selectbox('change_password', active_box());
		$this->form->closeTab();
		
		$this->form->close('Submit');
		
		return $this->render();
	}
		
	public function update(Request $request, $id) {
		$this->get_session();
		
		$this->model_find($id);
		
		if (null === $request->password) {
			unset($this->validations['password']);
			$request->offsetUnset('password');
		}
		$request->validate($this->validations);
		
		$this->set_data_before_post($request, __FUNCTION__);
		$this->update_data($request, $id, false);
		$this->set_data_after_post($this->group_id, $id);
		
		return self::redirect('edit', $request);
	}
	
	public function updateX(Request $request, $id) {
		$this->get_session();
		
		$this->model_find($id);
		$data = $request->all();
		
		if ($this->is_root) {
			if (true === is_multiplatform()) {
				$this->validations[$this->platform_key] = 'required';
			}
		}
		$this->validations['email'] = 'required';
		if ($this->model_data->email !== $data['email']) {
			$this->validations['email'] = 'required|unique:users';
		}
		if (null === $request->password) {
			unset($this->validations['password']);
			$request->offsetUnset('password');
		}
		$request->validate($this->validations);
		
		if (true === is_multiplatform()) {
			$request->offsetUnset($this->platform_key);
		}
		
		$this->set_data_before_post($request, __FUNCTION__);
		$this->update_data($request, $id, false);
		$this->set_data_after_post($this->group_id, $id);
		
		$route_back = str_replace('.', '/', $this->route_page);
		return redirect("{$route_back}/{$id}/edit");
	}
	
	private function input_group() {
		if (!$this->is_root) {
			if (true === is_multiplatform()) {
				$this->user_groups = Group::where('group_name', '!=', 'root')->where($this->platform_key, $this->session[$this->platform_key])->get();
			} else {
				$this->user_groups = Group::where('group_name', '!=', 'root')->get();
			}
		} else {
			$this->user_groups = Group::all();
		}
		
		return diy_selectbox($this->user_groups, 'id', 'group_info|group_alias');
	}
	
	private function input_language() {
		return diy_selectbox(Language::all(), 'abbr', 'language');
	}
	
	private function input_timezone() {
		return diy_selectbox(Timezone::all(), 'id', 'timezone');
	}
	
	public function set_data_before_post($request, $action_type = 'create', $callbackDataGroup = false) {
		if (true === is_object($request)) {
			$requests = $request;
		} else {
			$req      = new Request();
			$requests = $req->merge($request);
		}
		
		$group_id = [
			'group_id' => $requests->group_id,
			'email'    => $requests->email
		];
		$this->group_id = $group_id;
		
		$requests->offsetUnset('group_id');
		if (!empty($this->session['id'])) {
			$created_by = $this->session['id'];
		} else {
			$created_by = auth()->id();
		}
		
		$requests->merge(["{$action_type}d_by" => $created_by]);
		
		if(true === $callbackDataGroup) return $this->group_id;
	}
	
	private function set_data_after_post($data, $id = false) {
		$email = $data['email'];
		$user  = $this->model->select('id')->where('email', $email)->first();
		unset($data['email']);
		
		$new_array = array_merge($data, ['user_id' => $user->id]);
		$request   = new Request();
		$request->merge($new_array);
		
		$user_group = new Usergroup();
		if (false !== $id) {
			$userGroup = diy_query_get_id($user_group, ['user_id' => intval($id)]);
			if (!is_null($userGroup)) {
				diy_update($user_group->find($userGroup->id), $request, true);
			} else {
				diy_insert($user_group, $request, true);
			}
		} else {
			diy_insert($user_group, $request, true);
		}
	}
}