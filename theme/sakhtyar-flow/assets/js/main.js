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


/* === SakhtYar Flow v0.4.3 === */
document.addEventListener('DOMContentLoaded',function(){
  var path=(location.pathname||'/').replace(/\/+$/,'')||'/';
  var map={'/property-intelligence':'property','/regulations':'regulations','/feasibility':'feasibility','/ai-assistant':'ai','/builder-matching':'matching','/financial-analysis':'financial','/reports-documents':'reports','/monitoring-alerts':'monitoring','/owners':'owner','/builders':'builder','/investors':'investor','/advisors':'advisor','/roadmap':'roadmap','/academy':'academy','/docs':'docs','/case-studies':'cases','/about':'about','/contact':'contact','/request-demo':'contact','/blog':'blog'};
  var accent=map[path]||(document.querySelector('.syf-v43-single')?'blog':null);
  if(accent) document.body.classList.add('syf-page-accent-'+accent);
  document.querySelectorAll('.syf-app-nav a,.syf-mobile-nav a').forEach(function(a){try{var p=new URL(a.href,location.origin).pathname.replace(/\/+$/,'')||'/';if(p===path)a.classList.add('is-current')}catch(e){}});

  function texts(sel){return Array.prototype.slice.call(document.querySelectorAll(sel)).map(function(e){return(e.textContent||'').trim()}).filter(Boolean)}
  var page=document.querySelector('.syf-v42-module-page');
  if(page){
    var caps=page.querySelectorAll('.syf-v42-module-capability'),flows=page.querySelectorAll('.syf-v42-module-workflow article');
    var moduleTitle=(page.querySelector('h1')||{}).textContent||'ماژول ساخت‌یار';
    function mk(t,c,x){var e=document.createElement(t);if(c)e.className=c;if(x!==undefined)e.textContent=x;return e}
    function dialog(){
      var d=document.querySelector('.syf-v43-detail-dialog');if(d)return d;
      d=document.createElement('dialog');d.className='syf-v43-detail-dialog';
      var h=mk('div','syf-v43-detail-dialog__head'),copy=mk('div',''),close=mk('button','syf-v43-detail-dialog__close','×');
      copy.appendChild(mk('small','syf-v43-detail-kind','جزئیات'));copy.appendChild(mk('h2','syf-v43-detail-title',''));copy.appendChild(mk('p','syf-v43-detail-desc',''));
      close.type='button';close.setAttribute('aria-label','بستن');close.onclick=function(){d.close()};h.appendChild(copy);h.appendChild(close);
      d.appendChild(h);d.appendChild(mk('div','syf-v43-detail-dialog__body',''));d.addEventListener('click',function(e){if(e.target===d)d.close()});document.body.appendChild(d);return d
    }
    function open(card,kind,index){
      var d=dialog(),title=(card.querySelector('h3')||{}).textContent||('مرحله '+(index+1)),desc=(card.querySelector('p')||{}).textContent||'';
      d.querySelector('.syf-v43-detail-kind').textContent=(kind==='cap'?'جزئیات قابلیت':'جزئیات مرحله')+' / '+moduleTitle;d.querySelector('.syf-v43-detail-title').textContent=title;d.querySelector('.syf-v43-detail-desc').textContent=desc;
      var ins=texts('.syf-module-io-grid>article:first-child .syf-module-list p').slice(0,5),outs=texts('.syf-module-io-grid>article:nth-child(2) .syf-module-list p').slice(0,5),steps=Array.prototype.slice.call(flows).map(function(x){return(x.querySelector('h3')||{}).textContent||'مرحله'});
      var b=d.querySelector('.syf-v43-detail-dialog__body');b.innerHTML='';var io=mk('div','syf-v43-detail-dialog__io');
      [['ورودی‌های مرتبط',ins],['خروجی‌های مورد انتظار',outs]].forEach(function(g){var s=mk('section','syf-v43-detail-panel'),ul=mk('ul','');s.appendChild(mk('h3','',g[0]));g[1].forEach(function(x){ul.appendChild(mk('li','',x))});s.appendChild(ul);io.appendChild(s)});b.appendChild(io);
      var form=mk('section','syf-v43-demo-form'),fh=mk('div','syf-v43-demo-form__head');fh.appendChild(mk('h3','','نمونه فرم این بخش'));fh.appendChild(mk('span','','نمونه UI'));form.appendChild(fh);var fg=mk('div','syf-v43-demo-form__grid');ins.slice(0,3).forEach(function(x){var fld=mk('div','syf-v43-demo-field');fld.appendChild(mk('small','',x));fld.appendChild(mk('span','','در نسخه عملیاتی از پرونده/کاربر دریافت می‌شود'));fg.appendChild(fld)});form.appendChild(fg);var fb=mk('button','','اجرای نمونه در اپلیکیشن');fb.type='button';fb.disabled=true;form.appendChild(fb);b.appendChild(form);
      var f=mk('section','syf-v43-flow');f.appendChild(mk('h3','','فلوچارت این ماژول'));var tr=mk('div','syf-v43-flow__track');
      steps.forEach(function(x,i){var st=mk('div','syf-v43-flow__step'+(kind==='flow'&&i===index?' is-current':''));st.appendChild(mk('span','',String(i+1).padStart(2,'0')));st.appendChild(mk('strong','',x));tr.appendChild(st)});f.appendChild(tr);b.appendChild(f);
      b.appendChild(mk('div','syf-v43-detail-dialog__hint',kind==='cap'?'این قابلیت بخشی از زنجیره تصمیم است؛ کیفیت داده، فرضیات و مرحله بعدی را همزمان ببینید.':'ورودی این مرحله از قبل می‌آید و خروجی باید برای مرحله بعد قابل استفاده و قابل پیگیری باشد.'));
      if(d.showModal)d.showModal();else d.setAttribute('open','open')
    }
    caps.forEach(function(c,i){c.setAttribute('role','button');c.tabIndex=0;c.onclick=function(){open(c,'cap',i)};c.onkeydown=function(e){if(e.key==='Enter'||e.key===' '){e.preventDefault();open(c,'cap',i)}}});
    flows.forEach(function(c,i){c.setAttribute('role','button');c.tabIndex=0;c.onclick=function(){open(c,'flow',i)};c.onkeydown=function(e){if(e.key==='Enter'||e.key===' '){e.preventDefault();open(c,'flow',i)}}});
  }

  var article=document.querySelector('[data-syf-article-content]'),toc=document.querySelector('[data-syf-article-toc]');
  if(article&&toc)article.querySelectorAll('h2').forEach(function(h,i){if(!h.id)h.id='section-'+(i+1);var a=document.createElement('a');a.href='#'+h.id;a.textContent=h.textContent;toc.appendChild(a)});
});


