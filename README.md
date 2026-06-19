# PHP_Laravel12_Codebase_Mcp


## Project Description

PHP_Laravel12_Codebase_Mcp is a Laravel 12 demo application that showcases the integration of the Laravel Codebase MCP package.

The application manages blog posts and categories while demonstrating CRUD operations, model relationships, search functionality, pagination, and a modern Bootstrap 5 dashboard interface.


## Key Features

🚀 Laravel Codebase MCP Package Setup

📝 Create and Manage Blog Posts

📂 Category Management

🔍 Search Posts by Title, Content, or Category

📄 Pagination Support

🔗 Eloquent Relationships

📊 Dashboard Statistics

🎨 Modern Bootstrap 5 User Interface

📱 Responsive Design

⚡ Laravel 12 Implementation

🛠 Clean MVC Architecture

📦 Composer Package Integration


## Technologies Used

* Laravel 12
* PHP 8.2+
* MySQL
* Bootstrap 5
* HTML5
* CSS3
* Laravel Eloquent ORM
* Laravel Pagination
* Composer
* Laravel Codebase MCP (mateffy/laravel-codebase-mcp)



## Project Highlights

* Integration of Laravel Codebase MCP Package
* Category and Post Relationship Management
* Search Functionality Across Multiple Fields
* Pagination with Bootstrap Styling
* Dashboard Statistics Cards
* Responsive User Interface
* Clean MVC Architecture
* Eloquent ORM Relationships
* Form Validation
* Professional CRUD Implementation
* Blog Post Management System
* Category-Based Post Organization



## Application Flow

1. User opens the Blog Dashboard.
2. Dashboard displays total posts and categories.
3. User creates a new post.
4. User selects a category and enters post details.
5. Post is stored in the database.
6. User can view all posts in a responsive table.
7. User can search posts by title, content, or category.
8. Results are displayed with pagination.
9. Users can navigate between pages.
10. Dashboard statistics are updated automatically.




## Requirements

- PHP 8.2+
- Composer
- MySQL
- Laravel 12
- Node.js (optional for frontend assets)


---



## Installation Steps


---


## STEP 1: Create Laravel 12 Project

### Open terminal / CMD and run:

```
composer create-project laravel/laravel PHP_Laravel12_Codebase_Mcp

```

### Go inside project:

```
cd PHP_Laravel12_Codebase_Mcp

```

#### Explanation:

Creates a fresh Laravel 12 application with all required dependencies.

This serves as the base project for implementing the Laravel Codebase MCP package.




## STEP 2: Database Setup 

### Update database details:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel12_codebase_mcp
DB_USERNAME=root
DB_PASSWORD=

```

### Create database in MySQL / phpMyAdmin:

```
Database name: laravel12_codebase_mcp


```



#### Explanation:

Configures the MySQL database connection through the .env file.

The database stores categories and posts used in the application.




## STEP 3: Install MCP Package

### Run:

```
composer require mateffy/laravel-codebase-mcp --dev

```

#### Explanation:

Installs the Laravel Codebase MCP package using Composer.

This package enables AI-powered codebase introspection for Laravel projects.




## STEP 4: Create Model + Migration

### Run:

```
php artisan make:model Category -m

php artisan make:model Post -m

```

### database/migrations/create_categories_table.php

```
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};

```


### database/migrations/create_posts_table.php

```
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('category_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('title');

            $table->text('content');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};

```



### Create database only:

```
php artisan migrate

```


### app/Models/Category.php

```
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name'
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}

```


### app/Models/Post.php

```
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'content'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

```


#### Explanation:

Creates database tables and Eloquent models for categories and posts.

Defines relationships between categories and posts using Laravel ORM.





## STEP 5: Create Controller

### Run:

```
php artisan make:controller PostController --resource

```

### app/Http/Controllers/PostController.php

```
<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::with('category')

            ->when($request->search, function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('content', 'like', '%' . $request->search . '%')
                    ->orWhereHas('category', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%');
                    });
            })

            ->oldest()
            ->paginate(3)
            ->withQueryString();

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'title' => 'required',
            'content' => 'required',
        ]);

        Post::create($request->all());

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post created successfully.');
    }
}

```


#### Explanation: 

Handles business logic for listing, searching, and storing posts.

Connects models with Blade views and manages user requests.





## STEP 6: Add Routes

### routes/web.php

```
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return redirect()->route('posts.index');
});

Route::resource('posts', PostController::class);

```

#### Explanation: 

Defines application URLs and maps them to controller actions.

Provides access to post listing, creation, and storage features.




## STEP 7: Create View Folder and Blade Files

### Run:

```
mkdir resources/views/posts

