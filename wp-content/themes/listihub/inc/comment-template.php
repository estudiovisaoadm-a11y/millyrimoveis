<?php

function listihub_comment_form($listihub_comment_form_fields){

	$listihub_comment_form_fields['author'] = '
        <div class="row comment-form-wrap">
        <div class="col-lg-6">
            <div class="form-group ep-comment-input">
                <input type="text" name="author" id="name-cmt" placeholder="'.esc_attr__('Name*', 'listihub').'">
                <i class="far fa-user"></i>
            </div>
        </div>
    ';

	$listihub_comment_form_fields['email'] =  '
        <div class="col-lg-6">
            <div class="form-group ep-comment-input">
                <input type="email" name="email" id="email-cmt" placeholder="'.esc_attr__('Email*', 'listihub').'">
                <i class="far fa-envelope"></i>
            </div>
        </div>
    ';

	$listihub_comment_form_fields['url'] = '
        <div class="col-lg-12">
            <div class="form-group ep-comment-input">
                <input type="text" name="url" id="website-cmt"  placeholder="'.esc_attr__('Website', 'listihub').'">
                <i class="fas fa-globe-europe"></i>
            </div>
        </div>
        </div>  
    ';

	return $listihub_comment_form_fields;
}

add_filter('comment_form_default_fields', 'listihub_comment_form');

function listihub_comment_default_form($default_form){

	$default_form['comment_field'] = '
        <div class="row">
            <div class="col-sm-12">
                <div class="comment-message ep-comment-input">
                    <textarea name="comment" id="message-cmt" rows="5" required="required"  placeholder="'.esc_attr__('Your Comment*', 'listihub').'"></textarea>
                    <i class="fas fa-pencil-alt"></i>
                </div>
            </div>
        </div>
    ';

	$default_form['submit_button'] = '
        <button type="submit" class="ep-button">'.esc_html__('Post Comment', 'listihub').'<svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7 17L17 7M17 7H7M17 7V17" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg></button>
    ';

	$default_form['comment_notes_before'] = esc_html__('All fields marked with an asterisk (*) are required', 'listihub' );
	$default_form['title_reply'] = esc_html__('Leave A Comment', 'listihub');
	$default_form['title_reply_before'] = '<h4 class="comments-heading">';
	$default_form['title_reply_after'] = '</h4>';

	return $default_form;
}

add_filter('comment_form_defaults', 'listihub_comment_default_form');


function listihub_move_comment_field_to_bottom( $fields ) {
	$comment_field = $fields['comment'];
	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;
	return $fields;
}

add_filter( 'comment_form_fields', 'listihub_move_comment_field_to_bottom' );