<div align="center">

# 🏢 Sistem Kepegawaian

### *Sistem Manajemen Kepegawaian Modern dengan Mutasi & Riwayat Jabatan*

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/TailwindCSS-3.x-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="Tailwind">
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Status-Production%20Ready-success?style=flat-square" alt="Status">
  <img src="https://img.shields.io/badge/Version-2.0.0-blue?style=flat-square" alt="Version">
  <img src="https://img.shields.io/badge/License-MIT-green?style=flat-square" alt="License">
</p>

---

</div>

## 📋 Tentang Sistem

**Sistem Kepegawaian** adalah aplikasi web modern yang dirancang khusus untuk mengelola data kepegawaian dengan fokus pada sistem mutasi dan riwayat jabatan. Sistem ini menyediakan solusi terintegrasi untuk manajemen pegawai PNS, PPPK, dan NON ASN dengan workflow mutasi yang komprehensif dan tracking riwayat jabatan yang detail.

### ✨ Fitur Utama

<table>
<tr>
<td width="50%">

#### 👥 **Manajemen Pegawai**
- 📝 Data pegawai lengkap (PNS, PPPK, NON ASN)
- 🎓 Integrasi data pendidikan & golongan
- 📄 Upload dokumen (foto, SK, ijazah)
- 📊 Status kepegawaian real-time
- 🔍 Filter & pencarian advanced

#### 🔄 **Sistem Mutasi Terintegrasi**
- 📋 Workflow mutasi masuk otomatis
- 📝 Riwayat mutasi komprehensif
- 🏛️ Deteksi mutasi intra/inter kecamatan
- ⚡ Auto-redirect setelah input pegawai PNS

</td>
<td width="50%">

#### 📋 **Riwayat Jabatan**
- 🏢 Tracking posisi & jabatan
- 📅 Timeline karir pegawai
- ✏️ CRUD riwayat jabatan
- 🔗 Terintegrasi dengan data pegawai

#### 📊 **Pelaporan & Notifikasi**
- 📈 Dashboard mutasi real-time
- 📋 Laporan pegawai & mutasi
- 🔔 Sistem notifikasi terintegrasi
- 📱 UI responsif modern

</td>
</tr>
</table>

---

## 🚀 Quick Start

### 📋 Prerequisites

Pastikan sistem Anda memiliki:

```bash
🔧 PHP >= 8.2
🗄️ MySQL >= 8.0
🎼 Composer
🟢 Node.js & NPM
```

### ⚡ Instalasi

1. **Clone Repository**
   ```bash
   git clone https://github.com/hafisc/sistem-kepegawaian.git
   cd sistem-kepegawaian
   ```

2. **Install Dependencies**
   ```bash
   composer install --no-dev
   npm install
   npm run build
   ```

3. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Configuration**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=kepegawaian
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Database Migration & Seeding**
   ```bash
   php artisan migrate:fresh --seed
   ```

6. **Start Development Server**
   ```bash
   php artisan serve
   ```

🎉 **Akses aplikasi di**: `http://127.0.0.1:8000`

---

## 👤 Default Accounts

| Role | Username | Password | Akses |
|------|----------|----------|-------|
| 👨‍💼 **Admin** | `admin` | `admin123` | Full system access |
| 👤 **User** | `user` | `user123` | Personal dashboard |

---

## 🏗️ Arsitektur Sistem

### 📁 Struktur Database

```
📊 Users (Pegawai)
├── 👤 Personal Info (NIP, NIK, Gender, etc.)
├── 🏢 Employment Info (Position, Rank, Type)
├── 🎓 Education Info (Level, Major, Year)
└── 📄 Documents (Photo, SK, Ijazah Files)

📋 Transfers (Mutasi)
├── 🔄 Mutasi Masuk/Keluar
├── 📝 Riwayat Mutasi
├── 📍 Unit Asal & Tujuan
└── 📄 Dokumen Pendukung

🏢 Position Histories (Riwayat Jabatan)
├── 📋 Posisi & Jabatan
├── 📅 Periode Jabatan
├── 🏛️ Unit Kerja
└── 📝 Keterangan

📚 Master Data
├── 🎓 Educations (Tingkat Pendidikan)
├── 🏅 Grades (Golongan)
├── 👑 Ranks (Pangkat)
├── 🕌 Religions (Agama)
└── 🏛️ Villages (Desa/Unit)
```

