<form role="search" method="get" class="form--inverse search-form" action="<?= esc_url(home_url('/')); ?>" novalidate="novalidate">
  	<div class="form-group form-group--compact form-group--search">
		<input type="search" name="s" value="<?= get_search_query(); ?>" class="form-item search-field" placeholder="<?php esc_attr_e('Search', 'agora-folio'); ?>" aria-label="<?php esc_attr_e('Search for:', 'agora-folio'); ?>" required>
    	<button type="submit" class="btn btn--secondary search-submit" title="<?php esc_attr_e('Search', 'agora-folio'); ?>" aria-label="<?php esc_attr_e('Search', 'agora-folio'); ?>"><span class="icon icon--search-full icon--small" aria-hidden="true"></span></button>
	</div>
</form>
