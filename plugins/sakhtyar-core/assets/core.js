
document.addEventListener('DOMContentLoaded', function () {
  var cfg = window.SYF_CORE || {};

  function gateDialog() {
    var existing = document.querySelector('.syf-core-gate-dialog');
    if (existing) return existing;

    var dialog = document.createElement('dialog');
    dialog.className = 'syf-core-gate-dialog';
    dialog.innerHTML =
      '<div class="syf-core-gate-dialog__inner">' +
        '<button type="button" class="syf-core-gate-dialog__close" aria-label="بستن">×</button>' +
        '<div class="syf-core-gate-dialog__icon">🔐</div>' +
        '<h2>برای دیدن جزئیات، حساب ساخت‌یار لازم است</h2>' +
        '<p>بعد از ساخت حساب رایگان می‌توانید فلوچارت‌ها، جزئیات ماژول‌ها و محتوای کامل دانش ساخت را ببینید.</p>' +
        '<div class="syf-core-gate-dialog__actions">' +
          '<a class="syf-btn syf-btn--primary" data-syf-gate-account>ساخت حساب / ورود</a>' +
          '<button type="button" class="syf-btn syf-btn--outline" data-syf-gate-cancel>فعلاً نه</button>' +
        '</div>' +
      '</div>';

    document.body.appendChild(dialog);

    dialog.querySelector('.syf-core-gate-dialog__close').addEventListener('click', function(){ dialog.close(); });
    dialog.querySelector('[data-syf-gate-cancel]').addEventListener('click', function(){ dialog.close(); });
    dialog.addEventListener('click', function(e){ if(e.target === dialog) dialog.close(); });

    return dialog;
  }

  document.addEventListener('click', function (event) {
    if (cfg.canModuleDetails) return;
    var target = event.target.closest('.syf-v42-module-capability,.syf-v42-module-workflow article');
    if (!target) return;

    event.preventDefault();
    event.stopPropagation();
    event.stopImmediatePropagation();

    var dialog = gateDialog();
    var account = dialog.querySelector('[data-syf-gate-account]');
    var next = encodeURIComponent(window.location.href);
    account.href = (cfg.accountUrl || '/account/') + '?next=' + next;

    if (typeof dialog.showModal === 'function') dialog.showModal();
    else dialog.setAttribute('open','open');
  }, true);

  var analytics = document.querySelector('[data-syf-analytics]');
  if (!analytics || !cfg.canAnalytics || !cfg.restUrl) return;

  var region = analytics.querySelector('[data-syf-region]');
  var period = analytics.querySelector('[data-syf-period]');

  function el(selector){ return analytics.querySelector(selector); }
  function clear(node){ while(node && node.firstChild) node.removeChild(node.firstChild); }

  function render(data){
    var state = analytics.querySelector('.syf-core-source-state');
    var source = el('[data-syf-source]');
    var updated = el('[data-syf-updated]');
    if(source) source.textContent = data.source === 'live' ? 'داده زنده Backend' : 'حالت نمایشی';
    if(updated) updated.textContent = data.updated_at ? 'آخرین به‌روزرسانی: ' + data.updated_at : '';
    if(state) state.classList.toggle('is-live', data.source === 'live');

    var kpis = el('[data-syf-kpis]');
    clear(kpis);
    (data.metrics || []).forEach(function(item){
      var article = document.createElement('article');
      article.innerHTML = '<small></small><strong></strong><span></span>';
      article.querySelector('small').textContent = item.label || '';
      article.querySelector('strong').textContent = item.value || '—';
      article.querySelector('span').textContent = item.delta || '';
      kpis.appendChild(article);
    });

    var series = data.price_series || [];
    if(series.length > 1){
      var values = series.map(function(i){return Number(i.value)||0;});
      var min = Math.min.apply(null, values);
      var max = Math.max.apply(null, values);
      var spread = Math.max(1, max-min);
      var points = series.map(function(item,index){
        var x = 20 + (index * (600/(series.length-1)));
        var y = 185 - (((Number(item.value)||0)-min)/spread)*120;
        return x.toFixed(1)+','+y.toFixed(1);
      }).join(' ');
      var line = el('[data-syf-chart-line]');
      var area = el('[data-syf-chart-area]');
      if(line) line.setAttribute('points',points);
      if(area) area.setAttribute('points','20,190 '+points+' 620,190');

      var labels = el('[data-syf-chart-labels]');
      clear(labels);
      series.forEach(function(item){
        var span=document.createElement('span'); span.textContent=item.label||''; labels.appendChild(span);
      });
    }

    var segments = el('[data-syf-segments]');
    clear(segments);
    (data.segments||[]).forEach(function(item){
      var row=document.createElement('div');
      row.innerHTML='<div><span></span><b></b></div><i><em></em></i>';
      row.querySelector('span').textContent=item.label||'';
      row.querySelector('b').textContent=(item.value||0)+'%';
      row.querySelector('em').style.width=Math.max(0,Math.min(100,Number(item.value)||0))+'%';
      segments.appendChild(row);
    });

    var signals=el('[data-syf-signals]');
    clear(signals);
    (data.signals||[]).forEach(function(item){
      var card=document.createElement('article');
      card.innerHTML='<small></small><strong></strong><span></span>';
      card.querySelector('small').textContent=item.title||'';
      card.querySelector('strong').textContent=item.state||'';
      card.querySelector('span').textContent=item.level==='high'?'اولویت بالا':(item.level==='medium'?'نیازمند توجه':'پایدار');
      signals.appendChild(card);
    });

    var note=el('[data-syf-note]');
    if(note) note.textContent=data.note||'';
  }

  function load(){
    var url = new URL(cfg.restUrl, window.location.origin);
    url.searchParams.set('region', region ? region.value : '6');
    url.searchParams.set('period', period ? period.value : '30d');

    fetch(url.toString(), {
      credentials:'same-origin',
      headers:{'X-WP-Nonce': cfg.restNonce || ''}
    })
      .then(function(r){ if(!r.ok) throw new Error('request failed'); return r.json(); })
      .then(render)
      .catch(function(){
        var source=el('[data-syf-source]');
        if(source) source.textContent='خطا در دریافت داده';
      });
  }

  if(region) region.addEventListener('change',load);
  if(period) period.addEventListener('change',load);
  load();
});
