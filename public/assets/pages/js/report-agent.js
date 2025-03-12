const lang = getCookie("lang")
const loadChartDashboard = async () => {
    let token = getTokenFromStore();
    // console.log(token)
    const POST = await fetch("/admin/report/agent/sum", {
        method: "POST",
        headers: {
            'Authorization': `Bearer ${token}`, // Authorization header with Bearer token
            'Content-Type': 'application/json' // Example of setting another header
        },
    })
    let resp = await POST.json();

    const labels = resp.sumUser.labels
    const series = resp.sumUser.series

    var options = {
        series: series,
        labels: labels,
        chart: {
            type: 'polarArea',
        },
        stroke: {
            colors: ['#fff']
        },
        fill: {
            opacity: 0.8
        },
        title: {
            text: lang == "th" ? "รายงานผลรวมผู้ใช้" : 'Report Users Sum',
            align: 'left'
        },
        yaxis: {
            show: false
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                },
                legend: {
                    position: 'bottom'
                }
            }
        }],

    };

    const chart1 = new ApexCharts(document.querySelector("#chart1"), options);
    chart1.render();
}



$(document).ready(function () {
    loadChartDashboard();
});