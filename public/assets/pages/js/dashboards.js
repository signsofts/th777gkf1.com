
const lang = getCookie("lang")


const loadChartDashboard = async () => {
    let data = JSON.parse(document.getElementById("loadChartDashboardData").value);
    var options = {
        series: [{
            name: "amount",
            data: data
        }],
        chart: {
            height: 350,
            type: 'line',
            zoom: {
                enabled: false
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'straight'
        },
        title: {
            text: lang == "th" ? "สรุปกำไรประจำปี" : 'Summary of Annual Profits',
            align: 'left'
        },
        grid: {
            row: {
                colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                opacity: 0.3
            },
        },
        xaxis: {
            categories: lang == "th" ? ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'] : ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        }
    };

    var incomeChart = new ApexCharts(document.querySelector("#incomeChart"), options);
    incomeChart.render();
}



$(document).ready(function () {
    loadChartDashboard();
});