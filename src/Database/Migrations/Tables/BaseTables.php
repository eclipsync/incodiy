<?php
namespace Incodiy\Codiy\Database\Migrations\Tables;

use Illuminate\Database\Schema\Blueprint;
use Incodiy\Codiy\Database\Migrations\Config;
/**
 * Created on Dec 17, 2022
 *
 * Time Created : 3:10:43 AM
 * Filename : BaseTables.php
 *
 * @filesource BaseTables.php
 *            
 * @author    wisnuwidi @Incodiy - 2022
 * @copyright wisnuwidi
 * @email     wisnuwidi@incodiy.com
 */
class BaseTables extends Config {
	
	public function __construct() {
		$this->schema();
	}
	
	public function up() {
		if (true === $this->is_multiplatform) {
			$this->multiple_modular_tables();
			$this->multiple_main_tables();
			$this->multiple_relation_tables();
		} else {
			$this->multiple_main_tables();
			$this->multiple_relation_tables();
		}
		$this->extract_transform_and_load_table();
	}
	
	public function drop() {
		// RELATIONAL
		$this->schema::dropIfExists('base_page_privilege');
		$this->schema::dropIfExists('base_group_privilege');
		$this->schema::dropIfExists('base_user_group');
		
		// BASE ( MAIN ) TABLES
		$this->schema::dropIfExists('base_module');
		$this->schema::dropIfExists('base_group');
		$this->schema::dropIfExists('base_language');
		$this->schema::dropIfExists('base_timezone');
		$this->schema::dropIfExists('base_postal_code');
		$this->schema::dropIfExists('base_preference');
		$this->schema::dropIfExists('base_icon');
		$this->schema::dropIfExists('base_maintenance');
		if (true === $this->is_multiplatform) {
			$this->schema::dropIfExists('base_about');
			$this->schema::dropIfExists('base_teams');
			$this->schema::dropIfExists('base_contact');
			$this->schema::dropIfExists('base_faq');
			$this->schema::dropIfExists('tapi_client');
		}
		
		if (true === $this->is_multiplatform) {
			// APPROVALS
			$this->schema::dropIfExists('base_banners');
			$this->schema::dropIfExists('base_approval_banners');
			$this->schema::dropIfExists('mod_banners');
			$this->schema::dropIfExists('base_banners_type');
			$this->schema::dropIfExists('base_articles');
			$this->schema::dropIfExists('base_approval_articles');
			$this->schema::dropIfExists('mod_articles');
			$this->schema::dropIfExists('base_articles_type');
			
			// MODULARS
			$this->schema::dropIfExists('mod_articles');
			$this->schema::dropIfExists('mod_sholat_jadwal');
			$this->schema::dropIfExists('mod_sholat_imam');
			$this->schema::dropIfExists('mod_kajian_jadwal');
			$this->schema::dropIfExists('mod_kajian_pengisi');
			$this->schema::dropIfExists('mod_messages');
		}
		
		if (true === $this->is_multiplatform) {
			$this->schema::dropIfExists('mod_ziswaf');
			$this->schema::dropIfExists('mod_ziswaf_status');
			$this->schema::dropIfExists('mod_ziswaf_category');
			$this->schema::dropIfExists('mod_ziswaf_donation_type');
			
			$this->schema::dropIfExists('subscribers');
			$this->schema::dropIfExists('subscriber_token');
			$this->schema::dropIfExists('prayer_time_adjustment');
			
			// PLATFORM TABLES
			$this->schema::dropIfExists($this->platform_table);
			$this->schema::dropIfExists("{$this->platform_table}_type");
			$this->schema::dropIfExists("{$this->platform_table}_land_status");
		}
		
		$this->schema::dropIfExists('base_extransload');
	}
	
	public function last_drop() {
		$this->schema::dropIfExists('users');
		$this->schema::dropIfExists('log_activities');
	}
	
