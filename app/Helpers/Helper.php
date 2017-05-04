<?php
/**
 * Created by PhpStorm.
 * User: Designer
 * Date: 08.10.2016
 * Time: 18:02
 */

namespace App\Helpers;

use App\User;

use Carbon\Carbon;

use Auth;

use App\Category;

use App\Helpers;

use App\Library\Location;

use App\Library\Settings;

use Illuminate\Support\Facades\App;

use Illuminate\Support\Facades\Config;

class Helper
{

    public static $countries = [
        "AF" => "Afghanistan",
        "AL" => "Albania",
        "DZ" => "Algeria",
        "AS" => "American Samoa",
        "AD" => "Andorra",
        "AO" => "Angola",
        "AI" => "Anguilla",
        "AQ" => "Antarctica",
        "AG" => "Antigua and Barbuda",
        "AR" => "Argentina",
        "AM" => "Armenia",
        "AW" => "Aruba",
        "AU" => "Australia",
        "AT" => "Austria",
        "AZ" => "Azerbaijan",
        "BS" => "Bahamas",
        "BH" => "Bahrain",
        "BD" => "Bangladesh",
        "BB" => "Barbados",
        "BY" => "Belarus",
        "BE" => "Belgium",
        "BZ" => "Belize",
        "BJ" => "Benin",
        "BM" => "Bermuda",
        "BT" => "Bhutan",
        "BO" => "Bolivia",
        "BA" => "Bosnia and Herzegovina",
        "BW" => "Botswana",
        "BV" => "Bouvet Island",
        "BR" => "Brazil",
        "BQ" => "British Antarctic Territory",
        "IO" => "British Indian Ocean Territory",
        "VG" => "British Virgin Islands",
        "BN" => "Brunei",
        "BG" => "Bulgaria",
        "BF" => "Burkina Faso",
        "BI" => "Burundi",
        "KH" => "Cambodia",
        "CM" => "Cameroon",
        "CA" => "Canada",
        "CT" => "Canton and Enderbury Islands",
        "CV" => "Cape Verde",
        "KY" => "Cayman Islands",
        "CF" => "Central African Republic",
        "TD" => "Chad",
        "CL" => "Chile",
        "CN" => "China",
        "CX" => "Christmas Island",
        "CC" => "Cocos [Keeling] Islands",
        "CO" => "Colombia",
        "KM" => "Comoros",
        "CG" => "Congo - Brazzaville",
        "CD" => "Congo - Kinshasa",
        "CK" => "Cook Islands",
        "CR" => "Costa Rica",
        "HR" => "Croatia",
        "CU" => "Cuba",
        "CY" => "Cyprus",
        "CZ" => "Czech Republic",
        "CI" => "Côte d’Ivoire",
        "DK" => "Denmark",
        "DJ" => "Djibouti",
        "DM" => "Dominica",
        "DO" => "Dominican Republic",
        "NQ" => "Dronning Maud Land",
        "DD" => "East Germany",
        "EC" => "Ecuador",
        "EG" => "Egypt",
        "SV" => "El Salvador",
        "GQ" => "Equatorial Guinea",
        "ER" => "Eritrea",
        "EE" => "Estonia",
        "ET" => "Ethiopia",
        "FK" => "Falkland Islands",
        "FO" => "Faroe Islands",
        "FJ" => "Fiji",
        "FI" => "Finland",
        "FR" => "France",
        "GF" => "French Guiana",
        "PF" => "French Polynesia",
        "TF" => "French Southern Territories",
        "FQ" => "French Southern and Antarctic Territories",
        "GA" => "Gabon",
        "GM" => "Gambia",
        "GE" => "Georgia",
        "DE" => "Germany",
        "GH" => "Ghana",
        "GI" => "Gibraltar",
        "GR" => "Greece",
        "GL" => "Greenland",
        "GD" => "Grenada",
        "GP" => "Guadeloupe",
        "GU" => "Guam",
        "GT" => "Guatemala",
        "GG" => "Guernsey",
        "GN" => "Guinea",
        "GW" => "Guinea-Bissau",
        "GY" => "Guyana",
        "HT" => "Haiti",
        "HM" => "Heard Island and McDonald Islands",
        "HN" => "Honduras",
        "HK" => "Hong Kong SAR China",
        "HU" => "Hungary",
        "IS" => "Iceland",
        "IN" => "India",
        "ID" => "Indonesia",
        "IR" => "Iran",
        "IQ" => "Iraq",
        "IE" => "Ireland",
        "IM" => "Isle of Man",
        "IL" => "Israel",
        "IT" => "Italy",
        "JM" => "Jamaica",
        "JP" => "Japan",
        "JE" => "Jersey",
        "JT" => "Johnston Island",
        "JO" => "Jordan",
        "KZ" => "Kazakhstan",
        "KE" => "Kenya",
        "KI" => "Kiribati",
        "KW" => "Kuwait",
        "KG" => "Kyrgyzstan",
        "LA" => "Laos",
        "LV" => "Latvia",
        "LB" => "Lebanon",
        "LS" => "Lesotho",
        "LR" => "Liberia",
        "LY" => "Libya",
        "LI" => "Liechtenstein",
        "LT" => "Lithuania",
        "LU" => "Luxembourg",
        "MO" => "Macau SAR China",
        "MK" => "Macedonia",
        "MG" => "Madagascar",
        "MW" => "Malawi",
        "MY" => "Malaysia",
        "MV" => "Maldives",
        "ML" => "Mali",
        "MT" => "Malta",
        "MH" => "Marshall Islands",
        "MQ" => "Martinique",
        "MR" => "Mauritania",
        "MU" => "Mauritius",
        "YT" => "Mayotte",
        "FX" => "Metropolitan France",
        "MX" => "Mexico",
        "FM" => "Micronesia",
        "MI" => "Midway Islands",
        "MD" => "Moldova",
        "MC" => "Monaco",
        "MN" => "Mongolia",
        "ME" => "Montenegro",
        "MS" => "Montserrat",
        "MA" => "Morocco",
        "MZ" => "Mozambique",
        "MM" => "Myanmar [Burma]",
        "NA" => "Namibia",
        "NR" => "Nauru",
        "NP" => "Nepal",
        "NL" => "Netherlands",
        "AN" => "Netherlands Antilles",
        "NT" => "Neutral Zone",
        "NC" => "New Caledonia",
        "NZ" => "New Zealand",
        "NI" => "Nicaragua",
        "NE" => "Niger",
        "NG" => "Nigeria",
        "NU" => "Niue",
        "NF" => "Norfolk Island",
        "KP" => "North Korea",
        "VD" => "North Vietnam",
        "MP" => "Northern Mariana Islands",
        "NO" => "Norway",
        "OM" => "Oman",
        "PC" => "Pacific Islands Trust Territory",
        "PK" => "Pakistan",
        "PW" => "Palau",
        "PS" => "Palestinian Territories",
        "PA" => "Panama",
        "PZ" => "Panama Canal Zone",
        "PG" => "Papua New Guinea",
        "PY" => "Paraguay",
        "YD" => "People's Democratic Republic of Yemen",
        "PE" => "Peru",
        "PH" => "Philippines",
        "PN" => "Pitcairn Islands",
        "PL" => "Poland",
        "PT" => "Portugal",
        "PR" => "Puerto Rico",
        "QA" => "Qatar",
        "RO" => "Romania",
        "RU" => "Russia",
        "RW" => "Rwanda",
        "RE" => "Réunion",
        "BL" => "Saint Barthélemy",
        "SH" => "Saint Helena",
        "KN" => "Saint Kitts and Nevis",
        "LC" => "Saint Lucia",
        "MF" => "Saint Martin",
        "PM" => "Saint Pierre and Miquelon",
        "VC" => "Saint Vincent and the Grenadines",
        "WS" => "Samoa",
        "SM" => "San Marino",
        "SA" => "Saudi Arabia",
        "SN" => "Senegal",
        "RS" => "Serbia",
        "CS" => "Serbia and Montenegro",
        "SC" => "Seychelles",
        "SL" => "Sierra Leone",
        "SG" => "Singapore",
        "SK" => "Slovakia",
        "SI" => "Slovenia",
        "SB" => "Solomon Islands",
        "SO" => "Somalia",
        "ZA" => "South Africa",
        "GS" => "South Georgia and the South Sandwich Islands",
        "KR" => "South Korea",
        "ES" => "Spain",
        "LK" => "Sri Lanka",
        "SD" => "Sudan",
        "SR" => "Suriname",
        "SJ" => "Svalbard and Jan Mayen",
        "SZ" => "Swaziland",
        "SE" => "Sweden",
        "CH" => "Switzerland",
        "SY" => "Syria",
        "ST" => "São Tomé and Príncipe",
        "TW" => "Taiwan",
        "TJ" => "Tajikistan",
        "TZ" => "Tanzania",
        "TH" => "Thailand",
        "TL" => "Timor-Leste",
        "TG" => "Togo",
        "TK" => "Tokelau",
        "TO" => "Tonga",
        "TT" => "Trinidad and Tobago",
        "TN" => "Tunisia",
        "TR" => "Turkey",
        "TM" => "Turkmenistan",
        "TC" => "Turks and Caicos Islands",
        "TV" => "Tuvalu",
        "UM" => "U.S. Minor Outlying Islands",
        "PU" => "U.S. Miscellaneous Pacific Islands",
        "VI" => "U.S. Virgin Islands",
        "UG" => "Uganda",
        "UA" => "Ukraine",
        "SU" => "Union of Soviet Socialist Republics",
        "AE" => "United Arab Emirates",
        "GB" => "United Kingdom",
        "US" => "United States",
        "ZZ" => "Unknown or Invalid Region",
        "UY" => "Uruguay",
        "UZ" => "Uzbekistan",
        "VU" => "Vanuatu",
        "VA" => "Vatican City",
        "VE" => "Venezuela",
        "VN" => "Vietnam",
        "WK" => "Wake Island",
        "WF" => "Wallis and Futuna",
        "EH" => "Western Sahara",
        "YE" => "Yemen",
        "ZM" => "Zambia",
        "ZW" => "Zimbabwe",
        "AX" => "Åland Islands",
        "NONE" => "Select country"
    ];

