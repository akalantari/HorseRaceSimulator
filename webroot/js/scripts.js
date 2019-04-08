/* jshint -W097 */ // don't warn about "use strict"
'use strict';

function populateSingleRaceChart(id, horses, data) {
    var obj = $('#chart-race-' + id);
    var ctx = obj[0].getContext('2d');

    var horizontalBarChartData = {
        labels: horses,
        datasets: [{
            label: 'Distance Covered',
            backgroundColor: Chart.helpers.color(window.chartColors.blue).alpha(0.5).rgbString(),
            borderColor: window.chartColors.blue,
            borderWidth: 1,
            data: data
        }]
    };

    obj[0].chart = new Chart(ctx, {
        type: 'horizontalBar',
        data: horizontalBarChartData,
        options: {
            // Elements options apply to all of the options unless overridden in a dataset
            // In this case, we are setting the border of each horizontal bar to be 2px wide
            elements: {
                rectangle: {
                    borderWidth: 2,
                }
            },
            responsive: true,
            legend: {
                position: false,
            },
            title: {
                display: true,
                text: 'Distances covered in Race #' + id
            },
            scales: {
                xAxes: [{
                    ticks: {
                        min: 0,
                        max: 1500,
                        stepSize: 300
                    }
                }]
            }
        }
    });
}

function populateSingleHorseChart(id, horseName, data) {
    var obj = $('#chart-horse-' + id);
    var ctx = obj[0].getContext('2d');

    var horizontalBarChartData = {
        labels: [horseName+' Stats'],
        datasets: [{
            label: 'Speed',
            backgroundColor: Chart.helpers.color(window.chartColors.green).alpha(0.5).rgbString(),
            borderColor: window.chartColors.green,
            borderWidth: 1,
            data: [data[0]]
        },{
            label: 'Endurance',
            backgroundColor: Chart.helpers.color(window.chartColors.red).alpha(0.5).rgbString(),
            borderColor: window.chartColors.red,
            borderWidth: 1,
            data: [data[1]]
        },{
            label: 'Strength',
            backgroundColor: Chart.helpers.color(window.chartColors.purple).alpha(0.5).rgbString(),
            borderColor: window.chartColors.purple,
            borderWidth: 1,
            data: [data[2]]
        }]
    };

    obj[0].chart = new Chart(ctx, {
        type: 'bar',
        data: horizontalBarChartData,
        options: {
            // Elements options apply to all of the options unless overridden in a dataset
            // In this case, we are setting the border of each horizontal bar to be 2px wide
            elements: {
                rectangle: {
                    borderWidth: 2,
                }
            },
            responsive: true,
            legend: {
                position: 'bottom',
            },
            title: {
                display: true,
                text: horseName+' stats'
            },
            scales: {
                yAxes: [{
                    ticks: {
                        min: 0,
                        max: 10.0,
                        stepSize: 1.0
                    }
                }]
            }
        }
    });
}

function populateRaceHorsesChart(id, horseNames, data) {
    var obj = $('#chart-horses-' + id);
    var ctx = obj[0].getContext('2d');

    var horizontalBarChartData = {
        labels: horseNames,
        datasets: [{
            label: 'Speed',
            backgroundColor: Chart.helpers.color(window.chartColors.green).alpha(0.5).rgbString(),
            borderColor: window.chartColors.green,
            borderWidth: 1,
            data: data[0]
        },{
            label: 'Endurance',
            backgroundColor: Chart.helpers.color(window.chartColors.red).alpha(0.5).rgbString(),
            borderColor: window.chartColors.red,
            borderWidth: 1,
            data: data[1]
        },{
            label: 'Strength',
            backgroundColor: Chart.helpers.color(window.chartColors.purple).alpha(0.5).rgbString(),
            borderColor: window.chartColors.purple,
            borderWidth: 1,
            data: data[2]
        }]
    };

    obj[0].chart = new Chart(ctx, {
        type: 'bar',
        data: horizontalBarChartData,
        options: {
            // Elements options apply to all of the options unless overridden in a dataset
            // In this case, we are setting the border of each horizontal bar to be 2px wide
            elements: {
                rectangle: {
                    borderWidth: 2,
                }
            },
            responsive: true,
            legend: {
                position: 'bottom',
            },
            title: {
                display: true,
                text: 'Horses'
            },
            scales: {
                yAxes: [{
                    ticks: {
                        min: 0,
                        max: 10.0,
                        stepSize: 1.0
                    }
                }]
            }
        }
    });
}