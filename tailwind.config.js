import forms from '@tailwindcss/forms';

export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './app/Filament/**/*.php',
  ],
  theme: {
    extend: {},
  },
  plugins: [forms],
};
