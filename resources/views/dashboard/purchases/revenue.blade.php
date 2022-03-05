<div class="container">
    <div class="row">
        <div class="col-lg-4 col-md-6 col-12 pl-0">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{number_format($weekly_revenue / 100, 2, ',', '.')}}<sup style="font-size: 20px">$</sup></h3>
                    <p>Last Week</p>
                </div>
                <div class="icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-12">

            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{number_format($monthly_revenue / 100, 2, ',', '.')}}<sup style="font-size: 20px">$</sup></h3>
                    <p>Last Month</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-area"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-12 pr-0">

            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{number_format($yearly_revenue / 100, 2, ',', '.')}}<sup style="font-size: 20px">$</sup></h3>
                    <p>Last Year</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
        </div>
    </div>
</div>