### 🔄 Workflow Mutasi

<div align="center">

```mermaid
graph TD
    A[👥 Tambah Pegawai PNS] --> B{Jenis Pegawai}
    B -->|PNS| C[📋 Form Mutasi Masuk]
    B -->|PPPK/NON ASN| D[✅ Selesai]
    
    C --> E[💾 Simpan Mutasi Masuk]
    E --> F[📝 Form Riwayat Mutasi]
    F --> G[💾 Simpan Riwayat]
    G --> H[🔄 Kembali ke Daftar Pegawai]
    
    I[👤 Kelola Pegawai] --> J[📋 Aksi Pegawai]
    J --> K[👁️ Detail]
    J --> L[📜 Riwayat Jabatan]
    J --> M[🔄 Riwayat Mutasi]
    J --> N[➡️ Mutasi Baru]
    J --> O[✏️ Edit]
```

</div>

---

## 📊 System Analysis & Design

### 🎯 Use Case Diagram

<div align="center">

```mermaid
graph TB
    subgraph "Sistem Kepegawaian"
        subgraph "Admin Functions"
            UC1[Kelola Data Pegawai]
            UC2[Proses Mutasi Masuk]
            UC3[Kelola Riwayat Mutasi]
            UC4[Kelola Riwayat Jabatan]
            UC5[Generate Laporan]
            UC6[Kelola Master Data]
            UC7[Kelola Notifikasi]
        end
        
        subgraph "User Functions"
            UC8[Lihat Profile]
            UC9[Update Profile]
            UC10[Lihat Riwayat Mutasi]
            UC11[Lihat Riwayat Jabatan]
        end
    end
    
    Admin[👨‍💼 Admin] --> UC1
    Admin --> UC2
    Admin --> UC3
    Admin --> UC4
    Admin --> UC5
    Admin --> UC6
    Admin --> UC7
    
    User[👤 User/Pegawai] --> UC8
    User --> UC9
    User --> UC10
    User --> UC11
    
    UC2 -.-> UC3
    UC1 -.-> UC4
```

</div>

### 📋 Activity Diagram - Proses Mutasi PNS

<div align="center">

```mermaid
graph TD
    Start([🚀 Mulai]) --> A1[📝 Input Data Pegawai PNS]
    A1 --> A2{Validasi Data}
    A2 -->|❌ Invalid| A3[⚠️ Tampilkan Error]
    A3 --> A1
    A2 -->|✅ Valid| A4[💾 Simpan Data Pegawai]
    A4 --> A5[🔄 Auto Redirect ke Form Mutasi Masuk]
    A5 --> A6[📋 Isi Form Mutasi Masuk]
    A6 --> A7{Validasi Mutasi}
    A7 -->|❌ Invalid| A8[⚠️ Tampilkan Error Mutasi]
    A8 --> A6
    A7 -->|✅ Valid| A9[💾 Simpan Data Mutasi Masuk]
    A9 --> A10{Cek Jenis Mutasi}
    A10 -->|Intra-Kecamatan| A11[✅ Set Status Aktif]
    A10 -->|Inter-Kecamatan| A12[⏳ Set Status Sesuai Aturan]
    A11 --> A13[🔄 Redirect ke Form Riwayat Mutasi]
    A12 --> A13
    A13 --> A14[📝 Isi Riwayat Mutasi]
    A14 --> A15{Validasi Riwayat}
    A15 -->|❌ Invalid| A16[⚠️ Tampilkan Error Riwayat]
    A16 --> A14
    A15 -->|✅ Valid| A17[💾 Simpan Riwayat Mutasi]
    A17 --> A18[🔔 Kirim Notifikasi]
    A18 --> A19[🔄 Redirect ke Daftar Pegawai]
    A19 --> End([🏁 Selesai])
```

</div>

### 🏗️ Class Diagram

<div align="center">

