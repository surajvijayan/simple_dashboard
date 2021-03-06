<?php
/*
	Open-Dashboard: Designed by Suraj Vijayan  
	First Release: Aug. 16th. 2018
*/
header("Access-Control-Allow-Origin: *");
include_once('../vars.inc');

/***********************************************************************************************/

function print_header($dashboard_js,$widgets_js)
{
global $ROOT;
echo <<<EOF
<!DOCTYPE html>
<html id="html1" lang="en" class="ui-widget-content">
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
  <title>Open-Dashboard</title>
  <!-- prerequisites -->
  <link  rel="stylesheet" type="text/css" href="$ROOT/static_files/css/jquery.themes.css"> 
  <script type="text/javascript" src="$ROOT/static_files/jquery-3.3.1.min.js"></script>
  <script type="text/javascript" src="$ROOT/static_files/jquery-ui-1.12.1/jquery-ui.min.js"></script> 
  <script type="text/javascript" src="$ROOT/static_files/js/jquery.redirect.js"></script>
  <script type="text/javascript" src="$ROOT/static_files/js/jquery.themes.js"></script>
  <script type="text/javascript" src="$ROOT/static_files/js/chosen.jquery.min.js"></script>
  <script type="text/javascript" src="$ROOT/static_files/js/pagination.js"></script>
  <script type="text/javascript" src="$ROOT/static_files/js/noty.min.js"></script>
  <link  rel="stylesheet" type="text/css" href="$ROOT/static_files/jquery-ui-themes-1.12.1/jquery-ui.theme.css" />
  <link  rel="stylesheet" type="text/css" href="$ROOT/static_files/jquery-ui-themes-1.12.1/jquery-ui.structure.min.css" />
  <link  rel="stylesheet" type="text/css" href="$ROOT/static_files/css/chosen.min.css" />
  <link  rel="stylesheet" type="text/css" href="$ROOT/static_files/css/pagination.css" />
  <link  rel="stylesheet" type="text/css" href="$ROOT/static_files/css/noty.css" />

  <script type="text/javascript" src="$ROOT/static_files/amcharts/amcharts.js"></script>
  <script type="text/javascript" src="$ROOT/static_files/amcharts/serial.js"></script>
  <script type="text/javascript" src="$ROOT/static_files/amcharts/pie.js"></script>
  <script src="$ROOT/static_files/amcharts/plugins/export/export.js" type="text/javascript"></script>
  <link  rel="stylesheet" type="text/css" href="$ROOT/static_files/amcharts/plugins/export/export.css" >
  <script src="$ROOT/static_files/amcharts/themes/light.js"></script>
  <script src="$ROOT/static_files/amcharts/themes/dark.js"></script>
  <script src="$ROOT/static_files/amcharts/themes/patterns.js"></script>
  <script src="$ROOT/static_files/amcharts/themes/black.js"></script>
  <script src="$ROOT/static_files/amcharts/themes/chalk.js"></script>
  <script type="text/javascript" src="$ROOT/static_files/dashboard/$widgets_js"></script>
  <script type="text/javascript" src="$ROOT/static_files/dashboard/$dashboard_js"></script>
  <link  href="$ROOT/static_files/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <script src="$ROOT/static_files/jqGrid/jquery.jqgrid.min.js"> type="text/javascript"></script>
  <link  rel="stylesheet" type="text/css" href="$ROOT/static_files/css/menu.css" />
  <link  rel="stylesheet" href="$ROOT/static_files/css/amcharts.css" type="text/css" />
  <link  rel="stylesheet" type="text/css" href="$ROOT/static_files/jqGrid/css/ui.jqgrid.css">
  <link  rel="stylesheet" type="text/css" href="$ROOT/static_files/css/dashboard.css" />
</head>
EOF;
  //<link  rel="stylesheet" type="text/css" media="screen and (max-device-width: 1920px)" href="$ROOT/static_files/css/dashboard.css" />
  //<link  rel="stylesheet" type="text/css" media="screen and (min-device-width: 2000px)" href="$ROOT/static_files/css/dashboard.css" />
  return;
}
/***********************************************************************************************/

