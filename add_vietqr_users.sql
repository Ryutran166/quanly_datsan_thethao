-- Thêm trường VietQR cho owner (users)
-- Chạy trong MySQL/MariaDB

ALTER TABLE `users`
  ADD COLUMN `vietqr_bank_code` VARCHAR(20) NULL,
  ADD COLUMN `vietqr_account_number` VARCHAR(50) NULL,
  ADD COLUMN `vietqr_account_name` VARCHAR(100) NULL;

