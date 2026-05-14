document.addEventListener('DOMContentLoaded', function () {
  const canvas = document.getElementById('adminChart');
  if (!canvas || !window.Chart) return;
  const stats = JSON.parse(canvas.dataset.stats || '{}');
  new Chart(canvas, {
    type: 'bar',
    data: { labels: Object.keys(stats), datasets: [{ label: 'WORKWAVE', data: Object.values(stats), backgroundColor: '#eb1616' }] },
    options: { responsive: true, plugins: { legend: { display: false } } }
  });
});
