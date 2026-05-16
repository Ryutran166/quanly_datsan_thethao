- [x] Nghiên cứu owner_bookings hiển thị total_amount ở views/owner/bookings/OwnerBookingsList.php
- [x] Xác định root cause: OwnerController::getBookingsByOwner() không SELECT b.total_amount nên bị set về 0
- [x] Sửa src/Controllers/Owner/OwnerController.php: thêm b.total_amount vào SELECT để hiển thị đúng giá trị trong bảng bookings