function date_range_input_form($form_id,$days,$args)
{
	$from_date = date('Y-m-d',strtotime("-$days days"));
	$to_date = date('Y-m-d',strtotime("now"));
    $max_date_range = $args[0];
echo <<<EOF
    <form id="$form_id" action="" method="">
    	From Date <input type="text" name="from_date" class="date_input" value="$from_date">
    	To Date <input type="text" name="to_date" class="date_input" value="$to_date">
		<input type='submit' name='submit' class='button' value='Go!'/>
		<input type="hidden" name="max_date_range" value="$max_date_range">
    </form>
EOF;
}
/***********************************************************************************************/

function date_input_form($form_id,$days)
{
	$today = date('Y-m-d',strtotime("-$days days"));
echo <<<EOF
    <form id="$form_id" action="" method="">
    	Date <input type="text" name="date_input" class="date_input" value="$today">
		<input type='submit' name='submit' class='button' value='Go!'/>
    </form>
EOF;
}
/***********************************************************************************************/

function region_input_form($form_id,$args)
{
	$region = $args[0];
	$regions = array('EU' => 'European Union',
					 'EFTA' => 'European Free Trade Association',
					 'CARICOM' => 'Caribbean Community',
					 'PA' => 'Pacific Alliance',
					 'AU' => 'African Union',
					 'USAN' => 'Union of South American Nations',
					 'EEU' => 'Eurasian Economic Union',
					 'AL' => 'Arab League',
					 'ASEAN' => 'Association of Southeast Asian Nations',
					 'CAIS' => 'Central American Integration System',
					 'CEFTA' => 'Central European Free Trade Agreement',
					 'NAFTA' => 'North American Free Trade Agreement',
					 'SAARC' => 'South Asian Association for Regional Cooperation');
echo <<<EOF
    <form id="$form_id" action="" method="">
       Region
      <select name="region" id="region">
EOF;
      foreach($regions as $key => $mregion)
      {
          if($region == $key)
              print "<option value=\"$key\" SELECTED>$mregion</option>\n";
            else
              print "<option value=\"$key\">$mregion</option>\n";
      }
echo <<<EOF
      </select>
		<input type='submit' name='submit' class='button' value='Go!'/>
    </form>
EOF;
}
/***********************************************************************************************/

