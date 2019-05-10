/**
 * File Bar Actions
 */
 var $ = jQuery;
$(document).ready(function(){

    // File myajax.js connection control
    $('#share_btn').click(function(){
        alert('Share Button clicked!')
    });



  // ACTION: Remove File AJAX Action
  $('#file_remove').click(function(){
    var id = this.id;
    var split_id = id.split("_");

    $('figure').each(function(i,elem) {
    if ($(this).hasClass("active")) {
        // alert("Остановлено на " + i + "-м пункте списка.");
        alert('This file will be removed! '+'Are you sure?')
        var imgElement_src = $( '.figure.active #img_'+i ).attr("src");
        var imgFile_src = $( '.figure.active #img_'+i ).attr("data-src");
        var curUser_src = $( '.figure.active #img_'+i ).attr("data-usr");
        console.log(imgElement_src);
        var data = {
            action: 'myajax-remove',
            nonce_code : the_ajax_script.nonce,
            path: imgElement_src,
            fileName: imgFile_src,
            currentUser: curUser_src
        };
        $.post( the_ajax_script.myajaxurl, data, function(response) {
            console.log(split_id);
            console.log('Response: '+response);
            // Changing image source when remove
            if(response){
              // $("#img_" + split_id[1]).attr("src","images/noimage.png");
              $('figure.active').parents().eq(1).remove();
              // location.reload();
            } else alert('ERROR: You cannot remove this file');
          
        });    
        // return false;
    } else {
        // alert(i + ': ' + $(elem).text());
    }
    });    

  });



    // ACTION: Rename File AJAX Action
    $('#file_rename').click(function (event) {
        $('#renFileModal').modal('show');
        console.log('test');
        var id = this.id;
        var split_id = id.split("_");

        $('figure').each(function(i,elem) {
        if ($(this).hasClass("active")) {
            // alert("Остановлено на " + i + "-м пункте списка.");
            // alert('This file will be renamed! '+'Are you sure?');
            var imgElement_src = $( '.figure.active #img_'+i ).attr("src");
            var imgFile_src = $( '.figure.active #img_'+i ).attr("data-src");
            var curUser_src = $( '.figure.active #img_'+i ).attr("data-usr");
            console.log(imgElement_src);
            $( '[name="renfile"]' ).attr('value', imgFile_src);
            $( '[name="renfile"]' ).change(function() {
                // alert( "Handler for .change() called." );
                var newFileName_src = $( '[name="renfile"]' ).attr('value');
                console.log(newFileName_src);
                $( "#renFileModal" ).submit(function( event ) {
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

                    $.post( the_ajax_script.myajaxurl, data, function(response) {
                        console.log(split_id);
                        console.log('Response: '+response);
                        // Changing image source when remove
                        if(response){
                          // $("#img_" + split_id[1]).attr("src","images/noimage.png");
                          // $('figure.active').parents().eq(1).remove();
                          // alert('Server response received!')
                          // location.reload();+
                          console.log(data);
                          // $('figure.active .figure-caption li').empty();
                          $('figure.active .figure-caption .list-inline-item span:last-child').text(newFileName_src);
                          // $('figure.active .figure-caption li').replaceWith(data.newFileName);
                          // $('figure.active .figure-caption .list-inline-item').replaceWith($('figure.active .figure-caption .list-inline-item', $(newFileName)));
                          // $('figure.active .figure-caption .list-inline-item').replaceWith(newFileName);
                          // $('figure.active .figure-caption .list-inline-item').replaceWith(data[newFileName]);
                          // $('#renFileModal').modal('hide');
                        } else alert('ERROR: You cannot remove this file');
                      
                    });                    
                $('#renFileModal').modal('hide');
                });                
            });            

            return false;
        
        } else {
            // alert(i + ': ' + $(elem).text());
        }

        });

    });  







}); // $(document).ready(function() close curls! 