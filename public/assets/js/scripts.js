function initializeJS() {
    //tool tips
    jQuery('.tooltips').tooltip();
    $('[data-toggle="tooltip"]').tooltip();

    //popovers
    jQuery('.popovers').popover();
    $('[data-toggle="popover"]').popover({
        html : true
    });

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
            cancelButtonText: "Cancelar",  
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

var CURRENT_URL = window.location.href.split('?')[0];

function getPages(page) {
    if(page) {
        $.ajax({
            url: page,
            type:"GET",
            dataType: 'json',
            success: function(response) {
                if(response.success){
                    $('#load-content').html(response.view);
                    CURRENT_URL = page;
                }
            },
            error: function (status) {
                console.log(status)
            }
        });
    }
}

//open create show or edit in modal or content
$(document).on('click', '.create-edit-show', function () {
    $('[data-toggle="tooltip"]').tooltip('hide');
    var $this = $(this);
    var title = $this.attr("title");
    if(!title) {
        title = $this.data("title");
    }
    var message = $this.data("message");

    current_model = $this.data('model');
    if($this.data('current')){
        CURRENT_URL = $this.data('current');
    }
    if($this.data('div')){
        divId = $this.data('div');
    } else {
        divId = 'tab-content';
    }
    var href = $this.data('href');
    if($this.data('url')){
        href = $this.data('url');
    }
    $.ajax({
        url: href,
        type:'GET',
        success: function(response) {
            if(response.success){
                if(current_model == 'modal') {
                    $('#modal-title').text(title);
                    $('#modal-title').html(title);
                    $('#content-modal').html(response.view);
                    $('#general-modal').modal('show');
                } else {
                    $('.top_search').hide();
                    $('.btn-create').hide();
                    current_title = $('#content-title').text();
                    $('#content-title').text(title);
                    $('#tab-content').html(response.view);
                }
            } else {
                sweetAlert("Oops...", response.message, "error");
            }
        },
        error: function (status) {
            console.log(status.statusText);
        }
    });
});

function showLoading() {
    $('#loading').addClass('is-active');
}

function hideLoading() {
    $('#loading').removeClass('is-active'); 
}