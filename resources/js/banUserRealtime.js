import './bootstrap';
// console.log(`user_id: ${userId}`);
window.Echo.private(`user.${userId}`)
    .listen('UserBannedEvent', (e) => {
        console.log('Event received:', e);

        // Hiển thị modal
        const modalHtml = `
            <div id="banModal" class="modal fade" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                    <div class="modal-content shadow-lg border-0">
                        <div class="modal-header bg-danger">
                            <h5 class="modal-title text-center text-light">
                                Tài khoản bị khóa
                            </h5>
                        </div>
                        <div class="modal-body text-center">
                            <p class="fs-6">
                                <strong>Lý do:</strong> <span class="text-danger">${e.reason}</span>
                            </p>
                            <p class="text-muted small">
                                Tài khoản của bạn đã bị khóa vì lý do trên. Bạn sẽ bị đăng xuất trong <span id="logoutTimer">5</span> giây.
                            </p>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button id="understoodBtn" class="btn btn-outline-danger w-100">Tôi đã hiểu!</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        $('body').append(modalHtml);
        $('#banModal').modal('show');

        // Logout sau 5 giây
        let countdown = 5;
        const timer = setInterval(() => {
            countdown--;
            document.getElementById('logoutTimer').innerText = countdown;
            if (countdown <= 0) {
                clearInterval(timer);
                window.location.href = '/logout';
            }
        }, 1000);

        // Xử lý khi nhấn nút "Tôi đã hiểu"
        $('#understoodBtn').on('click', function () {
            window.location.href = '/logout';
        });
    });
