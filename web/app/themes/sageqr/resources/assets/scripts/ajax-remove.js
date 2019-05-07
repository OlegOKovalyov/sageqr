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