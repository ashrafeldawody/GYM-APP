let colors = ["#f085ba","#2bc789","#7400e0","#5e8a00","#0081fb","#008641","#ffa8e6","#62914a","#560042","#0097a8","#ed8164","#00558f"];

window.loadPieChart =  function(selector,route){
        $.ajax( {
            type:'GET',
            url:route,
        })
        .done(function(data) {
            if (data.values.length === 0) console.log('empty');;
            const ctx = $(selector);
            new Chart(ctx, {
                type: 'pie',
                data: {
                    datasets: [{
                        backgroundColor: colors,
                        hoverBackgroundColor: colors,
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
            if (data.values.length === 0) console.log('empty');
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