```mermaid
classDiagram
    class User {
        +id: int
        +name: string
        +username: string
        +email: string
        +nip: string
        +nik: string
        +employee_type: enum
        +position: string
        +rank: string
        +work_unit: string
        +is_active: boolean
        +photo: string
        +login()
        +updateProfile()
        +uploadDocument()
    }
    
    class Transfer {
        +id: int
        +user_id: int
        +from_unit: string
        +to_unit: string
        +transfer_date: date
        +reason: string
        +status: enum
        +supporting_docs: string
        +createMutasi()
        +updateStatus()
        +generateReport()
    }
    
    class PositionHistory {
        +id: int
        +user_id: int
        +position: string
        +unit: string
        +start_date: date
        +end_date: date
        +notes: text
        +addPosition()
        +updatePosition()
        +getTimeline()
    }
    
    class Education {
        +id: int
        +level: string
        +description: string
        +getEducationLevels()
    }
    
    class Grade {
        +id: int
        +code: string
        +name: string
        +getGrades()
    }
    
    class Notification {
        +id: int
        +user_id: int
        +title: string
        +message: text
        +is_read: boolean
        +send()
        +markAsRead()
    }
    
    User ||--o{ Transfer : "has many"
    User ||--o{ PositionHistory : "has many"
    User ||--o{ Notification : "receives"
    User }o--|| Education : "has education level"
    User }o--|| Grade : "has grade"
```

</div>

### 🗄️ Entity Relationship Diagram (ERD)

<div align="center">

```mermaid
erDiagram
    USERS {
        int id PK
        string name
        string username UK
        string email UK
        string nip UK
        string nik UK
        enum employee_type
        string position
        string rank
        string work_unit
        boolean is_active
        string photo
        timestamp created_at
        timestamp updated_at
    }
    
    TRANSFERS {
        int id PK
        int user_id FK
        string from_unit
        string to_unit
        date transfer_date
        string reason
        enum status
        string supporting_docs
        text notes
        timestamp created_at
        timestamp updated_at
    }
    
    POSITION_HISTORIES {
        int id PK
        int user_id FK
        string position
        string unit
        date start_date
        date end_date
        text notes
        timestamp created_at
        timestamp updated_at
    }
    
    EDUCATIONS {
        int id PK
        string level UK
        string description
        timestamp created_at
        timestamp updated_at
    }
    
    GRADES {
        int id PK
        string code UK
        string name
        timestamp created_at
        timestamp updated_at
    }
    
    RANKS {
        int id PK
        string code UK
        string name
        int grade_id FK
        timestamp created_at
        timestamp updated_at
    }
    
    RELIGIONS {
        int id PK
        string name UK
        timestamp created_at
        timestamp updated_at
    }
    
    VILLAGES {
        int id PK
        string name
        string district
        string province
        boolean is_active
        timestamp created_at
        timestamp updated_at
    }
    
    NOTIFICATIONS {
        int id PK
        int user_id FK
        string title
        text message
        boolean is_read
        timestamp created_at
        timestamp updated_at
    }
    
    USERS ||--o{ TRANSFERS : "has"
    USERS ||--o{ POSITION_HISTORIES : "has"
    USERS ||--o{ NOTIFICATIONS : "receives"
    USERS }o--|| EDUCATIONS : "belongs to"
    USERS }o--|| GRADES : "belongs to"
    USERS }o--|| RANKS : "belongs to"
    USERS }o--|| RELIGIONS : "belongs to"
    GRADES ||--o{ RANKS : "contains"
```

</div>

### 🔄 Sequence Diagram - Login & Mutasi Process

<div align="center">

