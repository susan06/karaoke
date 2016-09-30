function initializeJS() {

    //tool tips
    jQuery('.tooltips').tooltip();
    $('[data-toggle="tooltip"]').tooltip();

    //popovers
    jQuery('.popovers').popover();
    $('[data-toggle="popover"]').popover();
    
    //custom scrollbar
        //for html
    //jQuery("html").niceScroll({styler:"fb",cursorcolor:"#007AFF", cursorwidth: '6', cursorborderradius: '10px', background: '#F7F7F7', cursorborder: '', zindex: '1000'});
        //for sidebar
    //jQuery("#sidebar").niceScroll({styler:"fb",cursorcolor:"#007AFF", cursorwidth: '3', cursorborderradius: '10px', background: '#F7F7F7', cursorborder: ''});
        // for scroll panel
    //jQuery(".scroll-panel").niceScroll({styler:"fb",cursorcolor:"#007AFF", cursorwidth: '3', cursorborderradius: '10px', background: '#F7F7F7', cursorborder: ''});
    
    //sidebar dropdown menu
    jQuery('#sidebar .sub-menu > a').click(function () {
        var last = jQuery('.sub-menu.open', jQuery('#sidebar'));        
        jQuery('.menu-arrow').removeClass('arrow_carrot-right');
        jQuery('.sub', last).slideUp(200);
        var sub = jQuery(this).next();
        if (sub.is(":visible")) {
            jQuery('.menu-arrow').addClass('arrow_carrot-right');            
            sub.slideUp(200);
        } else {
            jQuery('.menu-arrow').addClass('arrow_carrot-down');            
            sub.slideDown(200);
        }
        var o = (jQuery(this).offset());
        diff = 200 - o.top;
        if(diff>0)
            jQuery("#sidebar").scrollTo("-="+Math.abs(diff),500);
        else
            jQuery("#sidebar").scrollTo("+="+Math.abs(diff),500);
    });

    jQuery('.toggle-nav').click(function () {
        if (jQuery('#sidebar > ul').is(":visible") === true) {
            jQuery('#main-content').css({
                'margin-left': '0px'
            });
            jQuery('#sidebar').css({
                'margin-left': '-180px'
            });
            jQuery('#sidebar > ul').hide();
            jQuery("#container").addClass("sidebar-closed");
        } else {
            jQuery('#main-content').css({
                'margin-left': '180px'
            });
            jQuery('#sidebar > ul').show();
            jQuery('#sidebar').css({
                'margin-left': '0'
            });
            jQuery("#container").removeClass("sidebar-closed");
        }
    });

    //bar chart
    if (jQuery(".custom-custom-bar-chart")) {
        jQuery(".bar").each(function () {
            var i = jQuery(this).find(".value").html();
            jQuery(this).find(".value").html("");
            jQuery(this).find(".value").animate({
                height: i
            }, 2000)
        })
    }

    //delete register
    $('.btn-delete').click(function() {
        var $this = $(this);
        var row = $this.closest('tr');
        swal({   
            title: $this.data('confirm-title'),   
            text: $this.data('confirm-text'),   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: $this.data('confirm-delete'),   
            closeOnConfirm: false }, 
            function(isConfirm){   
                if (isConfirm) {  
                    $.ajax({
                        type: 'POST',
                        url: $this.data('href'),
                        dataType: 'json',
                        data: { 'id': $this.data('id') },
                        success: function (request) {                         
                            if(request.success) {  
                                row.remove();
                                swal("Eliminado!", "Su registro ha sido eliminado.", "success");
                            } else {
                                swal("Error", request.message, "error");
                                row.addClass('danger');
                            }
                        },
                        error: function () {
                            row.addClass('danger');
                        }
                    });     
            } 
        });
    });

}

jQuery(document).ready(function(){
    initializeJS();
});