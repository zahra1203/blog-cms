<?php
// ============================================================
// STEP 6 - HALAMAN UTAMA (index.php)
// Fungsi: Tampilan utama CMS dengan navigasi, tabel data,
//         dan semua modal form (CRUD) menggunakan fetch API
// ============================================================
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Blog (CMS)</title>
    <style>
        /* ===================== RESET & BASE ===================== */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 14px;
            background: #f0f2f5;
            color: #333;
            min-height: 100vh;
        }

        /* ===================== HEADER ===================== */
        header {
            background: #1e293b;
            color: #fff;
            padding: 14px 24px;
            display: flex;
            align-items: center;
            gap: 10px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        }
        header .logo { font-size: 20px; }
        header h1 { font-size: 18px; font-weight: 600; }
        header p  { font-size: 12px; color: #94a3b8; margin-top: 2px; }

        /* ===================== LAYOUT ===================== */
        .wrapper {
            display: flex;
            min-height: calc(100vh - 54px);
        }

        /* ===================== SIDEBAR ===================== */
        aside {
            width: 210px;
            background: #fff;
            border-right: 1px solid #e2e8f0;
            padding: 20px 0;
            flex-shrink: 0;
        }
        aside .menu-label {
            font-size: 11px;
            font-weight: 700;
            color: #94a3b8;
            letter-spacing: 1px;
            padding: 0 20px 10px;
            text-transform: uppercase;
        }
        aside a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 20px;
            color: #475569;
            text-decoration: none;
            cursor: pointer;
            transition: all .2s;
            font-weight: 500;
            border-left: 3px solid transparent;
        }
        aside a:hover  { background: #f8fafc; color: #1e293b; }
        aside a.active { background: #eff6ff; color: #2563eb; border-left-color: #2563eb; }
        aside a .icon  { font-size: 16px; width: 20px; text-align: center; }

        /* ===================== CONTENT AREA ===================== */
        main {
            flex: 1;
            padding: 28px;
            overflow-x: auto;
        }
        .section { display: none; }
        .section.active { display: block; }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .section-header h2 {
            font-size: 20px;
            font-weight: 600;
            color: #1e293b;
        }

        /* ===================== BUTTONS ===================== */
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            transition: all .2s;
        }
        .btn-primary   { background: #2563eb; color: #fff; }
        .btn-primary:hover { background: #1d4ed8; }
        .btn-success   { background: #059669; color: #fff; }
        .btn-success:hover { background: #047857; }
        .btn-danger    { background: #dc2626; color: #fff; }
        .btn-danger:hover  { background: #b91c1c; }
        .btn-secondary { background: #e2e8f0; color: #475569; }
        .btn-secondary:hover { background: #cbd5e1; }
        .btn-sm { padding: 5px 12px; font-size: 12px; }

        /* ===================== TABLE ===================== */
        .card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        table { width: 100%; border-collapse: collapse; }
        thead { background: #f8fafc; }
        th {
            padding: 12px 16px;
            text-align: left;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #64748b;
            border-bottom: 1px solid #e2e8f0;
        }
        td {
            padding: 12px 16px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
            color: #334155;
        }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #f8fafc; }

        .foto-thumb {
            width: 48px;
            height: 48px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #e2e8f0;
        }
        .gambar-thumb {
            width: 60px;
            height: 42px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
        }
        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            background: #dbeafe;
            color: #1d4ed8;
        }
        .password-masked { font-family: monospace; color: #94a3b8; font-size: 13px; }
        .aksi-btns { display: flex; gap: 6px; }

        /* ===================== MODAL ===================== */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }
        .modal-overlay.show { display: flex; }

        .modal {
            background: #fff;
            border-radius: 12px;
            width: 100%;
            max-width: 520px;
            max-height: 90vh;
            overflow-y: auto;
            padding: 28px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
            animation: slideUp .25s ease;
        }
        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to   { transform: translateY(0);    opacity: 1; }
        }
        .modal-title {
            font-size: 18px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 20px;
        }

        /* Modal Konfirmasi Hapus */
        .modal-hapus { max-width: 360px; text-align: center; }
        .modal-hapus .icon-hapus { font-size: 40px; color: #dc2626; margin-bottom: 12px; }
        .modal-hapus h3 { font-size: 17px; font-weight: 700; color: #1e293b; margin-bottom: 6px; }
        .modal-hapus p  { color: #64748b; font-size: 13px; margin-bottom: 20px; }
        .modal-hapus .btn-group { display: flex; gap: 10px; justify-content: center; }

        /* ===================== FORM ===================== */
        .form-row { display: flex; gap: 14px; }
        .form-row .form-group { flex: 1; }

        .form-group { margin-bottom: 16px; }
        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 9px 12px;
            border: 1px solid #d1d5db;
            border-radius: 7px;
            font-size: 14px;
            color: #1f2937;
            outline: none;
            transition: border-color .2s;
            background: #fff;
        }
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37,99,235,.1);
        }
        .form-group textarea { resize: vertical; min-height: 90px; }
        .form-hint { font-size: 12px; color: #94a3b8; margin-top: 4px; }

        .form-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
            border-top: 1px solid #f1f5f9;
            padding-top: 16px;
        }

        /* ===================== ALERT ===================== */
        .alert {
            padding: 10px 14px;
            border-radius: 7px;
            font-size: 13px;
            margin-bottom: 14px;
        }
        .alert-success { background: #dcfce7; color: #166534; }
        .alert-error   { background: #fee2e2; color: #991b1b; }

        .empty-row td { text-align: center; color: #94a3b8; padding: 32px; }
    </style>
</head>
<body>

<!-- ==================== HEADER ==================== -->
<header>
    <span class="logo">📰</span>
    <div>
        <h1>Sistem Manajemen Blog (CMS)</h1>
        <p>Blog Keren</p>
    </div>
</header>

<div class="wrapper">

    <!-- ==================== SIDEBAR ==================== -->
    <aside>
        <div class="menu-label">Menu Utama</div>
        <a class="nav-link active" data-target="penulis">
            <span class="icon">👤</span> Kelola Penulis
        </a>
        <a class="nav-link" data-target="artikel">
            <span class="icon">📄</span> Kelola Artikel
        </a>
        <a class="nav-link" data-target="kategori">
            <span class="icon">🗂️</span> Kelola Kategori
        </a>
    </aside>

    <!-- ==================== MAIN CONTENT ==================== -->
    <main>

        <!-- ===== SECTION: PENULIS ===== -->
        <div id="section-penulis" class="section active">
            <div class="section-header">
                <h2>Data Penulis</h2>
                <button class="btn btn-primary" onclick="bukaModalTambahPenulis()">+ Tambah Penulis</button>
            </div>
            <div id="alert-penulis"></div>
            <div class="card">
                <table>
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tabel-penulis">
                        <tr class="empty-row"><td colspan="5">Memuat data...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ===== SECTION: ARTIKEL ===== -->
        <div id="section-artikel" class="section">
            <div class="section-header">
                <h2>Data Artikel</h2>
                <button class="btn btn-primary" onclick="bukaModalTambahArtikel()">+ Tambah Artikel</button>
            </div>
            <div id="alert-artikel"></div>
            <div class="card">
                <table>
                    <thead>
                        <tr>
                            <th>Gambar</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Penulis</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tabel-artikel">
                        <tr class="empty-row"><td colspan="6">Memuat data...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ===== SECTION: KATEGORI ===== -->
        <div id="section-kategori" class="section">
            <div class="section-header">
                <h2>Data Kategori Artikel</h2>
                <button class="btn btn-primary" onclick="bukaModalTambahKategori()">+ Tambah Kategori</button>
            </div>
            <div id="alert-kategori"></div>
            <div class="card">
                <table>
                    <thead>
                        <tr>
                            <th>Nama Kategori</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tabel-kategori">
                        <tr class="empty-row"><td colspan="3">Memuat data...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</div>

<!-- ============================================================
     MODAL: TAMBAH PENULIS
     ============================================================ -->
<div class="modal-overlay" id="modal-tambah-penulis">
    <div class="modal">
        <div class="modal-title">Tambah Penulis</div>
        <div id="alert-form-tambah-penulis"></div>
        <div class="form-row">
            <div class="form-group">
                <label>Nama Depan</label>
                <input type="text" id="tp-nama-depan" placeholder="Ahmad">
            </div>
            <div class="form-group">
                <label>Nama Belakang</label>
                <input type="text" id="tp-nama-belakang" placeholder="Fauzi">
            </div>
        </div>
        <div class="form-group">
            <label>Username</label>
            <input type="text" id="tp-username" autocomplete="off" placeholder="ahmad_f">
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" id="tp-password" autocomplete="new-password" placeholder="••••••••••••">
        </div>
        <div class="form-group">
            <label>Foto Profil</label>
            <input type="file" id="tp-foto" accept="image/*">
            <div class="form-hint">Opsional. Maks 2 MB. Format: JPG, PNG, GIF, WEBP.</div>
        </div>
        <div class="form-footer">
            <button class="btn btn-secondary" onclick="tutupModal('modal-tambah-penulis')">Batal</button>
            <button class="btn btn-success" onclick="simpanPenulis()">Simpan Data</button>
        </div>
    </div>
</div>

<!-- ============================================================
     MODAL: EDIT PENULIS
     ============================================================ -->
<div class="modal-overlay" id="modal-edit-penulis">
    <div class="modal">
        <div class="modal-title">Edit Penulis</div>
        <div id="alert-form-edit-penulis"></div>
        <input type="hidden" id="ep-id">
        <div class="form-row">
            <div class="form-group">
                <label>Nama Depan</label>
                <input type="text" id="ep-nama-depan">
            </div>
            <div class="form-group">
                <label>Nama Belakang</label>
                <input type="text" id="ep-nama-belakang">
            </div>
        </div>
        <div class="form-group">
            <label>Username</label>
            <input type="text" id="ep-username">
        </div>
        <div class="form-group">
            <label>Password Baru <span style="font-weight:400;color:#94a3b8">(kosongkan jika tidak diganti)</span></label>
            <input type="password" id="ep-password" placeholder="••••••••••••">
        </div>
        <div class="form-group">
            <label>Foto Profil <span style="font-weight:400;color:#94a3b8">(kosongkan jika tidak diganti)</span></label>
            <input type="file" id="ep-foto" accept="image/*">
            <div class="form-hint">Maks 2 MB. Format: JPG, PNG, GIF, WEBP.</div>
        </div>
        <div class="form-footer">
            <button class="btn btn-secondary" onclick="tutupModal('modal-edit-penulis')">Batal</button>
            <button class="btn btn-success" onclick="updatePenulis()">Simpan Perubahan</button>
        </div>
    </div>
</div>

<!-- ============================================================
     MODAL: HAPUS PENULIS
     ============================================================ -->
<div class="modal-overlay" id="modal-hapus-penulis">
    <div class="modal modal-hapus">
        <div class="icon-hapus">🗑️</div>
        <h3>Hapus data ini?</h3>
        <p>Data yang dihapus tidak dapat dikembalikan.</p>
        <input type="hidden" id="hapus-penulis-id">
        <div class="btn-group">
            <button class="btn btn-secondary" onclick="tutupModal('modal-hapus-penulis')">Batal</button>
            <button class="btn btn-danger" onclick="konfirmasiHapusPenulis()">Ya, Hapus</button>
        </div>
    </div>
</div>

<!-- ============================================================
     MODAL: TAMBAH ARTIKEL
     ============================================================ -->
<div class="modal-overlay" id="modal-tambah-artikel">
    <div class="modal">
        <div class="modal-title">Tambah Artikel</div>
        <div id="alert-form-tambah-artikel"></div>
        <div class="form-group">
            <label>Judul</label>
            <input type="text" id="ta-judul" placeholder="Judul artikel...">
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Penulis</label>
                <select id="ta-penulis"></select>
            </div>
            <div class="form-group">
                <label>Kategori</label>
                <select id="ta-kategori"></select>
            </div>
        </div>
        <div class="form-group">
            <label>Isi Artikel</label>
            <textarea id="ta-isi" placeholder="Tulis isi artikel di sini..."></textarea>
        </div>
        <div class="form-group">
            <label>Gambar</label>
            <input type="file" id="ta-gambar" accept="image/*">
            <div class="form-hint">Wajib. Maks 2 MB. Format: JPG, PNG, GIF, WEBP.</div>
        </div>
        <div class="form-footer">
            <button class="btn btn-secondary" onclick="tutupModal('modal-tambah-artikel')">Batal</button>
            <button class="btn btn-success" onclick="simpanArtikel()">Simpan Data</button>
        </div>
    </div>
</div>

<!-- ============================================================
     MODAL: EDIT ARTIKEL
     ============================================================ -->
<div class="modal-overlay" id="modal-edit-artikel">
    <div class="modal">
        <div class="modal-title">Edit Artikel</div>
        <div id="alert-form-edit-artikel"></div>
        <input type="hidden" id="ea-id">
        <div class="form-group">
            <label>Judul</label>
            <input type="text" id="ea-judul">
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Penulis</label>
                <select id="ea-penulis"></select>
            </div>
            <div class="form-group">
                <label>Kategori</label>
                <select id="ea-kategori"></select>
            </div>
        </div>
        <div class="form-group">
            <label>Isi Artikel</label>
            <textarea id="ea-isi"></textarea>
        </div>
        <div class="form-group">
            <label>Gambar <span style="font-weight:400;color:#94a3b8">(kosongkan jika tidak diganti)</span></label>
            <input type="file" id="ea-gambar" accept="image/*">
            <div class="form-hint">Maks 2 MB. Format: JPG, PNG, GIF, WEBP.</div>
        </div>
        <div class="form-footer">
            <button class="btn btn-secondary" onclick="tutupModal('modal-edit-artikel')">Batal</button>
            <button class="btn btn-success" onclick="updateArtikel()">Simpan Perubahan</button>
        </div>
    </div>
</div>

<!-- ============================================================
     MODAL: HAPUS ARTIKEL
     ============================================================ -->
<div class="modal-overlay" id="modal-hapus-artikel">
    <div class="modal modal-hapus">
        <div class="icon-hapus">🗑️</div>
        <h3>Hapus data ini?</h3>
        <p>Data yang dihapus tidak dapat dikembalikan.</p>
        <input type="hidden" id="hapus-artikel-id">
        <div class="btn-group">
            <button class="btn btn-secondary" onclick="tutupModal('modal-hapus-artikel')">Batal</button>
            <button class="btn btn-danger" onclick="konfirmasiHapusArtikel()">Ya, Hapus</button>
        </div>
    </div>
</div>

<!-- ============================================================
     MODAL: TAMBAH KATEGORI
     ============================================================ -->
<div class="modal-overlay" id="modal-tambah-kategori">
    <div class="modal">
        <div class="modal-title">Tambah Kategori</div>
        <div id="alert-form-tambah-kategori"></div>
        <div class="form-group">
            <label>Nama Kategori</label>
            <input type="text" id="tk-nama" placeholder="Nama kategori...">
        </div>
        <div class="form-group">
            <label>Keterangan</label>
            <textarea id="tk-keterangan" placeholder="Deskripsi kategori..."></textarea>
        </div>
        <div class="form-footer">
            <button class="btn btn-secondary" onclick="tutupModal('modal-tambah-kategori')">Batal</button>
            <button class="btn btn-success" onclick="simpanKategori()">Simpan Data</button>
        </div>
    </div>
</div>

<!-- ============================================================
     MODAL: EDIT KATEGORI
     ============================================================ -->
<div class="modal-overlay" id="modal-edit-kategori">
    <div class="modal">
        <div class="modal-title">Edit Kategori</div>
        <div id="alert-form-edit-kategori"></div>
        <input type="hidden" id="ek-id">
        <div class="form-group">
            <label>Nama Kategori</label>
            <input type="text" id="ek-nama">
        </div>
        <div class="form-group">
            <label>Keterangan</label>
            <textarea id="ek-keterangan"></textarea>
        </div>
        <div class="form-footer">
            <button class="btn btn-secondary" onclick="tutupModal('modal-edit-kategori')">Batal</button>
            <button class="btn btn-success" onclick="updateKategori()">Simpan Perubahan</button>
        </div>
    </div>
</div>

<!-- ============================================================
     MODAL: HAPUS KATEGORI
     ============================================================ -->
<div class="modal-overlay" id="modal-hapus-kategori">
    <div class="modal modal-hapus">
        <div class="icon-hapus">🗑️</div>
        <h3>Hapus data ini?</h3>
        <p>Data yang dihapus tidak dapat dikembalikan.</p>
        <input type="hidden" id="hapus-kategori-id">
        <div class="btn-group">
            <button class="btn btn-secondary" onclick="tutupModal('modal-hapus-kategori')">Batal</button>
            <button class="btn btn-danger" onclick="konfirmasiHapusKategori()">Ya, Hapus</button>
        </div>
    </div>
</div>

<!-- ============================================================
     JAVASCRIPT - FETCH API (ASYNCHRONOUS)
     ============================================================ -->
<script>
// ==========================================
// UTILITAS UMUM
// ==========================================

/** Tampilkan/sembunyikan section sesuai menu yang diklik */
document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', function () {
        document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
        document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
        this.classList.add('active');
        document.getElementById('section-' + this.dataset.target).classList.add('active');
    });
});

/** Buka modal */
function bukaModal(id) {
    document.getElementById(id).classList.add('show');
}

/** Tutup modal */
function tutupModal(id) {
    document.getElementById(id).classList.remove('show');
}

/** Tutup modal jika klik area luar */
document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', function (e) {
        if (e.target === this) this.classList.remove('show');
    });
});

/** Tampilkan alert */
function tampilAlert(elId, pesan, tipe = 'success') {
    const el = document.getElementById(elId);
    el.innerHTML = `<div class="alert alert-${tipe}">${htmlEscape(pesan)}</div>`;
    setTimeout(() => { el.innerHTML = ''; }, 4000);
}

/** Sanitasi output (XSS prevention) */
function htmlEscape(str) {
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}

// ==========================================
// CRUD PENULIS
// ==========================================

/** Muat data penulis ke tabel */
async function muatPenulis() {
    try {
        const res  = await fetch('ambil_penulis.php');
        const json = await res.json();
        const tbody = document.getElementById('tabel-penulis');

        if (!json.data || json.data.length === 0) {
            tbody.innerHTML = '<tr class="empty-row"><td colspan="5">Belum ada data penulis.</td></tr>';
            return;
        }

        tbody.innerHTML = json.data.map(p => `
            <tr>
                <td>
                    <img src="uploads_penulis/${htmlEscape(p.foto)}"
                         alt="foto"
                         class="foto-thumb"
                         onerror="this.src='uploads_penulis/default.png'">
                </td>
                <td>${htmlEscape(p.nama_depan)} ${htmlEscape(p.nama_belakang)}</td>
                <td>${htmlEscape(p.user_name)}</td>
                <td class="password-masked">${htmlEscape(p.password.substring(0, 14))}...</td>
                <td>
                    <div class="aksi-btns">
                        <button class="btn btn-success btn-sm" onclick="bukaEditPenulis(${p.id})">Edit</button>
                        <button class="btn btn-danger btn-sm"  onclick="bukaHapusPenulis(${p.id})">Hapus</button>
                    </div>
                </td>
            </tr>
        `).join('');
    } catch (err) {
        console.error('Gagal memuat penulis:', err);
    }
}

/** Buka modal tambah penulis */
function bukaModalTambahPenulis() {
    document.getElementById('tp-nama-depan').value   = '';
    document.getElementById('tp-nama-belakang').value = '';
    document.getElementById('tp-username').value     = '';
    document.getElementById('tp-password').value     = '';
    document.getElementById('tp-foto').value         = '';
    document.getElementById('alert-form-tambah-penulis').innerHTML = '';
    bukaModal('modal-tambah-penulis');
}

/** Simpan penulis baru */
async function simpanPenulis() {
    const fd = new FormData();
    fd.append('nama_depan', document.getElementById('tp-nama-depan').value.trim());
    fd.append('nama_belakang', document.getElementById('tp-nama-belakang').value.trim());
    fd.append('user_name', document.getElementById('tp-username').value.trim());
    fd.append('password', document.getElementById('tp-password').value);

    const foto = document.getElementById('tp-foto').files[0];
    if (foto) fd.append('foto', foto);

    const res  = await fetch('simpan_penulis.php', { method: 'POST', body: fd });
    const json = await res.json();

    if (json.status === 'sukses') {
        tutupModal('modal-tambah-penulis');
        tampilAlert('alert-penulis', json.pesan, 'success');
        muatPenulis();
    } else {
        tampilAlert('alert-form-tambah-penulis', json.pesan, 'error');
    }
}

/** Buka modal edit penulis (isi otomatis dari DB) */
async function bukaEditPenulis(id) {
    const res  = await fetch('ambil_satu_penulis.php?id=' + id);
    const json = await res.json();
    if (json.status !== 'sukses') { alert(json.pesan); return; }

    const p = json.data;
    document.getElementById('ep-id').value          = p.id;
    document.getElementById('ep-nama-depan').value  = p.nama_depan;
    document.getElementById('ep-nama-belakang').value = p.nama_belakang;
    document.getElementById('ep-username').value    = p.user_name;
    document.getElementById('ep-password').value    = '';
    document.getElementById('ep-foto').value        = '';
    document.getElementById('alert-form-edit-penulis').innerHTML = '';
    bukaModal('modal-edit-penulis');
}

/** Update penulis */
async function updatePenulis() {
    const fd = new FormData();
    fd.append('id',            document.getElementById('ep-id').value);
    fd.append('nama_depan',    document.getElementById('ep-nama-depan').value.trim());
    fd.append('nama_belakang', document.getElementById('ep-nama-belakang').value.trim());
    fd.append('user_name',     document.getElementById('ep-username').value.trim());
    fd.append('password_baru', document.getElementById('ep-password').value);

    const foto = document.getElementById('ep-foto').files[0];
    if (foto) fd.append('foto', foto);

    const res  = await fetch('update_penulis.php', { method: 'POST', body: fd });
    const json = await res.json();

    if (json.status === 'sukses') {
        tutupModal('modal-edit-penulis');
        tampilAlert('alert-penulis', json.pesan, 'success');
        muatPenulis();
    } else {
        tampilAlert('alert-form-edit-penulis', json.pesan, 'error');
    }
}

/** Buka konfirmasi hapus penulis */
function bukaHapusPenulis(id) {
    document.getElementById('hapus-penulis-id').value = id;
    bukaModal('modal-hapus-penulis');
}

/** Konfirmasi & eksekusi hapus penulis */
async function konfirmasiHapusPenulis() {
    const fd = new FormData();
    fd.append('id', document.getElementById('hapus-penulis-id').value);

    const res  = await fetch('hapus_penulis.php', { method: 'POST', body: fd });
    const json = await res.json();

    tutupModal('modal-hapus-penulis');
    tampilAlert('alert-penulis', json.pesan, json.status === 'sukses' ? 'success' : 'error');
    if (json.status === 'sukses') muatPenulis();
}

// ==========================================
// CRUD ARTIKEL
// ==========================================

/** Muat daftar penulis ke dropdown */
async function muatDropdownPenulis(selectId, selectedId = null) {
    const res  = await fetch('ambil_penulis.php');
    const json = await res.json();
    const sel  = document.getElementById(selectId);
    sel.innerHTML = json.data.map(p =>
        `<option value="${p.id}" ${p.id == selectedId ? 'selected' : ''}>
            ${htmlEscape(p.nama_depan)} ${htmlEscape(p.nama_belakang)}
         </option>`
    ).join('');
}

/** Muat daftar kategori ke dropdown */
async function muatDropdownKategori(selectId, selectedId = null) {
    const res  = await fetch('ambil_kategori.php');
    const json = await res.json();
    const sel  = document.getElementById(selectId);
    sel.innerHTML = json.data.map(k =>
        `<option value="${k.id}" ${k.id == selectedId ? 'selected' : ''}>
            ${htmlEscape(k.nama_kategori)}
         </option>`
    ).join('');
}

/** Muat data artikel ke tabel */
async function muatArtikel() {
    try {
        const res   = await fetch('ambil_artikel.php');
        const json  = await res.json();
        const tbody = document.getElementById('tabel-artikel');

        if (!json.data || json.data.length === 0) {
            tbody.innerHTML = '<tr class="empty-row"><td colspan="6">Belum ada data artikel.</td></tr>';
            return;
        }

        tbody.innerHTML = json.data.map(a => `
            <tr>
                <td>
                    <img src="uploads_artikel/${htmlEscape(a.gambar)}"
                         alt="gambar"
                         class="gambar-thumb"
                         onerror="this.src='uploads_penulis/default.png'">
                </td>
                <td>${htmlEscape(a.judul)}</td>
                <td><span class="badge">${htmlEscape(a.nama_kategori)}</span></td>
                <td>${htmlEscape(a.nama_penulis)}</td>
                <td>${htmlEscape(a.hari_tanggal)}</td>
                <td>
                    <div class="aksi-btns">
                        <button class="btn btn-success btn-sm" onclick="bukaEditArtikel(${a.id})">Edit</button>
                        <button class="btn btn-danger btn-sm"  onclick="bukaHapusArtikel(${a.id})">Hapus</button>
                    </div>
                </td>
            </tr>
        `).join('');
    } catch (err) {
        console.error('Gagal memuat artikel:', err);
    }
}

/** Buka modal tambah artikel */
async function bukaModalTambahArtikel() {
    document.getElementById('ta-judul').value  = '';
    document.getElementById('ta-isi').value    = '';
    document.getElementById('ta-gambar').value = '';
    document.getElementById('alert-form-tambah-artikel').innerHTML = '';
    await muatDropdownPenulis('ta-penulis');
    await muatDropdownKategori('ta-kategori');
    bukaModal('modal-tambah-artikel');
}

/** Simpan artikel baru */
async function simpanArtikel() {
    const fd = new FormData();
    fd.append('judul',       document.getElementById('ta-judul').value.trim());
    fd.append('isi',         document.getElementById('ta-isi').value.trim());
    fd.append('id_penulis',  document.getElementById('ta-penulis').value);
    fd.append('id_kategori', document.getElementById('ta-kategori').value);

    const gambar = document.getElementById('ta-gambar').files[0];
    if (gambar) fd.append('gambar', gambar);

    const res  = await fetch('simpan_artikel.php', { method: 'POST', body: fd });
    const json = await res.json();

    if (json.status === 'sukses') {
        tutupModal('modal-tambah-artikel');
        tampilAlert('alert-artikel', json.pesan, 'success');
        muatArtikel();
    } else {
        tampilAlert('alert-form-tambah-artikel', json.pesan, 'error');
    }
}

/** Buka modal edit artikel */
async function bukaEditArtikel(id) {
    const res  = await fetch('ambil_satu_artikel.php?id=' + id);
    const json = await res.json();
    if (json.status !== 'sukses') { alert(json.pesan); return; }

    const a = json.data;
    document.getElementById('ea-id').value    = a.id;
    document.getElementById('ea-judul').value = a.judul;
    document.getElementById('ea-isi').value   = a.isi;
    document.getElementById('ea-gambar').value = '';
    document.getElementById('alert-form-edit-artikel').innerHTML = '';

    await muatDropdownPenulis('ea-penulis', a.id_penulis);
    await muatDropdownKategori('ea-kategori', a.id_kategori);
    bukaModal('modal-edit-artikel');
}

/** Update artikel */
async function updateArtikel() {
    const fd = new FormData();
    fd.append('id',          document.getElementById('ea-id').value);
    fd.append('judul',       document.getElementById('ea-judul').value.trim());
    fd.append('isi',         document.getElementById('ea-isi').value.trim());
    fd.append('id_penulis',  document.getElementById('ea-penulis').value);
    fd.append('id_kategori', document.getElementById('ea-kategori').value);

    const gambar = document.getElementById('ea-gambar').files[0];
    if (gambar) fd.append('gambar', gambar);

    const res  = await fetch('update_artikel.php', { method: 'POST', body: fd });
    const json = await res.json();

    if (json.status === 'sukses') {
        tutupModal('modal-edit-artikel');
        tampilAlert('alert-artikel', json.pesan, 'success');
        muatArtikel();
    } else {
        tampilAlert('alert-form-edit-artikel', json.pesan, 'error');
    }
}

/** Buka konfirmasi hapus artikel */
function bukaHapusArtikel(id) {
    document.getElementById('hapus-artikel-id').value = id;
    bukaModal('modal-hapus-artikel');
}

/** Konfirmasi & eksekusi hapus artikel */
async function konfirmasiHapusArtikel() {
    const fd = new FormData();
    fd.append('id', document.getElementById('hapus-artikel-id').value);

    const res  = await fetch('hapus_artikel.php', { method: 'POST', body: fd });
    const json = await res.json();

    tutupModal('modal-hapus-artikel');
    tampilAlert('alert-artikel', json.pesan, json.status === 'sukses' ? 'success' : 'error');
    if (json.status === 'sukses') muatArtikel();
}

// ==========================================
// CRUD KATEGORI
// ==========================================

/** Muat data kategori ke tabel */
async function muatKategori() {
    try {
        const res   = await fetch('ambil_kategori.php');
        const json  = await res.json();
        const tbody = document.getElementById('tabel-kategori');

        if (!json.data || json.data.length === 0) {
            tbody.innerHTML = '<tr class="empty-row"><td colspan="3">Belum ada data kategori.</td></tr>';
            return;
        }

        tbody.innerHTML = json.data.map(k => `
            <tr>
                <td><span class="badge">${htmlEscape(k.nama_kategori)}</span></td>
                <td>${htmlEscape(k.keterangan || '-')}</td>
                <td>
                    <div class="aksi-btns">
                        <button class="btn btn-success btn-sm" onclick="bukaEditKategori(${k.id})">Edit</button>
                        <button class="btn btn-danger btn-sm"  onclick="bukaHapusKategori(${k.id})">Hapus</button>
                    </div>
                </td>
            </tr>
        `).join('');
    } catch (err) {
        console.error('Gagal memuat kategori:', err);
    }
}

/** Buka modal tambah kategori */
function bukaModalTambahKategori() {
    document.getElementById('tk-nama').value       = '';
    document.getElementById('tk-keterangan').value = '';
    document.getElementById('alert-form-tambah-kategori').innerHTML = '';
    bukaModal('modal-tambah-kategori');
}

/** Simpan kategori baru */
async function simpanKategori() {
    const fd = new FormData();
    fd.append('nama_kategori', document.getElementById('tk-nama').value.trim());
    fd.append('keterangan',    document.getElementById('tk-keterangan').value.trim());

    const res  = await fetch('simpan_kategori.php', { method: 'POST', body: fd });
    const json = await res.json();

    if (json.status === 'sukses') {
        tutupModal('modal-tambah-kategori');
        tampilAlert('alert-kategori', json.pesan, 'success');
        muatKategori();
    } else {
        tampilAlert('alert-form-tambah-kategori', json.pesan, 'error');
    }
}

/** Buka modal edit kategori */
async function bukaEditKategori(id) {
    const res  = await fetch('ambil_satu_kategori.php?id=' + id);
    const json = await res.json();
    if (json.status !== 'sukses') { alert(json.pesan); return; }

    const k = json.data;
    document.getElementById('ek-id').value         = k.id;
    document.getElementById('ek-nama').value       = k.nama_kategori;
    document.getElementById('ek-keterangan').value = k.keterangan || '';
    document.getElementById('alert-form-edit-kategori').innerHTML = '';
    bukaModal('modal-edit-kategori');
}

/** Update kategori */
async function updateKategori() {
    const fd = new FormData();
    fd.append('id',            document.getElementById('ek-id').value);
    fd.append('nama_kategori', document.getElementById('ek-nama').value.trim());
    fd.append('keterangan',    document.getElementById('ek-keterangan').value.trim());

    const res  = await fetch('update_kategori.php', { method: 'POST', body: fd });
    const json = await res.json();

    if (json.status === 'sukses') {
        tutupModal('modal-edit-kategori');
        tampilAlert('alert-kategori', json.pesan, 'success');
        muatKategori();
    } else {
        tampilAlert('alert-form-edit-kategori', json.pesan, 'error');
    }
}

/** Buka konfirmasi hapus kategori */
function bukaHapusKategori(id) {
    document.getElementById('hapus-kategori-id').value = id;
    bukaModal('modal-hapus-kategori');
}

/** Konfirmasi & eksekusi hapus kategori */
async function konfirmasiHapusKategori() {
    const fd = new FormData();
    fd.append('id', document.getElementById('hapus-kategori-id').value);

    const res  = await fetch('hapus_kategori.php', { method: 'POST', body: fd });
    const json = await res.json();

    tutupModal('modal-hapus-kategori');
    tampilAlert('alert-kategori', json.pesan, json.status === 'sukses' ? 'success' : 'error');
    if (json.status === 'sukses') muatKategori();
}

// ==========================================
// INISIALISASI: Muat data saat halaman dibuka
// ==========================================
muatPenulis();
muatArtikel();
muatKategori();
</script>

</body>
</html>