```mermaid
sequenceDiagram
    participant U as 👤 User/Admin
    participant C as 🖥️ Controller
    participant M as 📊 Model
    participant DB as 🗄️ Database
    participant N as 🔔 Notification
    
    Note over U,N: Login Process
    U->>C: POST /login (credentials)
    C->>M: validate credentials
    M->>DB: check user table
    DB-->>M: user data
    M-->>C: authentication result
    C-->>U: redirect to dashboard
    
    Note over U,N: Add PNS Employee Process
    U->>C: POST /admin/users (PNS data)
    C->>M: validate & create user
    M->>DB: insert user data
    DB-->>M: user created
    M-->>C: success response
    C->>C: check employee_type === 'PNS'
    C-->>U: redirect to mutasi masuk form
    
    Note over U,N: Mutasi Process
    U->>C: POST /admin/mutasi/masuk
    C->>M: create transfer record
    M->>DB: insert transfer data
    DB-->>M: transfer created
    C->>C: check intra/inter district
    C->>M: update user status if needed
    M->>DB: update user table
    C-->>U: redirect to riwayat mutasi
    
    U->>C: POST /admin/mutasi/riwayat
    C->>M: update transfer with history
    M->>DB: update transfer record
    DB-->>M: history saved
    C->>N: send notification
    N->>DB: store notification
    C-->>U: redirect to users list
```

</div>

---

## 🛠️ Tech Stack

<div align="center">

### Backend
![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)

### Frontend
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![Blade](https://img.shields.io/badge/Blade-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)

### Tools & Libraries
![Composer](https://img.shields.io/badge/Composer-885630?style=for-the-badge&logo=composer&logoColor=white)
![NPM](https://img.shields.io/badge/NPM-CB3837?style=for-the-badge&logo=npm&logoColor=white)
![Font Awesome](https://img.shields.io/badge/Font_Awesome-339AF0?style=for-the-badge&logo=fontawesome&logoColor=white)

</div>

---

## 📸 Screenshots

<div align="center">

### 🔐 Login Page
*Modern authentication dengan role-based access*

### 👨‍💼 Admin Dashboard
*Dashboard komprehensif dengan statistik mutasi real-time*

### 👥 Manajemen Pegawai
*Interface lengkap dengan aksi mutasi dan riwayat jabatan*

### 🔄 Workflow Mutasi
*Sistem mutasi terintegrasi dengan auto-redirect*

### 📋 Riwayat Jabatan
*Tracking karir pegawai dengan timeline lengkap*

</div>

---

## 🤝 Contributing

Kami menyambut kontribusi dari komunitas! Berikut cara berkontribusi:

1. 🍴 **Fork** repository ini
2. 🌿 **Create** feature branch (`git checkout -b feature/AmazingFeature`)
3. 💾 **Commit** perubahan (`git commit -m 'Add some AmazingFeature'`)
4. 📤 **Push** ke branch (`git push origin feature/AmazingFeature`)
5. 🔄 **Open** Pull Request

### 📝 Development Guidelines

- 🧪 Test fitur mutasi dan riwayat jabatan
- 📚 Update dokumentasi untuk workflow baru
- 🎨 Ikuti coding standards Laravel
- 🔍 Pastikan validasi form mutasi
- 🔄 Test auto-redirect setelah input PNS

---

## 📞 Support & Contact

<div align="center">

### 🆘 Butuh Bantuan?

📧 **Email**: hafisc@kepegawaian.com  
📱 **GitHub**: https://github.com/hafisc  
🌐 **Repository**: https://github.com/hafisc/sistem-kepegawaian  
📖 **Issues**: https://github.com/hafisc/sistem-kepegawaian/issues  

### 🐛 Bug Reports

Laporkan bug melalui [GitHub Issues](https://github.com/hafisc/sistem-kepegawaian/issues)

</div>

---

## 📄 License

Sistem ini dilisensikan di bawah [MIT License](https://opensource.org/licenses/MIT).

```
MIT License - Bebas digunakan untuk proyek komersial dan non-komersial
```

---

<div align="center">

### 🌟 Jika project ini membantu, berikan ⭐ star!

**Made with ❤️ for Modern Employee Management**

### 🚀 Fitur Terbaru v2.0
- ✅ Sistem mutasi terintegrasi
- ✅ Riwayat jabatan komprehensif  
- ✅ Auto-redirect workflow PNS
- ✅ Upload dokumen multi-format
- ✅ Filter dan pencarian advanced
- ✅ UI/UX responsif modern

---

*© 2025 Sistem Kepegawaian v2.0. All rights reserved.*

</div>
