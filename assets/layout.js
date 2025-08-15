// layout.js
// Highlight active sidebar links based on the ?path query parameter

document.addEventListener('DOMContentLoaded', highlightActiveSidebarLink);

function highlightActiveSidebarLink() {
  const links = document.querySelectorAll('.sidebar .nav-link[href]');
  const collapses = document.querySelectorAll('.sidebar .collapse');

  const params = new URLSearchParams(window.location.search);
  const currentPage = params.get('path') || 'home';

  // Reset active states
  links.forEach(link => {
    link.classList.remove('active');
    link.removeAttribute('aria-current');
  });
  collapses.forEach(collapse => {
    collapse.classList.remove('show');
    const parentToggle = collapse.previousElementSibling;
    if (parentToggle && parentToggle.classList.contains('nav-link')) {
      parentToggle.classList.remove('active');
      parentToggle.setAttribute('aria-expanded', 'false');
    }
  });

  const activeLink = Array.from(links).find(link => {
    try {
      const url = new URL(link.getAttribute('href'), window.location.origin);
      return url.searchParams.get('path') === currentPage;
    } catch (e) {
      return false;
    }
  });

  if (activeLink) {
    activeLink.classList.add('active');
    activeLink.setAttribute('aria-current', 'page');

    // Update page title
    const pageName = activeLink.textContent.trim();
    document.title = `${pageName} | SIGE`;

    const collapseParent = activeLink.closest('.collapse');
    if (collapseParent) {
      const instance = bootstrap.Collapse.getOrCreateInstance(collapseParent, { toggle: false });
      instance.show();
      const parentToggle = collapseParent.previousElementSibling;
      if (parentToggle && parentToggle.classList.contains('nav-link')) {
        parentToggle.classList.add('active');
        parentToggle.setAttribute('aria-expanded', 'true');
      }
    }
  }
}
