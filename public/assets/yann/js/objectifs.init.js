/*
Template Name: Velzon - Admin & Dashboard Template
Author: Themesbrand
Website: https://Themesbrand.com/
Contact: Themesbrand@gmail.com
File: Line Chart init js
*/

// get colors array from the string
function getChartColorsArray(chartId) {
    if (document.getElementById(chartId) !== null) {
        var colors = document.getElementById(chartId).getAttribute("data-colors");
        if (colors) {
            colors = JSON.parse(colors);
            return colors.map(function (value) {
                var newValue = value.replace(" ", "");
                if (newValue.indexOf(",") === -1) {
                    var color = getComputedStyle(document.documentElement).getPropertyValue(newValue);
                    if (color) return color;
                    else return newValue;
                    ;
                } else {
                    var val = value.split(',');
                    if (val.length == 2) {
                        var rgbaColor = getComputedStyle(document.documentElement).getPropertyValue(val[0]);
                        rgbaColor = "rgba(" + rgbaColor + "," + val[1] + ")";
                        return rgbaColor;
                    } else {
                        return newValue;
                    }
                }
            });
        }
    }
}


//  Basic Line Charts

var linechartBasicColors = getChartColorsArray("line_chart_basic");
if (linechartBasicColors) {

    const fetchUrl = window.apiRoot + "/objectifs.json"
    console.log('fetchUrl', fetchUrl)

    fetch(fetchUrl)
        .then((response) => response.json())
        .then((response) => {
            console.log(response)
            let xMonths = []
            let yObjectifs = []
            const objChassieu = response.filter((objectif) => objectif.service === 'chassieu')
            console.log(objChassieu)
            objChassieu.map((item) => {
                xMonths.push(item.month)
                yObjectifs.push(item.objectif)
            })
            console.log(xMonths, yObjectifs)

            var options = {
                series: [{
                    name: "Objectifs",
                    data: [...yObjectifs]
                }],
                chart: {
                    height: 350,
                    type: 'line',
                    zoom: {
                        enabled: false
                    },
                    toolbar: {
                        show: false
                    }
                },
                markers: {
                    size: 4,
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'straight'
                },
                colors: linechartBasicColors,
                title: {
                    text: 'Objectifs mensuels',
                    align: 'left',
                    style: {
                        fontWeight: 500,
                    },
                },

                xaxis: {
                    categories: [...xMonths],
                }
            };

            var chart = new ApexCharts(document.querySelector("#line_chart_basic"), options);
            chart.render();

        })

}