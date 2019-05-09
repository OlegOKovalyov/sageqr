/**
 * File Bar Actions
 */
 var $ = jQuery;
jQuery(document).ready(function(){

    // File myajax.js connection control
    jQuery('#share_btn').click(function(){
        alert('Share Button clicked!')
    });

  // ACTION: Remove File AJAX Action
  jQuery('#file_remove').click(function(){
    var id = this.id;
    var split_id = id.split("_");

    jQuery('figure').each(function(i,elem) {
    if (jQuery(this).hasClass("active")) {
        // alert("Остановлено на " + i + "-м пункте списка.");
        alert('This file will be removed! '+'Are you sure?')
        var imgElement_src = jQuery( '.figure.active #img_'+i ).attr("src");
        var imgFile_src = jQuery( '.figure.active #img_'+i ).attr("data-src");
        var curUser_src = jQuery( '.figure.active #img_'+i ).attr("data-usr");
        console.log(imgElement_src);
        var data = {
            action: 'myajax-remove',
            nonce_code : the_ajax_script.nonce,
            path: imgElement_src,
            fileName: imgFile_src,
            currentUser: curUser_src
        };
        jQuery.post( the_ajax_script.myajaxurl, data, function(response) {
            console.log(split_id);
            console.log('Response: '+response);
            // Changing image source when remove
            if(response){
              // jQuery("#img_" + split_id[1]).attr("src","images/noimage.png");
              jQuery('figure.active').parents().eq(1).remove();
              // location.reload();
            } else alert('ERROR: You cannot remove this file');
          
        });    
        // return false;
    } else {
        // alert(i + ': ' + jQuery(elem).text());
    }
    });    

  });



    // ACTION: Rename File AJAX Action
    jQuery('#file_rename').click(function (event) {
        jQuery('#renFileModal').modal('show');
        console.log('test');
        var id = this.id;
        var split_id = id.split("_");

        jQuery('figure').each(function(i,elem) {
        if (jQuery(this).hasClass("active")) {
            // alert("Остановлено на " + i + "-м пункте списка.");
            // alert('This file will be renamed! '+'Are you sure?');
            var imgElement_src = jQuery( '.figure.active #img_'+i ).attr("src");
            var imgFile_src = jQuery( '.figure.active #img_'+i ).attr("data-src");
            var curUser_src = jQuery( '.figure.active #img_'+i ).attr("data-usr");
            console.log(imgElement_src);
            jQuery( '[name="renfile"]' ).attr('value', imgFile_src);
            jQuery( '[name="renfile"]' ).change(function() {
                // alert( "Handler for .change() called." );
                var newFileName_src = jQuery( '[name="renfile"]' ).attr('value');
                console.log(newFileName_src);
                jQuery( "#renFileModal" ).submit(function( event ) {
                    // alert( "Handler for .submit() called." );
                    event.preventDefault();

                    var data = {
                        action: 'myajax-rename',
                        nonce_code : the_ajax_script.nonce,
                        path: imgElement_src,
                        fileName: imgFile_src,
                        newFileName: newFileName_src,
                        currentUser: curUser_src
                    };

                    jQuery.post( the_ajax_script.myajaxurl, data, function(response) {
                        console.log(split_id);
                        console.log('Response: '+response);
                        // Changing image source when remove
                        if(response){
                          // jQuery("#img_" + split_id[1]).attr("src","images/noimage.png");
                          // jQuery('figure.active').parents().eq(1).remove();
                          // alert('Server response received!')
                          // location.reload();+
                          console.log(data);
                          // jQuery('figure.active .figure-caption li').empty();
                          jQuery('figure.active .figure-caption .list-inline-item span:last-child').text(newFileName_src);
                          // jQuery('figure.active .figure-caption li').replaceWith(data.newFileName);
                          // jQuery('figure.active .figure-caption .list-inline-item').replaceWith(jQuery('figure.active .figure-caption .list-inline-item', jQuery(newFileName)));
                          // jQuery('figure.active .figure-caption .list-inline-item').replaceWith(newFileName);
                          // jQuery('figure.active .figure-caption .list-inline-item').replaceWith(data[newFileName]);
                          // jQuery('#renFileModal').modal('hide');
                        } else alert('ERROR: You cannot remove this file');
                      
                    });                    
                jQuery('#renFileModal').modal('hide');
                });                
            });            

            return false;
        
        } else {
            // alert(i + ': ' + jQuery(elem).text());
        }

        });

    });  



/*var kamaFiles; // переменная. будет содержать данные файлов

// заполняем переменную данными, при изменении значения поля file 
$('input[type=file]').on('change', function(){
    kamaFiles = this.kamaFiles;
    console.log(kamaFiles);
});*/
 






});    