
# Toko Online Zam Store!!!

Sebuah website Toko online yang menjual perabotan rumah tangga dengan menggunakan midtrans sebagai payment gateway untuk mempermudah seller dalam melakukan track transaksi.

#### Fitur
- Seller
    -   Crud Products
    -   Authentikasi Login Register
    -   Keamanan menggunakan sanctum
    -   Monitor Pesanan / order
- User
    -   Melihat 3 product paling laris dalam bulan ini
    -   Melihat Category Yang tersedia di dalam toko ini
    -   Melihat product berdasarkan kategori yang dipilih
    -   Checkout Product Berdasarkan Seller yang dipilih
    -   Pembayaran yang mudah menggunakan midtrans
    -   Authentikasi Login Register
    -   Ubah Data profile
    -   History pesanan

### Cara menjalankan applikasi

```bash
composer install
```

```bash
php artisan migrate
```

```bash
php artisan db:seed
```

```bash
npm run install
```

### Buka .env lalu isi midtrans sesuai dengan key
```bash
MIDTRANS_MERCHAT_ID=id_merchant
MIDTRANS_CLIENT_KEY=client_key
MIDTRANS_SERVER_KEY=server_key
```

### Lalu jalankan aplikasi dengan perintah 

```bash
php artisan serve
```

```bash
npm run dev
```
