process.env.DISABLE_NOTIFIER = true;

const elixir = require('laravel-elixir');

elixir(function(mix) {
    mix.sass('main.scss');
});