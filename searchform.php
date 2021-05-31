<form role="search" method="get" class="search-form pr flex" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <input type="search" class="search-field" placeholder="<?php echo esc_attr__( 'Search products...', 'koganic' ); ?>" value="<?php echo the_search_query(); ?>" name="s" />
    <button type="submit" class="search-submit"><i class="sl icon-search"></i></button>
</form>
