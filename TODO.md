# TODO - Thêm lựa chọn thanh toán (tiền mặt/QR)


## Checklist
- [ ] Cập nhật DB: thêm cột `payment_method` vào bảng `bookings`.
- [ ] Update `views/Courts/CourtsBooking.php`: thêm UI chọn phương thức thanh toán + hidden input `payment_method`.
- [ ] Update `src/Controllers/CourtsController.php`: đọc `payment_method` từ POST và truyền sang `bookingModel->createBooking()`.
- [ ] Update `src/Models/BookingModel.php`: nhận `payment_method` và insert vào bảng `bookings`.
- [ ] Update `views/Courts/BookingSuccess.php`: hiển thị phương thức thanh toán đã chọn.
- [ ] Chạy thử luồng đặt sân: chọn slot -> chọn payment -> confirm -> xem success.

