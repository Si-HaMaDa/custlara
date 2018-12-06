$(document).ready(function(){
    console.log('HaMaDa');
    $('#statu').on('change', function(){
        var valus_note = ['a', 'f', 's'];
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
function start_conv(){$('#statu').val('p');$('#try_note').fadeOut();}
function end_convf(){$('#statu').val('f');$('#try_note').fadeIn()}
function end_convs(){$('#statu').val('s');$('#try_note').fadeIn()}
function need_atten(){$('#statu').val('a');$('#try_note').fadeIn()}
function start_soul(){$('#statu').val('p');$('#try_note').fadeOut();}


