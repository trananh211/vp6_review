<div class="cs-review-all" style="padding-top: 20px;">
	<?php 
		$reviews = [
			'mug' => '19963',
			'fleece-blanket' => '18333',
			'canvas' => '20596',
			'mask' => '56561'
		];
		$terms = get_the_terms( $post->cat_ID , 'product_cat' );
		$id = 'all';
		if (sizeof($terms) > 0)
		{
			foreach ($terms as $item)
			{
				$cat_name = $item->slug;
				if (array_key_exists($cat_name, $reviews))
				{
					$id = $reviews[$cat_name];
					break;
				}
			}
		}
		if ($id != 'all')
		{
			echo do_shortcode( '[jgm-review-widget id='.$id.']' );
		} else {
			echo do_shortcode( '[jgm-all-reviews]' );
		}
	?>
</div>