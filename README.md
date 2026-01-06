# languafe/laravel-reactions

This package allows you to add reactions to eloquent models, and includes a
ready-to-use blade component that renders a reaction panel with clickable
buttons (requires authentication) and the count for each reaction.

Reactions are implemented as a polymorphic one-to-many relationship, and can be
added to any existing model by adding the `HasReactions` trait.

The package adds a HTTP POST endpoint at `/reactions`, which is used by the
reaction panel's UI in order to store reactions.

Created during "Day of Coolness" at Joubel on July 5th 2022 by Erik Langhaug
where my goal was to learn about creating Laravel packages.

# Usage

In order to make use of this package, you need an eloquent model for which you
wish to enable "reactions" (which are just represented as strings and can be
anything you like).

## Installation

Add the package as a composer dependency.

`composer require languafe/laravel-reactions`

Run included migration to create the `reactions` database table.

`php artisan migrate`

### Publishable items

> A "publishable" item from a Laravel package is something you can copy into the
project directory of your own Laravel application in order to override default
behavior provided by the package.

#### Configuration

To publish the config file (currently used to set which reactions are allowed) do:

`php artisan vendor:publish --tag=reactions-config`

Edit the config/reactions.php file to control which reactions are allowed.

```php
<?php // config/reactions.php
return [
    'allowed' => ['👍', '🙂', '👎', '🙁']
];
```

#### Overriding views

If you want to modify the views (currently just a single anonymous blade component):

`php artisan vendor:publish --tag=reactions-views`

(When you do this, then the blade file now found inside your resources/views/vendor/reactions folder will take precedence.)

## Add `HasReactions` trait to your eloquent model

Assuming you have a `Post` eloquent model.

(If you don't, create one with `php artisan make:model Post -a`)

```
class Post extends Model
{
  ...
  use HasReactions;
  ...
}
```

## Display the reaction panel

Add the anonymous blade component to any view. The value passed as the `:model`
prop is expected to have the `HasReactions` trait.

```
<x-reactions::panel :model="App\Models\Post::first()" />
```

You can also use the Livewire component:

```
<livewire:reactions:panel :model="App\Models\Post::first()" />
```

If you are signed in, you should be able to click each reaction.
