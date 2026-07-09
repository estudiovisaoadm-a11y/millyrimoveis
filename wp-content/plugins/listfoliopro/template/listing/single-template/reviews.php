<?php	
	 if ( ! defined( 'ABSPATH' ) ) exit; 
	
?>
<div class=" border-bottom pb-15 mb-3 toptitle d-none"><i class="<?php echo esc_html($saved_icon); ?>"></i> <?php esc_html_e('Reviews for', 'listfoliopro'); ?> <?php echo get_the_title($listingid); ?></div>

	<div class="row mx-0 ">
		<div class="col-md-6">
			
				<?php
					$user_id=$id;
					$total_review_point=0;
					$one_review_total=0;
					$two_review_total=0;
					$three_review_total=0;
					$four_review_total=0;
					$five_review_total=0;
					$post_type='listfoliopro_review';
					$sql= $wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_type ='listfoliopro_review'  and post_author='%s' 	and post_status='publish' ORDER BY ID DESC",$user_id);
					$reg_page_user='';
					$iv_redirect_user = get_option( '_ep_ivproperty_profile_public_page');
					if($iv_redirect_user!='defult'){
						$reg_page_user= get_permalink( $iv_redirect_user) ;
					}
					$listing_author_link=get_option('listing_author_link');
					if($listing_author_link==""){$listing_author_link='author';}
					$author_reviews = $wpdb->get_results($sql);
					$total_reviews=count($author_reviews);
					if($total_reviews>0){
						foreach ( $author_reviews as $review )
						{
							$review_val=(int)get_post_meta($review->ID,'review_value',true);
							$review_val2=(float)get_post_meta($review->ID,'review_value',true);
							$total_review_point=$total_review_point+ $review_val2;
							if($review_val=='1'){
								$one_review_total=$one_review_total+1;
							}
							if($review_val=='2'){
								$two_review_total=$two_review_total+1;
							}
							if($review_val=='3'){
								$three_review_total=$three_review_total+1;
							}
							if($review_val=='4'){
								$four_review_total=$four_review_total+1;
							}
							if($review_val=='5'){
								$five_review_total=$five_review_total+1;
							}
						}
					}
					$avg_review=0;
					if($total_review_point>0){
						$avg_review= (float)$total_review_point/(float)$total_reviews;
					}
					$saved_listing_avg_rating=get_post_meta($id,'review',true);
					if($avg_review!=$saved_listing_avg_rating){
						update_post_meta($id,'review',$avg_review);
					}
				?>
				<h3 class="toptitle m-0 py-2"><?php  esc_html_e('Average rating', 'listfoliopro'); ?></h3>
				<h3 class="toptitle bold padding-bottom-7"><?php echo number_format($avg_review, 1, '.', ''); ?> / <?php  esc_html_e('5', 'listfoliopro'); ?></h3>
				<?php
				if($avg_review >=.75 ){ ?><i class="fas fa-star off-white"></i><?php }elseif($avg_review >=.1){ ?><i class="fas fa-star-half-alt  half-off-white"></i> <?php }else{?> <i class="far fa-star off-white"></i><?php } ?>
				<?php
				if($avg_review >=1.75 ){ ?><i class="fas fa-star off-white"></i><?php }elseif($avg_review >=1.1){ ?><i class="fas fa-star-half-alt  half-off-white"></i> <?php }else{?> <i class="far fa-star off-white"></i><?php } ?>
				<?php
				if($avg_review >=2.75 ){ ?><i class="fas fa-star off-white"></i><?php }elseif($avg_review >=2.1){ ?><i class="fas fa-star-half-alt  half-off-white"></i> <?php }else{?> <i class="far fa-star off-white"></i><?php } ?>
				<?php
					if($avg_review >=3.75 ){ ?><i class="fas fa-star off-white"></i><?php }elseif($avg_review >=3.1){ ?>
				<i class="fas fa-star-half-alt  half-off-white"></i> <?php }else{?> <i class="far fa-star off-white"></i><?php } ?>
				<?php
				if($avg_review >=4.75 ){ ?><i class="fas fa-star off-white"></i><?php }elseif($avg_review >=4.1){ ?><i class="fas fa-star-half-alt  half-off-white"></i> <?php }else{?> <i class="far fa-star off-white"></i><?php } ?>
				
		</div>



		<div class="col-md-6">
			<h3 class="m-0 py-2 toptitle"><?php  esc_html_e('Rating breakdown', 'listfoliopro'); ?> </h3>
			
			<div class="d-flex review_rating_container">
				<div class="review_rating_star">
					<?php  esc_html_e('5', 'listfoliopro'); ?> <i class="fa fa-star 3x blue-star"></i>
				</div>
				<div class="progress mt-2 review_rating_bar">
					<?php $bar_value=0; if($total_reviews>0){
						$bar_value=($five_review_total/$total_reviews)*100;
					} ?>
					<div class="progress-bar bg-primary" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="5" style="width:<?php echo esc_html($bar_value);?>%">
					</div>
				</div>
				<div class="ml-1" ><?php echo esc_html($five_review_total);?></div>
			</div>
			<div class="d-flex review_rating_container">
				<div class="review_rating_star">
					<?php  esc_html_e('4', 'listfoliopro'); ?> <i class="fa fa-star 3x blue-star"></i>
				</div>
				<div class="progress mt-2 review_rating_bar">
					<?php $bar_value=0;
						if($total_reviews>0){
							$bar_value=($four_review_total/$total_reviews)*100;
						}
					?>
					<div class="progress-bar bg-success" role="progressbar" aria-valuenow="4" aria-valuemin="0" aria-valuemax="5" style="width: <?php echo esc_html($bar_value);?>%"></div>
				</div>
				<div class="ml-1"><?php echo esc_html($four_review_total);?></div>
			</div>
            <div class="d-flex review_rating_container">
				<div class="review_rating_star ">
					<?php  esc_html_e('3', 'listfoliopro'); ?> <i class="fa fa-star 3x blue-star"></i>
				</div>
				<div class="progress mt-2 review_rating_bar">
					<?php $bar_value=0;
						if($total_reviews>0){
							$bar_value=($three_review_total/$total_reviews)*100;
						}
					?>
					<div class="progress-bar bg-info" role="progressbar" aria-valuenow="4" aria-valuemin="0" aria-valuemax="5" style="width: <?php echo esc_html($bar_value);?>%"></div>
				</div>
				<div class="ml-1"><?php echo esc_html($three_review_total);?></div>
			</div>
            <div class="d-flex review_rating_container">
				<div class="review_rating_star">
					<?php  esc_html_e('2', 'listfoliopro'); ?> <i class="fa fa-star 3x blue-star"></i>
				</div>
				<div class="progress mt-2 review_rating_bar">
					<?php $bar_value=0;
						if($total_reviews>0){
							$bar_value=($two_review_total/$total_reviews)*100;
						}
					?>
					<div class="progress bg-warning" role="progressbar" aria-valuenow="4" aria-valuemin="0" aria-valuemax="5" style="width: <?php echo esc_html($bar_value);?>%"></div>
					
					
				</div>
				
				<div class="ml-1"><?php echo esc_html($two_review_total);?></div>
			</div>
            <div class="d-flex review_rating_container">
				<div class="review_rating_star">
					<?php  esc_html_e('1', 'listfoliopro'); ?> <i class="fa fa-star 3x blue-star"></i>
				</div>
				<div class="progress mt-2 review_rating_bar">
					<?php $bar_value=0;
						if($total_reviews>0){
							$bar_value=($one_review_total/$total_reviews)*100;
						}
					?>
					<div class="progress-bar bg-danger" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="5" style="width: <?php echo esc_html($bar_value);?>%"></div>
				</div>
				<div class="ml-1"><?php echo esc_html($one_review_total);?></div>
			</div>
		</div>
	</div>
	<div class="agent-info__separator my-5 mx-0"></div>
	<?php
        foreach ( $author_reviews as $review )
		{
			$user_review_val=0;
			$review_submitter=get_post_meta($review->ID, 'review_submitter', true);
			$user_review_val=get_post_meta($review->ID, 'review_value', true);
		?>
		<div class="listfoliopro-single-review-item" >
            <div class="review-image mt-4">
	            <?php
	            $user_image_path=get_user_meta($review_submitter, 'iv_profile_pic_url',true);
	            if($user_image_path==''){
		            $user_image_path=listfoliopro_ep_URLPATH.'assets/images/Blank-Profile.jpg';
	            }
	            ?>

                <img src="<?php echo esc_url($user_image_path);?>" alt="image">
            </div>

            <div class="review-details">
                <div class="user-review-value">
                    <i class="far fa-star fa-sm  <?php echo ($user_review_val>0?'fas fa-star off-white': 'far fa-star off-white');?>"></i>
                    <i class="far fa-star fa-sm <?php echo ($user_review_val>1?'fas fa-star off-white': 'far fa-star off-white');?>"></i>
                    <i class="far fa-star fa-sm <?php echo ($user_review_val>2?'fas fa-star off-white': 'far fa-star off-white');?>"></i>
                    <i class="far fa-star fa-sm <?php echo ($user_review_val>3?'fas fa-star off-white': 'far fa-star off-white');?>"></i>
                    <i class="far fa-star fa-sm <?php echo ($user_review_val>4?'fas fa-star off-white': 'far fa-star off-white');?>"></i>
                </div>



	            <?php
	            $userreview = get_user_by( 'id', $review_submitter );
	            $name_display=get_user_meta($review_submitter,'first_name',true).' '.get_user_meta($review_submitter,'last_name',true);
	            $profile_public=get_option('listfoliopro_profile_public_page');
	            $reg_page_u= get_permalink( $profile_public);
	            $reg_page_u= $reg_page_u.'?&id='.$review_submitter;
	            ?>

                <div class="review-name">
		            <?php echo (trim($name_display)!=""? $name_display : $userreview->display_name );?>
                </div>

                <div class="review-date">
                    <?php echo gmdate('M d, Y',strtotime($review->post_date)); ?>
                </div>

                <div class=""><h6><?php echo esc_html($review->post_title); ?></h6></div>

                <div class="review-text"><?php echo esc_html($review->post_content); ?></div>
            </div>

		</div>
		<?php
		}
	?>


	<div class="row mt-5" >
		<div class="col-md-12">
            <form id="iv_review_form" name="iv_review_form" class="" role="form" onsubmit="return false;">
				<div class="row">
					<div class="col-sm-12">
						<h3 ><?php  esc_html_e('Rate us and Write a Review', 'listfoliopro'); ?></h3>
						<p class="review-form-subtitle"><?php  esc_html_e('Your email address will not be published. Required fields are marked *', 'listfoliopro'); ?></p>
					</div>
				</div>

                <div class="form-rating">
	                <?php  esc_html_e('Your Rating*', 'listfoliopro'); ?>
                    <div></div>
                    <div class="stars">
                        <input class="star star-5" id="star-5" type="radio" name="star" value="5"/>
                        <label class="star star-5 " for="star-5"></label>
                        <input class="star star-4" id="star-4" type="radio" name="star" value="4"/>
                        <label class="star star-4" for="star-4"></label>
                        <input class="star star-3" id="star-3" type="radio" name="star" value="3"/>
                        <label class="star star-3" for="star-3"></label>
                        <input class="star star-2" id="star-2" type="radio" name="star" value="2" />
                        <label class="star star-2" for="star-2"></label>
                        <input class="star star-1" id="star-1" type="radio" name="star" value="1" />
                        <label class="star star-1" for="star-1"></label>
                    </div>
                </div>

                <div class="review-subject-and-comment">
                    <div class="row form-group">
                        <div class="col-12 col-md-3 text-description d-none">
			                <?php  esc_html_e('Subject', 'listfoliopro'); ?>
                        </div>
                        <div class="col-12">
                            <input type="text" class="form-control review_sub" name="review_subject"   value="" placeholder="<?php  esc_html_e('Enter review title*', 'listfoliopro'); ?>">
                        </div>
                    </div>

                    <div class="row form-group my-0">
                        <div class="col-md-3 text-description d-none">
			                <?php  esc_html_e('Comments', 'listfoliopro'); ?>
                        </div>
                        <div class="col-12">
                            <textarea class="form-control" cols="50"  name="review_comment" id="review_comment" placeholder="<?php  esc_html_e('Enter review comments*', 'listfoliopro'); ?>" rows="4" ></textarea>
                        </div>
                    </div>

                    <div class="row form-group mt-2">
                        <div class="col-12">
                            <div id="rmessage"></div>
                        </div>
                        <div class="col-12  text-right">
                            <button type="button" class="listfoliopro-button mt-3" onclick="return listfoliopro_iv_submit_review();" ><?php  esc_html_e('Submit Now', 'listfoliopro'); ?></button>
                            <input type="hidden" name="listingid" id="listingid" value="<?php echo esc_html($listingid); ?>">
                        </div>
                    </div>
                </div>
			</form>
		</div>
	</div>