function gdp_input_form($form_id,$args)
{
    $year = "2017";
    $c2 = array();
    $c3 = array();
    //This should be retrieved from DB/external storage for every unique logged in user to restore saved Form values
    $form_values = '[
                     {"name":"country","value":"CAN"},{"name":"country","value":"CHN"},
                     {"name":"country","value":"DEU"},{"name":"country","value":"GBR"},
                     {"name":"country","value":"IND"},{"name":"country","value":"JPN"},
                     {"name":"country","value":"USA"},{"name":"fyear","value":"2010"}
                    ]';
    $c2 = json_decode($form_values,true);
    foreach($c2 as $key => $value) 
    {
        if($value["name"] == "country")
            array_push($c3,$value["value"]);
        if($value["name"] == "fyear")
            $year = $value["value"]; 
    }
    if(!empty($c3))
        $args = $c3;
    $countries = array(
	"ABW" => "Aruba",
	"AFG" => "Afghanistan",
	"AGO" => "Angola",
	"AIA" => "Anguilla",
	"ALA" => "Åland Islands",
	"ALB" => "Albania",
	"AND" => "Andorra",
	"ARE" => "United Arab Emirates",
	"ARG" => "Argentina",
	"ARM" => "Armenia",
	"ASM" => "American Samoa",
	"ATA" => "Antarctica",
	"ATF" => "French Southern Territories",
	"ATG" => "Antigua and Barbuda",
	"AUS" => "Australia",
	"AUT" => "Austria",
	"AZE" => "Azerbaijan",
	"BDI" => "Burundi",
	"BEL" => "Belgium",
	"BEN" => "Benin",
	"BES" => "Bonaire, Sint Eustatius and Saba",
	"BFA" => "Burkina Faso",
	"BGD" => "Bangladesh",
	"BGR" => "Bulgaria",
	"BHR" => "Bahrain",
	"BHS" => "Bahamas",
	"BIH" => "Bosnia and Herzegovina",
	"BLM" => "Saint Barthélemy",
	"BLR" => "Belarus",
	"BLZ" => "Belize",
	"BMU" => "Bermuda",
	"BOL" => "Bolivia, Plurinational State of",
	"BRA" => "Brazil",
	"BRB" => "Barbados",
	"BRN" => "Brunei Darussalam",
	"BTN" => "Bhutan",
	"BVT" => "Bouvet Island",
	"BWA" => "Botswana",
	"CAF" => "Central African Republic",
	"CAN" => "Canada",
	"CCK" => "Cocos (Keeling) Islands",
	"CHE" => "Switzerland",
	"CHL" => "Chile",
	"CHN" => "China",
	"CIV" => "Côte d'Ivoire",
	"CMR" => "Cameroon",
	"COD" => "Congo, the Democratic Republic of the",
	"COG" => "Congo",
	"COK" => "Cook Islands",
	"COL" => "Colombia",
	"COM" => "Comoros",
	"CPV" => "Cabo Verde",
	"CRI" => "Costa Rica",
	"CUB" => "Cuba",
	"CUW" => "Curaçao",
	"CXR" => "Christmas Island",
	"CYM" => "Cayman Islands",
	"CYP" => "Cyprus",
	"CZE" => "Czechia",
	"DEU" => "Germany",
	"DJI" => "Djibouti",
	"DMA" => "Dominica",
	"DNK" => "Denmark",
	"DOM" => "Dominican Republic",
	"DZA" => "Algeria",
	"ECU" => "Ecuador",
	"EGY" => "Egypt",
	"ERI" => "Eritrea",
	"ESH" => "Western Sahara",
	"ESP" => "Spain",
	"EST" => "Estonia",
	"ETH" => "Ethiopia",
	"FIN" => "Finland",
	"FJI" => "Fiji",
	"FLK" => "Falkland Islands (Malvinas)",
	"FRA" => "France",
	"FRO" => "Faroe Islands",
	"FSM" => "Micronesia, Federated States of",
	"GAB" => "Gabon",
	"GBR" => "United Kingdom",
	"GEO" => "Georgia",
	"GGY" => "Guernsey",
	"GHA" => "Ghana",
	"GIB" => "Gibraltar",
	"GIN" => "Guinea",
	"GLP" => "Guadeloupe",
	"GMB" => "Gambia",
	"GNB" => "Guinea-Bissau",
	"GNQ" => "Equatorial Guinea",
	"GRC" => "Greece",
	"GRD" => "Grenada",
	"GRL" => "Greenland",
	"GTM" => "Guatemala",
	"GUF" => "French Guiana",
	"GUM" => "Guam",
	"GUY" => "Guyana",
	"HKG" => "Hong Kong",
	"HMD" => "Heard Island and McDonald Islands",
	"HND" => "Honduras",
	"HRV" => "Croatia",
	"HTI" => "Haiti",
	"HUN" => "Hungary",
	"IDN" => "Indonesia",
	"IMN" => "Isle of Man",
	"IND" => "India",
	"IOT" => "British Indian Ocean Territory",
	"IRL" => "Ireland",
	"IRN" => "Iran, Islamic Republic of",
	"IRQ" => "Iraq",
	"ISL" => "Iceland",
	"ISR" => "Israel",
	"ITA" => "Italy",
	"JAM" => "Jamaica",
	"JEY" => "Jersey",
	"JOR" => "Jordan",
	"JPN" => "Japan",
	"KAZ" => "Kazakhstan",
	"KEN" => "Kenya",
	"KGZ" => "Kyrgyzstan",
	"KHM" => "Cambodia",
	"KIR" => "Kiribati",
	"KNA" => "Saint Kitts and Nevis",
	"KOR" => "Korea, Republic of",
	"KWT" => "Kuwait",
	"LAO" => "Lao People's Democratic Republic",
	"LBN" => "Lebanon",
	"LBR" => "Liberia",
	"LBY" => "Libya",
	"LCA" => "Saint Lucia",
	"LIE" => "Liechtenstein",
	"LKA" => "Sri Lanka",
	"LSO" => "Lesotho",
	"LTU" => "Lithuania",
	"LUX" => "Luxembourg",
	"LVA" => "Latvia",
	"MAC" => "Macao",
	"MAF" => "Saint Martin (French part)",
	"MAR" => "Morocco",
	"MCO" => "Monaco",
	"MDA" => "Moldova, Republic of",
	"MDG" => "Madagascar",
	"MDV" => "Maldives",
	"MEX" => "Mexico",
	"MHL" => "Marshall Islands",
	"MKD" => "Macedonia, the former Yugoslav Republic of",
	"MLI" => "Mali",
	"MLT" => "Malta",
	"MMR" => "Myanmar",
	"MNE" => "Montenegro",
	"MNG" => "Mongolia",
	"MNP" => "Northern Mariana Islands",
	"MOZ" => "Mozambique",
	"MRT" => "Mauritania",
	"MSR" => "Montserrat",
	"MTQ" => "Martinique",
	"MUS" => "Mauritius",
	"MWI" => "Malawi",
	"MYS" => "Malaysia",
	"MYT" => "Mayotte",
	"NAM" => "Namibia",
	"NCL" => "New Caledonia",
	"NER" => "Niger",
	"NFK" => "Norfolk Island",
	"NGA" => "Nigeria",
	"NIC" => "Nicaragua",
	"NIU" => "Niue",
	"NLD" => "Netherlands",
	"NOR" => "Norway",
	"NPL" => "Nepal",
	"NRU" => "Nauru",
	"NZL" => "New Zealand",
	"OMN" => "Oman",
	"PAK" => "Pakistan",
	"PAN" => "Panama",
	"PCN" => "Pitcairn",
	"PER" => "Peru",
	"PHL" => "Philippines",
	"PLW" => "Palau",
	"PNG" => "Papua New Guinea",
	"POL" => "Poland",
	"PRI" => "Puerto Rico",
	"PRK" => "Korea, Democratic People's Republic of",
	"PRT" => "Portugal",
	"PRY" => "Paraguay",
	"PSE" => "Palestine, State of",
	"PYF" => "French Polynesia",
	"QAT" => "Qatar",
	"REU" => "Réunion",
	"ROU" => "Romania",
	"RUS" => "Russian Federation",
	"RWA" => "Rwanda",
	"SAU" => "Saudi Arabia",
	"SDN" => "Sudan",
	"SEN" => "Senegal",
	"SGP" => "Singapore",
	"SGS" => "South Georgia and the South Sandwich Islands",
	"SHN" => "Saint Helena, Ascension and Tristan da Cunha",
	"SJM" => "Svalbard and Jan Mayen",
	"SLB" => "Solomon Islands",
	"SLE" => "Sierra Leone",
	"SLV" => "El Salvador",
	"SMR" => "San Marino",
	"SOM" => "Somalia",
	"SPM" => "Saint Pierre and Miquelon",
	"SRB" => "Serbia",
	"SSD" => "South Sudan",
	"STP" => "Sao Tome and Principe",
	"SUR" => "Suriname",
	"SVK" => "Slovakia",
	"SVN" => "Slovenia",
	"SWE" => "Sweden",
	"SWZ" => "Eswatini",
	"SXM" => "Sint Maarten (Dutch part)",
	"SYC" => "Seychelles",
	"SYR" => "Syrian Arab Republic",
	"TCA" => "Turks and Caicos Islands",
	"TCD" => "Chad",
	"TGO" => "Togo",
	"THA" => "Thailand",
	"TJK" => "Tajikistan",
	"TKL" => "Tokelau",
	"TKM" => "Turkmenistan",
	"TLS" => "Timor-Leste",
	"TON" => "Tonga",
	"TTO" => "Trinidad and Tobago",
	"TUN" => "Tunisia",
	"TUR" => "Turkey",
	"TUV" => "Tuvalu",
	"TWN" => "Taiwan, Province of China",
	"TZA" => "Tanzania, United Republic of",
	"UGA" => "Uganda",
	"UKR" => "Ukraine",
	"UMI" => "United States Minor Outlying Islands",
	"URY" => "Uruguay",
	"USA" => "United States of America",
	"UZB" => "Uzbekistan",
	"VAT" => "Holy See",
	"VCT" => "Saint Vincent and the Grenadines",
	"VEN" => "Venezuela, Bolivarian Republic of",
	"VGB" => "Virgin Islands, British",
	"VIR" => "Virgin Islands, U.S.",
	"VNM" => "Viet Nam",
	"VUT" => "Vanuatu",
	"WLF" => "Wallis and Futuna",
	"WSM" => "Samoa",
	"YEM" => "Yemen",
	"ZAF" => "South Africa",
	"ZMB" => "Zambia",
	"ZWE" => "Zimbabwe"
);
echo <<<EOF
    <form id="$form_id" action="" method="">
      Country
	  <select style="width:450px" name="country" id="country" class="chosen-select" multiple>
