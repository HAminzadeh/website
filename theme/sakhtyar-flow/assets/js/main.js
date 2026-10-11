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

/* === SakhtYar Flow v0.4.2 === */
document.addEventListener('DOMContentLoaded',function(){
  document.querySelectorAll('[data-syf-preview-tabs]').forEach(function(group){
    var tabs=group.querySelectorAll('[data-syf-preview-tab]');
    var panels=group.querySelectorAll('[data-syf-preview-panel]');
    tabs.forEach(function(tab){
      tab.addEventListener('click',function(){
        var key=tab.getAttribute('data-syf-preview-tab');
        tabs.forEach(function(item){item.classList.toggle('is-active',item===tab);});
        panels.forEach(function(panel){
          panel.classList.toggle('is-active',panel.getAttribute('data-syf-preview-panel')===key);
        });
      });
    });
  });

  var reduced=window.matchMedia&&window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var revealItems=document.querySelectorAll('[data-syf-reveal]');
  if(reduced||!('IntersectionObserver' in window)){
    revealItems.forEach(function(item){item.classList.add('is-visible');});
  }else{
    revealItems.forEach(function(item){item.classList.add('syf-reveal-ready');});
    var observer=new IntersectionObserver(function(entries){
      entries.forEach(function(entry){
        if(entry.isIntersecting){
          entry.target.classList.add('is-visible');
          observer.unobserve(entry.target);
        }
      });
    },{threshold:.12,rootMargin:'0px 0px -30px 0px'});
    revealItems.forEach(function(item){observer.observe(item);});
  }
});

