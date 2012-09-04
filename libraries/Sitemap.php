<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * Sitemap class for ci-sitemap library.
 * 
 * @author Roumen Damianoff <roumen@dawebs.com>
 * @version 1.1
 * @link https://github.com/RoumenMe/ci-sitemap GitHub
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */

class Sitemap
{

    public $records = array();


    /**
     * Add new sitemap item to $records array
     */
    public function add($loc, $lastmod = null, $priority = '0.50', $freq = 'monthly')
    {
        $this->records[] = array(
            'loc' => $loc,
            'lastmod' => $lastmod,
            'priority' => $priority,
            'freq'=> $freq
        );
    }


    /**
     * Returns xml document with all sitemap items from $records array
     */
    public function render()
    {
        $CI =& get_instance();
        $data['records'] = $this->records;
        
        $CI->load->view('sitemap/view', $data);
    }

}