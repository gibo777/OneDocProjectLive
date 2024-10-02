// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

function number_format(number, decimals, dec_point, thousands_sep) {
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
  number = (number + '').replace(',', '').replace(' ', '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}




// Create a gradient function
function createGradient(ctx, color1, color2) {
  // Create a linear gradient
  var gradient = ctx.createLinearGradient(0, 0, 0, 400); // Adjust the gradient dimensions as needed
  gradient.addColorStop(0, color1); // Start color (more opaque)
  gradient.addColorStop(1, color2); // End color (more transparent)
  return gradient;
}

// Area Chart Example
var ctx = document.getElementById("myAreaChart").getContext('2d');
var myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    datasets: [
      {
        label: "Company 1",
        lineTension: 0.3,
        backgroundColor: createGradient(ctx, 'rgba(255, 99, 132, 0.3)', 'rgba(255, 99, 132, 0)'), // Gradient for red
        borderColor: "rgba(255, 99, 132, 1)", // Red
        pointRadius: 3,
        pointBackgroundColor: "rgba(255, 99, 132, 1)", // Red
        pointBorderColor: "rgba(255, 99, 132, 1)", // Red
        pointHoverRadius: 3,
        pointHoverBackgroundColor: "rgba(255, 99, 132, 1)", // Red
        pointHoverBorderColor: "rgba(255, 99, 132, 1)", // Red
        pointHitRadius: 10,
        pointBorderWidth: 2,
        data: [20000, 30000, 25000,10000, 20000, 15000, 25000, 40000, 10000, 10000, 5000, 15000],
      },
      {
        label: "Company 2",
        lineTension: 0.3,
        backgroundColor: createGradient(ctx, 'rgba(75, 192, 192, 0.3)', 'rgba(75, 192, 192, 0)'), // Gradient for green
        borderColor: "rgba(75, 192, 192, 1)", // Green
        pointRadius: 3,
        pointBackgroundColor: "rgba(75, 192, 192, 1)", // Green
        pointBorderColor: "rgba(75, 192, 192, 1)", // Green
        pointHoverRadius: 3,
        pointHoverBackgroundColor: "rgba(75, 192, 192, 1)", // Green
        pointHoverBorderColor: "rgba(75, 192, 192, 1)", // Green
        pointHitRadius: 10,
        pointBorderWidth: 2,
        data: [0, 12000, 7000, 22000, 14000, 26000, 31000, 24000, 39000, 13000, 9000, 21000],
      },
      {
        label: "Company 3",
        lineTension: 0.3,
        backgroundColor: createGradient(ctx, 'rgba(54, 162, 235, 0.3)', 'rgba(54, 162, 235, 0)'), // Gradient for blue
        borderColor: "rgba(54, 162, 235, 1)", // Blue
        pointRadius: 3,
        pointBackgroundColor: "rgba(54, 162, 235, 1)", // Blue
        pointBorderColor: "rgba(54, 162, 235, 1)", // Blue
        pointHoverRadius: 3,
        pointHoverBackgroundColor: "rgba(54, 162, 235, 1)", // Blue
        pointHoverBorderColor: "rgba(54, 162, 235, 1)", // Blue
        pointHitRadius: 10,
        pointBorderWidth: 2,
        data: [0, 15000, 8000, 12000, 11000, 18000, 16000, 27000, 22000, 29000, 26000, 41000],
      },
      {
        label: "Company 4",
        lineTension: 0.3,
        backgroundColor: createGradient(ctx, 'rgba(54, 162, 235, 0.3)', 'rgba(54, 162, 235, 0)'), // Gradient for blue
        borderColor: "rgba(54, 162, 235, 1)", // Blue
        pointRadius: 3,
        pointBackgroundColor: "rgba(54, 162, 235, 1)", // Blue
        pointBorderColor: "rgba(54, 162, 235, 1)", // Blue
        pointHoverRadius: 3,
        pointHoverBackgroundColor: "rgba(54, 162, 235, 1)", // Blue
        pointHoverBorderColor: "rgba(54, 162, 235, 1)", // Blue
        pointHitRadius: 10,
        pointBorderWidth: 2,
        data: [22000, 29000, 26000, 18000, 16000, 27000, 41000, 1000, 15000, 8000, 12000, 11000],
      }
    ],
  },
  options: {
    maintainAspectRatio: false,
    layout: {
      padding: {
        left: 10,
        right: 25,
        top: 25,
        bottom: 0
      }
    },
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false,
          drawBorder: false
        },
        ticks: {
          maxTicksLimit: 7
        }
      }],
      yAxes: [{
        ticks: {
          maxTicksLimit: 5,
          padding: 10,
          // Include a peso sign in the ticks
          callback: function(value, index, values) {
            return /*'₱' +*/ number_format(value);
          }
        },
        gridLines: {
          color: "rgb(234, 236, 244)",
          zeroLineColor: "rgb(234, 236, 244)",
          drawBorder: false,
          borderDash: [2],
          zeroLineBorderDash: [2]
        }
      }],
    },
    legend: {
      display: true
    },
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      titleMarginBottom: 10,
      titleFontColor: '#6e707e',
      titleFontSize: 14,
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      intersect: false,
      mode: 'index',
      caretPadding: 10,
      callbacks: {
        label: function(tooltipItem, chart) {
          var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
          return datasetLabel + ': ' /*+': ₱'*/ + number_format(tooltipItem.yLabel);
        }
      }
    }
  }
});
