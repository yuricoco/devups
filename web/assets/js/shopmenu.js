
/*---------------------------------------------------
    Main Menu
----------------------------------------------------- */
$('#column-left .nav > li > .dropdown-menu').each(function() {
    var menu = $('#column-left').offset();
    var dropdown = $(this).parent().offset();

    var i = (dropdown.left + $(this).outerWidth()) - (menu.left + $('#column-left').outerWidth());

    if (i > 0) {
        $(this).css('margin-left', '-' + (i + 5) + 'px');
    }
});

var $screensize = $(window).width();
$('#column-left .nav > li, #header .links > ul > li').on("mouseover", function() {

    if ($screensize > 991) {
        $(this).find('> .dropdown-menu').stop(true, true).slideDown('fast');
    }
    $(this).bind('mouseleave', function() {

        if ($screensize > 991) {
            $(this).find('> .dropdown-menu').stop(true, true).css('display', 'none');
        }
    });});
$('#column-left .nav > li div > ul > li').on("mouseover", function() {
    if ($screensize > 991) {
        $(this).find('> div').css('display', 'block');
    }
    $(this).bind('mouseleave', function() {
        if ($screensize > 991) {
            $(this).find('> div').css('display', 'none');
        }
    });});
$('#column-left .nav > li > .dropdown-menu').closest("li").addClass('sub');

// Clearfix for sub Menu column
$( document ).ready(function() {
    $screensize = $(window).width();
    if ($screensize > 1199) {
        $('#column-left .nav > li.mega-menu > div > .column:nth-child(6n)').after('<div class="clearfix visible-lg-block"></div>');
    }
    if ($screensize < 1199) {
        $('#column-left .nav > li.mega-menu > div > .column:nth-child(4n)').after('<div class="clearfix visible-lg-block visible-md-block"></div>');
    }
});
$( window ).resize(function() {
    $screensize = $(window).width();
    if ($screensize > 1199) {
        $("#column-left .nav > li.mega-menu > div .clearfix.visible-lg-block").remove();
        $('#column-left .nav > li.mega-menu > div > .column:nth-child(6n)').after('<div class="clearfix visible-lg-block"></div>');
    }
    if ($screensize < 1199) {
        $("#column-left .nav > li.mega-menu > div .clearfix.visible-lg-block").remove();
        $('#column-left .nav > li.mega-menu > div > .column:nth-child(4n)').after('<div class="clearfix visible-lg-block visible-md-block"></div>');
    }
});

// Clearfix for Brand Menu column
$( document ).ready(function() {
    $screensize = $(window).width();
    if ($screensize > 1199) {
        $('#column-left .nav > li.menu_brands > div > div:nth-child(12n)').after('<div class="clearfix visible-lg-block"></div>');
    }
    if ($screensize < 1199) {
        $('#column-left .nav > li.menu_brands > div > div:nth-child(6n)').after('<div class="clearfix visible-lg-block visible-md-block"></div>');
    }
    if ($screensize < 991) {
        $("#column-left .nav > li.menu_brands > div > .clearfix.visible-lg-block").remove();
        $('#column-left .nav > li.menu_brands > div > div:nth-child(4n)').after('<div class="clearfix visible-lg-block visible-sm-block"></div>');
        $('#column-left .nav > li.menu_brands > div > div:last-child').after('<div class="clearfix visible-lg-block visible-sm-block"></div>');
    }
    if ($screensize < 767) {
        $("#column-left .nav > li.menu_brands > div > .clearfix.visible-lg-block").remove();
        $('#column-left .nav > li.menu_brands > div > div:nth-child(2n)').after('<div class="clearfix visible-lg-block visible-xs-block"></div>');
        $('#column-left .nav > li.menu_brands > div > div:last-child').after('<div class="clearfix visible-lg-block visible-xs-block"></div>');
    }
});
$( window ).resize(function() {
    $screensize = $(window).width();
    if ($screensize > 1199) {
        $("#column-left .nav > li.menu_brands > div > .clearfix.visible-lg-block").remove();
        $('#column-left .nav > li.menu_brands > div > div:nth-child(12n)').after('<div class="clearfix visible-lg-block"></div>');
    }
    if ($screensize < 1199) {
        $("#column-left .nav > li.menu_brands > div > .clearfix.visible-lg-block").remove();
        $('#column-left .nav > li.menu_brands > div > div:nth-child(6n)').after('<div class="clearfix visible-lg-block visible-md-block"></div>');
    }
    if ($screensize < 991) {
        $("#column-left .nav > li.menu_brands > div > .clearfix.visible-lg-block").remove();
        $('#column-left .nav > li.menu_brands > div > div:nth-child(4n)').after('<div class="clearfix visible-lg-block visible-sm-block"></div>');
        $('#column-left .nav > li.menu_brands > div > div:last-child').after('<div class="clearfix visible-lg-block visible-sm-block"></div>');
    }
    if ($screensize < 767) {
        $("#column-left .nav > li.menu_brands > div > .clearfix.visible-lg-block").remove();
        $('#column-left .nav > li.menu_brands > div > div:nth-child(4n)').after('<div class="clearfix visible-lg-block visible-xs-block"></div>');
        $('#column-left .nav > li.menu_brands > div > div:last-child').after('<div class="clearfix visible-lg-block visible-xs-block"></div>');
    }
});

/*---------------------------------------------------
    Mobile Main Menu
----------------------------------------------------- */
$('#column-left .navbar-header > span').on("click", function() {
    $(this).toggleClass("active");
    $("#column-left .navbar-collapse").slideToggle('medium');
    return false;
});

//mobile sub menu plus/mines button
$('#column-left .nav > li > div > .column > div, .submenu, #column-left .nav > li .dropdown-menu').before('<span class="submore"></span>');
