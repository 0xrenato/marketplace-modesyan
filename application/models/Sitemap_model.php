<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sitemap_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->urls = array();
    }

    //input values
    public function input_values()
    {
        $data = array(
            'frequency' => $this->product_settings->sitemap_frequency,
            'last_modification' => $this->product_settings->sitemap_last_modification,
            'priority' => $this->product_settings->sitemap_priority,
            'lastmod_time' => NULL
        );
        return $data;
    }

    //update sitemap settings
    public function update_sitemap_settings()
    {
        $db_data = array(
            'sitemap_frequency' => $this->input->post('frequency', true),
            'sitemap_last_modification' => $this->input->post('last_modification', true),
            'sitemap_priority' => $this->input->post('priority', true)
        );

        $this->db->where('id', 1);
        $this->db->update('product_settings', $db_data);
    }

    public function add($loc, $changefreq = NULL, $lastmod = NULL, $priority = NULL, $priority_value = NULL, $lastmod_time = NULL)
    {
        $item = new stdClass();
        $item->loc = $loc;
        $item->lastmod = $lastmod;
        $item->lastmod_time = $lastmod_time;
        $item->changefreq = $changefreq;
        $item->priority = $priority;
        $item->priority_value = $priority_value;
        $this->urls[] = $item;

        return true;
    }

    /**
     * Generate the sitemap file and replace any output with the valid XML of the sitemap
     *
     * @param string $type Type of sitemap to be generated. Use 'urlset' for a normal sitemap. Use 'sitemapindex' for a sitemap index file.
     * @access public
     * @return void
     */
    public function output($type = 'urlset')
    {

        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><urlset/>');
        $xml->addAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        if (!empty($this->urls)) {
            foreach ($this->urls as $url) {
                $child = $xml->addChild('url');
                $child->addChild('loc', strtolower($url->loc));

                if (isset($url->lastmod) && $url->lastmod != 'none') {
                    if ($url->lastmod == 'server_response') {
                        $child->addChild('lastmod', date("Y-m-d"));
                    } else {
                        $child->addChild('lastmod', $url->lastmod_time);
                    }
                }

                if (isset($url->changefreq) && $url->changefreq != 'none') {
                    $child->addChild('changefreq', $url->changefreq);
                }

                if (isset($url->priority) && $url->priority != 'none') {
                    $child->addChild('priority', $url->priority_value);
                }
            }
        }
        header('Content-Disposition: attachment; filename="sitemap.xml"');
        $this->output->set_content_type('application/xml')->set_output($xml->saveXML());

    }


    /**
     * Clear all items in the sitemap to be generated
     *
     * @access public
     * @return boolean
     */
    public function clear()
    {
        $this->urls = array();
        return true;
    }

    /**
     * Base Url
     */
    public function get_base_url($lang_id)
    {
        if ($lang_id == $this->general_settings->site_lang) {
            return base_url();
        } else {
            $lang = get_language($lang_id);
            if (!empty($lang)) {
                return base_url() . $lang->short_form . "/";
            }
        }
    }


    /**
     * Static Page Urls
     */
    public function add_static_urls($frequency, $last_modification, $priority, $lastmod_time)
    {
        $priority_value = 0.8;
        $this->sitemap_model->add(base_url(), $frequency, $last_modification, '1', '1', $lastmod_time);
    }


    /**
     * Page Urls
     */
    public function add_page_urls($frequency, $last_modification, $priority, $lastmod_time)
    {
        $pages = $this->page_model->get_pages_all();
        if (!empty($pages)) {
            foreach ($pages as $page) {
                if (empty($page->link) && $page->visibility == 1) {
                    $base_url = $this->get_base_url($page->lang_id);
                    $priority_value = 0.8;
                    $this->sitemap_model->add($base_url . $page->slug, $frequency, $last_modification, $priority, $priority_value, $lastmod_time);
                }
            }
        }
    }


    /**
     * Product Category Urls
     */
    public function add_product_category_urls($frequency, $last_modification, $priority, $lastmod_time)
    {
        $priority_value = 0.8;
        $categories = $this->category_model->get_categories();
        if (!empty($categories)) {
            foreach ($categories as $category) {
                if ($category->visibility == 1) {
                    $this->sitemap_model->add(generate_category_url($category), $frequency, $last_modification, $priority, $priority_value, $lastmod_time);
                }
            }
        }
    }


    /**
     * Product Urls
     */
    public function add_product_urls($frequency, $last_modification, $priority, $lastmod_time)
    {
        $priority_value = 0.8;
        $products = $this->product_model->get_products();
        if (!empty($products)) {
            foreach ($products as $product) {
                $add_link = true;
                if ($this->general_settings->show_sold_products != 1 && $product->is_sold == 1) {
                    $add_link = false;
                }
                if ($add_link) {
                    $this->sitemap_model->add(generate_product_url($product), $frequency, $last_modification, $priority, $priority_value, $lastmod_time);
                }
            }
        }
    }


    /**
     * Blog Category Urls
     */
    public function add_blog_category_urls($frequency, $last_modification, $priority, $lastmod_time)
    {
        $priority_value = 0.8;

        $categories = $this->blog_category_model->get_categories_all();
        if (!empty($categories)) {
            foreach ($categories as $category) {
                $base_url = $this->get_base_url($category->lang_id);
                $this->sitemap_model->add($base_url . get_route("blog") . "/" . $category->slug, $frequency, $last_modification, $priority, $priority_value, $lastmod_time);
            }
        }
    }


    /**
     * Post Urls
     */
    public function add_blog_post_urls($frequency, $last_modification, $priority, $lastmod_time)
    {
        $posts = $this->blog_model->get_posts_all_joined();
        $priority_value = 0.8;
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $base_url = $this->get_base_url($post->lang_id);
                $this->sitemap_model->add($base_url . get_route("blog") . "/" . $post->category_slug . "/" . $post->slug, $frequency, $last_modification, $priority, $priority_value, $lastmod_time);
            }
        }
    }


    /**
     * Blog Tag Urls
     */
    public function add_blog_tag_urls($frequency, $last_modification, $priority, $lastmod_time)
    {
        $tags = $this->tag_model->get_tags_all();
        $priority_value = 0.8;
        if (!empty($tags)) {
            foreach ($tags as $tag) {
                $tag = $this->tag_model->get_post_tag($tag->tag_slug);
                $base_url = $this->get_base_url($tag->tag_lang_id);
                $this->sitemap_model->add($base_url . get_route("blog") . "/" . get_route("tag") . "/" . $tag->tag_slug, $frequency, $last_modification, $priority, $priority_value, $lastmod_time);
            }
        }
    }


    public function download_sitemap()
    {
        $data = $this->input_values();
        $this->add_static_urls($data['frequency'], $data['last_modification'], $data['priority'], $data['lastmod_time']);
        $this->add_page_urls($data['frequency'], $data['last_modification'], $data['priority'], $data['lastmod_time']);
        $this->add_product_category_urls($data['frequency'], $data['last_modification'], $data['priority'], $data['lastmod_time']);
        $this->add_product_urls($data['frequency'], $data['last_modification'], $data['priority'], $data['lastmod_time']);
        $this->add_blog_category_urls($data['frequency'], $data['last_modification'], $data['priority'], $data['lastmod_time']);
        $this->add_blog_post_urls($data['frequency'], $data['last_modification'], $data['priority'], $data['lastmod_time']);
        $this->add_blog_tag_urls($data['frequency'], $data['last_modification'], $data['priority'], $data['lastmod_time']);
        $this->sitemap_model->output('sitemapindex');
    }


    public function update_sitemap()
    {
        $full_path = FCPATH . "sitemap.xml";
        if (file_exists($full_path)) {
            unlink($full_path);
        }
        $data = $this->input_values();
        $this->add_static_urls($data['frequency'], $data['last_modification'], $data['priority'], $data['lastmod_time']);
        $this->add_page_urls($data['frequency'], $data['last_modification'], $data['priority'], $data['lastmod_time']);
        $this->add_product_category_urls($data['frequency'], $data['last_modification'], $data['priority'], $data['lastmod_time']);
        $this->add_product_urls($data['frequency'], $data['last_modification'], $data['priority'], $data['lastmod_time']);
        $this->add_blog_category_urls($data['frequency'], $data['last_modification'], $data['priority'], $data['lastmod_time']);
        $this->add_blog_post_urls($data['frequency'], $data['last_modification'], $data['priority'], $data['lastmod_time']);
        $this->add_blog_tag_urls($data['frequency'], $data['last_modification'], $data['priority'], $data['lastmod_time']);

        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><urlset/>');
        $xml->addAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

        if (!empty($this->urls)) {
            foreach ($this->urls as $url) {
                $child = $xml->addChild('url');
                $child->addChild('loc', strtolower($url->loc));

                if (isset($url->lastmod) && $url->lastmod != 'none') {
                    if ($url->lastmod == 'server_response') {
                        $child->addChild('lastmod', date("Y-m-d"));
                    } else {
                        $child->addChild('lastmod', $url->lastmod_time);
                    }
                }

                if (isset($url->changefreq) && $url->changefreq != 'none') {
                    $child->addChild('changefreq', $url->changefreq);
                }

                if (isset($url->priority) && $url->priority != 'none') {
                    $child->addChild('priority', $url->priority_value);
                }
            }
        }
        $xml->saveXML($full_path);
    }
}
