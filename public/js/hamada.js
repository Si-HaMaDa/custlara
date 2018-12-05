$(document).ready(function(){
    console.log('HaMaDa');
    $('#statu').on('change', function(){
        var valus_note = ['2', '3', '4'];
        if ( valus_note.includes( $(this).val() ) ){
            $('#try_note').fadeIn();
        }else{
            $('#try_note').fadeOut();
        }
    });
    $('#f_call').on('change', function(){
        console.log($(this).val());
        if ( $(this).is(':checked') ){
            $('#d_statu').fadeOut();
        }else{
            $('#d_statu').fadeIn();
        }
    });
})
function start_conv(){$('#statu').val('1');$('#try_note').fadeOut();}
function end_convf(){$('#statu').val('3');$('#try_note').fadeIn()}
function end_convs(){$('#statu').val('4');$('#try_note').fadeIn()}
function need_atten(){$('#statu').val('2');$('#try_note').fadeIn()}
function start_soul(){$('#statu').val('1');$('#try_note').fadeOut();}


