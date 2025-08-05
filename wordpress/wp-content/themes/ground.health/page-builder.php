<?php
/*
Template Name: Page Builder
*/

get_header();
?>

<div id="page-builder-content">

<?php
if( have_rows('page_builder_sections') ):

    while( have_rows('page_builder_sections') ): the_row();

        // Dynamically load the template part based on layout name
        get_template_part('template-parts/' . get_row_layout());

    endwhile;

else:
    echo '<p>No sections found. Please add some content in the Page Builder.</p>';
endif;
?>

</div>

<?php get_footer(); ?>
