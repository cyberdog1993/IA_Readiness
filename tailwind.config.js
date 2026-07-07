import forms from '@tailwindcss/forms';

export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './app/Filament/**/*.php',
    './vendor/filament/**/*.blade.php',
    './vendor/filament/*/resources/views/**/*.blade.php',
    './storage/framework/views/*.php',
  ],
  theme: {
    extend: {},
  },
  plugins: [forms],
};
