
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
            $(".chosen-choices li").css("background","LightBlue");
            break;
        default:
            AmCharts.theme = AmCharts.themes.light;
            $(".chosen-choices li").css("background","LightBlue");
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
	vph = vph - 100;
	$('#scroll').css({'height': vph + 'px'});
}
/***************************************************************************************************/

function dispatch_events(ROOT)
{
var option;
$.themes.setDefaults({themeBase: '../jquery-ui-themes-1.12.1/themes/',
                      previews: '../js/themes-preview.gif',
                      icons: '../js/themes.gif',
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
    get_theme_cookie();
    $('#selectThemes').themes({themes: ['darkhive','cupertino','smoothness','dotluv']});
    $('#scroll').css({'z-index':'1','position':'absolute'});
    $( '#list1 li').click(function()
    {
        $('#list1').option = $(this).text();
        $("h2#heading").text(option);
    });
    $(".date_input").datepicker({dateFormat: "yy-mm-dd"}).attr('readonly', 'true');
	$('.chosen-select').chosen({max_selected_options:7}).change();	$("h4#date").text("Last Updated: "+Date());
	$('#DIV_1').addClass('big_div_class');
	$('#DIV_1').show();
	get_country_fact_sheets_submit(ROOT,'DIV_1','#form_get_country_fact_sheets','#click_get_country_fact_sheets');
	$('#form_get_country_fact_sheets').trigger('submit');
	$("h4#date").text("Last Updated: "+Date());
	$('#DIV_2').addClass('big_div_class');
	$('#DIV_2').show();
	country_area_submit(ROOT,'DIV_2','#form_country_area','#click_country_area');
	$('#form_country_area').trigger('submit');
	$("h4#date").text("Last Updated: "+Date());
	$('#DIV_3').addClass('big_div_class');
	$('#DIV_3').show();
	country_gdp_submit(ROOT,'DIV_3','#form_country_gdp','#click_country_gdp');
	$('#form_country_gdp').trigger('submit');
	$("h4#date").text("Last Updated: "+Date());
	$('#DIV_4').addClass('big_div_class');
	countries_data_submit(ROOT,'DIV_4','#form_countries_data');
	$('#form_countries_data').trigger('submit');
	$("h4#date").text("Last Updated: "+Date());
});
}
