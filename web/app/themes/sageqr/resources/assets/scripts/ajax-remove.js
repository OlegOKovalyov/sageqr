// var ppp = 1; // Post per page
//     var pageNumber = 2;
//     var total = jQuery('#totalpages').val();
//     jQuery("#more_posts").on("click", function ($) { // When btn is pressed.
//         jQuery("#more_posts").attr("disabled", true); // Disable the button, temp.
//         pageNumber++;
//         var str = '&pageNumber=' + pageNumber + '&ppp=' + ppp + '&action=more_post_ajax';
//         jQuery.ajax({
//             type: "POST",
//             dataType: "html",
//             url: rm_ajax_script.ajaxurl,
//             data: str,
//             success: function (data) {
//                 var $data = jQuery(data);
//                 if ($data.length) {
//                     jQuery("#ajax-posts").append($data);
//                     jQuery("#more_posts").attr("disabled", false);
//                 } else {
//                     jQuery("#more_posts").attr("disabled", true);
//                 }                
//                 if (total < pageNumber) {
//                     jQuery("#more_posts").hide();
//                 }
//             },
//             error: function (jqXHR, textStatus, errorThrown) {
//                 $loader.html(jqXHR + " :: " + textStatus + " :: " + errorThrown);
//             }
  
//         });
//         return false;
// });


// $('.delete').live('click',function(){ 
//   deleteFile( $(this).attr('id') );
// });

// function deleteFile(id){
//     $.ajax({
//         url: 'deletefile.php?fileid='+id,
//         success: function() {
//             alert('File deleted.');
//         }
//     });
// }

// jQuery("remove_btn").click(function(){
//   jQuery("#div1").load("demo_test.txt", function(responseTxt, statusTxt, xhr){
//     if(statusTxt == "success")
//       alert("External content loaded successfully!");
//     if(statusTxt == "error")
//       alert("Error: " + xhr.status + ": " + xhr.statusText);
//   });
// }); 



// jQuery.ajax({
//       url: '/my-documents/',
//       data: {'file' : file_path },
//       dataType: 'json', 
//       success: function (response) {
//          if( response.status === true ) {
//              alert('File Deleted!');
//          }
//          else alert('Something Went Wrong!');
//       }
//     });

// jQuery.ajax({
//     type: 'post',
//     dataType: 'json',
//     url: jsforwp_globals.ajax_url,
//     data: {
//         action: jsforwp_add_like,
//         _ajax_nonce: jsforwp_globals.nonce
//     },
//     //...
// });
// console.log(data);


function removeFile(id){
    alert("File will be remove! Are you sure?");


var file; // переменная. будет содержать данные файлов

// заполняем переменную данными файлов, при изменении значения file поля
    file = this.file;
    console.log('file:')
    console.log(file.name);
    var data = new FormData(); console.log(data);
    // заполняем объект данных файлами в подходящем для отправки формате
    jQuery.each( file, function( key, value ){
        data.append( key, value );
    });    
    // добавим переменную идентификатор запроса
    data.append( 'file_to_remove', 1 );
    // AJAX запрос
    jQuery.ajax({
        // url         : "<?php //get_template_directory_uri('/inc/ajax-remove.php') ?>",
        // url         : '/app/themes/sageqr/resources/views/inc/file_remove.php',
        // url         : '<?php //get_template_directory() ?>' + 'inc/file-remove.php',
        // url         : 'http://test5.local/web/app/themes/sageqr/resources/views/inc/file-remove.php',
        // url         : '/app/themes/sageqr/resources/views/inc/file_remove.php',
        // url         : '../file_remove.php',
        // url         : '//var/www/test5.local/public_html/bedrock/web/app/themes/sageqr/resources/views/inc/file_remove.php', // WORKING!!!
        // url         : '../inc/file_remove.php',
        url         : '/app/themes/sageqr/resources/views/inc/file_remove',
        type        : 'POST',
        data        : data,
        cache       : false,
        dataType    : 'json',
        // отключаем обработку передаваемых данных, пусть передаются как есть
        processData : false,
        // отключаем установку заголовка типа запроса. Так jQuery скажет серверу что это строковой запрос
        contentType : false,
        // функция успешного ответа сервера
        success     : function( respond, status, jqXHR ){

            // ОК
            if( typeof respond.error === 'undefined' ){
                // файлы загружены, делаем что-нибудь

                // покажем пути к загруженным файлам в блок '.ajax-reply'

                var files_path = respond.files;
                var html = '';
                jQuery.each( files_path, function( key, val ){
                     html += val +'<br>';
                } )

                jQuery('.ajax-reply').html( html );
            }
            // error
            else {
                console.log('ОШИБКА: ' + respond.error );
            }
        },
        // функция ошибки ответа сервера
        error: function( jqXHR, status, errorThrown ){
            console.log( 'ОШИБКА AJAX запроса: ' + status, jqXHR );
        }

    });

    // jQuery.ajax({
    //     url: 'deletefile.php?fileid='+id,
    //     success: function() {
    //         alert('File deleted.');
    //     }
    // });
}

// jQuery(document).ready(function($){
//     jQuery('figure').each(function(i,elem) {
//     if (jQuery(this).hasClass("active")) {
//         alert("Остановлено на " + i + "-м пункте списка.");
//         var imgElement_src = jQuery( '.figure.active #img_'+i ).attr("src");
//         console.log('imgElement_src');
//         var data = {
//             action: 'myajax-submit',
//             path: imgElement_src
//         };
//         jQuery.post( the_ajax_script.myajaxurl, data, function(response) {
     
//             // Changing image source when remove
//             if(response == 1){
//               jQuery("#img_" + split_id[1]).attr("src","images/noimage.png");
//             } else alert('ERROR: You cannot remove this file');
          
//         });    
//         return false;
//     } else {
//         alert(i + ': ' + jQuery(elem).text());
//     }
// });   
// })