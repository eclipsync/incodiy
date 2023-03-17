<?php
namespace Incodiy\Codiy\Database\Seeders\Includes;

use Illuminate\Support\Facades\DB;
/**
 * Created on Dec 12, 2022
 * 
 * Time Created : 1:58:39 PM
 *
 * @filesource	Timezone.php
 *
 * @author     wisnuwidi@incodiy.com - 2022
 * @copyright  wisnuwidi
 * @email      wisnuwidi@incodiy.com
 */
trait Timezone {
	
	private function insertTimezone() {
		// TIMEZONE TABLE
		DB::table('base_timezone')->delete();
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Accra']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Addis_Ababa']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Algiers']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Asmera']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Bamako']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Bangui']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Banjul']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Bissau']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Blantyre']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Brazzaville']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Bujumbura']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Cairo']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Casablanca']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Ceuta']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Conakry']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Dakar']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Dar_es_Salaam']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Djibouti']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Douala']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/El_Aaiun']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Freetown']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Gaborone']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Harare']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Johannesburg']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Kampala']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Khartoum']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Kigali']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Kinshasa']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Lagos']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Libreville']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Lome']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Luanda']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Lubumbashi']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Lusaka']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Malabo']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Maputo']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Maseru']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Mbabane']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Mogadishu']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Monrovia']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Nairobi']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Ndjamena']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Niamey']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Nouakchott']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Ouagadougou']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Porto-Novo']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Sao_Tome']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Tripoli']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Tunis']);
		DB::table('base_timezone')->insert(['timezone' => 'Africa/Windhoek']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Adak']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Anchorage']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Anguilla']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Antigua']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Araguaina']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Argentina/La_Rioja']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Argentina/Rio_Gallegos']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Argentina/San_Juan']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Argentina/Tucuman']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Argentina/Ushuaia']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Aruba']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Asuncion']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Bahia']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Barbados']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Belem']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Belize']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Blanc-Sablon']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Boa_Vista']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Bogota']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Boise']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Buenos_Aires']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Cambridge_Bay']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Campo_Grande']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Cancun']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Caracas']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Catamarca']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Cayenne']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Cayman']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Chicago']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Chihuahua']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Coral_Harbour']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Cordoba']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Costa_Rica']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Cuiaba']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Curacao']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Danmarkshavn']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Dawson']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Dawson_Creek']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Denver']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Detroit']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Dominica']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Edmonton']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Eirunepe']);
		DB::table('base_timezone')->insert(['timezone' => 'America/El_Salvador']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Fortaleza']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Glace_Bay']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Godthab']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Goose_Bay']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Grand_Turk']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Grenada']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Guadeloupe']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Guatemala']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Guayaquil']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Guyana']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Halifax']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Havana']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Hermosillo']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Indiana/Knox']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Indiana/Marengo']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Indiana/Petersburg']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Indiana/Vevay']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Indiana/Vincennes']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Indianapolis']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Inuvik']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Iqaluit']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Jamaica']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Jujuy']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Juneau']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Kentucky/Monticello']);
		DB::table('base_timezone')->insert(['timezone' => 'America/La_Paz']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Lima']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Los_Angeles']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Louisville']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Maceio']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Managua']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Manaus']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Martinique']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Mazatlan']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Mendoza']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Menominee']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Merida']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Mexico_City']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Miquelon']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Moncton']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Monterrey']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Montevideo']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Montreal']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Montserrat']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Nassau']);
		DB::table('base_timezone')->insert(['timezone' => 'America/New_York']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Nipigon']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Nome']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Noronha']);
		DB::table('base_timezone')->insert(['timezone' => 'America/North_Dakota/Center']);
		DB::table('base_timezone')->insert(['timezone' => 'America/North_Dakota/New_Salem']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Panama']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Pangnirtung']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Paramaribo']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Phoenix']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Port-au-Prince']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Port_of_Spain']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Porto_Velho']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Puerto_Rico']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Rainy_River']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Rankin_Inlet']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Recife']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Regina']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Rio_Branco']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Santiago']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Santo_Domingo']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Sao_Paulo']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Scoresbysund']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Shiprock']);
		DB::table('base_timezone')->insert(['timezone' => 'America/St_Johns']);
		DB::table('base_timezone')->insert(['timezone' => 'America/St_Kitts']);
		DB::table('base_timezone')->insert(['timezone' => 'America/St_Lucia']);
		DB::table('base_timezone')->insert(['timezone' => 'America/St_Thomas']);
		DB::table('base_timezone')->insert(['timezone' => 'America/St_Vincent']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Swift_Current']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Tegucigalpa']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Thule']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Thunder_Bay']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Tijuana']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Toronto']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Tortola']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Vancouver']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Whitehorse']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Winnipeg']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Yakutat']);
		DB::table('base_timezone')->insert(['timezone' => 'America/Yellowknife']);
		DB::table('base_timezone')->insert(['timezone' => 'Antarctica/Casey']);
		DB::table('base_timezone')->insert(['timezone' => 'Antarctica/Davis']);
		DB::table('base_timezone')->insert(['timezone' => 'Antarctica/DumontDUrville']);
		DB::table('base_timezone')->insert(['timezone' => 'Antarctica/Mawson']);
		DB::table('base_timezone')->insert(['timezone' => 'Antarctica/McMurdo']);
		DB::table('base_timezone')->insert(['timezone' => 'Antarctica/Palmer']);
		DB::table('base_timezone')->insert(['timezone' => 'Antarctica/Rothera']);
		DB::table('base_timezone')->insert(['timezone' => 'Antarctica/Syowa']);
		DB::table('base_timezone')->insert(['timezone' => 'Antarctica/Vostok']);
		DB::table('base_timezone')->insert(['timezone' => 'Asia/Aden']);
		DB::table('base_timezone')->insert(['timezone' => 'Asia/Almaty']);
		DB::table('base_timezone')->insert(['timezone' => 'Asia/Amman']);
		DB::table('base_timezone')->insert(['timezone' => 'Asia/Anadyr']);
		DB::table('base_timezone')->insert(['timezone' => 'Asia/Aqtau']);
		DB::table('base_timezone')->insert(['timezone' => 'Asia/Aqtobe']);
		DB::table('base_timezone')->insert(['timezone' => 'Asia/Ashgabat']);
		DB::table('base_timezone')->insert(['timezone' => 'Asia/Baghdad']);
		DB::table('base_timezone')->insert(['timezone' => 'Asia/Bahrain']);
		DB::table('base_timezone')->insert(['timezone' => 'Asia/Baku']);
		DB::table('base_timezone')->insert(['timezone' => 'Asia/Bangkok']);
		DB::table('base_timezone')->insert(['timezone' => 'Asia/Beirut']);
		DB::table('base_timezone')->insert(['timezone' => 'Asia/Bishkek']);
		DB::table('base_timezone')->insert(['timezone' => 'Asia/Brunei']);
		DB::table('base_timezone')->insert(['timezone' => 'Asia/Calcutta']);
		DB::table('base_timezone')->insert(['timezone' => 'Asia/Choibalsan']);
		DB::table('base_timezone')->insert(['timezone' => 'Asia/Chongqing']);
		DB::table('base_timezone')->insert(['timezone' => 'Asia/Colombo']);
		DB::table('base_timezone')->insert(['timezone' => 'Asia/Damascus']);
		DB::table('base_timezone')->insert(['timezone' => 'Asia/Dhaka']);
		DB::table('base_timezone')->insert(['timezone' => 'Asia/Dili']);
		DB::table('base_timezone')->insert(['timezone' => 'Asia/Dubai']);
		DB::table('base_timezone')->insert(['timezone' => 'Asia/Dushanbe']);
		DB::table('base_timezone')->insert(['timezone' => 'Asia/Gaza']);
		DB::table('base_timezone')->insert(['timezone' => 'Asia/Harbin']);
		DB::table('base_timezone')->insert(['timezone' => 'Asia/Hong_Kong']);
		DB::table('base_timezone')->insert(['timezone' => 'Asia/Hovd']);
		DB::table('base_timezone')->insert(['timezone' => 'Asia/Irkutsk']);
		DB::table('base_timezone')->insert(['timezone' => 'Asia/Jakarta']);
		DB::table('base_timezone')->insert(['timezone' => 'Asia/Jayapura']);
		DB::table('base_timezone')->insert(['timezone' => 'Asia/Jerusalem']);
		DB::table('base_timezone')->insert(['timezone' => 'Asia/Kabul']);
		DB::table('base_timezone')->insert(['timezone' => 'Asia/Kamchatka']);
		DB::table('base_timezone')->insert(['timezone' => 'Asia/Karachi']);
		DB::table('base_timezone')->insert(['timezone' => 'Asia/Kashgar']);
		DB::table('base_timezone')->insert(['timezone' => 'Asia/Katmandu']);
		DB::table('base_timezone')->insert(['timezone' => 'Asia/Krasnoyarsk']);
		DB::table('base_timezone')->insert(['timezone' => 'Asia/Kuala_Lumpur']);
		DB::table('base_timezone')->insert(['timezone' => 'Asia/Kuching']);
		DB::table('base_timezone')->insert(['timezone' => 'Asia/Kuwait']);
		DB::table('base_timezone')->insert(['timezone' => 'Asia/Macau']);
		DB::table('base_timezone')->insert(['timezone' => 'Asia/Magadan']);
	}
}