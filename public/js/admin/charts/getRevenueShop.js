let myBarChart = null;

function createChart(labels, data) {
    // Destroy existing chart if it exists
    if (myBarChart) {
        myBarChart.destroy();
    }

    const chartOptions = {
        responsive: true,
        scales: {
            y: {
                min: 0,
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return new Intl.NumberFormat('vi-VN').format(value) + ' đ';
                    }
                }
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return new Intl.NumberFormat('vi-VN').format(context.raw) + ' đ';
                    }
                }
            },
            legend: {
                display: true,
                position: 'top'
            }
        }
    };

    // Round all values in data to avoid discrepancies
    data = data.map(value => Math.round(value));

    const revenueCtx = document.getElementById("myBarChart");

    // Check if canvas element exists
    if (!revenueCtx) {
        console.error('Chart canvas element not found');
        return;
    }

    try {
        myBarChart = new Chart(revenueCtx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: "Doanh thu",
                    data: data,
                    backgroundColor: 'rgba(78, 115, 223, 0.5)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    borderWidth: 1
                }]
            },
            options: chartOptions
        });
    } catch (error) {
        console.error('Error creating chart:', error);
    }
}

function formatCurrency(amount) {
    try {
        return new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        }).format(amount);
    } catch (error) {
        console.error('Error formatting currency:', error);
        return '0 đ';
    }
}

function updateTotals(totals) {
    try {
        const elements = {
            'total_revenue': totals.total_revenue,
            'total_cost': totals.total_cost,
            'profit': totals.profit,
            'total_orders': totals.total_orders
        };

        for (const [id, value] of Object.entries(elements)) {
            const element = document.getElementById(id);
            if (element) {
                element.textContent = id === 'total_orders'
                    ? value.toLocaleString('vi-VN')
                    : formatCurrency(value);
            }
        }
    } catch (error) {
        console.error('Error updating totals:', error);
    }
}

async function fetchChartData(timeFrame) {
    try {
        const response = await fetch(`/admin/statistics/revenue?time_frame=${timeFrame}`);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();
        createChart(data.labels, data.revenue);
        updateTotals(data.totals);
    } catch (error) {
        console.error('Error fetching chart data:', error);
        // Show user-friendly error message
        const chartContainer = document.getElementById('myBarChart')?.parentElement;
        if (chartContainer) {
            chartContainer.innerHTML = `
                <div class="alert alert-danger">
                    Không thể tải dữ liệu. Vui lòng thử lại sau.
                </div>
            `;
        }
    }
}

async function applyCustomFilter() {
    const startDate = document.getElementById('startDate')?.value;
    const endDate = document.getElementById('endDate')?.value;

    if (!startDate || !endDate) {
        alert('Vui lòng chọn ngày bắt đầu và ngày kết thúc');
        return;
    }

    if (startDate > endDate) {
        alert('Ngày bắt đầu không được lớn hơn ngày kết thúc');
        return;
    }

    try {
        const response = await fetch(
            `/admin/statistics/revenue?time_frame=custom&start_date=${startDate}&end_date=${endDate}`
        );

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        createChart(data.labels, data.revenue);
        updateTotals(data.totals);
    } catch (error) {
        console.error('Error applying custom filter:', error);
        alert('Không thể tải dữ liệu. Vui lòng thử lại sau.');
    }
}

// Tải biểu đồ mặc định (tháng này) khi trang load
document.addEventListener('DOMContentLoaded', () => {
    fetchChartData('this_month').catch(error => {
        console.error('Error initializing chart:', error);
    });
});