    public static $codes = [
        'BD' => '880',
        'BE' => '32',
        'BF' => '226',
        'BG' => '359',
        'BA' => '387',
        'BB' => '+1-246',
        'WF' => '681',
        'BL' => '590',
        'BM' => '+1-441',
        'BN' => '673',
        'BO' => '591',
        'BH' => '973',
        'BI' => '257',
        'BJ' => '229',
        'BT' => '975',
        'JM' => '+1-876',
        'BV' => '',
        'BW' => '267',
        'WS' => '685',
        'BQ' => '599',
        'BR' => '55',
        'BS' => '+1-242',
        'JE' => '+44-1534',
        'BY' => '375',
        'BZ' => '501',
        'RU' => '7',
        'RW' => '250',
        'RS' => '381',
        'TL' => '670',
        'RE' => '262',
        'TM' => '993',
        'TJ' => '992',
        'RO' => '40',
        'TK' => '690',
        'GW' => '245',
        'GU' => '+1-671',
        'GT' => '502',
        'GS' => '',
        'GR' => '30',
        'GQ' => '240',
        'GP' => '590',
        'JP' => '81',
        'GY' => '592',
        'GG' => '+44-1481',
        'GF' => '594',
        'GE' => '995',
        'GD' => '+1-473',
        'GB' => '44',
        'GA' => '241',
        'SV' => '503',
        'GN' => '224',
        'GM' => '220',
        'GL' => '299',
        'GI' => '350',
        'GH' => '233',
        'OM' => '968',
        'TN' => '216',
        'JO' => '962',
        'HR' => '385',
        'HT' => '509',
        'HU' => '36',
        'HK' => '852',
        'HN' => '504',
        'HM' => ' ',
        'VE' => '58',
        'PR' => '+1-787 and 1-939',
        'PS' => '970',
        'PW' => '680',
        'PT' => '351',
        'SJ' => '47',
        'PY' => '595',
        'IQ' => '964',
        'PA' => '507',
        'PF' => '689',
        'PG' => '675',
        'PE' => '51',
        'PK' => '92',
        'PH' => '63',
        'PN' => '870',
        'PL' => '48',
        'PM' => '508',
        'ZM' => '260',
        'EH' => '212',
        'EE' => '372',
        'EG' => '20',
        'ZA' => '27',
        'EC' => '593',
        'IT' => '39',
        'VN' => '84',
        'SB' => '677',
        'ET' => '251',
        'SO' => '252',
        'ZW' => '263',
        'SA' => '966',
        'ES' => '34',
        'ER' => '291',
        'ME' => '382',
        'MD' => '373',
        'MG' => '261',
        'MF' => '590',
        'MA' => '212',
        'MC' => '377',
        'UZ' => '998',
        'MM' => '95',
        'ML' => '223',
        'MO' => '853',
        'MN' => '976',
        'MH' => '692',
        'MK' => '389',
        'MU' => '230',
        'MT' => '356',
        'MW' => '265',
        'MV' => '960',
        'MQ' => '596',
        'MP' => '+1-670',
        'MS' => '+1-664',
        'MR' => '222',
        'IM' => '+44-1624',
        'UG' => '256',
        'TZ' => '255',
        'MY' => '60',
        'MX' => '52',
        'IL' => '972',
        'FR' => '33',
        'IO' => '246',
        'SH' => '290',
        'FI' => '358',
        'FJ' => '679',
        'FK' => '500',
        'FM' => '691',
        'FO' => '298',
        'NI' => '505',
        'NL' => '31',
        'NO' => '47',
        'NA' => '264',
        'VU' => '678',
        'NC' => '687',
        'NE' => '227',
        'NF' => '672',
        'NG' => '234',
        'NZ' => '64',
        'NP' => '977',
        'NR' => '674',
        'NU' => '683',
        'CK' => '682',
        'XK' => '',
        'CI' => '225',
        'CH' => '41',
        'CO' => '57',
        'CN' => '86',
        'CM' => '237',
        'CL' => '56',
        'CC' => '61',
        'CA' => '1',
        'CG' => '242',
        'CF' => '236',
        'CD' => '243',
        'CZ' => '420',
        'CY' => '357',
        'CX' => '61',
        'CR' => '506',
        'CW' => '599',
        'CV' => '238',
        'CU' => '53',
        'SZ' => '268',
        'SY' => '963',
        'SX' => '599',
        'KG' => '996',
        'KE' => '254',
        'SS' => '211',
        'SR' => '597',
        'KI' => '686',
        'KH' => '855',
        'KN' => '+1-869',
        'KM' => '269',
        'ST' => '239',
        'SK' => '421',
        'KR' => '82',
        'SI' => '386',
        'KP' => '850',
        'KW' => '965',
        'SN' => '221',
        'SM' => '378',
        'SL' => '232',
        'SC' => '248',
        'KZ' => '7',
        'KY' => '+1-345',
        'SG' => '65',
        'SE' => '46',
        'SD' => '249',
        'DO' => '+1-809 and 1-829',
        'DM' => '+1-767',
        'DJ' => '253',
        'DK' => '45',
        'VG' => '+1-284',
        'DE' => '49',
        'YE' => '967',
        'DZ' => '213',
        'US' => '1',
        'UY' => '598',
        'YT' => '262',
        'UM' => '1',
        'LB' => '961',
        'LC' => '+1-758',
        'LA' => '856',
        'TV' => '688',
        'TW' => '886',
        'TT' => '+1-868',
        'TR' => '90',
        'LK' => '94',
        'LI' => '423',
        'LV' => '371',
        'TO' => '676',
        'LT' => '370',
        'LU' => '352',
        'LR' => '231',
        'LS' => '266',
        'TH' => '66',
        'TF' => '',
        'TG' => '228',
        'TD' => '235',
        'TC' => '+1-649',
        'LY' => '218',
        'VA' => '379',
        'VC' => '+1-784',
        'AE' => '971',
        'AD' => '376',
        'AG' => '+1-268',
        'AF' => '93',
        'AI' => '+1-264',
        'VI' => '+1-340',
        'IS' => '354',
        'IR' => '98',
        'AM' => '374',
        'AL' => '355',
        'AO' => '244',
        'AQ' => '',
        'AS' => '+1-684',
        'AR' => '54',
        'AU' => '61',
        'AT' => '43',
        'AW' => '297',
        'IN' => '91',
        'AX' => '+358-18',
        'AZ' => '994',
        'IE' => '353',
        'ID' => '62',
        'UA' => '380',
        'QA' => '974',
        'MZ' => '258',
    ];

