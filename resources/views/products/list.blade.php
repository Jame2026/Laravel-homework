<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Products API UI</h2>
            <a href="{{ route('products.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> Create
            </a>
        </div>

        <div id="message" class="alert d-none"></div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="productsBody">
                    <tr>
                        <td colspan="7" class="text-center">Loading products...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const productsUrl = '/api/products';
        const messageBox = document.getElementById('message');

        function escapeHtml(value) {
            const div = document.createElement('div');
            div.textContent = value ?? '';
            return div.innerHTML;
        }

        function formatPrice(value) {
            return new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD'
            }).format(Number(value || 0));
        }

        function showMessage(type, text) {
            messageBox.className = `alert alert-${type}`;
            messageBox.textContent = text;
            messageBox.classList.remove('d-none');
        }

        async function loadProducts() {
            try {
                const response = await fetch(productsUrl);
                const products = await response.json();
                renderProducts(products);
            } catch (error) {
                document.getElementById('productsBody').innerHTML = '<tr><td colspan="7" class="text-danger text-center">Failed to load products.</td></tr>';
            }
        }

        function renderProducts(products) {
            const body = document.getElementById('productsBody');

            if (products.length === 0) {
                body.innerHTML = '<tr><td colspan="7" class="text-center">No products found.</td></tr>';
                return;
            }

            body.innerHTML = products.map(product => `
                <tr>
                    <td>${escapeHtml(product.id)}</td>
                    <td>${escapeHtml(product.name)}</td>
                    <td>${product.image_url ? `<img src="${escapeHtml(product.image_url)}" width="80" height="80" class="object-fit-cover" alt="${escapeHtml(product.name)}">` : '<span class="text-muted">No image</span>'}</td>
                    <td>${formatPrice(product.price)}</td>
                    <td>${escapeHtml(product.stock)}</td>
                    <td><span class="badge ${product.is_active ? 'bg-success' : 'bg-danger'}">${product.is_active ? 'Active' : 'Inactive'}</span></td>
                    <td>
                        <a href="/products/${product.id}" class="text-success me-2" title="View">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        <a href="/products/${product.id}/edit" class="text-info me-2" title="Edit">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <button type="button" class="btn btn-link p-0 text-danger" onclick="deleteProduct(${product.id}, '${escapeHtml(product.name)}')" title="Delete">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `).join('');
        }

        async function deleteProduct(id, name) {
            if (!confirm(`Delete ${name}?`)) {
                return;
            }

            try {
                const response = await fetch(`${productsUrl}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error('Delete failed');
                }

                showMessage('success', 'Product deleted successfully.');
                loadProducts();
            } catch (error) {
                showMessage('danger', 'Failed to delete product.');
            }
        }

        document.addEventListener('DOMContentLoaded', loadProducts);
    </script>
</body>
</html>
