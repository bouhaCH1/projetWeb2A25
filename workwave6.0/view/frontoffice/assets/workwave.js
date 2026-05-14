document.addEventListener('DOMContentLoaded', function () {
  const qrs = document.querySelectorAll('.ww-qr-code[data-url]');
  if (qrs.length && window.QRCode) {
    qrs.forEach((qr) => {
      const size = qr.classList.contains('small') ? 96 : 112;
      qr.textContent = '';
      new QRCode(qr, { text: qr.dataset.url, width: size, height: size, colorDark: '#0a0e27', colorLight: '#ffffff' });
    });
  }

  const mapEl = document.getElementById('ww-map');
  if (mapEl && window.L) {
    const lat = parseFloat(mapEl.dataset.lat || '36.8065');
    const lng = parseFloat(mapEl.dataset.lng || '10.1815');
    const map = L.map(mapEl).setView([lat, lng], 8);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '&copy; OpenStreetMap'
    }).addTo(map);
    L.marker([lat, lng]).addTo(map).bindPopup('Search center');
    const addMarkers = (items, label) => items.forEach((item) => {
      if (!item.lat || !item.lng) return;
      L.marker([parseFloat(item.lat), parseFloat(item.lng)]).addTo(map)
        .bindPopup(label + ': ' + (item.display_name || item.company_name || item.first_name));
    });
    addMarkers(JSON.parse(mapEl.dataset.freelancers || '[]'), 'Freelancer');
    addMarkers(JSON.parse(mapEl.dataset.companies || '[]'), 'Company');
  }
});
