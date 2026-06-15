<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Edit Product</h4>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">Back</a>
                    </div>

                    <div class="card-body">
                        <div id="errors" class="alert alert-danger d-none"></div>

                        <form id="productForm" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">Category</label>
                                <select name="category_id" id="category_id" class="form-select" required></select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Product Name</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Current Image</label>
                                <div>
                                    <img id="currentImage" src="" width="120" class="d-none mb-2" alt="Current Product Image">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">New Image</label>
                                <input type="file" name="image" id="image" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Price</label>
                                <input type="number" step="0.01" min="0" name="price" id="price" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Stock</label>
                                <input type="number" min="0" name="stock" id="stock" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="is_active" id="is_active" class="form-select">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>

    <script>
        const productId = '{{ $product }}';
        const form = document.getElementById('productForm');
        const errorsBox = document.getElementById('errors');

        async function loadCategories() {
            const response = await fetch('/api/categories');
            const categories = await response.json();

            document.getElementById('category_id').innerHTML = categories.map(category => `
                <option value="${category.id}">${category.name}</option>
            `).join('');
        }

        async function loadProduct() {
            const response = await fetch(`/api/products/${productId}`);
            const product = await response.json();

            document.getElementById('category_id').value = product.category_id;
            document.getElementById('name').value = product.name;
            document.getElementById('price').value = product.price;
            document.getElementById('stock').value = product.stock;
            document.getElementById('is_active').value = product.is_active ? '1' : '0';

            const image = document.getElementById('currentImage');
            if (product.image_url) {
                image.src = product.image_url;
                image.classList.remove('d-none');
            }
        }

        function showErrors(errors) {
            if (!errors) {
                errorsBox.textContent = 'Something went wrong.';
                errorsBox.classList.remove('d-none');
                return;
            }

            errorsBox.innerHTML = Object.values(errors).flat().map(error => `<div>${error}</div>`).join('');
            errorsBox.classList.remove('d-none');
        }

        form.addEventListener('submit', async event => {
            event.preventDefault();
            errorsBox.classList.add('d-none');

            const formData = new FormData(form);

            if (!document.getElementById('image').files.length) {
                formData.delete('image');
            }

            const response = await fetch(`/api/products/${productId}`, {
                method: 'PUT',
                headers: {
                    'Accept': 'application/json'
                },
                body: formData
            });

            if (!response.ok) {
                const data = await response.json();
                showErrors(data.errors);
                return;
            }

            window.location.href = '/products';
        });

        document.addEventListener('DOMContentLoaded', () => {
            loadCategories();
            loadProduct();
        });
    </script>
</body>
</html>
