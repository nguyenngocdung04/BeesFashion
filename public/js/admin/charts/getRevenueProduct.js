// Chart instances
let revenueChart = null;
let profitChart = null;

// Utility functions for number formatting
function formatCurrency(value) {
    return new Intl.NumberFormat('vi-VN').format(value) + ' đ';
}

function formatNumber(value) {
    return new Intl.NumberFormat('vi-VN').format(value);
}

function toFixedNumber(number, decimals = 2) {
    return Number(Number(number || 0).toFixed(decimals));
}

// Calculation functions
function calculateProfitMargin(revenue, profit) {
    if (!revenue || revenue <= 0 || !profit) return 0;
    return toFixedNumber((profit / revenue) * 100, 1);
}

function calculateTotals(data) {
    if (!Array.isArray(data)) {
        return {
            totalQuantity: 0,
            totalRevenue: 0,
            totalCost: 0,
            totalProfit: 0
        };
    }

    const totals = data.reduce((acc, item) => {
        // Ensure all values are valid numbers
        const quantity = toFixedNumber(item.total_quantity);
        const revenue = toFixedNumber(item.total_revenue);
        const cost = toFixedNumber(item.total_cost);
        const profit = toFixedNumber(item.profit);

        return {
            totalQuantity: acc.totalQuantity + quantity,
            totalRevenue: acc.totalRevenue + revenue,
            totalCost: acc.totalCost + cost,
            totalProfit: acc.totalProfit + profit
        };
    }, {
        totalQuantity: 0,
        totalRevenue: 0,
        totalCost: 0,
        totalProfit: 0
    });

    // Round final results
    return {
        totalQuantity: toFixedNumber(totals.totalQuantity),
        totalRevenue: toFixedNumber(totals.totalRevenue),
        totalCost: toFixedNumber(totals.totalCost),
        totalProfit: toFixedNumber(totals.totalProfit)
    };
}

// Helper function to truncate text
function truncateText(text, maxLength = 7) {
    if (!text) return '';
    const words = text.split(' ');
    if (words.length <= 1) return text;
    return words[0] + ' ...';
}

// Chart functions
function initializeCharts(data) {
    const chartOptions = {
        responsive: true,
        scales: {
            y: {
                min: 0,
                beginAtZero: true,
                ticks: {
                    callback: function (value) {
                        return formatCurrency(value);
                    }
                }
            },
            x: {
                ticks: {
                    callback: function (value, index) {
                        const label = this.getLabelForValue(value);
                        return truncateText(label);
                    }
                }
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    title: function (context) {
                        return context[0].label;
                    },
                    label: function (context) {
                        return formatCurrency(context.raw);
                    }
                }
            },
            legend: {
                display: true,
                position: 'top'
            }
        }
    };

    // Initialize Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    revenueChart = new Chart(revenueCtx, {
        type: 'bar',
        data: {
            labels: data.map(item => item.name),
            datasets: [{
                label: 'Doanh thu',
                data: data.map(item => item.total_revenue),
                backgroundColor: 'rgba(78, 115, 223, 0.5)',
                borderColor: 'rgba(78, 115, 223, 1)',
                borderWidth: 1
            }]
        },
        options: chartOptions
    });

    // Initialize Profit Chart
    const profitCtx = document.getElementById('profitChart').getContext('2d');
    profitChart = new Chart(profitCtx, {
        type: 'bar',
        data: {
            labels: data.map(item => item.name),
            datasets: [{
                label: 'Lợi nhuận',
                data: data.map(item => item.profit),
                backgroundColor: 'rgba(28, 200, 138, 0.5)',
                borderColor: 'rgba(28, 200, 138, 1)',
                borderWidth: 1
            }]
        },
        options: chartOptions
    });
}

function updateCharts(data) {
    if (revenueChart) {
        revenueChart.data.labels = data.map(item => item.name);
        revenueChart.data.datasets[0].data = data.map(item => item.total_revenue);
        revenueChart.update();
    }

    if (profitChart) {
        profitChart.data.labels = data.map(item => item.name);
        profitChart.data.datasets[0].data = data.map(item => item.profit);
        profitChart.update();
    }
}

