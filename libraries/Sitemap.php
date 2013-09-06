<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * Sitemap class for ci-sitemap library.
 *
 * @author Roumen Damianoff <roumen@dawebs.com>
 * @version 1.2.2
 * @link http://roumen.it/projects/ci-sitemap
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */

class Sitemap
{

    public $items = array();
    public $title;
    public $link;


    /**
     * Add new sitemap item to $items array
     *
     * @param string $loc
     * @param string $lastmod
     * @param string $priority
     * @param string $freq
     * @param string $title
     *
     * @return void
     */
    public function add($loc, $lastmod = null, $priority = '0.50', $freq = 'monthly', $title = null)
    {
        $this->items[] = array(
            'loc' => $loc,
            'lastmod' => $lastmod,
            'priority' => $priority,
            'freq' => $freq,
            'title' => $title
        );
    }


    /**
     * Returns document with all sitemap items from $items array
     *
     * @param string $format (options: xml, html, txt, ror-rss, ror-rdf)
     *
     * @return View
     */
    public function render($format = 'xml')
    {
        $CI =& get_instance();

        if (empty($this->link)) $this->link = $CI->config->item('base_url');
        if (empty($this->title)) $this->title = 'Sitemap for ' . $this->link;

        $data['channel'] = array(
            'title' => $this->title,
            'link' => $this->link
        );

        $data['items'] = $this->items;

        $CI->load->view('sitemap/'.$format, $data);
    }

}