# Create a crud for model in some steps

[![Latest Version on Packagist](https://img.shields.io/packagist/v/dlogon/quick-crud-for-laravel.svg?style=flat-square)](https://packagist.org/packages/dlogon/quick-crud-for-laravel)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/dlogon/quick-crud-for-laravel/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/dlogon/quick-crud-for-laravel/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/dlogon/quick-crud-for-laravel/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/dlogon/quick-crud-for-laravel/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/dlogon/quick-crud-for-laravel.svg?style=flat-square)](https://packagist.org/packages/dlogon/quick-crud-for-laravel)

Create a Crud for model in some steps

### Requirements

This package uses TailwindCSS (https://tailwindcss.com/) for styling. It uses some of the base laravel breeze/jetstream components and styles.

## Installation

You can install the package via composer:

```bash
composer require dlogon/quick-crud-for-laravel
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="quick-crud-for-laravel-config"
```

This is the contents of the published config file:

```php
<?php

return [
    /*
    |--------------------------------------------------------------------------
    | models folder
    |--------------------------------------------------------------------------
    |
    |
    |
    */
    'models_folder' => [
        'App\\Models\\' => app_path('Models'),
    ],
    'route_file_name' => 'quickcrud.php',
];

```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="quick-crud-for-laravel-views"
```

## Usage

Once you have created your model and running the migrations, you can run the command

```bash
php artisan quickcrud:all <your-model-name>
```

This will create:

-A Controller named \<your model name\>Controller

-A view named index inside views/crudable/\<your model in lower case\>/index.blade.php

-A view named show inside views/crudable/\<your model in lower case\>/show.blade.php

-A route file named quickcrud.php

Then you should add the trait `Dlogon\QuickCrudForLaravel\Traits\NavigationUtils;`
to your model, for example:

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Dlogon\QuickCrudForLaravel\Traits\NavigationUtils;

class Blog extends Model
{
    use HasFactory;
    use NavigationUtils;
}
```

Then you should include the quickcrud.php file in your web.php route file, o copy the generated routes in web.php

```php
<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

include __DIR__.'/quickcrud.php';
```

With this steps, you are now able to navigate to yourhost/\<your model name in lower and plural>
and see the index view with a table with search, and buttons to do operations with your model

If your model is in another namespace than the default `App/Models/` you can pass a second argument with the namespace

```bash
php artisan quickcrud:all artisan quickcrud:all Test1 App\\Models\\deep\\

```

### Example:

We generate the Blog model with this migration

```php
public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("content");
            $table->timestamps();
        });
    }
```

Then we run the migrations, and we run

```bash
php artisan quickcrud:all Blog
```

this will create the next controller in the controller folder

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dlogon\TailwindAlerts\Facades\TailwindAlerts;
use Dlogon\QuickCrudForLaravel\Helpers\Search;
use App\Models\Blog;

class BlogController extends Controller
{
    public $tableFields = array (
  'id' => 'id',
  'name' => 'name',
  'content' => 'content',
  'created_at' => 'created_at',
  'updated_at' => 'updated_at',
);

    /*
    [
        "label" => "tablefieldName",
        'label' => ["type" => "related", "field" =>"relationName.fieldNameOfRelatedModel"],
        'label' => ["type"=>"money", "field"=>'moneyOrDecimalField']
    ]
    */

    public $searchFields = [
            "created_at" => [
            "type" => "singleDate", // search by date
            "label" => "Creation date",
        ],
        /*
        "fieldName" =>[
            "type" => "text" // search by text
            "placeholder" => "my search"
        ]

        "customer_id" => [
                "type" => "related", // search by related model
                "elements" => $allCustomers, //<- this will populate a select dropdown
                "modelDisplay" => "name",
                "label" => "Cliente", <--what show to
                "value" => "id" <-- what find to
            ]
        */
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($models = null)
    {
        $models = $models ?? Blog::orderBy("id")->paginate(10);
        $fields = $this->tableFields;
        $searchFields = $this->searchFields;
        return view(
            "crudable.blog.index",
            [
                "models" => $models,
                "fields" => $fields,
                "searchFields" => $searchFields
            ]
        );
    }

    public function search(Request $request)
    {
        $models = Blog::query();
        if ($request->has('q'))
            $models = Search::searchByQueryParams(new Blog, $request)->get();
        return $this->index($models);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $model
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        $fields = $this->tableFields;

        return view(
            "crudable.blog.show",
            [
                "model" => $blog,
                "fields" => $fields
            ]
        );
    }

        /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();
        TailwindAlerts::addBottomToastMessage("Deleted", TailwindAlerts::ERROR);
        return redirect()->route("blogs.index");
    }
}
```

and the index and show views.

### table fields

We have a `table` component inside the recent created index view, connected to the `$tablefields` controller variable.

We should pass an asoc array with the key as the label column displayed in the table component and the value as the column name in our database model.

##### Example:

```php
    ["Creation date" => "created_at"]
```

You can alternatively pass an array instead the database-model-column, if you do this,
you should pass the type and field structure.

```php
    ['label' => ["type" => "related|money", "field" =>"relationName.fieldNameOfRelatedModel|numericMoneyField"]],
```

If you set the type as related, you should put in field `relationName.fieldName` where fieldName is the column name in the related model

##### Example:

```php
['Post title' => ["type" => "related", "field" =>"post.title"]],
```

If you set the type as money, you should put the numeric field in the field key of array

##### Example:

```php
['Price' => ["type" => "money", "field" =>"price"]],
```

### search fields

By default the variable controller `$searchfields` has the created_at field for search, you can define the next 3 structures for a search field

#### Text

```php
    "fieldName" =>[
                "type" => "text"
                "placeholder" => "my search"
            ]
```

where

-   fieldName: is the column name in your model
-   type: the type of search defined as text
-   placeholder: What to display in the text input

#### Date

```php
    "fieldName" =>[
                "type" => "singleDate"
                "label" => "my date"
            ]
```

where

-   fieldName: is the datetime column name in your model
-   type: the type of date
-   label: is what the label show aside the input date

#### Related

This will show a dropdown for a seach of related models

```php
    "fieldName" => [
                    "type" => "related",
                    "elements" => $models,
                    "modelDisplay" => "name",
                    "label" => "Comments",
                    "value" => "id"
                ]

```

where

-   fieldName: the foreign key contained in your current model
-   type: the type of related
-   elements: the related models for a search, for example if you generate a Invoice quickcrud, and you want to search the invoices related to costumer, you should put here Customer::all()
-   modelDisplay: what field of the related model you want to display
-   label: is what the label show aside the input dropdown
-   value: the related column in the related model search for

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [Diego Lopez](https://github.com/dlogon)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
