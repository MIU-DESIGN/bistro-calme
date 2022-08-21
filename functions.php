<?php
/**
 * <title>タグを出力する
 */
add_theme_support('title-tag');

add_filter('document_title_separator',
'my_document_title_separator');
function my_document_title_separator($separator){
  $separator = '|';
  return $separator;
}

add_filter('document_title_parts',
'my_document_title_parts');
function my_document_title_parts($title){
  if(is_home()){
    unset($title['tagline']);
    $title['title'] = 'BISTRO CALMEはカジュアルワインバーよりなビストロです。';
  }
  return $title;
}

add_theme_support('post-thumbnails');

/**
 * カスタムメニュー機能を使用可能にする
 */
add_theme_support('menus');

/**
 * ページ内検索から固定ページを除外
 */
function SearchFilter($query) {
if ($query->is_search) {
 $query->set('post_type', 'post');
 }
 return $query;
}
add_filter('pre_get_posts','SearchFilter');

/**
 * コメントフォームの表示変更
 */
add_filter('comment_form_default_fields', 'my_comment_form_default_fields');
function my_comment_form_default_fields($args){
  $args['author'] = ''; //名前を削除
  $args['email'] = ''; //メールアドレスを削除
  $args['url'] = ''; //サイトを削除
  return $args;
}

/**
 * 記事一覧をカスタマイズするアクションフック
 */
add_action( 'pre_get_posts', 'my_pre_get_posts');
function my_pre_get_posts($query){
  // 管理画面、メインクエリ以外には設定しない
  if(is_admin() || !$query->is_main_query() ){
    return;
  }
  
  //トップページ の 場合
  if($query->is_home()){
    $query->set('posts_per_page', 3);
    // $query->set('category_name', 'news');
    return;
  }
}

add_action('wp', 'my_wpautop');
function my_wpautop(){
  if(is_page('contact')){
    remove_filter('the_content','wpautop');
  }
}