EOF;
      foreach($countries as $key => $mcountry)
      {
          if(array_search($key,$args) != FALSE)
              print "<option value=\"$key\" SELECTED>$mcountry</option>\n";
            else
              print "<option value=\"$key\">$mcountry</option>\n";
      }
echo <<<EOF
      </select>
	  Year <select name="fyear">
     		<option value="2001">2001</option>
     		<option value="2002">2002</option>
     		<option value="2003">2003</option>
     		<option value="2004">2004</option>
     		<option value="2005">2005</option>
     		<option value="2006">2006</option>
     		<option value="2007">2007</option>
     		<option value="2008">2008</option>
     		<option value="2009">2009</option>
     		<option value="2010">2010</option>
     		<option value="2011">2011</option>
     		<option value="2012">2012</option>
     		<option value="2013">2013</option>
     		<option value="2014">2014</option>
     		<option value="2015">2015</option>
     		<option value="2016">2016</option>
     		<option value="2017" SELECTED>$year</option>
			</select>
      <input type='submit' name='submit' class='button' value='Go!'/>
    </form>
EOF;
}
/***********************************************************************************************/

function login_check()
{
	return true;
}
/***********************************************************************************************/

function curPageURL()
{
$pageURL = 'http';
    if ($_SERVER["HTTPS"] == "on")
    {
        $pageURL .= "s";
    }
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80")
        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"]."/".$_SERVER["REQUEST_URI"];
    else
        $pageURL .= $_SERVER["SERVER_NAME"]."/".$_SERVER["REQUEST_URI"];
    return $pageURL;
}
/****************************************************************************************/

