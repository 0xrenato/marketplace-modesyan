<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rss_controller extends Home_Core_Controller
{
	public function __construct()
	{
		parent::__construct();

		if ($this->general_settings->rss_system != 1) {
			redirect(lang_base_url());
		}

		//load the library
		$this->load->helper('xml');
	}


	/**
	 * Rss Page
	 */
	public function rss_feeds()
	{
		$data['title'] = trans("rss_feeds");
		$data['description'] = trans("rss_feeds") . " - " . $this->app_name;
		$data['keywords'] = trans("rss_feeds") . "," . $this->app_name;

		$this->load->view('partials/_header', $data);
		$this->load->view('rss/rss_feeds', $data);
		$this->load->view('partials/_footer');
	}


	/**
	 * Rss Latest Products
	 */
	public function latest_products()
	{
		$data['feed_name'] = $this->app_name . " " . trans("rss_feeds") . " - " . trans("latest_products");
		$data['encoding'] = 'utf-8';
		$data['feed_url'] = lang_base_url() . 'rss/' . get_route("latest_products");
		$data['page_description'] = $this->app_name . " " . trans("rss_feeds") . " - " . trans("latest_products");
		$data['page_language'] = $this->selected_lang->short_form;
		$data['creator_email'] = '';
		$data['products'] = $this->product_model->get_products_limited(30);

		header("Content-Type: application/rss+xml; charset=utf-8");
		$this->load->view('rss/rss', $data);
	}


	/**
	 * Rss Featured Products
	 */
	public function featured_products()
	{
		$data['feed_name'] = $this->app_name . " " . trans("rss_feeds") . " - " . trans("featured_products");
		$data['encoding'] = 'utf-8';
		$data['feed_url'] = lang_base_url() . 'rss/' . get_route("featured_products");
		$data['page_description'] = $this->app_name . " " . trans("rss_feeds") . " - " . trans("featured_products");
		$data['page_language'] = $this->selected_lang->short_form;
		$data['creator_email'] = '';
		$data['products'] = $this->product_model->get_promoted_products();

		header("Content-Type: application/rss+xml; charset=utf-8");
		$this->load->view('rss/rss', $data);
	}


	/**
	 * Rss By Category
	 */
	public function rss_by_category($slug)
	{
		$slug = clean_slug($slug);
		$category = $this->category_model->get_category_by_slug($slug);
		if (empty($category)) {
			redirect(generate_url("rss_feeds"));
		}
		$data['products'] = $this->product_model->get_rss_products_by_category($category->id);

		$data['feed_name'] = $this->app_name . " " . trans("rss_feeds") . " - " . $category->name;
		$data['encoding'] = 'utf-8';
		$data['feed_url'] = lang_base_url() . 'rss/' . get_route("category", true) . $slug;
		$data['page_description'] = $this->app_name . " " . trans("rss_feeds") . " - " . $category->name;
		$data['page_language'] = $this->selected_lang->short_form;
		$data['creator_email'] = '';

		header("Content-Type: application/rss+xml; charset=utf-8");
		$this->load->view('rss/rss', $data);
	}


	/**
	 * Rss By Seller
	 */
	public function rss_by_seller($slug)
	{
		$slug = clean_slug($slug);
		$user = $this->auth_model->get_user_by_slug($slug);
		if (empty($user)) {
			redirect(generate_url("rss_feeds"));
		}
		if ($user->show_rss_feeds != 1) {
			redirect(generate_profile_url($slug));
		}
		$data['products'] = $this->product_model->get_rss_products_by_user($user->id);

		$data['feed_name'] = $this->app_name . " " . trans("rss_feeds") . " - " . $user->username;
		$data['encoding'] = 'utf-8';
		$data['feed_url'] = lang_base_url() . 'rss/' . get_route("seller", true) . $slug;
		$data['page_description'] = $this->app_name . " " . trans("rss_feeds") . " - " . $user->username;
		$data['page_language'] = $this->selected_lang->short_form;
		$data['creator_email'] = '';

		header("Content-Type: application/rss+xml; charset=utf-8");
		$this->load->view('rss/rss', $data);
	}
}
