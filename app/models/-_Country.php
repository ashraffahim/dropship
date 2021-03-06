<?php

namespace models;

class _Country {

	public function list($ac = false) {
		$cl = [
			"AF" => ["Afghanistan","؋","AFN","93"],
			"AX" => ["Aland Islands","358","€","EUR"],
			"AL" => ["Albania","Lek","ALL","355"],
			"DZ" => ["Algeria","دج","DZD","213"],
			"AS" => ["American Samoa","$","USD","1684"],
			"AD" => ["Andorra","€","EUR","376"],
			"AO" => ["Angola","Kz","AOA","244"],
			"AI" => ["Anguilla","$","XCD","1264"],
			"AQ" => ["Antarctica","$","AAD","672"],
			"AG" => ["Antigua and Barbuda","$","XCD","1268"],
			"AR" => ["Argentina","$","ARS","54"],
			"AM" => ["Armenia","֏","AMD","374"],
			"AW" => ["Aruba","ƒ","AWG","297"],
			"AU" => ["Australia","$","AUD","61"],
			"AT" => ["Austria","€","EUR","43"],
			"AZ" => ["Azerbaijan","m","AZN","994"],
			"BS" => ["Bahamas","B$","BSD","1242"],
			"BH" => ["Bahrain",".د.ب","BHD","973"],
			"BD" => ["Bangladesh","৳","BDT","880"],
			"BB" => ["Barbados","Bds$","BBD","1246"],
			"BY" => ["Belarus","Br","BYN","375"],
			"BE" => ["Belgium","€","EUR","32"],
			"BZ" => ["Belize","$","BZD","501"],
			"BJ" => ["Benin","CFA","XOF","229"],
			"BM" => ["Bermuda","$","BMD","1441"],
			"BT" => ["Bhutan","Nu.","BTN","975"],
			"BO" => ["Bolivia","Bs.","BOB","591"],
			"BQ" => ["Bonaire, Sint Eustatius and Saba","$","USD","599"],
			"BA" => ["Bosnia and Herzegovina","KM","BAM","387"],
			"BW" => ["Botswana","P","BWP","267"],
			"BV" => ["Bouvet Island","kr","NOK","55"],
			"BR" => ["Brazil","R$","BRL","55"],
			"IO" => ["British Indian Ocean Territory","$","USD","246"],
			"BN" => ["Brunei Darussalam","B$","BND","673"],
			"BG" => ["Bulgaria","Лв.","BGN","359"],
			"BF" => ["Burkina Faso","CFA","XOF","226"],
			"BI" => ["Burundi","FBu","BIF","257"],
			"KH" => ["Cambodia","KHR","KHR","855"],
			"CM" => ["Cameroon","FCFA","XAF","237"],
			"CA" => ["Canada","$","CAD","1"],
			"CV" => ["Cape Verde","$","CVE","238"],
			"KY" => ["Cayman Islands","$","KYD","1345"],
			"CF" => ["Central African Republic","FCFA","XAF","236"],
			"TD" => ["Chad","FCFA","XAF","235"],
			"CL" => ["Chile","$","CLP","56"],
			"CN" => ["China","¥","CNY","86"],
			"CX" => ["Christmas Island","$","AUD","61"],
			"CC" => ["Cocos (Keeling) Islands","$","AUD","672"],
			"CO" => ["Colombia","$","COP","57"],
			"KM" => ["Comoros","CF","KMF","269"],
			"CG" => ["Congo","FC","XAF","242"],
			"CD" => ["Congo, Democratic Republic of the Congo","FC","CDF","242"],
			"CK" => ["Cook Islands","$","NZD","682"],
			"CR" => ["Costa Rica","₡","CRC","506"],
			"CI" => ["Cote D\'Ivoire","CFA","XOF","225"],
			"HR" => ["Croatia","kn","HRK","385"],
			"CU" => ["Cuba","$","CUP","53"],
			"CW" => ["Curacao","ƒ","ANG","599"],
			"CY" => ["Cyprus","€","EUR","357"],
			"CZ" => ["Czech Republic","Kč","CZK","420"],
			"DK" => ["Denmark","Kr.","DKK","45"],
			"DJ" => ["Djibouti","Fdj","DJF","253"],
			"DM" => ["Dominica","$","XCD","1767"],
			"DO" => ["Dominican Republic","$","DOP","1809"],
			"EC" => ["Ecuador","$","USD","593"],
			"EG" => ["Egypt","ج.م","EGP","20"],
			"SV" => ["El Salvador","$","USD","503"],
			"GQ" => ["Equatorial Guinea","FCFA","XAF","240"],
			"ER" => ["Eritrea","Nfk","ERN","291"],
			"EE" => ["Estonia","€","EUR","372"],
			"ET" => ["Ethiopia","Nkf","ETB","251"],
			"FK" => ["Falkland Islands (Malvinas)","£","FKP","500"],
			"FO" => ["Faroe Islands","Kr.","DKK","298"],
			"FJ" => ["Fiji","FJ$","FJD","679"],
			"FI" => ["Finland","€","EUR","358"],
			"FR" => ["France","€","EUR","33"],
			"GF" => ["French Guiana","€","EUR","594"],
			"PF" => ["French Polynesia","₣","XPF","689"],
			"TF" => ["French Southern Territories","€","EUR","262"],
			"GA" => ["Gabon","FCFA","XAF","241"],
			"GM" => ["Gambia","D","GMD","220"],
			"GE" => ["Georgia","ლ","GEL","995"],
			"DE" => ["Germany","€","EUR","49"],
			"GH" => ["Ghana","GH₵","GHS","233"],
			"GI" => ["Gibraltar","£","GIP","350"],
			"GR" => ["Greece","€","EUR","30"],
			"GL" => ["Greenland","Kr.","DKK","299"],
			"GD" => ["Grenada","$","XCD","1473"],
			"GP" => ["Guadeloupe","€","EUR","590"],
			"GU" => ["Guam","$","USD","1671"],
			"GT" => ["Guatemala","Q","GTQ","502"],
			"GG" => ["Guernsey","£","GBP","44"],
			"GN" => ["Guinea","FG","GNF","224"],
			"GW" => ["Guinea-Bissau","CFA","XOF","245"],
			"GY" => ["Guyana","$","GYD","592"],
			"HT" => ["Haiti","G","HTG","509"],
			"HM" => ["Heard Island and Mcdonald Islands","$","AUD","0"],
			"VA" => ["Holy See (Vatican City State)","€","EUR","39"],
			"HN" => ["Honduras","L","HNL","504"],
			"HK" => ["Hong Kong","$","HKD","852"],
			"HU" => ["Hungary","Ft","HUF","36"],
			"IS" => ["Iceland","kr","ISK","354"],
			"IN" => ["India","₹","INR","91"],
			"ID" => ["Indonesia","Rp","IDR","62"],
			"IR" => ["Iran, Islamic Republic of","﷼","IRR","98"],
			"IQ" => ["Iraq","د.ع","IQD","964"],
			"IE" => ["Ireland","€","EUR","353"],
			"IM" => ["Isle of Man","£","GBP","44"],
			"IL" => ["Israel","₪","ILS","972"],
			"IT" => ["Italy","€","EUR","39"],
			"JM" => ["Jamaica","J$","JMD","1876"],
			"JP" => ["Japan","¥","JPY","81"],
			"JE" => ["Jersey","£","GBP","44"],
			"JO" => ["Jordan","ا.د","JOD","962"],
			"KZ" => ["Kazakhstan","лв","KZT","7"],
			"KE" => ["Kenya","KSh","KES","254"],
			"KI" => ["Kiribati","$","AUD","686"],
			"KP" => ["Korea, Democratic People\'s Republic of","₩","KPW","850"],
			"KR" => ["Korea, Republic of","₩","KRW","82"],
			"XK" => ["Kosovo","€","EUR","381"],
			"KW" => ["Kuwait","ك.د","KWD","965"],
			"KG" => ["Kyrgyzstan","лв","KGS","996"],
			"LA" => ["Lao People\'s Democratic Republic","₭","LAK","856"],
			"LV" => ["Latvia","€","EUR","371"],
			"LB" => ["Lebanon","£","LBP","961"],
			"LS" => ["Lesotho","L","LSL","266"],
			"LR" => ["Liberia","$","LRD","231"],
			"LY" => ["Libyan Arab Jamahiriya","د.ل","LYD","218"],
			"LI" => ["Liechtenstein","CHf","CHF","423"],
			"LT" => ["Lithuania","€","EUR","370"],
			"LU" => ["Luxembourg","€","EUR","352"],
			"MO" => ["Macao","$","MOP","853"],
			"MK" => ["Macedonia, the Former Yugoslav Republic of","ден","MKD","389"],
			"MG" => ["Madagascar","Ar","MGA","261"],
			"MW" => ["Malawi","MK","MWK","265"],
			"MY" => ["Malaysia","RM","MYR","60"],
			"MV" => ["Maldives","Rf","MVR","960"],
			"ML" => ["Mali","CFA","XOF","223"],
			"MT" => ["Malta","€","EUR","356"],
			"MH" => ["Marshall Islands","$","USD","692"],
			"MQ" => ["Martinique","€","EUR","596"],
			"MR" => ["Mauritania","MRU","MRO","222"],
			"MU" => ["Mauritius","₨","MUR","230"],
			"YT" => ["Mayotte","€","EUR","269"],
			"MX" => ["Mexico","$","MXN","52"],
			"FM" => ["Micronesia, Federated States of","$","USD","691"],
			"MD" => ["Moldova, Republic of","L","MDL","373"],
			"MC" => ["Monaco","€","EUR","377"],
			"MN" => ["Mongolia","₮","MNT","976"],
			"ME" => ["Montenegro","€","EUR","382"],
			"MS" => ["Montserrat","$","XCD","1664"],
			"MA" => ["Morocco","DH","MAD","212"],
			"MZ" => ["Mozambique","MT","MZN","258"],
			"MM" => ["Myanmar","K","MMK","95"],
			"NA" => ["Namibia","$","NAD","264"],
			"NR" => ["Nauru","$","AUD","674"],
			"NP" => ["Nepal","₨","NPR","977"],
			"NL" => ["Netherlands","€","EUR","31"],
			"AN" => ["Netherlands Antilles","NAf","ANG","599"],
			"NC" => ["New Caledonia","₣","XPF","687"],
			"NZ" => ["New Zealand","$","NZD","64"],
			"NI" => ["Nicaragua","C$","NIO","505"],
			"NE" => ["Niger","CFA","XOF","227"],
			"NG" => ["Nigeria","₦","NGN","234"],
			"NU" => ["Niue","$","NZD","683"],
			"NF" => ["Norfolk Island","$","AUD","672"],
			"MP" => ["Northern Mariana Islands","$","USD","1670"],
			"NO" => ["Norway","kr","NOK","47"],
			"OM" => ["Oman",".ع.ر","OMR","968"],
			"PK" => ["Pakistan","₨","PKR","92"],
			"PW" => ["Palau","$","USD","680"],
			"PS" => ["Palestinian Territory, Occupied","₪","ILS","970"],
			"PA" => ["Panama","B/.","PAB","507"],
			"PG" => ["Papua New Guinea","K","PGK","675"],
			"PY" => ["Paraguay","₲","PYG","595"],
			"PE" => ["Peru","S/.","PEN","51"],
			"PH" => ["Philippines","₱","PHP","63"],
			"PN" => ["Pitcairn","$","NZD","64"],
			"PL" => ["Poland","zł","PLN","48"],
			"PT" => ["Portugal","€","EUR","351"],
			"PR" => ["Puerto Rico","$","USD","1787"],
			"QA" => ["Qatar","ق.ر","QAR","974"],
			"RE" => ["Reunion","€","EUR","262"],
			"RO" => ["Romania","lei","RON","40"],
			"RU" => ["Russian Federation","₽","RUB","70"],
			"RW" => ["Rwanda","FRw","RWF","250"],
			"BL" => ["Saint Barthelemy","€","EUR","590"],
			"SH" => ["Saint Helena","£","SHP","290"],
			"KN" => ["Saint Kitts and Nevis","$","XCD","1869"],
			"LC" => ["Saint Lucia","$","XCD","1758"],
			"MF" => ["Saint Martin","€","EUR","590"],
			"PM" => ["Saint Pierre and Miquelon","€","EUR","508"],
			"VC" => ["Saint Vincent and the Grenadines","$","XCD","1784"],
			"WS" => ["Samoa","SAT","WST","684"],
			"SM" => ["San Marino","€","EUR","378"],
			"ST" => ["Sao Tome and Principe","Db","STD","239"],
			"SA" => ["Saudi Arabia","﷼","SAR","966"],
			"SN" => ["Senegal","CFA","XOF","221"],
			"RS" => ["Serbia","din","RSD","381"],
			"CS" => ["Serbia and Montenegro","din","RSD","381"],
			"SC" => ["Seychelles","SRe","SCR","248"],
			"SL" => ["Sierra Leone","Le","SLL","232"],
			"SG" => ["Singapore","$","SGD","65"],
			"SX" => ["Sint Maarten","ƒ","ANG","1"],
			"SK" => ["Slovakia","€","EUR","421"],
			"SI" => ["Slovenia","€","EUR","386"],
			"SB" => ["Solomon Islands","Si$","SBD","677"],
			"SO" => ["Somalia","Sh.so.","SOS","252"],
			"ZA" => ["South Africa","R","ZAR","27"],
			"GS" => ["South Georgia and the South Sandwich Islands","£","GBP","500"],
			"SS" => ["South Sudan","£","SSP","211"],
			"ES" => ["Spain","€","EUR","34"],
			"LK" => ["Sri Lanka","Rs","LKR","94"],
			"SD" => ["Sudan",".س.ج","SDG","249"],
			"SR" => ["Suriname","$","SRD","597"],
			"SJ" => ["Svalbard and Jan Mayen","kr","NOK","47"],
			"SZ" => ["Swaziland","E","SZL","268"],
			"SE" => ["Sweden","kr","SEK","46"],
			"CH" => ["Switzerland","CHf","CHF","41"],
			"SY" => ["Syrian Arab Republic","LS","SYP","963"],
			"TW" => ["Taiwan, Province of China","$","TWD","886"],
			"TJ" => ["Tajikistan","SM","TJS","992"],
			"TZ" => ["Tanzania, United Republic of","TSh","TZS","255"],
			"TH" => ["Thailand","฿","THB","66"],
			"TL" => ["Timor-Leste","$","USD","670"],
			"TG" => ["Togo","CFA","XOF","228"],
			"TK" => ["Tokelau","$","NZD","690"],
			"TO" => ["Tonga","$","TOP","676"],
			"TT" => ["Trinidad and Tobago","$","TTD","1868"],
			"TN" => ["Tunisia","ت.د","TND","216"],
			"TR" => ["Turkey","₺","TRY","90"],
			"TM" => ["Turkmenistan","T","TMT","7370"],
			"TC" => ["Turks and Caicos Islands","$","USD","1649"],
			"TV" => ["Tuvalu","$","AUD","688"],
			"UG" => ["Uganda","USh","UGX","256"],
			"UA" => ["Ukraine","₴","UAH","380"],
			"AE" => ["United Arab Emirates","إ.د","AED","971"],
			"GB" => ["United Kingdom","£","GBP","44"],
			"US" => ["United States","$","USD","1"],
			"UM" => ["United States Minor Outlying Islands","$","USD","1"],
			"UY" => ["Uruguay","$","UYU","598"],
			"UZ" => ["Uzbekistan","лв","UZS","998"],
			"VU" => ["Vanuatu","VT","VUV","678"],
			"VE" => ["Venezuela","Bs","VEF","58"],
			"VN" => ["Viet Nam","₫","VND","84"],
			"VG" => ["Virgin Islands, British","$","USD","1284"],
			"VI" => ["Virgin Islands, U.s.","$","USD","1340"],
			"WF" => ["Wallis and Futuna","₣","XPF","681"],
			"EH" => ["Western Sahara","MAD","MAD","212"],
			"YE" => ["Yemen","﷼","YER","967"],
			"ZM" => ["Zambia","ZK","ZMW","260"],
			"ZW" => ["Zimbabwe","$","ZWL","263"]
		];

		return $cl;
	}
}

?>