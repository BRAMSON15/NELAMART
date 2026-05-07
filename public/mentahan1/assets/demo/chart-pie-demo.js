// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#555555';

// Pie Chart Example
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
  type: 'pie',
  data: {
    labels: ["Makanan", "Minuman", "Fashion", "Kerajinan", "Lainnya"],
    datasets: [{
      data: [30, 25, 20, 15, 10],
      backgroundColor: [
        'rgba(38, 185, 154, 0.9)',
        'rgba(52, 152, 219, 0.9)',
        'rgba(240, 165, 0, 0.9)',
        'rgba(231, 76, 60, 0.9)',
        'rgba(155, 89, 182, 0.9)'
      ],
      borderColor: ['#fff','#fff','#fff','#fff','#fff'],
      borderWidth: 2,
    }],
  },
  options: {
    legend: {
      labels: { fontColor: '#555555' }
    }
  }
});
