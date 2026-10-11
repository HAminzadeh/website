document.addEventListener('DOMContentLoaded',function(){
  var toggle=document.querySelector('.syf-mobile-toggle');
  var mobile=document.getElementById('syf-mobile-nav');
  if(toggle&&mobile){toggle.addEventListener('click',function(){
    var open=mobile.classList.toggle('is-open');
    toggle.setAttribute('aria-expanded',open?'true':'false');
    toggle.textContent=open?'×':'☰';
  });}

  document.querySelectorAll('[data-syf-static-form]').forEach(function(form){
    form.addEventListener('submit',function(event){
      event.preventDefault();
      var message=form.querySelector('[data-syf-form-message]');
      if(message) message.textContent='فرم نمایشی است؛ اتصال به backend در فاز بعدی فعال می‌شود.';
    });
  });

  document.querySelectorAll('.syf-faq').forEach(function(item){
    item.addEventListener('toggle',function(){
      var marker=item.querySelector('summary span');
      if(marker) marker.textContent=item.open?'−':'+';
    });
  });
});