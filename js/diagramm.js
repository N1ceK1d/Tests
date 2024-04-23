function showDiagramm(php_data, id, username) {
    //console.log(php_data)
    //console.log(id)
    //console.log(username)
    new Chart(
        document.querySelector(`.diagramm-item #myChart${id}`),
        {
        type: 'bar',
        data: {
            labels: php_data.map(row => row.criterion_name),
            datasets: [{
              label: username,
              data: php_data.map(row => row.points),
              backgroundColor: '#0d6efd',
            },]
        },
        options: {
            legend: {display: true},
            scales: {
                yAxes: [{
                    ticks: {
                      beginAtZero: true,
                      max: 100
                    }
                }],
            }
        }
    });
}

function showComparisonsDiagramm(employees_data, managers_data, id, manager_name = 'Руководитель') {
    console.log(employees_data);
    new Chart(
        document.querySelector(`.diagramm-item #myChart${id}`),
        {
            type: 'bar',
            data: {
                labels: managers_data.map(row => row.criterion_name),
                datasets: [{
                    type: 'bar',
                    label: "Сотрудники",
                    data: employees_data.map(row => row.points),
                    backgroundColor: '#0d6efd',
                },
                {
                    type: 'bar',
                    label: manager_name,
                    data: managers_data.map(row => row.points),
                    backgroundColor: '#E40045',
                }]
            },
            options: {
                legend: {display: true},
                scales: {
                    yAxes: [{
                        ticks: {
                          beginAtZero: true,
                          max: 100
                        }
                    }],
                }
            }
        }
    );
}