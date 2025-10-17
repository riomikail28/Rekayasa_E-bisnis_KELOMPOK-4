# TODO: Update ERP Backend Features

## Overview
Update the BuketMiniku e-commerce ERP backend with new admin features: Website Settings Management, Financial Reports, Analytics & Statistics, Shipping Management, and Stock Management.

## Steps
- [x] Update views/admin/dashboard_admin.php: Add new page names to $adminPages array and add sidebar links for the new main pages (pengaturan_website, laporan_keuangan, analitik_statistik, manajemen_pengiriman, manajemen_stok).
- [x] Create models/pengaturanModel.php: Functions for getting and updating website settings (general, logo, favicon, contact info).
- [x] Create models/pengirimanModel.php: Functions for CRUD operations on shipping data (shipments, costs).
- [x] Create models/stokModel.php: Functions for CRUD operations on stock data (integrate with products if needed).
- [x] Create controllers/pengaturanController.php: Handle POST requests for updating settings.
- [x] Create controllers/pengirimanController.php: Handle CRUD for shipping.
- [x] Create controllers/stokController.php: Handle CRUD for stock.
- [x] Create views/admin/pages/pengaturan_website.php: Main page with tabs for Pengaturan Umum, Logo, Favicon, Informasi Kontak.
- [x] Create views/admin/pages/laporan_keuangan.php: Main page with sections for Daftar Laporan Keuangan, Laporan Pendapatan, Laporan Pengeluaran.
- [x] Create views/admin/pages/analitik_statistik.php: Expand analytics with Laporan Pengunjung, Laporan Penjualan, Laporan Produk Terlaris.
- [x] Create views/admin/pages/manajemen_pengiriman.php: List shipments with add/edit/delete, include Biaya Pengiriman.
- [x] Create views/admin/pages/manajemen_stok.php: List stock with add/edit/delete, low stock warnings.
- [x] Test new pages by accessing admin dashboard and verifying functionality.