    public static function parseDateTime($datetime, $return)
    {
        $date = date('m/d/Y', strtotime($datetime));
        $time = date('H:i', strtotime($datetime));

        $arr = [
            "date" => $date,
            "time" => $time
        ];

        return $arr[$return];
    }


    public static function existsImage($url_image)
    {
        return (is_null($url_image)) ? "https://igpsblogs.files.wordpress.com/2015/10/no-image-available.gif?w=700" : url($url_image);
    }


    public static function activationStatusAccount($data, $type)
    {

        $filtered_phone = $data->activation()->where('type', 'phone');
        $filtered_email = $data->activation()->where('type', 'email');


        if ($filtered_email->get()->count() == 0) {
            return 0;
        }

        if ($filtered_phone->get()->count() == 0) {
            return 0;
        }

        $status = [
            "email" => $filtered_email->get()->first()->activated,
            "phone" => $filtered_phone->get()->first()->activated
        ];

        return $status[$type];
    }

    public static function forkPhone($phone, $type = "phone")
    {


        $p = explode(" ", $phone);

        $phone = (isset($p[1])) ? $p[1] : "";
        $code = (isset($p[0])) ? $p[0] : "";

        $arr = ["phone" => $phone, "code" => $code];

        return $arr[$type];

    }

    public static function changeTimeZone($date, $zone)
    {

        $_date = date("Y-m-d", strtotime($date));
        $_date = explode("-", $_date);

        $time = date("H:i:s", strtotime($date));
        $time = explode(":", $time);

        // Carbon::create($year, $month, $day, $hour, $minute, $second, $tz);
        return Carbon::create($_date[0], $_date[1], $_date[2], $time[0], $time[1], 00)->timezone($zone)->format("m/d/Y H:i:s");

    }

