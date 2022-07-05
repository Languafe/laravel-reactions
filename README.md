# languafe/laravel-reactions

Day of Coolness project July 5th 2022 by Erik Langhaug.

"Creating a Laravel package."


# Usage

In order to make use of this package, you need an eloquent model for which you
wish to enable "reactions" (which are just represented as strings and can be
anything you like).

By default, only authenticated users will be able to add reactions, and each
user can only add a specific reaction once (clicking again will delete that
reaction for the user).

## Installation

Add the following to composer.json

```
"require": {
  ...
  "languafe/laravel-reactions": "dev-main",
  ...
}
...
"repositories": [
      {
          "type": "vcs",
          "url": "git@github.com:Languafe/laravel-reactions.git"
      }
  ],
...
```

Install the package with `composer update languafe/laravel-reactions` after doing this.

### Publishing resources

#### Configuration

To publish the config file (currently used to set which reactions are allowed) do:

`php artisan vendor:publish --tag=reactions-config`

Edit the config/reactions.php file to control which reactions are allowed.

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

If you are signed in, you should be able to click each reaction.