function dashboard_form($widget)
{
	switch($widget["INPUT_FORM"])
	{
		case "COUNTRIES_REGION":
			region_input_form("form_" . $widget["NAME"],$widget["INPUT_FORM_ARGS"]);
			break;
		case "GDP_REGIONS":
			gdp_input_form("form_" . $widget["NAME"],$widget["INPUT_FORM_ARGS"]);
			break;
		case "DATE_RANGE":
			date_range_input_form("form_" . $widget["NAME"],$widget["INPUT_FORM_ARGS"]);
			break;
	}
}
/**********************************************************************************************/

function dashboard_header($ROOT,$view)
{
global $panes;
echo <<<EOF
<body id="body1" class="ui-widget-content">  
    <span style="width:100%;height:75px;margin-left:3px;margin-right:3px;border:none">
            <ul class="nav" id="list2">
            <li id=t1 class="dropdown ui-widget-header"><a href="#"><i class="ui-widget-content fa fa-bars"></i></a>
            <ul id="list1">
EOF;
		foreach($panes as $pane)
        {
			print "<li><a href=./dashboard_" . $pane["name"] . ".php>" . $pane["header"] . "</a></li>";
		}
echo <<<EOF
            </ul>
            </li>
            </ul>
		<span id=n1 class="ui-widget-header fa fa-tachometer fa-5x fa_custom fa-pull-left"></span>
        <h4 id=date class="save-session ui-widget-content ui-corner-all" style="text-align:right;float:right;margin:20px"></h4>
		<h2 class="ui-widget-header ui-corner-all fa fa-3x fa_custom fa-pull-left">Open-Dashboard</h2>
		<h2 id='heading' class="ui-widget-header ui-corner-all fa-2x fa_custom fa-pull-left">$view</h2>
		<h2 id="save-session" class="save-session ui-widget-content fa fa_custom fa-pull-right"><a href=#>save-session</a></h2>
		<div id="hoverThemes" class="save-session theme ui-widget-content fa fa_custom fa-pull-right">Themes
            <span id=selectThemes class="fa fa_custom fa-pull-right"></span>
        </div>
    </span>
<!-- scroll DIV -->
<div id="scroll" class="ui-widget-content">
    <!-- MAIN DIV -->
    <div>
EOF;
}
/**********************************************************************************************/