    public static function formatDatetimeFromString($string_date, $withFormat = false)
    {

        if (empty($string_date)) {
            return Carbon::now();
        }

        $date = Carbon::createFromFormat('m/d/Y', $string_date);

        if ($withFormat) {
            return $date->toDateString();
        }

        return $date->toDateTimeString();
    }

    public static function nickname($nickname)
    {

        return (empty($nickname)) ? "none" : $nickname;
    }

    public static function timezones()
    {

        return $timezones = [

            "-12" => "(GMT-12:00) International Date Line West",
            "-11" => "(GMT-11:00) Midway Island, Samoa",
            "-10" => "(GMT-10:00) Hawaii",
            "-9" => "(GMT-09:00) Alaska",
            "-8" => "(GMT-08:00) Pacific Time (US & Canada)",
            "-7" => "(GMT-07:00) Arizona",
            "-6" => "(GMT-06:00) Central America",
            "-5" => "(GMT-05:00) Eastern Time (US & Canada)",
            "-4" => "(GMT-04:00) Atlantic Time (Canada)",
            "-3.5" => "(GMT-03:30) Newfoundland",
            "-3" => "(GMT-03:00) Buenos Aires, Georgetown",
            "-2" => "(GMT-02:00) Mid-Atlantic",
            "-1" => "(GMT-01:00) Cape Verde Is.",
            "0" => "(GMT+00:00) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London",
            "1" => "(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna",
            "2" => "(GMT+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius",
            "3" => "(GMT+03:00) Moscow, St. Petersburg, Volgograd",
            "3.5" => "(GMT+03:30) Tehran",
            "4" => "(GMT+04:00) Abu Dhabi, Muscat",
            "4.5" => "(GMT+04:30) Kabul",
            "5" => "(GMT+05:00) Islamabad, Karachi, Tashkent",
            "5.5" => "(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi",
            "5.75" => "(GMT+05:45) Kathmandu",
            "6" => "(GMT+06:00) Almaty, Novosibirsk",
            "6.5" => "(GMT+06:30) Yangon (Rangoon)",
            "7" => "(GMT+07:00) Bangkok, Hanoi, Jakarta",
            "8" => "(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi",
            "9" => "(GMT+09:00) Osaka, Sapporo, Tokyo",
            "9.5" => "(GMT+09:30) Darwin",
            "10" => "(GMT+10:00) Canberra, Melbourne, Sydney",
            "11" => "(GMT+11:00) Magadan, Solomon Is., New Caledonia",
            "12" => "(GMT+12:00) Fiji, Kamchatka, Marshall Is.",
            "13" => "(GMT+13:00) Nuku'alofa"
        ];

    }

