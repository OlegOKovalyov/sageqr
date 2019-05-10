export default {
  init() {
    // JavaScript to be fired on all pages
    // Плавное появление страниц на экране
    $(document).ready(function(){
        setTimeout(function () {
            $('body').addClass('active');
        }, 2000);
        $('body').fadeIn(1000); 
        $('.template-user-login').fadeIn(600);
        $('.template-user-register').fadeIn(600);
        $('.template-user-lost-password').fadeIn(600);
    });    
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
