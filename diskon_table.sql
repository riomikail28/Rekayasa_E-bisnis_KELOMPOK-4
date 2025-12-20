-- Create diskon table
CREATE TABLE IF NOT EXISTS diskon (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_diskon VARCHAR(50) NOT NULL UNIQUE,
    persentase_diskon INT NOT NULL CHECK (persentase_diskon >= 1 AND persentase_diskon <= 100),
    tanggal_mulai DATE NOT NULL,
    tanggal_akhir DATE NOT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
