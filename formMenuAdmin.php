<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Tambah Menu - Daun Hijau Cafe</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
    :root {
        --primary-green: #198754;
        --dark-green: #155724;
        --light-green: #d1e7dd;
        --hover-green: #157347;
    }

    body {
        background: linear-gradient(135deg, #1a5d1a 0%, #2d8c2d 100%);
        min-height: 100vh;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .admin-container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 0 1rem;
    }

    .admin-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        border: none;
    }

    .admin-header {
        background: linear-gradient(135deg, var(--primary-green), var(--dark-green));
        color: white;
        padding: 2rem;
        text-align: center;
    }

    .admin-title {
        font-weight: 700;
        margin-bottom: 0.5rem;
        font-size: 2rem;
    }

    .admin-subtitle {
        opacity: 0.9;
        font-size: 1.1rem;
    }

    .admin-body {
        padding: 2.5rem;
    }

    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
    }

    .form-control,
    .form-select {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25);
    }

    .input-group-text {
        background-color: var(--light-green);
        border: 2px solid #e9ecef;
        border-right: none;
        color: var(--dark-green);
        font-weight: 600;
    }

    .form-control:focus+.input-group-text {
        border-color: var(--primary-green);
    }

    .btn-admin {
        background: linear-gradient(135deg, var(--primary-green), var(--dark-green));
        border: none;
        color: white;
        padding: 14px 28px;
        font-weight: 600;
        border-radius: 12px;
        transition: all 0.3s ease;
        font-size: 1.1rem;
        width: 100%;
    }

    .btn-admin:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(25, 135, 84, 0.3);
        background: linear-gradient(135deg, var(--hover-green), var(--primary-green));
    }

    .btn-admin:active {
        transform: translateY(0);
    }

    .category-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.9rem;
        margin: 0.25rem;
    }

    .category-coffee {
        background-color: #e7f5ff;
        color: #1971c2;
        border: 2px solid #a5d8ff;
    }

    .category-drink {
        background-color: #fff0f6;
        color: #c2255c;
        border: 2px solid #fcc2d7;
    }

    .category-food {
        background-color: #fff9db;
        color: #e67700;
        border: 2px solid #ffec99;
    }

    .preview-card {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border: 2px dashed #dee2e6;
        border-radius: 15px;
        padding: 2rem;
        text-align: center;
        margin-top: 1rem;
    }

    .preview-title {
        color: var(--dark-green);
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .menu-preview {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        text-align: left;
    }

    .menu-name {
        color: var(--dark-green);
        font-weight: 700;
        font-size: 1.3rem;
        margin-bottom: 0.5rem;
    }

    .menu-description {
        color: #6c757d;
        margin-bottom: 1rem;
        line-height: 1.5;
    }

    .menu-price {
        color: var(--primary-green);
        font-weight: 700;
        font-size: 1.4rem;
    }

    .menu-category {
        display: inline-block;
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-top: 0.5rem;
    }

    .form-section {
        margin-bottom: 2rem;
    }

    .section-title {
        color: var(--dark-green);
        font-weight: 600;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--light-green);
    }

    .character-count {
        font-size: 0.8rem;
        color: #6c757d;
        text-align: right;
        margin-top: 0.25rem;
    }

    .character-count.warning {
        color: #e67700;
    }

    .character-count.danger {
        color: #c2255c;
    }

    .success-message {
        background: linear-gradient(135deg, #d3f9d8, #b2f2bb);
        border: 2px solid #51cf66;
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        color: #2b8a3e;
        font-weight: 600;
        display: none;
    }

    @media (max-width: 768px) {
        .admin-container {
            margin: 1rem auto;
        }

        .admin-body {
            padding: 1.5rem;
        }

        .admin-title {
            font-size: 1.5rem;
        }
    }
    </style>
</head>

<body>
    <div class="admin-container">
        <div class="admin-card">
            <!-- Header -->
            <div class="admin-header">
                <h1 class="admin-title">
                    <i class="bi bi-plus-circle me-2"></i>
                    Tambah Menu Baru
                </h1>
                <p class="admin-subtitle">Kelola menu Daun Hijau Cafe dengan mudah</p>
            </div>

            <!-- Success Message -->
            <div class="success-message" id="successMessage">
                <i class="bi bi-check-circle-fill me-2"></i>
                Menu berhasil ditambahkan!
            </div>

            <!-- Form -->
            <div class="admin-body">
                <form id="menuForm" action="">
                    <!-- Nama Menu -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="bi bi-card-heading me-2"></i>
                            Informasi Menu
                        </h3>
                        <div class="mb-3">
                            <label for="menuName" class="form-label">Nama Menu</label>
                            <input type="text" class="form-control" id="menuName" name="name"
                                placeholder="Contoh: Espresso Double Shot" required maxlength="50">
                            <div class="character-count">
                                <span id="nameCount">0</span>/50 karakter
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-3">
                            <label for="menuDescription" class="form-label">Deskripsi Menu</label>
                            <textarea class="form-control" id="menuDescription" name="description" rows="3"
                                placeholder="Jelaskan tentang menu ini..." maxlength="200"></textarea>
                            <div class="character-count">
                                <span id="descriptionCount">0</span>/200 karakter
                            </div>
                        </div>
                    </div>

                    <!-- Harga dan Kategori -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="bi bi-tags me-2"></i>
                            Detail Harga & Kategori
                        </h3>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="menuPrice" class="form-label">Harga (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="menuPrice" name="price"
                                        placeholder="25000" min="0" step="500" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="menuCategory" class="form-label">Kategori</label>
                                <select class="form-select" id="menuCategory" name="category" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="coffee">Coffee</option>
                                    <option value="minuman">Minuman</option>
                                    <option value="makanan">Makanan</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Preview -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="bi bi-eye me-2"></i>
                            Preview Menu
                        </h3>
                        <div class="preview-card">
                            <h4 class="preview-title">Pratinjau Menu</h4>
                            <div class="menu-preview">
                                <div class="menu-name" id="previewName">Nama Menu akan muncul di sini</div>
                                <div class="menu-description" id="previewDescription">
                                    Deskripsi menu akan muncul di sini
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="menu-price" id="previewPrice">Rp 0</div>
                                    <span class="menu-category" id="previewCategory">-</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <button type="submit" class="btn-admin">
                        <i class="bi bi-plus-circle me-2"></i>
                        Tambah Menu
                    </button>
                </form>
                <?php 
                    include 'env.php';
                    $name = $_POST["name"];
                    $description = $_POST["description"];
                    $price = $_POST["price"];
                    $category = $_POST["category"];
                    $komentar = $_POST["komentar"];

                    $sql = "INSERT INTO products (name, description, price, category, komentar) VALUES ('$name', '$description', '$price', '$category')";
                    if($koneksi->query($sql) === TRUE){
                    // echo("Data berhasil ditambahkan");            // echo("<br> <a href= '../index.php'>HOME</a>");
                    }else{
                        echo("Error " . $sql . "<br>" . $koneksi->error);
                    }
                ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('menuForm');
        const successMessage = document.getElementById('successMessage');

        // Element untuk character count
        const nameInput = document.getElementById('menuName');
        const descriptionInput = document.getElementById('menuDescription');
        const nameCount = document.getElementById('nameCount');
        const descriptionCount = document.getElementById('descriptionCount');

        // Element untuk preview
        const previewName = document.getElementById('previewName');
        const previewDescription = document.getElementById('previewDescription');
        const previewPrice = document.getElementById('previewPrice');
        const previewCategory = document.getElementById('previewCategory');

        // Update character count
        nameInput.addEventListener('input', function() {
            const count = this.value.length;
            nameCount.textContent = count;
            nameCount.className = 'character-count' +
                (count > 40 ? ' warning' : '') +
                (count >= 50 ? ' danger' : '');

            // Update preview
            previewName.textContent = this.value || 'Nama Menu akan muncul di sini';
        });

        descriptionInput.addEventListener('input', function() {
            const count = this.value.length;
            descriptionCount.textContent = count;
            descriptionCount.className = 'character-count' +
                (count > 180 ? ' warning' : '') +
                (count >= 200 ? ' danger' : '');

            // Update preview
            previewDescription.textContent = this.value || 'Deskripsi menu akan muncul di sini';
        });

        // Update price preview
        document.getElementById('menuPrice').addEventListener('input', function() {
            const price = parseInt(this.value) || 0;
            previewPrice.textContent = 'Rp ' + price.toLocaleString('id-ID');
        });

        // Update category preview
        document.getElementById('menuCategory').addEventListener('change', function() {
            const category = this.value;
            let categoryText = '-';
            let categoryClass = '';

            switch (category) {
                case 'coffee':
                    categoryText = 'Coffee';
                    categoryClass = 'category-coffee';
                    break;
                case 'minuman':
                    categoryText = 'Minuman';
                    categoryClass = 'category-drink';
                    break;
                case 'makanan':
                    categoryText = 'Makanan';
                    categoryClass = 'category-food';
                    break;
            }

            previewCategory.textContent = categoryText;
            previewCategory.className = 'menu-category ' + categoryClass;
        });

        // Form submission
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Simulasi pengiriman data (dalam implementasi nyata, ini akan AJAX ke backend)
            const formData = new FormData(form);
            const menuData = {
                name: formData.get('name'),
                description: formData.get('description'),
                price: formData.get('price'),
                category: formData.get('category')
            };

            console.log('Data menu yang akan dikirim:', menuData);

            // Tampilkan pesan sukses
            successMessage.style.display = 'block';

            // Reset form setelah 2 detik
            setTimeout(() => {
                form.reset();
                successMessage.style.display = 'none';

                // Reset preview
                previewName.textContent = 'Nama Menu akan muncul di sini';
                previewDescription.textContent = 'Deskripsi menu akan muncul di sini';
                previewPrice.textContent = 'Rp 0';
                previewCategory.textContent = '-';
                previewCategory.className = 'menu-category';

                // Reset character count
                nameCount.textContent = '0';
                descriptionCount.textContent = '0';
                nameCount.className = 'character-count';
                descriptionCount.className = 'character-count';

            }, 3000);
        });
    });
    </script>
</body>

</html>