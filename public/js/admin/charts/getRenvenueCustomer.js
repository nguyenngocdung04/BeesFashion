document.addEventListener('DOMContentLoaded', function() {
    const formatters = {
        currency: (amount) => new Intl.NumberFormat('vi-VN').format(amount) + 'đ',
        number: (number) => new Intl.NumberFormat('vi-VN').format(number),
        date: (dateString) => new Date(dateString).toLocaleDateString('vi-VN')
    };

    const revenueFilterForm = document.getElementById('revenueFilterForm');
    const timeTypeInput = revenueFilterForm.querySelector('input[name="time_type"]');
    const filterButtons = revenueFilterForm.querySelectorAll('.btn-group .btn');
    let customersDataTable;

    const handleButtonClick = (button) => {
        filterButtons.forEach(btn => {
            btn.classList.remove('active');
        });
        button.classList.add('active');
        timeTypeInput.value = button.dataset.value;
        fetchData();
    };

    const updateCustomerTable = (customers) => {
        if (customersDataTable) {
            customersDataTable.destroy();
        }
        const tbody = document.querySelector('#customersTable tbody');
        tbody.innerHTML = customers.map((customer, index) => `
            <tr>
                <td>${index + 1}</td>
                <td>${customer.full_name}</td>
                <td>${customer.email}</td>
                <td><span class="${customer.tier.class}">${customer.tier.name}</span></td>
                <td data-sort="${customer.total_orders}">${formatters.number(customer.total_orders)}</td>
                <td data-sort="${customer.total_spending}">${formatters.currency(customer.total_spending)}</td>
                <td data-sort="${customer.average_order_value}">${formatters.currency(customer.average_order_value)}</td>
                <td data-sort="${new Date(customer.first_order_date).getTime()}">${formatters.date(customer.first_order_date)}</td>
                <td data-sort="${new Date(customer.last_order_date).getTime()}">${formatters.date(customer.last_order_date)}</td>
            </tr>
        `).join('');

        customersDataTable = $('#customersTable').DataTable({
            language: {
                search: "Tìm kiếm:",
                lengthMenu: "Hiển thị _MENU_ dòng",
                info: "Hiển thị _START_ đến _END_ của _TOTAL_ dòng",
                infoEmpty: "Hiển thị 0 đến 0 của 0 dòng",
                infoFiltered: "(được lọc từ _MAX_ dòng)",
                paginate: {
                    first: "Đầu",
                    last: "Cuối",
                    next: "Sau",
                    previous: "Trước"
                }
            },
            order: [[4, 'desc']], // Sort by total spending by default
            pageLength: 10,
            columnDefs: [
                { type: 'num', targets: [3, 4, 5] },
                { type: 'date', targets: [6, 7] }
            ]
        });
    };

    const updateRevenueTable = (revenueStats) => {
        const tbody = document.querySelector('#revenueTable tbody');
        tbody.innerHTML = revenueStats.map(stat => `
            <tr>
                <td>${stat.period}</td>
                <td>${formatters.number(stat.total_customers)}</td>
                <td>${formatters.number(stat.total_orders)}</td>
                <td>${formatters.currency(stat.total_revenue)}</td>
                <td>${formatters.currency(stat.average_order_value)}</td>
                <td>${formatters.currency(stat.average_customer_spending)}</td>
            </tr>
        `).join('');
    };
  
    const fetchData = async () => {
        try {
            const response = await fetch(`/admin/statistics/revenueCustomer?time_type=${timeTypeInput.value}`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();

            if (data) {
                updateCustomerTable(data.customerDetails);
                updateRevenueTable(data.revenueStats);
            }
        } catch (error) {
            console.error('Error fetching data:', error);
            alert('Có lỗi xảy ra khi tải dữ liệu. Vui lòng thử lại sau.');
        }
    };

    filterButtons.forEach(button => {
        button.addEventListener('click', () => handleButtonClick(button));
    });

    fetchData();
});
