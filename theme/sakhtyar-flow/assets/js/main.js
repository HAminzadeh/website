document.addEventListener('DOMContentLoaded', function () {
  const toggle = document.querySelector('.syf-mobile-toggle');
  const nav = document.querySelector('.syf-nav');
  if (!toggle || !nav) return;

  toggle.addEventListener('click', function () {
    const isOpen = nav.style.display === 'flex';
    nav.style.display = isOpen ? 'none' : 'flex';
    if (!isOpen) {
      nav.style.position = 'absolute';
      nav.style.top = '72px';
      nav.style.right = '4vw';
      nav.style.left = '4vw';
      nav.style.flexDirection = 'column';
      nav.style.alignItems = 'stretch';
      nav.style.padding = '14px';
      nav.style.background = '#0b1628';
      nav.style.border = '1px solid rgba(255,255,255,.08)';
      nav.style.borderRadius = '16px';
      nav.style.boxShadow = '0 20px 50px rgba(0,0,0,.25)';
    }
  });
});