```


### resources/views/posts/index.blade.php


``` 
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Codebase MCP - Blog Management</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f7fc;
        }

        .navbar-custom {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
        }

        .card-custom {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .table thead {
            background: #4f46e5;
            color: white;
        }

        .page-title {
            font-weight: 700;
        }

        .badge-category {
            background: #e0e7ff;
            color: #4338ca;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 13px;
        }

        .stats-card {
            border-radius: 15px;
            color: white;
            padding: 20px;
        }

        .bg-posts {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
        }

        .bg-categories {
            background: linear-gradient(135deg, #16a34a, #15803d);
        }

        .pagination {
            justify-content: center;
        }

        .pagination .page-item .page-link {
            border-radius: 8px;
            margin: 0 3px;
            color: #4f46e5;
        }

        .pagination .page-item.active .page-link {
            background: #4f46e5;
            border-color: #4f46e5;
            color: #fff;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-dark navbar-custom shadow">
        <div class="container">
            <a class="navbar-brand fw-bold">🚀 Laravel Codebase MCP</a>
        </div>
    </nav>

    <div class="container py-5">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="page-title">Blog Management Dashboard</h2>
                <p class="text-muted">Laravel 12 + MCP Demo</p>
            </div>

            <a href="{{ route('posts.create') }}" class="btn btn-primary">
                + Create Post
            </a>
        </div>

        <!-- Stats -->
        <div class="row mb-4">

            <div class="col-md-6">
                <div class="stats-card bg-posts">
                    <h5>Total Posts</h5>
                    <h2>{{ $posts->total() }}</h2>
                </div>
            </div>

            <div class="col-md-6">
                <div class="stats-card bg-categories">
                    <h5>Total Categories</h5>
                    <h2>{{ \App\Models\Category::count() }}</h2>
                </div>
            </div>

        </div>

        <!-- 🔍 SEARCH BOX -->
        <div class="card card-custom mb-4">
            <div class="card-body">

                <form method="GET" action="{{ route('posts.index') }}">

                    <div class="row">

                        <div class="col-md-10">
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                                placeholder="Search by title, content or category...">
                        </div>

                        <div class="col-md-2">
                            <button class="btn btn-primary w-100">
                                Search
                            </button>
                        </div>

                    </div>

                </form>

            </div>
        </div>

        <!-- TABLE -->
        <div class="card card-custom">

            <div class="card-header bg-white py-3">
                <h5>📚 Posts List</h5>
            </div>

            <div class="card-body">

                <table class="table table-hover align-middle">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Title</th>
                            <th>Content</th>
                            <th>Date</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($posts as $post)

                            <tr>
                                <td>{{ $post->id }}</td>

                                <td>
                                    <span class="badge-category">
                                        {{ $post->category->name }}
                                    </span>
                                </td>

                                <td>{{ $post->title }}</td>

                                <td>{{ Str::limit($post->content, 80) }}</td>

                                <td>{{ $post->created_at->format('d M Y') }}</td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    No Posts Found
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

                <!-- 🔢 NUMBER ONLY PAGINATION -->
                <div class="mt-4">
                    {{ $posts->onEachSide(0)->links('pagination::bootstrap-5') }}
                </div>

            </div>

        </div>

    </div>

</body>

</html>

```


### resources/views/posts/create.blade.php
   
```
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f7fc;
        }

        .form-card {
            max-width: 800px;
            margin: 50px auto;
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, .08);
        }

        .card-header {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
            font-weight: 600;
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="card form-card">

            <div class="card-header py-3">
                Create New Post
            </div>

            <div class="card-body">

                <form method="POST" action="{{ route('posts.store') }}">

                    @csrf

                    <div class="mb-3">
                        <label class="form-label">
                            Category
                        </label>

                        <select name="category_id" class="form-select">

                            @foreach($categories as $category)

                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>

                            @endforeach

                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Post Title
                        </label>

                        <input type="text" name="title" class="form-control" placeholder="Enter Post Title">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Content
                        </label>

                        <textarea name="content" rows="6" class="form-control"
                            placeholder="Enter Post Content"></textarea>
                    </div>

                    <div class="d-flex gap-2">

                        <a href="{{ route('posts.index') }}" class="btn btn-secondary">
                            Back
                        </a>

                        <button type="submit" class="btn btn-success">
                            Save Post
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</body>

</html>

```




#### Explanation: 

Creates the user interface using Laravel Blade templates and Bootstrap 5.

Provides responsive pages for managing and viewing blog posts.




## STEP 8: Run the Application  

### Start dev server:

```
php artisan serve

```


### Open in browser:

```
http://127.0.0.1:8000/posts 

```

#### Explanation:

Starts the Laravel development server for local testing.

Allows users to access the application through a web browser.



## Expected Output:


### Posts Overview Dashboard 


<img width="1894" height="964" alt="Screenshot 2026-06-19 122552" src="https://github.com/user-attachments/assets/314664d5-6c95-4078-914c-2780dcd8d78d" />


### Post Creation Form


<img width="1911" height="952" alt="Screenshot 2026-06-19 123522" src="https://github.com/user-attachments/assets/45bbee70-6281-4101-83e1-c2d3f745d66b" />


### Advanced Search Functionality


<img width="1904" height="953" alt="Screenshot 2026-06-19 123649" src="https://github.com/user-attachments/assets/107ac352-4af6-421c-a74e-248d7fa67470" />

<img width="1908" height="937" alt="Screenshot 2026-06-19 123706" src="https://github.com/user-attachments/assets/ca011278-2cac-41b9-bec6-dce07aeebd51" />

<img width="1910" height="953" alt="Screenshot 2026-06-19 123732" src="https://github.com/user-attachments/assets/89ac4035-9147-4a75-a56e-6f352517977d" />


### Pagination Management


<img width="1878" height="959" alt="Screenshot 2026-06-19 123818" src="https://github.com/user-attachments/assets/e449e01d-ba84-4bf4-96bd-2fd31b899696" />





---



## Project Folder Structure

```
PHP_Laravel12_Codebase_Mcp
│
├── app
│   ├── Models
│   │   ├── Category.php
│   │   └── Post.php
│   │
│   └── Http
│       └── Controllers
│           └── PostController.php
│
├── database
│   └── migrations
│       ├── 0001_01_01_000000_create_users_table.php
│       ├── 0001_01_01_000001_create_cache_table.php
│       ├── 0001_01_01_000002_create_jobs_table.php
│       ├── 2026_06_19_000001_create_categories_table.php
│       └── 2026_06_19_000002_create_posts_table.php
│
├── resources
│   └── views
│       └── posts
│           ├── index.blade.php
│           └── create.blade.php
│
├── routes
│   └── web.php
│
├── composer.json
├── package.json
├── .env
└── README.md
```
