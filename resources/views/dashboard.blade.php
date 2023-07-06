@extends('layouts.main.app')

@section('title', 'Dashboard')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li id="moduleName" class="breadcrumb-item active">
    Dashboard
</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Dashboard</h1>
<small id="controllerName"></small>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible">
            <button class="close" data-dismiss="alert">&times;</button>
            {{session('success') . ", " . auth()->user()->FIRST_NAME . "!"}}
        </div>
        @endif
        <div>
            {{auth()->user()->USER_ID}}
        </div>

    </div>
</div>
<div class="row mb-3">
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0">Vehicles</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column">
                    <div>
                        <i class="fas fa fa-caret-right text-success"></i>
                        <a href="#">On Requisition<span class="float-right"><strong>58</strong></span></a>
                    </div>
                    <div>
                        <i class="fas fa fa-caret-right text-success"></i>
                        <a href="#">On Maintenance <span class="float-right"><strong>23</strong></span></a>
                    </div>
                    <div>
                        <i class="fas fa fa-caret-right text-success"></i>
                        <a href="#">Available <span class="float-right"><strong>2</strong></span></a>
                    </div>
                    <div>
                        &nbsp;
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0">Todays Requisition</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column">
                    <div>
                        <i class="fas fa fa-caret-right text-success"></i>
                        <a href="#">Vehicle Requisition <span class="float-right"><strong>0</strong></span></a>
                    </div>
                    <div>
                        <i class="fas fa fa-caret-right text-success"></i>
                        <a href="#">Pick & Drop Requisition <span class="float-right"><strong>0</strong></span></a>
                    </div>
                    <div>
                        <i class="fas fa fa-caret-right text-success"></i>
                        <a href="#">Maintenance Requisition<span class="float-right"><strong>0</strong></span></a>
                    </div>
                    <div>
                        <i class="fas fa fa-caret-right text-success"></i>
                        <a href="#">Fuel Requisition<span class="float-right"><strong>0</strong></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0">Reminder </h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column">
                    <div>
                        <i class="fas fa fa-caret-right text-success"></i>
                        <a href="#">Legal Doc Soon Expire <span class="float-right"><strong>0</strong></span></a>
                    </div>
                    <div>
                        <i class="fas fa fa-caret-right text-success"></i>
                        <a href="#">Legal Doc Expired <span class="float-right"><strong>0</strong></span></a>
                    </div>
                    <div>
                        &nbsp;
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0"> Others Activities</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column">
                    <div>
                        <i class="fas fa fa-caret-right text-success"></i>
                        <a href="#">Stock In <span class="float-right"><strong>185</strong></span></a>
                    </div>
                    <div>
                        <i class="fas fa fa-caret-right text-success"></i>
                        <a href="#"> Stock Out <span class="float-right"><strong>772040</strong></span></a>
                    </div>
                    <div>
                        &nbsp;
                    </div>
                    <div>
                        &nbsp;
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0">Expense Summary </h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart mb-3">
                    <canvas id="doughutChart" height="310"></canvas>
                </div>
                <div class="chart-legend">
                    <div class="chart-legend-item">
                        <div class="chart-legend-color kelly-green"></div>
                        <p>Fuel Cost</p>
                        <p class="percentage text-muted">15364.00</p>
                    </div>
                    <div class="chart-legend-item">
                        <div class="chart-legend-color kelly-green2"></div>
                        <p>Maintenance Cost</p>
                        <p class="percentage text-muted">44260.00</p>
                    </div>
                    <div class="chart-legend-item">
                        <div class="chart-legend-color whisper"></div>
                        <p>Other Cost</p>
                        <p class="percentage text-muted">1960.00</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h2 class="fs-18 font-weight-bold mb-0">Maintenance Cost</h2>
            </div>
            <div class="card-body">
                <canvas id="barChart" height="190"></canvas>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        //doughut chart
        var ctx = document.getElementById("doughutChart");
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [15364.00, 44260.00, 1960.00],
                    backgroundColor: [
                        "#37a000",
                        "#42b704",
                        "#e4e4e4",
                    ],
                    hoverBackgroundColor: [
                        "#4cd604",
                        "#4cd604",
                        "#4cd604"
                    ]
                }],
                labels: ["Fuel", "Maintenance", "Other"]
            },
            options: {
                legend: false,
                responsive: true,
                cutoutPercentage: 80
            }
        });

        //bar chart
        var chartColors = {
            gray: '#e4e4e4',
            orange: 'rgb(255, 159, 64)',
            yellow: 'rgb(255, 205, 86)',
            green: '#37a000',
            blue: 'rgb(54, 162, 235)',
            purple: 'rgb(153, 102, 255)',
            grey: 'rgb(231,233,237)'
        };

        var randomScalingFactor = function() {
            return (Math.random() > 0.5 ? 1.0 : 1.0) * Math.round(Math.random() * 100);
        };

        // draws a rectangle with a rounded top
        Chart.helpers.drawRoundedTopRectangle = function(ctx, x, y, width, height, radius) {
            ctx.beginPath();
            ctx.moveTo(x + radius, y);
            // top right corner
            ctx.lineTo(x + width - radius, y);
            ctx.quadraticCurveTo(x + width, y, x + width, y + radius);
            // bottom right	corner
            ctx.lineTo(x + width, y + height);
            // bottom left corner
            ctx.lineTo(x, y + height);
            // top left	
            ctx.lineTo(x, y + radius);
            ctx.quadraticCurveTo(x, y, x + radius, y);
            ctx.closePath();
        };

        Chart.elements.RoundedTopRectangle = Chart.elements.Rectangle.extend({
            draw: function() {
                var ctx = this._chart.ctx;
                var vm = this._view;
                var left, right, top, bottom, signX, signY, borderSkipped;
                var borderWidth = vm.borderWidth;

                if (!vm.horizontal) {
                    // bar
                    left = vm.x - vm.width / 2;
                    right = vm.x + vm.width / 2;
                    top = vm.y;
                    bottom = vm.base;
                    signX = 1;
                    signY = bottom > top ? 1 : -1;
                    borderSkipped = vm.borderSkipped || 'bottom';
                } else {
                    // horizontal bar
                    left = vm.base;
                    right = vm.x;
                    top = vm.y - vm.height / 2;
                    bottom = vm.y + vm.height / 2;
                    signX = right > left ? 1 : -1;
                    signY = 1;
                    borderSkipped = vm.borderSkipped || 'left';
                }

                // Canvas doesn't allow us to stroke inside the width so we can
                // adjust the sizes to fit if we're setting a stroke on the line
                if (borderWidth) {
                    // borderWidth shold be less than bar width and bar height.
                    var barSize = Math.min(Math.abs(left - right), Math.abs(top - bottom));
                    borderWidth = borderWidth > barSize ? barSize : borderWidth;
                    var halfStroke = borderWidth / 2;
                    // Adjust borderWidth when bar top position is near vm.base(zero).
                    var borderLeft = left + (borderSkipped !== 'left' ? halfStroke * signX : 0);
                    var borderRight = right + (borderSkipped !== 'right' ? -halfStroke * signX : 0);
                    var borderTop = top + (borderSkipped !== 'top' ? halfStroke * signY : 0);
                    var borderBottom = bottom + (borderSkipped !== 'bottom' ? -halfStroke * signY : 0);
                    // not become a vertical line?
                    if (borderLeft !== borderRight) {
                        top = borderTop;
                        bottom = borderBottom;
                    }
                    // not become a horizontal line?
                    if (borderTop !== borderBottom) {
                        left = borderLeft;
                        right = borderRight;
                    }
                }

                // calculate the bar width and roundess
                var barWidth = Math.abs(left - right);
                var roundness = this._chart.config.options.barRoundness || 0.5;
                var radius = barWidth * roundness * 0.5;

                // keep track of the original top of the bar
                var prevTop = top;

                // move the top down so there is room to draw the rounded top
                top = prevTop + radius;
                var barRadius = top - prevTop;

                ctx.beginPath();
                ctx.fillStyle = vm.backgroundColor;
                ctx.strokeStyle = vm.borderColor;
                ctx.lineWidth = borderWidth;

                // draw the rounded top rectangle
                Chart.helpers.drawRoundedTopRectangle(ctx, left, (top - barRadius + 1), barWidth,
                    bottom - prevTop, barRadius);

                ctx.fill();
                if (borderWidth) {
                    ctx.stroke();
                }

                // restore the original top value so tooltips and scales still work
                top = prevTop;
            }
        });

        Chart.defaults.roundedBar = Chart.helpers.clone(Chart.defaults.bar);

        Chart.controllers.roundedBar = Chart.controllers.bar.extend({
            dataElementType: Chart.elements.RoundedTopRectangle
        });

        var ctx = document.getElementById("barChart").getContext("2d");
        var myBar = new Chart(ctx, {
            type: 'roundedBar',
            data: {
                labels: ["Jun-22", "Jul-22", "Aug-22", "Sep-22", "Oct-22", "Nov-22", "Dec-22", "Jan-23", "Feb-23", "Mar-23", "Apr-23", "May-23", ],
                datasets: [{
                    label: 'Maintenance Cost',
                    backgroundColor: chartColors.green,
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1864.00, 0, ]
                }]
            },
            options: {
                legend: false,
                responsive: true,
                barRoundness: 1,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            padding: 10
                        },
                        gridLines: {
                            borderDash: [2],
                            borderDashOffset: [2],
                            drawBorder: false,
                            drawTicks: false
                        }
                    }],
                    xAxes: [{
                        maxBarThickness: 10,
                        gridLines: {
                            lineWidth: [0],
                            drawBorder: false,
                            drawOnChartArea: false,
                            drawTicks: false
                        },
                        ticks: {
                            padding: 20
                        }
                    }]
                }
            }
        });
    });
</script>

@endsection