    public static function countryName($key)
    {

        $countries = [
            "AF" => "Afghanistan",
            "AL" => "Albania",
            "DZ" => "Algeria",
            "AS" => "American Samoa",
            "AD" => "Andorra",
            "AO" => "Angola",
            "AI" => "Anguilla",
            "AQ" => "Antarctica",
            "AG" => "Antigua and Barbuda",
            "AR" => "Argentina",
            "AM" => "Armenia",
            "AW" => "Aruba",
            "AU" => "Australia",
            "AT" => "Austria",
            "AZ" => "Azerbaijan",
            "BS" => "Bahamas",
            "BH" => "Bahrain",
            "BD" => "Bangladesh",
            "BB" => "Barbados",
            "BY" => "Belarus",
            "BE" => "Belgium",
            "BZ" => "Belize",
            "BJ" => "Benin",
            "BM" => "Bermuda",
            "BT" => "Bhutan",
            "BO" => "Bolivia",
            "BA" => "Bosnia and Herzegovina",
            "BW" => "Botswana",
            "BV" => "Bouvet Island",
            "BR" => "Brazil",
            "BQ" => "British Antarctic Territory",
            "IO" => "British Indian Ocean Territory",
            "VG" => "British Virgin Islands",
            "BN" => "Brunei",
            "BG" => "Bulgaria",
            "BF" => "Burkina Faso",
            "BI" => "Burundi",
            "KH" => "Cambodia",
            "CM" => "Cameroon",
            "CA" => "Canada",
            "CT" => "Canton and Enderbury Islands",
            "CV" => "Cape Verde",
            "KY" => "Cayman Islands",
            "CF" => "Central African Republic",
            "TD" => "Chad",
            "CL" => "Chile",
            "CN" => "China",
            "CX" => "Christmas Island",
            "CC" => "Cocos [Keeling] Islands",
            "CO" => "Colombia",
            "KM" => "Comoros",
            "CG" => "Congo - Brazzaville",
            "CD" => "Congo - Kinshasa",
            "CK" => "Cook Islands",
            "CR" => "Costa Rica",
            "HR" => "Croatia",
            "CU" => "Cuba",
            "CY" => "Cyprus",
            "CZ" => "Czech Republic",
            "CI" => "Côte d’Ivoire",
            "DK" => "Denmark",
            "DJ" => "Djibouti",
            "DM" => "Dominica",
            "DO" => "Dominican Republic",
            "NQ" => "Dronning Maud Land",
            "DD" => "East Germany",
            "EC" => "Ecuador",
            "EG" => "Egypt",
            "SV" => "El Salvador",
            "GQ" => "Equatorial Guinea",
            "ER" => "Eritrea",
            "EE" => "Estonia",
            "ET" => "Ethiopia",
            "FK" => "Falkland Islands",
            "FO" => "Faroe Islands",
            "FJ" => "Fiji",
            "FI" => "Finland",
            "FR" => "France",
            "GF" => "French Guiana",
            "PF" => "French Polynesia",
            "TF" => "French Southern Territories",
            "FQ" => "French Southern and Antarctic Territories",
            "GA" => "Gabon",
            "GM" => "Gambia",
            "GE" => "Georgia",
            "DE" => "Germany",
            "GH" => "Ghana",
            "GI" => "Gibraltar",
            "GR" => "Greece",
            "GL" => "Greenland",
            "GD" => "Grenada",
            "GP" => "Guadeloupe",
            "GU" => "Guam",
            "GT" => "Guatemala",
            "GG" => "Guernsey",
            "GN" => "Guinea",
            "GW" => "Guinea-Bissau",
            "GY" => "Guyana",
            "HT" => "Haiti",
            "HM" => "Heard Island and McDonald Islands",
            "HN" => "Honduras",
            "HK" => "Hong Kong SAR China",
            "HU" => "Hungary",
            "IS" => "Iceland",
            "IN" => "India",
            "ID" => "Indonesia",
            "IR" => "Iran",
            "IQ" => "Iraq",
            "IE" => "Ireland",
            "IM" => "Isle of Man",
            "IL" => "Israel",
            "IT" => "Italy",
            "JM" => "Jamaica",
            "JP" => "Japan",
            "JE" => "Jersey",
            "JT" => "Johnston Island",
            "JO" => "Jordan",
            "KZ" => "Kazakhstan",
            "KE" => "Kenya",
            "KI" => "Kiribati",
            "KW" => "Kuwait",
            "KG" => "Kyrgyzstan",
            "LA" => "Laos",
            "LV" => "Latvia",
            "LB" => "Lebanon",
            "LS" => "Lesotho",
            "LR" => "Liberia",
            "LY" => "Libya",
            "LI" => "Liechtenstein",
            "LT" => "Lithuania",
            "LU" => "Luxembourg",
            "MO" => "Macau SAR China",
            "MK" => "Macedonia",
            "MG" => "Madagascar",
            "MW" => "Malawi",
            "MY" => "Malaysia",
            "MV" => "Maldives",
            "ML" => "Mali",
            "MT" => "Malta",
            "MH" => "Marshall Islands",
            "MQ" => "Martinique",
            "MR" => "Mauritania",
            "MU" => "Mauritius",
            "YT" => "Mayotte",
            "FX" => "Metropolitan France",
            "MX" => "Mexico",
            "FM" => "Micronesia",
            "MI" => "Midway Islands",
            "MD" => "Moldova",
            "MC" => "Monaco",
            "MN" => "Mongolia",
            "ME" => "Montenegro",
            "MS" => "Montserrat",
            "MA" => "Morocco",
            "MZ" => "Mozambique",
            "MM" => "Myanmar [Burma]",
            "NA" => "Namibia",
            "NR" => "Nauru",
            "NP" => "Nepal",
            "NL" => "Netherlands",
            "AN" => "Netherlands Antilles",
            "NT" => "Neutral Zone",
            "NC" => "New Caledonia",
            "NZ" => "New Zealand",
            "NI" => "Nicaragua",
            "NE" => "Niger",
            "NG" => "Nigeria",
            "NU" => "Niue",
            "NF" => "Norfolk Island",
            "KP" => "North Korea",
            "VD" => "North Vietnam",
            "MP" => "Northern Mariana Islands",
            "NO" => "Norway",
            "OM" => "Oman",
            "PC" => "Pacific Islands Trust Territory",
            "PK" => "Pakistan",
            "PW" => "Palau",
            "PS" => "Palestinian Territories",
            "PA" => "Panama",
            "PZ" => "Panama Canal Zone",
            "PG" => "Papua New Guinea",
            "PY" => "Paraguay",
            "YD" => "People's Democratic Republic of Yemen",
            "PE" => "Peru",
            "PH" => "Philippines",
            "PN" => "Pitcairn Islands",
            "PL" => "Poland",
            "PT" => "Portugal",
            "PR" => "Puerto Rico",
            "QA" => "Qatar",
            "RO" => "Romania",
            "RU" => "Russia",
            "RW" => "Rwanda",
            "RE" => "Réunion",
            "BL" => "Saint Barthélemy",
            "SH" => "Saint Helena",
            "KN" => "Saint Kitts and Nevis",
            "LC" => "Saint Lucia",
            "MF" => "Saint Martin",
            "PM" => "Saint Pierre and Miquelon",
            "VC" => "Saint Vincent and the Grenadines",
            "WS" => "Samoa",
            "SM" => "San Marino",
            "SA" => "Saudi Arabia",
            "SN" => "Senegal",
            "RS" => "Serbia",
            "CS" => "Serbia and Montenegro",
            "SC" => "Seychelles",
            "SL" => "Sierra Leone",
            "SG" => "Singapore",
            "SK" => "Slovakia",
            "SI" => "Slovenia",
            "SB" => "Solomon Islands",
            "SO" => "Somalia",
            "ZA" => "South Africa",
            "GS" => "South Georgia and the South Sandwich Islands",
            "KR" => "South Korea",
            "ES" => "Spain",
            "LK" => "Sri Lanka",
            "SD" => "Sudan",
            "SR" => "Suriname",
            "SJ" => "Svalbard and Jan Mayen",
            "SZ" => "Swaziland",
            "SE" => "Sweden",
            "CH" => "Switzerland",
            "SY" => "Syria",
            "ST" => "São Tomé and Príncipe",
            "TW" => "Taiwan",
            "TJ" => "Tajikistan",
            "TZ" => "Tanzania",
            "TH" => "Thailand",
            "TL" => "Timor-Leste",
            "TG" => "Togo",
            "TK" => "Tokelau",
            "TO" => "Tonga",
            "TT" => "Trinidad and Tobago",
            "TN" => "Tunisia",
            "TR" => "Turkey",
            "TM" => "Turkmenistan",
            "TC" => "Turks and Caicos Islands",
            "TV" => "Tuvalu",
            "UM" => "U.S. Minor Outlying Islands",
            "PU" => "U.S. Miscellaneous Pacific Islands",
            "VI" => "U.S. Virgin Islands",
            "UG" => "Uganda",
            "UA" => "Ukraine",
            "SU" => "Union of Soviet Socialist Republics",
            "AE" => "United Arab Emirates",
            "GB" => "United Kingdom",
            "US" => "United States",
            "ZZ" => "Unknown or Invalid Region",
            "UY" => "Uruguay",
            "UZ" => "Uzbekistan",
            "VU" => "Vanuatu",
            "VA" => "Vatican City",
            "VE" => "Venezuela",
            "VN" => "Vietnam",
            "WK" => "Wake Island",
            "WF" => "Wallis and Futuna",
            "EH" => "Western Sahara",
            "YE" => "Yemen",
            "ZM" => "Zambia",
            "ZW" => "Zimbabwe",
            "AX" => "Åland Islands",
            "NONE" => "Select country"
        ];

        return $countries[$key];
    }