	private function multiple_main_tables() {
		// Web Preference
		$this->schema::create('base_preference', function (Blueprint $table) {
			$this->set_engine($table, $this->setEngine);
			
			$table->increments('id')->unsigned();

			// WEB IDENTITY
			$table->string('title', 30)->nullable();
			$table->string('sub_title', 150)->nullable();
			$table->text('logo')->nullable();
			$table->text('logo_thumb')->nullable();
			$table->text('header')->nullable();
			$table->text('footer')->nullable();
			$table->string('template', 150)->nullable();
			$table->string('language', 150)->nullable();
			$table->string('timezone', 150)->nullable();

			// SESSIONS
			$table->string('session_name', '100')->nullable();
			$table->integer('session_lifetime')->nullable();

			// SEO
			$table->string('meta_author', 50)->nullable();
			$table->string('meta_title', 255)->nullable();
			$table->text('meta_keywords')->nullable();
			$table->text('meta_description')->nullable();

			// CONTACT EMAIL
			$table->string('email_person', 100)->nullable();
			$table->string('email_address', 255)->nullable();

			// SMTP
			$table->string('smtp_host', 255)->nullable();
			$table->integer('smtp_port')->nullable();
			$table->smallInteger('smtp_secure')->nullable();
			$table->string('smtp_user', 255)->nullable();
			$table->string('smtp_password', 255)->nullable();

			// LOGIN PREFERENCES
			$table->string('login_title', 50)->nullable();
			$table->text('login_background')->nullable();
			$table->text('login_background_thumb')->nullable();
			$table->integer('login_attempts')->nullable();
			$table->smallInteger('change_password')->nullable();

			// MAINTENANCE
			$table->smallInteger('debug')->nullable();
			$table->smallInteger('maintenance')->nullable();
		});

		// Users Table
		$this->schema::create('users', function (Blueprint $table) {
			$this->set_engine($table, $this->setEngine);

			$table->bigInteger('id', true)->unsigned();

			$table->string('username', 150);
			$table->string('fullname', 150)->nullable();
			$table->string('alias', 150)->nullable();
			$table->string('email')->unique();
			$table->timestamp('email_verified_at')->nullable();
			$table->string('password');

			$table->string('gender', 5)->nullable();
			$table->date('birth_date')->nullable();
			$table->string('birth_place', 50)->nullable();
			$table->string('photo')->nullable();
			$table->string('photo_thumb')->nullable();
			$table->string('file_info')->nullable();
			$table->text('address')->nullable();
			$table->string('phone', 20)->nullable();
			$table->string('language', 10)->nullable();

			$table->string('timezone', 20)->nullable();
			$table->string('ip_address', 20)->unique()->nullable();
			$table->string('first_route', 100)->nullable();

			$table->dateTime('reg_date')->nullable();
			$table->dateTime('last_visit_date')->nullable();
			$table->dateTime('past_visit_date')->nullable();
			$table->rememberToken();

			$table->smallInteger('change_password')->nullable();
			$table->dateTime('last_change_password_date')->nullable();
			$table->dateTime('expire_date')->nullable();
			$table->text('cryptcode')->nullable();
			
			$table->bigInteger('created_by');
			$table->bigInteger('updated_by')->nullable();
			$table->timestamps();
			
			$table->softDeletes();
			$table->smallInteger('active')->default(0);
			
			$table->index('username');
			$table->index('email');
			$table->index('cryptcode');
		});

		// Groups Table
		$this->schema::create('base_group', function (Blueprint $table) {
			$this->set_engine($table, $this->setEngine);

			$table->increments('id')->unsigned();

			$table->string('group_name', 30);
			$table->text('group_alias')->nullable();
			$table->text('group_info')->nullable();
			if (true === $this->is_multiplatform) $table->bigInteger($this->platform_key)->unsigned();

			$table->smallInteger('active')->default(0);
			$table->softDeletes();

			$table->index('group_name');
			if (true === $this->is_multiplatform) $table->index($this->platform_key);
			if (true === $this->is_multiplatform) $table->foreign($this->platform_key)->references('id')->on($this->platform_table)->onUpdate('cascade')->onDelete('cascade');
		});

		// Module Table
		$this->schema::create('base_module', function (Blueprint $table) {
			$this->set_engine($table, $this->setEngine);

			$table->increments('id')->unsigned();

			$table->string('route_path', 50);
			$table->string('parent_name', 50)->nullable();
			$table->string('module_name', 50)->nullable();
			$table->text('module_info')->nullable();
			$table->text('icon')->nullable();

			$table->string('menu_sort', 20)->nullable();
			$table->smallInteger('flag_status')->default(0);
			$table->smallInteger('active')->default(0);
			$table->softDeletes();
		});

		// Language Table
		$this->schema::create('base_language', function (Blueprint $table) {
			$this->set_engine($table, $this->setEngine);

			$table->string('abbr', 10)->nullable();
			$table->string('lang', 5)->nullable();
			$table->string('language', 150)->nullable();
			$table->string('charset', 10)->nullable();

			$table->primary('abbr');
			$table->index('lang');
		});

		// Timezone Table
		$this->schema::create('base_timezone', function (Blueprint $table) {
			$this->set_engine($table, $this->setEngine);

			$table->increments('id')->unsigned();
			$table->string('timezone', 30)->nullable();
		});

		// Log Activities
		$this->schema::create('log_activities', function (Blueprint $table) {
			$this->set_engine($table, $this->setEngine);

			$table->bigIncrements('id')->unsigned();

			$table->integer('user_id');
			$table->string('username')->nullable();
			$table->string('user_fullname')->nullable();
			$table->string('user_email')->nullable();

			$table->string('user_group_id');
			$table->string('user_group_name')->nullable();
			$table->string('user_group_info')->nullable();

			$table->string('route_path')->nullable();
			$table->string('module_name')->nullable();
			$table->string('page_info')->nullable();
			$table->text('urli')->nullable();
			$table->string('method', 8)->nullable();

			$table->string('ip_address', 300)->nullable();
			$table->string('user_agent')->nullable();
			$table->text('sql_dump')->nullable();

			$table->index('user_id');
			$table->index('user_group_id');

			$table->timestamps();
		});

		// Icon
		$this->schema::create('base_icon', function (Blueprint $table) {
			$this->set_engine($table, $this->setEngine);

			$table->bigIncrements('id')->unsigned();
			$table->string('type');
			$table->string('tag');
			$table->string('class');
			$table->string('label');

			$table->smallInteger('active')->default(0);
			$table->softDeletes();

			$table->timestamps();
		});

		// POSTAL CODE TABLE
		$this->schema::create('base_postal_code', function (Blueprint $table) {
			$this->set_engine($table, $this->setEngine);

			$table->increments('id')->unsigned();

			// WEB IDENTITY
			$table->string('province', 80);
			$table->string('regency', 100)->nullable();
			$table->string('sub_district', 100)->nullable();
			$table->string('urban_village', 100)->nullable();
			$table->string('postal_code', 5)->nullable();

			$table->index('postal_code');
			$table->timestamps();
		});

		// MAINTENANCE
		$this->schema::create('base_maintenance', function (Blueprint $table) {
			$this->set_engine($table, $this->setEngine);

			$table->increments('id')->unsigned();
			$table->string('title', 100);
			$table->text('description');
			$table->text('logo')->nullable();
			$table->text('logo_thumb')->nullable();
			$table->text('image')->nullable();
			$table->text('image_thumb')->nullable();
			$table->string('time_duration', 100);
			$table->smallInteger('subscribe_button')->default(0);
			$table->text('subscribe_text')->nullable();
			$table->smallInteger('status')->default(0);

			$table->timestamps();
			$table->softDeletes();
		});

		if (true === $this->is_multiplatform) {
			// Messages Table
			$this->schema::create('mod_messages', function (Blueprint $table) {
				$this->set_engine($table, $this->setEngine);

				$table->increments('id')->unsigned();
				$table->bigInteger($this->platform_key)->unsigned()->nullable();
				$table->bigInteger('user_id')->unsigned()->nullable();

				$table->string('from', 250)->nullable();
				$table->string('subject', 250);
				$table->text('message')->nullable();
				$table->smallInteger('read_status')->default(0);

				$table->softDeletes();
				$table->timestamps();

				$table->index($this->platform_key);
				$table->index('user_id');

				$table->foreign($this->platform_key)->references('id')->on($this->platform_table)->onUpdate('cascade')->onDelete('cascade');
				$table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
			});
		}
	}
	private function multiple_relation_tables() {
		// User Group Table
		$this->schema::create('base_user_group', function (Blueprint $table) {
			$this->set_engine($table, $this->setEngine);

			$table->bigInteger('id', true)->unsigned();

			$table->bigInteger('user_id')->unsigned();
			$table->integer('group_id')->unsigned();

			$table->index('user_id');
			$table->index('group_id');

			$table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('group_id')->references('id')->on('base_group')->onUpdate('cascade')->onDelete('cascade');
		});

		// Group Privilege Table
		$this->schema::create('base_group_privilege', function (Blueprint $table) {
			$this->set_engine($table, $this->setEngine);

			$table->bigInteger('id', true)->unsigned();

			$table->integer('group_id')->unsigned();
			$table->integer('module_id')->unsigned();

			$table->string('admin_privilege', 7)->nullable();
			$table->string('index_privilege', 7)->nullable();

			$table->index('group_id');
			$table->index('module_id');

			$table->foreign('group_id')->references('id')->on('base_group')->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('module_id')->references('id')->on('base_module')->onUpdate('cascade')->onDelete('cascade');
		});

		// Mapping Page Privilege Table
		$this->schema::create('base_page_privilege', function (Blueprint $table) {
			$this->set_engine($table, $this->setEngine);

			$table->bigInteger('id', true)->unsigned();

			$table->integer('group_id')->unsigned();
			$table->integer('module_id')->unsigned();

			$table->string('target_table', 150)->nullable();
			$table->string('target_field_name', 50)->nullable();
			$table->text('target_field_values')->nullable();

			$table->index('group_id');
			$table->index('module_id');

			$table->foreign('group_id')->references('id')->on('base_group')->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('module_id')->references('id')->on('base_module')->onUpdate('cascade')->onDelete('cascade');
		});
	}
	
