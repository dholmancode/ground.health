<?php
get_header();
?>
<main class="flex h-[100vh] flex-col items-center justify-center text-white">
  <div class="max-w-lg text-center">
    <h1 class="text-6xl font-extrabold mb-4 text-brand-accent">404</h1>
    <h2 class="text-2xl font-bold mb-2">Page Not Found</h2>
    <p class="mb-6 text-gray-400">Sorry, the page you’re looking for doesn’t exist or has been moved.</p>
    <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-block px-6 py-3 rounded bg-brand-accent text-white font-semibold hover:bg-brand-teal transition">Go Home</a>
  </div>
</main>
<?php get_footer(); ?>