function dashboard_footer($ROOT,$pane_name)
{
echo <<<EOF
    <!-- MAIN DIV -->
    </div>
<!-- scroll DIV -->
</div>
    <script type="text/javascript">
        dispatch_events('$ROOT','$pane_name');
    </script>
</body>
</html>
EOF;
}
/**********************************************************************************************/

function show_widgets($widgets_array)
{
	$widget_defs = array();

	$widget_defs['chart']['small'] = 'small_chart_outer';
	$widget_defs['chart']['medium'] = 'med_chart_outer';
	$widget_defs['chart']['big'] = 'big_chart_outer';
	$widget_defs['grid']['small'] = 'small_grid_outer';
	$widget_defs['grid']['medium'] = 'med_grid_outer';
	$widget_defs['grid']['big'] = 'big_grid_outer';

    $no = 1;
    foreach ($widgets_array as $row)
    {
echo <<<EOF
        <!-- Widget container $no -->
        <div class="widget_contr">
EOF;
        foreach ($row as $widget)
        {
            $div = 'DIV_' . $no;
			$page_id = "form_" . $widget["NAME"] . "_paging";
            if($widget["TYPE"] == "chart")
            {
                $sze = $widget["SIZE"];
                print "
                <!-- Widget outer --> 
                <div id=" . $div . "_outer class=" . $widget_defs['chart'][$sze] . ">
                    <h3 style='text-align:left;text-valign:top;display:inline-block'>" . $widget['HEADING'] . "</h3>
					<i  style='text-align:right;vertical-align: middle;display:inline-block' id=$page_id></i>
					<i id='" . $div . "_curtain' class='fa loading'>
					Loading...
					</i>
					<i id=" . $div . "_head  class='expand fa fa-expand fa-pull-right'></i>
                    <i class='expand ui-widget-header fa fa-chevron-circle-down fa-2x fa-pull-right' id=click_" . $widget['NAME'] . "></i>
                    <div id='" . $div . "' style='display:none;z-index:4;position:relative'>
                    </div>
                ";
                dashboard_form($widget);
            }
            else
            {
            print "
                <!-- Widget outer --> 
                <div id=" . $div . "_outer class=" . $widget_defs['grid'][$widget['SIZE']] . ">
                    <h3 style='text-align:left;text-valign:top;display:inline-block'>" . $widget['HEADING'] . "</h3>
					<i id=" . $div . "_head  class='expand fa fa-expand fa-pull-right'></i>
                    <table style='float: left;height:auto;' id='" . $div . "'></table>
                ";
                dashboard_form($widget);
            }
echo <<<EOF
                <!-- Widget outer -->
                </div>
EOF;
            $no++;
        }
echo <<<EOF
        <!-- Widget container $no -->
        </div>
EOF;
    }
}
/**********************************************************************************************/
?>