    public static function getCodeFromPhone($phone, $country = null)
    {

        $code = explode(" ", $phone);
        $key = isset(self::$codes[$code[0]]) ? self::$codes[$code[0]] : null;

        if (is_null($key)) {

            if (!empty($country)) {
                return $country;

            }

            return "NONE";

        }

        return self::$codes[$key];

    }

    public static function getCode($key)
    {

        return (isset(self::$codes[$key]) ? self::$codes[$key] : 994);
    }

    public static function codes()
    {

        return self::$codes;
    }

    public static function isMine($id)
    {

        if (Auth::check()) {
            if(Auth::user()->id == $id){
                return true;
            }
        }

        return false;
    }

    public static function countries()
    {

        return self::$countries;
    }

    public static function firstEmptyValue($collection, $title = "Select category")
    {

        $collection = $collection->sortBy("name");

        $arr = [
            "id" => "0",
            "name" => $title
        ];

        $select = collect($arr);

        $collection = $collection->prepend($select);

        return $collection;
    }

    public static function selectDropDownCategories($only_parent = false, $placeholder = false)
    {
        if ($only_parent) {

            $categories = Category::ParentCategory()->active()->get();

        } else {

            $categories = Category::active()->get();
        }


        $categories = $categories->map(function ($item) {
            $locale = empty(App::getLocale()) ? "en" : App::getLocale();
            return ['name' => $item->translate($locale)->name, 'id' => $item->id];
        });


        $categories = $categories->sortBy('name');

        if (!$placeholder) {
            $categories = Helpers\Helper::firstEmptyValue($categories)->pluck("name", "id");
        }

        return $categories;

      }

