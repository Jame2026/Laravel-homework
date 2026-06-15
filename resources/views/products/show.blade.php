<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Product Detail</h4>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">Back</a>
                    </div>

                    <div class="card-body" id="productDetail">
                        <div class="text-center">Loading product...</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>

    <script>
        const productId = '{{ $product }}';

        function formatPrice(value) {
            return new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD'
            }).format(Number(value || 0));
        }

        async function loadProduct() {
            const response = await fetch(`/api/products/${productId}`);
            const product = await response.json();

            document.getElementById('productDetail').innerHTML = `
                <img src="${product.image_url || ''}" class="img-fluid rounded mb-3 ${product.image_url ? '' : 'd-none'}" alt="${product.name}">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <td>${product.id}</td>
                        </tr>
                        <tr>
                            <th>Category</th>
                            <td>${product.category ? product.category.name : 'No category'}</td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td>${product.name}</td>
                        </tr>
                        <tr>
                            <th>Price</th>
                            <td>${formatPrice(product.price)}</td>
                        </tr>
                        <tr>
                            <th>Stock</th>
                            <td>${product.stock}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td><span class="badge ${product.is_active ? 'bg-success' : 'bg-danger'}">${product.is_active ? 'Active' : 'Inactive'}</span></td>
                        </tr>
                    </tbody>
                </table>
                <a href="/products/${product.id}/edit" class="btn btn-primary">Edit</a>
            `;
        }

        document.addEventListener('DOMContentLoaded', loadProduct);
    </script>
</body>
</html>
