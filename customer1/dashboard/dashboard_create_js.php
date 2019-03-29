<?php
include_once('../vars.inc');

if ($argc == 2) 
{
	if (php_sapi_name() == 'cli')
	{
		foreach($panes as $pane)
		{
			switch ($argv[1])
			{
                case "js":
                    create_js($pane["name"]);
					break;
				case "php":
					create_php($pane["name"]);
					break;
				case "widgets":
					create_widgets($pane["name"]);
					break;
				default:
					print "Usage: $argv[0] [js|php|widgets]" . "\n";
			}
		}
	}
}
else
	print "Usage: $argv[0] [js|php|widgets]" . "\n";

/*********************************************************************************************/

function print_top($fd,$count,$widgets_array)
{
fputs($fd,"

// This script has been auto-generated by Open-Dashboard. Never attempt to
// modify this.
// Suraj Vijayan
//
function get_theme_cookie()
{
    var cookieName = 'themeID';
    var search = new RegExp(cookieName + '=([^;]*)');
    var matches = search.exec(document.cookie);
    var themeId = (matches ? matches[1] : '') || '';
    if(themeId == '')
		themeId = 'smoothness';
    set_theme(themeId);
}
/***************************************************************************************************/

function set_theme(id)
{
    switch(id)
    {
        case 'uidarkness':
            AmCharts.theme = AmCharts.themes.black;
        case 'dotluv':
            AmCharts.theme = AmCharts.themes.dark;
            break;
        case 'darkhive':
            AmCharts.theme = AmCharts.themes.black;
            break;
        case 'blacktie':
            AmCharts.theme = AmCharts.themes.dark;
            break;
        case 'uilightness':
        case 'smoothness':
            AmCharts.theme = AmCharts.themes.light;
            break;
        case 'cupertino':
            AmCharts.theme = 'black';
            $('.chosen-choices li').css('background','LightBlue');
            break;
        default:
            AmCharts.theme = AmCharts.themes.light;
            $('.chosen-choices li').css('background','LightBlue');
            break;
    }
}
/***************************************************************************************************/

function fn(id,name,url)
{
    window.location.reload(true);
}
/***************************************************************************************************/

function resize_div() 
{
	vpw = $(window).width();
	vph = $(window).height();
	vph = vph - 125;
	$('#scroll').css({'height': vph + 'px'});
}
/***************************************************************************************************/

function serialize_forms(widgets_array,no_widgets,pane_name)
{
var i,args,fields;
/*
    for(i = 0;i < no_widgets;i++)
    {
        form_id = '#form_' + widgets_array[i].name; 
        var args = $(form_id).serializeArray();
        console.log('ID:'+i+' FORM:'+form_id)
        console.log(JSON.stringify(args));
    }
*/
    $('form').each
    (
        function(index)
        { 
            form_id = '#' + this.id;
            args = $(form_id).serializeArray();
            //store this JSON array of objects in DB
            console.log(JSON.stringify(args));
            $.each(args, function(i,field)
            {
                console.log('FORM_NAME:' +form_id + ' ' + field.name + ':' + field.value);
            });
        }
    );
}
/***************************************************************************************************/

function dispatch_events(ROOT,pane_name)
{
var w1,h1;
var no_widgets = $count;
");
create_js_config($fd,$widgets_array);
fputs($fd,"
var fscreen_flag = false;
$.themes.setDefaults({themeBase: '../static_files/jquery-ui-themes-1.12.1/themes/',
                      previews: '../static_files/js/themes-preview.gif',
                      icons: '../static_files/js/themes.gif',
                      cookieExpiry: 7,
                      themeFile: 'jquery-ui.min.css',
                      showPreview: false,
					  defaultTheme:'smoothness',
                      onSelect:fn});
$('#hoverThemes').hover(function() { $('#selectThemes').toggle()});
$('#selectThemes').hide();
$(window).onresize = function(event) 
{
	resize_div();
};

AmCharts.ready(function(){
	resize_div();
	$(window).on('resize', function()
	{
		resize_div();
	});
    var w = $(window).width()-55;
    var h = $(window).height()-120;
    var div_id = '';
    $('.fa-expand').click(function()
    {
        div_id = $(this).attr('id').split('_head')[0];
        $(this).toggleClass('fa-compress');
        if(fscreen_flag == false) // Maximizing
        {
            fscreen_flag = true;
            w1 =  $('#'+div_id).css('width');
            h1 =  $('#'+div_id+'_outer').css('height');
            $('#'+div_id+'_outer').animate({height:h}, 300,
            function()
            {
                for(i = 1;i <= no_widgets;i++)
                {
                    var tdiv = '#DIV_'+i;
                    if(tdiv != '#'+div_id)
                        $(tdiv+'_outer').fadeOut(1600, 'linear');
                }
            });
			id = div_id.split('DIV_')[1];
            if(widgets_array[id-1].type == 'chart')
                $('#'+div_id).animate({width:w}, 300);
            else
                $('table.'+div_id).attr('width', w);
            $('#'+div_id).addClass('active');
            $('#'+div_id).css({'z-index': '9999'});
        }
        else
        {
            fscreen_flag = false;
            div_id = $(this).attr('id').split('_head')[0];
            $('#'+div_id+'_outer').animate({height:h1}, 300,
            function()
            {
                for(i = 1;i <= no_widgets;i++)
                {
                    var tdiv = '#DIV_'+i;
                    if(tdiv != '#'+div_id)
                        $(tdiv+'_outer').fadeIn(1600, 'linear');
                }
            });
            $('#'+div_id).animate({width:w1}, 300);
            $('#'+div_id).addClass('active');
            $('#'+div_id).css({'z-index': '9999'});
        }
    });
    get_theme_cookie();
    $('#selectThemes').themes({themes: ['darkhive','cupertino','smoothness','dotluv']});
    $('#scroll').css({'z-index':'1','position':'absolute'});
    $( '#list1 li').click(function()
    {
        $('#list1').option = $(this).text();
    });
    $('.date_input').datepicker({dateFormat: 'yy-mm-dd'}).attr('readonly', 'true');
	$('.chosen-select').chosen({max_selected_options:7}).change();
    $( '#save-session').click(function()
    {
        serialize_forms(widgets_array,no_widgets,pane_name);
    });

");
}
/*****************************************************************************************/

function create_js($pane_name)
{
	global $panes;
	$js_file = "../static_files/dashboard/dashboard_" . $pane_name . ".js";
	$fd = fopen($js_file,"w");

	$found = FALSE;
	foreach($panes as $pane)
	{
		if($pane_name == $pane["name"])
		{
			$found = TRUE;
			if (!isset($pane["config"]))
			{
				print "'config' token is not defined in pane:$pane_name inside vars.inc file!\n";
				exit(0);
			}
		    if (!file_exists($pane["config"]))
            {
                print "Can't open:" . $pane["config"] . "!\n";
                exit(0);
            }
			include_once($pane["config"]);
			break;
		}
	}
	if (!$found)
	{
		print "Plane:$pane_name is not defined in in vars.inc file!\n";
		exit(0);
	}
	$count = array_sum(array_map("count", $widgets_array));
	print_top($fd,$count,$widgets_array);
	fputs($fd,"\t" . '$("h4#date").text("Last Updated: "+Date());' . "\n");
	$no = 1;
	foreach ($widgets_array as $row)
	{
		foreach ($row as $widget)
		{
			$div = 'DIV_' . $no;
			if($widget["TYPE"] == "chart")
			{
				switch ($widget["SIZE"])
				{
					case 'small':
						fputs($fd,"\t" . "$('#" . $div . "').addClass('small_div_class');" . "\n");
						break;
					case 'medium':
						fputs($fd,"\t" . "$('#" . $div . "').addClass('med_div_class');" . "\n");
						break;
					case 'big':
						fputs($fd,"\t" . "$('#" . $div . "').addClass('big_div_class');" . "\n");
						break;
				}
				fputs($fd,"\t" . "$('#" . $div . "').show();" . "\n");
				fputs($fd,"\t" . $widget['NAME'] . "_" . "submit(ROOT,'" . $div . "','#form_" . $widget['NAME'] . "','#click_" . $widget['NAME'] . "');" . "\n");
				fputs($fd,"\t" . "$('#form_" . $widget['NAME'] . "').trigger('submit');" . "\n");
				fputs($fd,"\t" . '$("h4#date").text("Last Updated: "+Date());' . "\n");
				if(!empty($widget["REFRESH_SECS"]) && $widget["REFRESH_SECS"] > 0)
				{
					$secs = $widget["REFRESH_SECS"] * 1000;
					fputs($fd,"\tsetInterval(" . "\n\t\tfunction()\n\t\t{\n\t\t\t" . "$('#form_" . $widget['NAME'] . "').trigger('submit');;\n\t\t},\n\t" . $secs . ");" . "\n");
				}
			}
			else
			{
				switch ($widget["SIZE"])
				{
					case 'small':
						fputs($fd,"\t" . "$('#" . $div . "').addClass('small_div_class');" . "\n");
						break;
					case 'medium':
						fputs($fd,"\t" . "$('#" . $div . "').addClass('med_div_class');" . "\n");
						break;
					case 'big':
						fputs($fd,"\t" . "$('#" . $div . "').addClass('big_div_class');" . "\n");
						break;
				}
				fputs($fd,"\t" . $widget['NAME' ] . "_submit(ROOT,'" . $div . "','#form_" . $widget['NAME'] . "');\n");
				fputs($fd,"\t" . "$('#form_" . $widget['NAME'] . "').trigger('submit');" . "\n");
				fputs($fd,"\t" . '$("h4#date").text("Last Updated: "+Date());' . "\n");
				if(!empty($widget["REFRESH_SECS"]) && $widget["REFRESH_SECS"] > 0)
				{
					$secs = $widget["REFRESH_SECS"] * 1000;
					fputs($fd,"\tsetInterval(" . "\n\t\tfunction()\n\t\t{\n\t\t\t" . "$('#form_" . $widget['NAME'] . "').trigger('submit');;\n\t\t},\n\t" . $secs .");\n");
				}
			}
			$no++;
		}
	}
	fputs($fd,"});\n}\n");
	fputs($fd,"/***************************************************************************************************/\n");
	fclose($fd);
}
/*****************************************************************************************/

function create_js_config($fd,$widgets_array)
{
    $no = 0;
    fprintf($fd, "\nvar widgets_array = [\n");
    $first = true;
    foreach ($widgets_array as $row)
    {
        foreach ($row as $widget)
        {
            if($first == true)
                $first = false;
            else
                fprintf($fd,",\n");
            fprintf($fd,"\t" . '{no:"' . $div = $no . '",'.
            'div:"' . $div = 'DIV_' . $no . '",'.
            'name:"' . $widget['NAME'] . '",'.
            'type:"' . $widget['TYPE'] . '"}');
            $no++;
        }
    }
    fputs($fd,"\n];\n");
}
/*********************************************************************************************/

function create_php($pane_name)
{
	$inc_file = "";
	$header = "";
	global $panes;
    $found = FALSE;
    foreach($panes as $pane)
    {
        if($pane_name == $pane["name"])
        {
            $found = TRUE;
            if (!isset($pane["config"]))
            {
                print "'config' token is not defined in pane:$pane_name inside vars.inc file!\n";
                exit(0);
            }
            if (!isset($pane["header"]))
            {
                print "'header' token is not defined in pane:$pane_name inside vars.inc file!\n";
                exit(0);
            }
            if (!file_exists($pane["config"]))
            {
                print "Can't open: " . $pane["config"] . "!\n";
                exit(0);
            }
            $inc_file = $pane["config"];
            $header = $pane["header"];
			$tokens = explode('.',$inc_file);
			$js_file = $tokens[0] . ".js";
			$widgets_file = $pane_name . "_widgets.js";
            break;
        }
    }
    if (!$found)
    {
        print "Plane:$pane_name is not defined in in vars.inc file!\n";
        exit(0);
    }
    $php_file = "dashboard_" . $pane_name . ".php";
    $fd = fopen($php_file,"w");

fputs($fd,"
<?php
/*
	Open-Dashboard: Designed by Suraj Vijayan - First Release: August 2018
*/
header('Access-Control-Allow-Origin: *');
session_start();
include_once('../vars.inc');
require_once('./dashboard.php');
require_once('./$inc_file');

print_header('$js_file','$widgets_file');
// Dashboard Menu stuff..
dashboard_header(\$ROOT,'$header');
show_widgets(\$widgets_array);
dashboard_footer(\$ROOT,'$pane_name');
?>
");
}
/*****************************************************************************************/

function create_widgets($pane_name)
{
    $inc_file = "";
    global $panes;
    $found = FALSE;
    foreach($panes as $pane)
    {
        if($pane_name == $pane["name"])
        {
            $found = TRUE;
            if (!isset($pane["config"]))
            {
                print "'config' token is not defined in pane:$pane_name inside vars.inc file!\n";
                exit(0);
            }
            if (!file_exists($pane["config"]))
            {
                print "Can't open:" . $pane["config"] . "!\n";
                exit(0);
            }
			else
            {
                $inc_file = $pane["config"];
            }
            if (!isset($pane["header"]))
            {
                print "'header' token is not defined in pane:$pane_name inside vars.inc file!\n";
                exit(0);
            }
			break;
        }
    }
    if (!$found)
    {
        print "Plane:$pane_name is not defined in in vars.inc file!\n";
        exit(0);
    }
    include_once($inc_file);
    $widgets_file = '../static_files/dashboard/' . $pane_name . "_widgets.js";
    $fd = fopen($widgets_file,"w");
    fputs($fd,"
/* Suraj Vijayan
 *
 * Got this from: http://chapter31.com/2006/12/07/including-js-files-from-within-js-files/
 *
 */
//this function includes all necessary js files for the application
function include(file)
{
    var script  = document.createElement('script');
    script.src  = file;
    script.type = 'text/javascript';
    script.defer = true;
    document.getElementsByTagName('head').item(0).appendChild(script);
}
");
	print '\n';
	if (!isset($widgets_array))
		return;
	foreach ($widgets_array as $row)
	{
		foreach ($row as $widget)
		{
			if($widget['TYPE'] == 'chart')
				$dir = 'static_files/dashboard/charts';
			else
				$dir = 'static_files/dashboard/grids';
			fputs($fd,"include('" . "$dir" . "/" . $widget["NAME"] . ".js" ."');\n");
		}
	}
}
/*****************************************************************************************/
?>