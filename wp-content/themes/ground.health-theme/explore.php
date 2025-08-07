<?php
/**
 * Template Name: Explore Page
 */
get_header();

$hero_image = get_field('hero_image');
$intro_text = get_field('intro_text');
?>

<main class="bg-charcoal min-h-screen text-peach font-body" x-data="explorePage()" x-init="init()">

  <!-- Hero Section -->
  <section class="relative w-full h-96 bg-cover bg-center flex items-center justify-center" style="background-image: url('<?php echo esc_url($hero_image['url']); ?>');">
    <div class="bg-charcoal bg-opacity-60 p-8 rounded-xl max-w-2xl text-center">
      <h1 class="text-4xl md:text-5xl font-heading text-white mb-4">Explore the Library</h1>
      <?php if ($intro_text): ?>
        <p class="text-lg md:text-xl text-peach"><?php echo esc_html($intro_text); ?></p>
      <?php endif; ?>
    </div>
  </section>

  <!-- Filters -->
  <section class="px-6 md:px-12 py-10 bg-charcoal border-b border-peach/30">
    <div class="max-w-5xl mx-auto flex flex-col md:flex-row md:items-center md:justify-between gap-6">
      <!-- Tag Filters -->
      <div class="flex flex-wrap gap-4">
        <template x-for="tag in allTags" :key="tag">
          <button
            @click="toggleTag(tag)"
            :class="{'bg-peach text-charcoal': isTagActive(tag), 'bg-charcoal border border-peach text-peach': !isTagActive(tag)}"
            class="px-4 py-2 rounded-full border cursor-pointer transition"
            x-text="tag"
          ></button>
        </template>
      </div>

      <!-- Search Bar -->
        <input
        type="search"
        placeholder="Search resources..."
        class="..."
        x-model.debounce.300="searchTerm"
        @input.debounce.300="filterItems"
        />

    </div>
  </section>

  <!-- Resource Grid -->
  <section class="px-6 md:px-12 py-12">
    <div class="max-w-6xl mx-auto grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
      <template x-for="item in pagedItems()" :key="item.link">
        <article
          class="bg-charcoal border border-peach rounded-xl shadow hover:shadow-lg transition p-4 flex flex-col justify-between"
        >
          <div class="mb-4" x-show="item.image">
            <img :src="item.image" alt="" class="w-full h-48 object-cover rounded-md" />
          </div>
          <div class="flex flex-col gap-2">
            <span class="text-sm text-gold uppercase" x-text="formatDate(item.pubDate)"></span>
            <h2 class="text-xl font-heading" x-text="item.title"></h2>
            <p class="text-sm" x-text="item.excerpt"></p>
          </div>
          <a
            :href="item.link"
            target="_blank"
            class="text-peach hover:underline mt-4 text-sm font-semibold"
            >View Resource →</a
          >
          <div class="mt-2 flex gap-1 flex-wrap">
            <template x-for="tag in item.tags" :key="tag">
              <span class="bg-gold text-charcoal px-2 py-0.5 rounded-full text-xs" x-text="tag"></span>
            </template>
          </div>
        </article>
      </template>
    </div>

    <!-- Pagination Controls -->
    <div class="mt-8 flex justify-center gap-4">
      <button @click="prevPage()" :disabled="page === 1" class="btn px-4 py-2 rounded bg-peach text-charcoal disabled:opacity-50 disabled:cursor-not-allowed">Previous</button>
      <span class="self-center text-peach" x-text="page"></span>
      <button @click="nextPage()" :disabled="page >= maxPage()" class="btn px-4 py-2 rounded bg-peach text-charcoal disabled:opacity-50 disabled:cursor-not-allowed">Next</button>
    </div>

    <!-- Loading Indicator -->
    <div x-show="loading" class="text-center text-peach mt-6">Loading resources...</div>
  </section>
</main>

<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
function explorePage() {
  return {
    items: [],
    filteredItems: [],
    allTags: [],
    activeTags: [],
    searchTerm: '',
    page: 1,
    perPage: 3,
    totalPages: 10,
    loading: false,

    init() {
      this.syncFromURL(); // Parse filters from URL on load
      this.loadPage(1);
    },

    async loadPage(page) {
      this.loading = true;
      const res = await fetch(`/wp-json/custom/v1/resources?page=${page}&per_page=${this.perPage}`);
      const data = await res.json();

      if (page === 1) {
        this.items = data.items;
      } else {
        this.items = this.items.concat(data.items);
      }

      this.totalPages = data.pagination.total_pages;

      // Collect unique tags
      const tagSet = new Set();
      this.items.forEach(item => item.tags.forEach(t => tagSet.add(t)));
      this.allTags = Array.from(tagSet).sort();

      // Apply filters
      this.filterItems();

      this.loading = false;
    },

    filterItems() {
      const term = this.searchTerm.toLowerCase();

      this.filteredItems = this.items.filter(item => {
        const matchesSearch = item.title.toLowerCase().includes(term) || item.excerpt.toLowerCase().includes(term);
        const matchesTags = this.activeTags.length === 0 || this.activeTags.every(t => item.tags.includes(t));
        return matchesSearch && matchesTags;
      });

      this.page = 1;
      this.updateURL();
    },

    toggleTag(tag) {
      if (this.activeTags.includes(tag)) {
        this.activeTags = this.activeTags.filter(t => t !== tag);
      } else {
        this.activeTags.push(tag);
      }
      this.filterItems();
    },

    isTagActive(tag) {
      return this.activeTags.includes(tag);
    },

    pagedItems() {
      const start = (this.page - 1) * this.perPage;
      return this.filteredItems.slice(start, start + this.perPage);
    },

    maxPage() {
      return Math.ceil(this.filteredItems.length / this.perPage) || 1;
    },

    async nextPage() {
      if (this.page < this.maxPage()) {
        this.page++;
      }
    },

    prevPage() {
      if (this.page > 1) this.page--;
    },

    formatDate(dateStr) {
      const options = { year: 'numeric', month: 'short', day: 'numeric' };
      return new Date(dateStr).toLocaleDateString(undefined, options);
    },

    // ✅ Update browser URL with filters
    updateURL() {
      const params = new URLSearchParams();
      if (this.searchTerm) params.set('search', this.searchTerm);
      if (this.activeTags.length > 0) params.set('tags', this.activeTags.join(','));
      const newUrl = `${window.location.pathname}?${params.toString()}`;
      window.history.replaceState({}, '', newUrl);
    },

    // ✅ Pull filters from URL on load
    syncFromURL() {
      const params = new URLSearchParams(window.location.search);
      const tags = params.get('tags');
      const search = params.get('search');

      if (tags) this.activeTags = tags.split(',');
      if (search) this.searchTerm = search;
    },
  }
}

</script>

<?php get_footer(); ?>
