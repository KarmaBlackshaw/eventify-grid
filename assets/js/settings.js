  $('#navbar li a.nav-link').on('click', function(){
    $('#navbar li a.active').removeClass('active');
    $(this).addClass('active');
  })

  $('#navbar li a.nav-link, #navbar .nav-item .dropdown-menu a.dropdown-item, #dropdown-profile a.nav-link, #dropdown-profile .dropdown-menu a.dropdown-item, a#redirect').on('click', function(e){
    e.preventDefault();
    if($(this).data('target') !== undefined){
      var target = $(this).data('target');
      var url = target.split('?').slice(-2)[0];
      var data = target.split('?').slice(-1)[0];
      var body = $('.page-main');
      var html = $('html');

      if(data === url){
        body.load(views(url));
      } else{
        body.load(views(url, data));
      }
    }
  });