    public static function pluckObject($object, $key, $value, $placeholder = "Select category")
    {

      $object = Helpers\Helper::firstEmptyValue($object, $placeholder);

      return $object->pluck($value, $key);
    }

    public static function payment($user){

		$payment = array(
			0 => false,
			1 => false
		);

			if(!is_null($user->payment)){

				$_payment = explode(",", $user->payment);
				$payment[0] = isset($_payment[0]) ? true : false;
				$payment[1] = isset($_payment[1]) ? true : false;
			}

			return $payment;
	}

	 public static function delivery($user){

		$payment = array(
			0 => false,
			1 => false
		);

			if(!is_null($user->delivery)){

				$_payment = explode(",", $user->delivery);
				$payment[0] = isset($_payment[0]) ? true : false;
				$payment[1] = isset($_payment[1]) ? true : false;
			}

			return $payment;
	}

    public static function statusAnnouncement($status)
    {

        $class = "";
        $title = "";

        switch ($status) {
            case 1:
                $class = "success";
                $title = "Active";
                break;
            case 2:
                $class = "default";
                $title = "Completed";
                break;
        }

        return [
            "class" => $class,
            "title" => $title
        ];
    }

    public static function statusOffer($status)
    {

        $class = "";
        $title = "";

        switch ($status) {
            case 1:
                $class = "info";
                $title = "Pending";
                break;
            case 2:
                $class = "success";
                $title = "Accepted";
                break;
            case 3:
                $class = "default";
                $title = "Archived";
                break;
        }

        return [
            "class" => $class,
            "title" => $title
        ];
    }

    public static function statisticProfile($id)
    {
        return User::where("users.id", $id)
            ->selectRaw('IFNULL(rating.rate, 0) AS rate, COUNT(offers.id) AS ofrs, COUNT(announcements.id) AS appts')
            ->leftJoin('announcements', 'users.id', '=', 'announcements.user_id')
            ->leftJoin('offers', 'users.id', '=', 'offers.user_id')
            ->leftJoin('rating', 'users.id', '=', 'rating.user_id')
            ->groupBy('users.id')
            ->groupBy('rating.rate')
            ->get()->first();
    }

    public static function mapInitialization($user)
    {
        if (empty($user->location)) {

            $x = Location::get()->lat;
            $y = Location::get()->lon;

        } else {

            $location = explode(",", $user->location);
            $x = $location[0];
            $y = $location[1];
        }

        return [
            "x" => $x,
            "y" => $y
        ];
    }

    public static function settings($field = null)
    {

        $settings = new Settings();
        return $settings->get($field);
    }

    public static function languageName()
    {

        foreach (Config::get('languages') as $lang => $language) {
            if ($lang != App::getLocale()) {
                return $lang;
            }
        }
    }

}