	private function multiple_modular_tables() {
		$this->schema::create("{$this->platform_table}_type", function (Blueprint $table) {
			$this->set_engine($table, $this->setEngine);

			$table->increments('id')->unsigned();
			$table->string('title', 80);
			$table->string('description', 80)->nullable();

			$table->smallInteger('active')->default(0);
			$table->softDeletes();

			$table->timestamps();
		});

		$this->schema::create("{$this->platform_table}_land_status", function (Blueprint $table) {
			$this->set_engine($table, $this->setEngine);

			$table->increments('id')->unsigned();
			$table->string('title', 80);
			$table->string('description', 80)->nullable();

			$table->smallInteger('active')->default(0);
			$table->softDeletes();

			$table->timestamps();
		});

		// MASJID TABLE
		$this->schema::create($this->platform_table, function (Blueprint $table) {
			$this->set_engine($table, $this->setEngine);

			$table->bigIncrements('id')->unsigned();

			// WEB IDENTITY
			$table->string('name', 30);
			$table->date('since')->nullable();
			$table->string('email', 50)->nullable();
			$table->string('phone', 20)->nullable();

			$table->text('images')->nullable();
			$table->text('images_thumb')->nullable();
			$table->string('latitude', 100)->nullable();
			$table->string('longitude', 100)->nullable();
			$table->string('postal_code', 5)->nullable();
			$table->string('urban_village', 100)->nullable();
			$table->string('sub_district', 100)->nullable();
			$table->string('regency', 100)->nullable();
			$table->string('province', 100)->nullable();
			$table->text('address')->nullable();

			$table->string('surface_area', 50)->nullable();
			$table->string('building_area', 50)->nullable();
			$table->string('people_volume', 50)->nullable();

			$table->integer('type_id')->unsigned()->nullable();
			$table->integer('land_status_id')->unsigned()->nullable();

			$table->text('description')->nullable();

			$table->smallInteger('active')->default(0);
			$table->softDeletes();

			$table->timestamps();

			$table->foreign('type_id')->references('id')->on("{$this->platform_table}_type")->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('land_status_id')->references('id')->on("{$this->platform_table}_land_status")->onUpdate('cascade')->onDelete('cascade');
		});

		// IMAM SHOLAT TABLE
		$this->schema::create('mod_sholat_imam', function (Blueprint $table) {
			$this->set_engine($table, $this->setEngine);

			$table->bigIncrements('id', true)->unsigned();
			$table->bigInteger($this->platform_key)->unsigned();

			$table->string('fullname', 100);
			$table->string('nickname', 50)->nullable();
			$table->date('birth_date')->nullable();
			$table->string('birth_place', 100)->nullable();

			$table->string('email', 150)->nullable();
			$table->string('phone', 15)->nullable();
			$table->text('photo')->nullable();
			$table->text('photo_thumb')->nullable();

			$table->smallInteger('active')->default(0);

			$table->timestamps();
			$table->softDeletes();

			$table->foreign($this->platform_key)->references('id')->on($this->platform_table)->onUpdate('cascade')->onDelete('cascade');
		});

		// JADWAL SHOLAT TABLE
		$this->schema::create('mod_sholat_jadwal', function (Blueprint $table) {
			$this->set_engine($table, $this->setEngine);

			$table->bigIncrements('id')->unsigned();
			$table->bigInteger($this->platform_key)->unsigned();
			$table->bigInteger('imam_id')->unsigned();

			$table->integer('imam_subuh')->unsigned();
			$table->integer('imam_dzuhur')->unsigned();
			$table->integer('imam_ashar')->unsigned();
			$table->integer('imam_maghrib')->unsigned();
			$table->integer('imam_isya')->unsigned();

			$table->text('event_name')->nullable();
			$table->date('open_period')->nullable();
			$table->date('closed_period')->nullable();
			$table->smallInteger('input_method')->default(0);
			$table->smallInteger('general_flag')->default(0);

			$table->foreign($this->platform_key)->references('id')->on($this->platform_table)->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('imam_id')->references('id')->on('mod_sholat_imam')->onUpdate('cascade')->onDelete('cascade');
		});

		// PENGISI KAJIAN TABLE
		$this->schema::create('mod_kajian_pengisi', function (Blueprint $table) {
			$this->set_engine($table, $this->setEngine);

			$table->bigIncrements('id', true)->unsigned();
			$table->bigInteger($this->platform_key)->unsigned();

			$table->string('fullname', 100);
			$table->string('nickname', 50)->nullable();
			$table->date('birth_date')->nullable();
			$table->string('birth_place', 100)->nullable();

			$table->string('email', 150)->nullable();
			$table->string('phone', 15)->nullable();
			$table->text('photo')->nullable();
			$table->text('photo_thumb')->nullable();

			$table->smallInteger('active')->default(0);

			$table->timestamps();
			$table->softDeletes();

			$table->index($this->platform_key);

			$table->foreign($this->platform_key)->references('id')->on($this->platform_table)->onUpdate('cascade')->onDelete('cascade');
		});

		// JADWAL KAJIAN TABLE
		$this->schema::create('mod_kajian_jadwal', function (Blueprint $table) {
			$this->set_engine($table, $this->setEngine);

			$table->bigIncrements('id')->unsigned();
			$table->bigInteger($this->platform_key)->unsigned();

			$table->bigInteger('pengisi_kajian_id')->unsigned();

			$table->string('topic', 10);
			$table->string('image', 280);
			$table->string('file', 280);
			$table->string('file_thumb', 300);
			$table->text('description');
			$table->string('tags', 250);

			$table->string('durations', 100);
			$table->dateTime('start_date');
			$table->dateTime('end_date');

			$table->dateTime('start_reg');
			$table->dateTime('end_reg');

			$table->index('tags');
			$table->index($this->platform_key);

			$table->foreign($this->platform_key)->references('id')->on($this->platform_table)->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('pengisi_kajian_id')->references('id')->on('mod_kajian_pengisi')->onUpdate('cascade')->onDelete('cascade');
		});

		// APPROVALS MODULES
		$this->approvals_modules();

		// About Table
		$this->schema::create('base_about', function (Blueprint $table) {
			$this->set_engine($table, $this->setEngine);

			$table->increments('id')->unsigned();

			$table->string('title', 50);
			$table->text('content')->nullable();

			$table->smallInteger('active')->default(0);
			$table->softDeletes();

			$table->timestamps();
		});

		// Teams Table
		$this->schema::create('base_teams', function (Blueprint $table) {
			$this->set_engine($table, $this->setEngine);

			$table->increments('id')->unsigned();

			$table->string('name', 50);
			$table->string('job_title', 50);
			$table->text('photo')->nullable();
			$table->text('photo_thumb')->nullable();
			$table->string('gender', 5)->nullable();
			$table->string('facebook', 50)->nullable();
			$table->string('twitter', 50)->nullable();
			$table->string('website', 50)->nullable();
			$table->string('whatsapp', 50)->nullable();
			$table->string('phone', 50)->nullable();
			$table->string('address', 50)->nullable();
			$table->text('content')->nullable();

			$table->smallInteger('active')->default(0);
			$table->softDeletes();

			$table->timestamps();
		});

		// Contact Table
		$this->schema::create('base_contact', function (Blueprint $table) {
			$this->set_engine($table, $this->setEngine);

			$table->increments('id')->unsigned();

			$table->string('title', 50);
			$table->string('name', 50);
			$table->string('email', 50);
			$table->string('phone', 50);
			$table->text('message')->nullable();

			$table->smallInteger('active')->default(0);
			$table->softDeletes();

			$table->timestamps();
		});

		// FAQ Table
		$this->schema::create('base_faq', function (Blueprint $table) {
			$this->set_engine($table, $this->setEngine);

			$table->increments('id')->unsigned();

			$table->text('question')->nullable();
			$table->text('answer')->nullable();

			$table->smallInteger('active')->default(0);
			$table->softDeletes();

			$table->timestamps();
		});

		$this->schema::create('prayer_time_adjustment', function (Blueprint $table) {
			$this->set_engine($table, $this->setEngine);

			$table->increments('id')->unsigned();
			$table->integer($this->platform_key)->unsigned();

			$table->string('prayer_time_name', 25);
			$table->string('time_adjustment', 15);

			$table->smallInteger('is_default')->default(0);

			$table->timestamps();
			$table->softDeletes();
		});

		$this->schema::create('tapi_client', function (Blueprint $table) {
			$this->set_engine($table, $this->setEngine);

			$table->increments('id')->unsigned();
			$table->string('api_key', 255);
			$table->string('app_name', 255);
			$table->smallInteger('status')->default(0);

			$table->timestamps();
			$table->softDeletes();
		});

		$this->schema::create('subscribers', function (Blueprint $table) {
			$this->set_engine($table, $this->setEngine);

			$table->increments('subscriber_id')->unsigned();
			$table->string('full_name', 50)->nullable();
			$table->string('username', 25)->nullable();
			$table->string('email', 50)->nullable();
			$table->text('password')->nullable();
			$table->date('birthday')->nullable();
			$table->string('birth_place', 50)->nullable();
			$table->string('phone_identifier', 5)->nullable()->default(62);
			$table->string('phone_number', 25)->nullable();

			$table->smallInteger('status')->default(1);

			$table->timestamps();
			$table->softDeletes();
		});

		$this->schema::create('subscriber_token', function (Blueprint $table) {
			$this->set_engine($table, $this->setEngine);

			$table->increments('token_id')->unsigned();
			$table->integer('subscriber_id')->unsigned();
			$table->string('token', 255)->nullable();
			$table->smallInteger('status')->default(1);
			$table->timestamps();
		});

		// ZISWAF
		$this->schema::create('mod_ziswaf_category', function (Blueprint $table) {
			$this->set_engine($table, $this->setEngine);

			$table->increments('id')->unsigned();
			$table->string('name', 255)->nullable();
			$table->smallInteger('status')->default(1);
			$table->timestamps();
		});

		$this->schema::create('mod_ziswaf_donation_type', function (Blueprint $table) {
			$this->set_engine($table, $this->setEngine);

			$table->increments('id')->unsigned();
			$table->string('name', 255)->nullable();
			$table->smallInteger('status')->default(1);
			$table->timestamps();
		});

		$this->schema::create('mod_ziswaf_status', function (Blueprint $table) {
			$this->set_engine($table, $this->setEngine);

			$table->increments('id')->unsigned();
			$table->string('name', 255)->nullable();
			$table->smallInteger('status')->default(1);
			$table->timestamps();
		});

		$this->schema::create('mod_ziswaf', function (Blueprint $table) {
			$this->set_engine($table, $this->setEngine);

			$table->increments('id')->unsigned();
			$table->integer('subs_id')->unsigned();

			$table->string('subscriber_alias', 100)->nullable();
			$table->string('trx_number', 255)->nullable();
			$table->text('payment_docs')->nullable();

			$table->integer('category_id')->unsigned();
			$table->integer('donation_type_id')->unsigned();

			$table->string('nominal_values', 80)->nullable();
			$table->string('nominal_extension', 25)->nullable();

			$table->text('notes')->nullable();
			$table->datetime('transfer_time');

			$table->smallInteger('status')->default(1);
			$table->timestamps();
			$table->softDeletes();

			$table->foreign('subs_id')->references('subscriber_id')->on('subscribers')->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('category_id')->references('id')->on('mod_ziswaf_category')->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('donation_type_id')->references('id')->on('mod_ziswaf_donation_type')->onUpdate('cascade')->onDelete('cascade');
		});
	}
	
