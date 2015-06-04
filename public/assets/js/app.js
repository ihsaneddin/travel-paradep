var App;App=(function($){"use strict";var handleNumberSignLinks,handleSidebarChat,handleSidebarOptions,handleSuperMenu,handleUiPro,init,isRTLVersion,isTouchDevice;isTouchDevice=function(){if(("ontouchstart"in window)||window.DocumentTouch&&document instanceof DocumentTouch){return true;}else{return false;}};isRTLVersion=function(){return $("body").hasClass('rtl');};init=function(){handleNumberSignLinks();handleSidebarOptions();handleSidebarChat();handleUiPro();handleSuperMenu();};handleNumberSignLinks=function(){$("[href|='#']").click(function(e){e.preventDefault();});};handleSidebarOptions=function(){var dividersTrigger,sidebar,wraper;sidebar=$(".social-sidebar");wraper=$(".wraper");return dividersTrigger=$("#panel #sidebar-dividers");};handleSidebarChat=function(){if(typeof chatboxManager!=='undefined'){chatboxManager.init({sender:{username:"Me",lastname:"Me"}});$(".chat-users .user-list li > a").click(function(event,ui){var id;id=$(this).attr("data-userid");chatboxManager.addBox(id,{title:"chatbox"+ id,firstname:$(this).attr("data-firstname"),lastname:$(this).attr("data-lastname"),status:$(this).attr("data-status")});event.preventDefault();});return;}};handleUiPro=function(){if(isTouchDevice()===false){if(isRTLVersion()){$.uiPro({leftMenu:".rightPanel",threshold:15});}else{$.uiPro({rightMenu:".rightPanel",threshold:15});}}};handleSuperMenu=function(){return $(document).on("click",".social-sm .dropdown-menu",function(e){e.stopPropagation();});};return{init:init,isTouchDevice:isTouchDevice};})(jQuery);

$(function () {

    $(window).scroll(function () {
        var top = $(document).scrollTop();
        var navbar = $('header > nav');

        if(top > 15){
            navbar.addClass('shadow-sm');
        }
        if(top > 200){
            navbar.addClass('shadow-md');
        }
        if(top > 400){
            navbar.addClass('shadow-lg');
        }
        if(top > 800){
            navbar.addClass('shadow-xl');
        }
        if(top < 15){
            navbar.removeClass('shadow-sm shadow-md shadow-lg shadow-xl');
        }
    });

    $.blockUI.defaults.message = 'Please Wait...';
    $.blockUI.defaults.css = {
        padding:  '5px 50px',
        '-webkit-border-radius': '100px',
        '-moz-border-radius': '100px',
        background: '#000',
        opacity: .5,
        margin:   0,
        top:    '40%',
        left:   '35%',
        textAlign:  'center',
        color:    '#fff',
        cursor:   'wait'
    };

    $('.input-date').datepicker().on('changeDate', function(ev){
        $(this).datepicker('hide');
    });
    $('.input-datetime').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 0
    });
    $('.input-datetime-only-date').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    }).on('changeDate', function(ev){
        if ($(this).hasClass('update-the-hour'))
        {
            var form_group = $(this).parents('div.form-group'),
                hour_input = form_group.find('div'+$(this).attr('data-hour-target'));
            if (hour_input.length)
            {
                var selected_hour = hour_input.find('input').val().length ? hour_input.find('input').val() : '00:00';
                hour_input.datetimepicker('update', new Date($(this).find('input').val()+' '+selected_hour));
            }
        }
    });
    $('.input-datetime-only-hour').datetimepicker({
        weekStart: 0,
        autoclose: 1,
        todayHighlight: 1,
        startView: 1,
        minView: 0,
        maxView: 1,
        forceParse: 0
    });


});

function generateRandomData(min, max, count)
{
    var d1 = [];
    for (var i = 1; i <= count; i++) {
        var val1 = min + 20 + Math.floor((Math.random()*max)+1);
        d1.push([i, val1]);
    };
    return d1;
}