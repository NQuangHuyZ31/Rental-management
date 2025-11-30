window.CustomChart = {
    renderChart(chartName, chartData) {
        console.log('Rendering chart:', chartName, chartData);

        // Validate data
        if (!chartData || !chartData.type) {
            console.error('Invalid chart data:', chartData);
            this.showError(chartName, 'Không có dữ liệu để hiển thị');
            return;
        }

        let isPie = chartData.type === 'pie' || chartData.type === 'doughnut';

        const chartOptions = isPie ? this.getPieChartOptions(chartData) : this.getStandardChartOptions(chartData);

        try {
            Highcharts.chart(chartName, chartOptions);
        } catch (error) {
            console.error('Error rendering chart:', error);
            this.showError(chartName, 'Lỗi hiển thị biểu đồ');
        }
    },

    showError(chartName, message) {
        document.getElementById(chartName).innerHTML = `<p class="text-center text-gray-500">${message}</p>`;
    },

    getStandardChartOptions(chartData) {
        return {
            chart: {
                type: chartData.type,
                backgroundColor: 'transparent',
                height: 300,
            },
            title: { text: chartData.title || '' },
            xAxis: {
                categories: chartData.categories || [],
                title: { text: chartData.xAxisTitle || '' },
            },
            yAxis: {
                min: 0,
                title: { text: chartData.yAxisTitle || 'Giá trị' },
            },
            series: chartData.series || [],
            credits: { enabled: false },
            plotOptions: this.getPlotOptions(chartData.type),
        };
    },

    getPieChartOptions(chartData) {
        return {
            chart: {
                type: 'pie',
                backgroundColor: 'transparent',
                height: 300,
            },
            title: { text: chartData.title || '' },
            tooltip: {
                pointFormat: '<b>{point.percentage:.1f}%</b>',
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        distance: 25, // Đưa label ra ngoài
                        format: '<b>{point.name}</b>: {point.percentage:.1f}%',
                    },
                    innerSize: chartData.type === 'doughnut' ? '50%' : '0%',
                },
            },
            series: [
                {
                    name: chartData.series?.[0]?.name || 'Data',
                    data: chartData.series?.[0]?.data || [],
                },
            ],
            credits: { enabled: false },
        };
    },

    getPieChartOptions(chartData) {
        return {
            chart: {
                type: 'pie',
                backgroundColor: 'transparent',
                height: 300,
            },
            title: { text: chartData.title || '' },

            tooltip: {
                pointFormat: '<b>{point.percentage:.1f}%</b>',
            },

            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',

                    dataLabels: {
                        enabled: true,
                        distance: -50, // distance dương = ngoài, âm = trong —> đổi sang DƯƠNG
                        format: '<b>{point.name}</b>: {point.percentage:.1f}%',
                        style: {
                            color: '#000', // tránh mất chữ khi trùng màu
                            fontSize: '13px',
                            fontWeight: 'bold',
                        },
                    },

                    showInLegend: false,
                    innerSize: chartData.type === 'doughnut' ? '50%' : '0%',
                },
            },

            series: [
                {
                    name: chartData.series?.[0]?.name || 'Data',
                    data: chartData.series?.[0]?.data || [],
                },
            ],

            credits: { enabled: false },
        };
    },
};
