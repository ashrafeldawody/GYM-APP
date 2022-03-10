window.loadPieChart =  function(selector,route){
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
                        backgroundColor: ['#FF6633', '#FFB399', '#FF33FF', '#FFFF99', '#00B3E6', '#E6B333', '#3366E6', '#999966', '#99FF99', '#B34D4D', '#80B300', '#809900', '#E6B3B3', '#6680B3', '#66991A'],
                        hoverBackgroundColor: ['#FF6633', '#FFB399', '#FF33FF', '#FFFF99', '#00B3E6', '#E6B333', '#3366E6', '#999966', '#99FF99', '#B34D4D', '#80B300', '#809900', '#E6B3B3', '#6680B3', '#66991A'],
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
                }
            });
        })
        .fail(function() {
            console.log("Error retrieving chart data");
        });
}
