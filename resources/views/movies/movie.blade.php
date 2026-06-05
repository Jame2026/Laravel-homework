<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie List</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Movie List</h1>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Date</th>
                <th>Price</th>
                <th>Author</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @forelse($movies as $movie)
                <tr>
                    <td>{{ $movie->id }}</td>
                    <td>{{ $movie->name }}</td>
                    <td>{{ $movie->date }}</td>
                    <td>${{ $movie->price }}</td>
                    <td>{{ $movie->author }}</td>
                    <td>{{ $movie->description }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No movies found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

</body>
</html>