// UI update functions
function updateSummaryCards(totals) {
    document.querySelector('.total-revenue').textContent = formatCurrency(totals.total_revenue);
    document.querySelector('.total-profit').textContent = formatCurrency(totals.total_profit);
    document.querySelector('.total-cost').textContent = formatCurrency(totals.total_cost);
    document.querySelector('.total-quantity').textContent = formatNumber(totals.total_quantity);
}

function updateDataTable(data) {
    const tableBody = document.querySelector('#revenueTable tbody');
    if (!tableBody) return;

    let html = '';
    data.data.forEach((item, index) => {
        const profitMargin = calculateProfitMargin(item.total_revenue, item.profit);

        html += `
            <tr ${item.name === 'Other products'}>
                <td>${index + 1}</td>
                <td>${item.name}</td>
                <td class="text-end">${formatNumber(item.total_quantity)}</td>
                <td class="text-end">${formatCurrency(item.total_revenue)}</td>
                <td class="text-end">${formatCurrency(item.total_cost)}</td>
                <td class="text-end">${formatCurrency(item.profit)}</td>
                <td class="text-end">${profitMargin}%</td>
            </tr>
        `;
    });

    // Calculate totals
    const totals = calculateTotals(data.data);
    const totalProfitMargin = calculateProfitMargin(totals.totalRevenue, totals.totalProfit);

    // Add totals row
    html += `
        <tr class="table-success"">
            <td class="text-dark font-weight-bold" colspan="2">Tổng cộng</td>
            <td class="text-end">${formatNumber(totals.totalQuantity)}</td>
            <td class="text-end">${formatCurrency(totals.totalRevenue)}</td>
            <td class="text-end">${formatCurrency(totals.totalCost)}</td>
            <td class="text-end">${formatCurrency(totals.totalProfit)}</td>
            <td class="text-end">${totalProfitMargin}%</td>
        </tr>
    `;

    tableBody.innerHTML = html;
}

function updatePeriodInput() {
    const periodType = document.getElementById('periodType');
    const periodInputContainer = document.getElementById('periodInputContainer');
    const currentDate = new Date();
    let html = '';

    switch (periodType.value) {
        case 'day':
            html = `
                <label class="form-label">Chọn ngày</label>
                <input type="date"
                       class="form-control"
                       name="date"
                       value="${currentDate.toISOString().split('T')[0]}"
                       max="${currentDate.toISOString().split('T')[0]}">`;
            break;

        case 'month':
            html = `
                <label class="form-label">Chọn tháng</label>
                <input type="month"
                       class="form-control"
                       name="date"
                       value="${currentDate.toISOString().slice(0, 7)}"
                       max="${currentDate.toISOString().slice(0, 7)}">`;
            break;

        case 'year':
            const currentYear = currentDate.getFullYear();
            const years = Array.from({ length: currentYear - 2009 }, (_, i) => currentYear - i);
            const yearOptions = years.map(year => `<option value="${year}">${year}</option>`).join('');

            html = `
                <label class="form-label">Chọn năm</label>
                <select class="form-control" name="date">
                    ${yearOptions}
                </select>`;
            break;
    }

    periodInputContainer.innerHTML = html;
}

// Event listeners
document.addEventListener('DOMContentLoaded', function () {
    // Initialize period input
    updatePeriodInput();

    // Initialize charts with initial data
    initializeCharts(window.initialData.data);

    // Period type change handler
    const periodType = document.getElementById('periodType');
    periodType.addEventListener('change', updatePeriodInput);

    // Form submission handler
    const statisticsForm = document.getElementById('statisticsForm');
    statisticsForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        const searchParams = new URLSearchParams(formData);

        fetch(`${window.location.pathname}?${searchParams.toString()}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => response.json())
            .then(data => {
                // Update charts and table
                updateCharts(data.data);
                updateDataTable(data);
                updateSummaryCards(data.totals);

                // Update URL without page reload
                window.history.pushState({}, '', `${window.location.pathname}?${searchParams.toString()}`);
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi tải dữ liệu. Vui lòng thử lại.');
            });
    });
});