	private function approvals_modules() {
		// BANNER TYPE
		$this->schema::create('base_banners_type', function (Blueprint $table) {
			$this->set_engine($table, $this->setEngine);

			$table->increments('id')->unsigned();
			$table->string('title', 80);
			$table->text('description')->nullable();

			$table->smallInteger('active')->default(0);
			$table->softDeletes();

			$table->timestamps();
		});

		// BANNER MODULE
		$this->schema::create('mod_banners', function (Blueprint $table) {
			$this->set_engine($table, $this->setEngine);

			$table->bigIncrements('id')->unsigned();
			$table->bigInteger($this->platform_key)->unsigned();

			$table->string('images', 280);
			$table->string('images_thumb', 300);

			$table->text('title_1')->nullable();
			$table->text('title_2')->nullable();
			$table->text('title_3')->nullable();
			$table->text('url')->nullable();
			$table->string('tags', 250)->nullable();

			$table->integer('banner_type')->unsigned()->nullable();
			$table->smallInteger('relational_flag')->default(0);
			$table->smallInteger('active')->default(0);

			$table->timestamps();
			$table->softDeletes();

			$table->index($this->platform_key);
			$table->index('banner_type');
			$table->index('tags');
			$table->index('relational_flag');

			$table->foreign($this->platform_key)->references('id')->on($this->platform_table)->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('banner_type')->references('id')->on('base_banners_type')->onUpdate('cascade')->onDelete('cascade');
		});

		// BANNER APPROVAL TABLE
		$this->schema::create('base_approval_banners', function (Blueprint $table) {
			$this->set_engine($table, $this->setEngine);

			$table->bigIncrements('id', true)->unsigned();

			$table->bigInteger('relation_id')->unsigned();
			$table->integer('request_status')->unsigned();
			$table->integer('update_status')->unsigned()->nullable();
			$table->text('logs')->nullable();

			$table->bigInteger('created_by')->nullable();
			$table->bigInteger('updated_by')->nullable();
			$table->timestamps();

			$table->index('relation_id');

			$table->foreign('relation_id')->references('id')->on('mod_banners')->onUpdate('cascade')->onDelete('cascade');
		});

		// BASE BANNER
		$this->schema::create('base_banners', function (Blueprint $table) {
			$this->set_engine($table, $this->setEngine);

			$table->bigIncrements('id')->unsigned();

			$table->index('banner_type');
			$table->bigInteger('approval_id')->unsigned()->nullable();

			$table->string('images', 280);
			$table->string('images_thumb', 300);

			$table->text('title_1')->nullable();
			$table->text('title_2')->nullable();
			$table->text('title_3')->nullable();
			$table->text('url')->nullable();
			$table->string('tags', 250)->nullable();

			$table->integer('banner_type')->unsigned()->nullable();
			$table->smallInteger('active')->default(0);

			$table->index('tags');

			$table->timestamps();
			$table->softDeletes();

			$table->foreign('banner_type')->references('id')->on('base_banners_type')->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('approval_id')->references('id')->on('base_approval_banners')->onUpdate('cascade')->onDelete('cascade');
		});

		// ARTICLE TYPE
		$this->schema::create('base_articles_type', function (Blueprint $table) {
			$this->set_engine($table, $this->setEngine);

			$table->increments('id')->unsigned();
			$table->string('title', 80);
			$table->text('description')->nullable();

			$table->smallInteger('active')->default(0);
			$table->softDeletes();

			$table->timestamps();
		});

		// ARTICLE MODULE
		$this->schema::create('mod_articles', function (Blueprint $table) {
			$this->set_engine($table, $this->setEngine);

			$table->bigIncrements('id')->unsigned();
			$table->bigInteger($this->platform_key)->unsigned();

			$table->string('title', 150);
			$table->string('title_uri', 180);
			$table->string('images', 250)->nullable();
			$table->string('images_thumb', 250)->nullable();
			$table->string('video', 250)->nullable();
			$table->string('file', 250)->nullable();
			$table->text('content')->nullable();

			$table->string('tags', 250)->nullable();
			$table->string('author', 250)->nullable();
			$table->string('author_alias', 250)->nullable();

			$table->bigInteger('hit');
			$table->smallInteger('sticky')->default(0);
			$table->smallInteger('share_button')->default(0);
			$table->smallInteger('enable_comment')->default(0);

			$table->integer('article_type')->unsigned()->nullable();
			$table->smallInteger('relational_flag')->default(0);
			$table->smallInteger('active')->default(0);

			$table->timestamps();
			$table->softDeletes();

			$table->index($this->platform_key);
			$table->index('article_type');
			$table->index('author');
			$table->index('title_uri');
			$table->index('tags');
			$table->index('relational_flag');

			$table->foreign($this->platform_key)->references('id')->on($this->platform_table)->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('article_type')->references('id')->on('base_articles_type')->onUpdate('cascade')->onDelete('cascade');
		});

		// ARTICLE APPROVAL TABLE
		$this->schema::create('base_approval_articles', function (Blueprint $table) {
			$this->set_engine($table, $this->setEngine);

			$table->bigIncrements('id', true)->unsigned();

			$table->bigInteger('relation_id')->unsigned();
			$table->integer('request_status')->unsigned();
			$table->integer('update_status')->unsigned()->nullable();
			$table->text('logs')->nullable();

			$table->bigInteger('created_by')->nullable();
			$table->bigInteger('updated_by')->nullable();
			$table->timestamps();

			$table->index('relation_id');

			$table->foreign('relation_id')->references('id')->on('mod_articles')->onUpdate('cascade')->onDelete('cascade');
		});

		// BASE BANNER
		$this->schema::create('base_articles', function (Blueprint $table) {
			$this->set_engine($table, $this->setEngine);

			$table->bigIncrements('id')->unsigned();
			$table->bigInteger('approval_id')->unsigned()->nullable();

			$table->string('title', 150);
			$table->string('title_uri', 180);
			$table->string('images', 250)->nullable();
			$table->string('images_thumb', 250)->nullable();
			$table->string('video', 250)->nullable();
			$table->string('file', 250)->nullable();
			$table->text('content')->nullable();

			$table->string('tags', 250)->nullable();
			$table->string('author', 250)->nullable();
			$table->string('author_alias', 250)->nullable();

			$table->bigInteger('hit');
			$table->smallInteger('sticky')->default(0);
			$table->smallInteger('share_button')->default(0);
			$table->smallInteger('enable_comment')->default(0);

			$table->integer('article_type')->unsigned()->nullable();
			$table->smallInteger('relational_flag')->default(0);
			$table->smallInteger('active')->default(0);

			$table->index('article_type');
			$table->index('author');
			$table->index('title_uri');
			$table->index('tags');

			$table->timestamps();
			$table->softDeletes();

			$table->foreign('article_type')->references('id')->on('base_articles_type')->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('approval_id')->references('id')->on('base_approval_articles')->onUpdate('cascade')->onDelete('cascade');
		});
	}
	
	private function extract_transform_and_load_table() {
		// EXTRACT-TRANSFORM-&-LOAD TABLE
		$this->schema::create('base_extransload', function (Blueprint $table) {
			$this->set_engine($table, $this->setEngine);

			$table->bigIncrements('id', true)->unsigned();

			$table->string('process_name', 300);
			$table->text('remarks')->nullable();
			$table->string('source_connection_name', 80);
			$table->string('source_table_name', 200);
			$table->integer('source_data_counts')->nullable()->default(0);

			$table->string('target_connection_name', 80);
			$table->string('target_table_name', 200);
			$table->integer('target_current_counts')->nullable()->default(0);

			$table->integer('success_data_transfers')->nullable()->default(0);

			$table->bigInteger('created_by')->nullable();
			$table->bigInteger('updated_by')->nullable();
			$table->timestamps();

			$table->index('source_table_name');
			$table->index('target_table_name');
		});
	}
}