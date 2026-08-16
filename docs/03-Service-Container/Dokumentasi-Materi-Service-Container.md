Service Container
│
├── 1. Apa masalah yang diselesaikan Container?
│
├── 2. Memahami `app()`
│
├── 3. `bind()`
│
├── 4. `singleton()`
│
├── 5. Interface → Implementation
│
├── 6. Dependency Injection
│
└── 7. Service Provider

#Service Container

Sebelumnya kita sudah mencoba melakukan Dependency Injection secara manual
Laravel memiliki fitur Dependency Injection secara otomatis, dan ini wajib dikuasai agar lebih mudah membuat aplikasi menggunakan Laravel
Di Laravel fitur ini bernama Service Container, dimana Service Container ini merupakan fitur yang digunakan untuk manajemen dependencies dan juga dependency injection

# Apa Masalah yang Diselesaikan Container?

Berikut adalah contoh sederhana tanpa menggunakan Service Container
Viewed Dokumentasi-Materi-Service-Container.md
Created Dokumentasi-Materi-Service-Container.md
Viewed Dokumentasi-Materi-Service-Container.md:1-63

Penjelasan mengenai apa saja masalah yang diselesaikan oleh Laravel **Service Container** telah dituliskan ke dalam file [Dokumentasi-Materi-Service-Container.md](file:///Users/afrizalwibisono/AppsProject/Experiment/laravel_training_v1/docs/03-Service-Container/Dokumentasi-Materi-Service-Container.md).

### Ringkasan Masalah yang Diselesaikan Service Container:

1. **Instansiasi Manual & Complex Dependencies (_Auto-wiring_)**
    - **Masalah:** Tanpa Service Container, jika sebuah class memiliki nested dependencies (misal `UserService` butuh `UserRepository`, yang butuh `DatabaseConnection`, yang butuh `Config`), kita harus membuat `new` untuk masing-masing objek secara manual.
    - **Solusi:** Service Container memanfaatkan PHP _Reflection_ untuk membuat dan menyusun seluruh dependency objek secara otomatis (_Auto-wiring_).

2. **Keterikatan Kode yang Tinggi (_Tight Coupling_)**
    - **Masalah:** Menggunakan keyword `new ConcreteClass()` secara langsung di banyak tempat membuat kode terikat pada satu implementasi konkrit.
    - **Solusi:** Mampu melakukan binding dari **Interface** ke **Concrete Class** (`bind`). Jika ingin mengganti vendor/implementasi (misal dari `GopayMethod` ke `MidtransMethod`), cukup ubah 1 baris binding pada Service Provider.

3. **Manajemen Lifecycle Objek (_Singleton vs New Instance_)**
    - **Masalah:** Membuat pattern Singleton secara manual membutuhkan boilerplate code.
    - **Solusi:** Container menyediakan opsi manajemen lifecycle objek yang mudah seperti `bind()` (membuat instance baru setiap dipanggil) dan `singleton()` (menggunakan instance yang sama di seluruh lifecycle aplikasi).

4. **Kemudahan Automated Testing (_Unit Testing & Mocking_)**
    - **Masalah:** Class yang menggunakan `new` secara langsung sulit di-test atau diisolasi dari dependency eksternal.
    - **Solusi:** Service Container mempermudah penggantian instance asli dengan _Mock/Stub Object_ saat testing dijalankan (`$this->app->instance(...)`).
