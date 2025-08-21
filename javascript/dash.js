const ctx = document.getElementById('myChart').getContext('2d');
    new Chart(ctx, {
      type: 'doughnut',  
      data: {
        labels: ['Red', 'Yellow', 'Blue', 'Green'],
        datasets: [{
          data: [30, 25, 15, 30],   
          backgroundColor: [
            '#FF6384',
            '#FFCE56',
            '#36A2EB',
            '#4BC0C0'
          ],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'bottom', 
          },
          title: {
            display: false
          }
        }
      }
    });
  