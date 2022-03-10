window.loadPieChart =  function(selector,route){
        let randomColors = getRandomColorsArray(12);
        $.ajax( {
            type:'GET',
            url:route,
        })
        .done(function(data) {
            const ctx = $(selector);
            new Chart(ctx, {
                type: 'pie',
                data: {
                    datasets: [{
                        backgroundColor: randomColors,
                        hoverBackgroundColor: randomColors,
                        data: data.values,
                    }],
                    labels: data.labels,
                },

            });
        })
        .fail(function() {
            console.log("Error retrieving chart data");
        });
}

window.loadRevenueChart =  function(selector,route){
    $.ajax( {
        type:'GET',
        url:route,
    })
        .done(function(data) {
            const ctx = $(selector);
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.labels,
                    datasets: [{
                        data: data.values,
                        label: "Revenue",
                        borderColor: "#3e95cd",
                        fill: false
                    }
                    ]
                },
                options: {
                    maintainAspectRatio : false,
                    responsive : true,
                    legend: {
                        display: false
                    },
                    scales: {
                        xAxes: [{
                            gridLines : {
                                display : false,
                            }
                        }],
                        yAxes: [{
                            gridLines : {
                                display : false,
                            }
                        }]
                    }
                },
            });
        })
        .fail(function() {
            console.log("Error retrieving chart data");
        });
}
function getRandomColorsArray(size) {
    let letters = '6789ABCDE'.split('');
    let colors = [];
    for (let i = 0; i < size; i++ ) {
        let color = '#';
        for (let i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 8)];
        }
        colors.push(color);
    }
    return colors;
}