/* SYF_UI_UX_V062 */
document.addEventListener('DOMContentLoaded', function () {
  const button = document.querySelector('.syf-mobile-toggle');
  const nav = document.getElementById('syf-mobile-nav');
  const more = document.querySelector('.syf-nav-more');

  if (button && nav) {
    const closeNav = () => {
      nav.classList.remove('is-open');
      button.setAttribute('aria-expanded', 'false');
      button.setAttribute('aria-label', 'باز کردن منو');
      button.textContent = '☰';
    };

    button.addEventListener('click', () => {
      button.setAttribute(
        'aria-label',
        nav.classList.contains('is-open') ? 'بستن منو' : 'باز کردن منو'
      );
    });

    nav.querySelectorAll('a').forEach(link =>
      link.addEventListener('click', closeNav)
    );

    document.addEventListener('click', event => {
      if (!nav.contains(event.target) && !button.contains(event.target)) {
        closeNav();
      }
    });

    window.addEventListener('resize', () => {
      if (window.innerWidth > 1180 && nav.classList.contains('is-open')) {
        closeNav();
      }
    });

    document.addEventListener('keydown', event => {
      if (event.key === 'Escape' && nav.classList.contains('is-open')) {
        closeNav();
        button.focus();
      }
    });
  }

  if (more) {
    document.addEventListener('click', event => {
      if (!more.contains(event.target)) more.open = false;
    });

    more.querySelectorAll('a').forEach(link =>
      link.addEventListener('click', () => { more.open = false; })
    );

    document.addEventListener('keydown', event => {
      if (event.key === 'Escape' && more.open) {
        more.open = false;
        more.querySelector('summary')?.focus();
      }
    });
  }

  document.querySelectorAll(
    '.syf-app-nav a.is-current,.syf-mobile-nav a.is-current'
  ).forEach(link => {
    link.setAttribute('aria-current', 'page');
  });
});