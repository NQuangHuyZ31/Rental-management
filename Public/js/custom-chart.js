window.CustomChart = {
    renderChart: function (chartName, chartData) {
        console.log('Rendering chart:', chartName, chartData);

        // Validate data
        if (!chartData || !chartData.type) {
            console.error('Invalid chart data:', chartData);
            document.getElementById(chartName).innerHTML = '<p class="text-center text-gray-500">Không có dữ liệu để hiển thị</p>';
            return;
        }

        let chartOptions = {
            chart: {
                type: chartData.type,
                backgroundColor: 'transparent',
                height: 300,
            },
            title: {
                text: '',
            },
            xAxis: {
                categories: chartData.categories || [],
                title: {
                    text: chartData.xAxisTitle || '',
                },
            },
            yAxis: {
                title: {
                    text: chartData.yAxisTitle || 'Giá trị',
                },
                min: 0,
            },
            series: chartData.series || [],
            credits: {
                enabled: false,
            },
            plotOptions: this.getPlotOptions(chartData.type),
        };

        // Special handling for pie charts
        if (chartData.type === 'pie' || chartData.type === 'doughnut') {
            chartOptions = {
                chart: {
                    type: chartData.type,
                    backgroundColor: 'transparent',
                    height: 300,
                },
                title: {
                    text: chartData.title || '',
                },
                series: [
                    {
                        name: chartData.series[0]?.name || 'Data',
                        data: chartData.series[0]?.data || [],
                    },
                ],
                credits: {
                    enabled: false,
                },
            };
        }

        try {
            Highcharts.chart(chartName, chartOptions);
        } catch (error) {
            console.error('Error rendering chart:', error);
            document.getElementById(chartName).innerHTML = '<p class="text-center text-gray-500">Lỗi hiển thị biểu đồ</p>';
        }
    },

    getPlotOptions: function (type) {
        switch (type) {
            case 'column':
                return {
                    column: {
                        color: '#3B82F6',
                    },
                };
            case 'bar':
                return {
                    bar: {
                        color: '#10B981',
                    },
                };
            case 'line':
                return {
                    line: {
                        marker: {
                            enabled: true,
                        },
                        color: '#F59E0B',
                    },
                };
            case 'pie':
                return {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f}%',
                        },
                    },
                };
            case 'doughnut':
                return {
                    pie: {
                        innerSize: '50%',
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f}%',
                        },
                    },
                };
            default:
                return {};
        }
    },
};
