<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

/**
 * Sitemap class for ci-sitemap library.
 *
 * @author Roumen Damianoff <roumen@dawebs.com>
 * @version 1.3.3
 * @link http://roumen.it/projects/ci-sitemap
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */

class Sitemap
{

    protected $items = array();
    protected $sitemaps = array();
    protected $title = null;
    protected $link = null;
    protected $escaping = true;


    public function getItems()
    {
        return $this->items;
    }


    public function getSitemaps()
    {
        return $this->sitemaps;
    }


    public function getTitle()
    {
        return $this->title;
    }


    public function getLink()
    {
        return $this->link;
    }


    public function getEscaping()
    {
        return $this->escaping;
    }


    public function setEscaping($b)
    {
        $this->escaping = $b;
    }


    public function setItems($items)
    {
        $this->items[] = $items;
    }


    public function resetItems()
    {
        $this->items[] = array_slice($this->items[], 0, 50000);
    }


    public function setSitemaps($sitemaps)
    {
        $this->sitemaps[] = $sitemaps;
    }


    public function setTitle($title)
    {
        $this->title = $title;
    }


    public function setLink($link)
    {
        $this->link = $link;
    }


    /**
     * Add new sitemap item to $items array
     *
     * @param string $loc
     * @param string $lastmod
     * @param string $priority
     * @param string $freq
     * @param array  $images
     * @param string $title
     * @param array $translations
     * @param array $videos
     * @param array $googlenews
     *
     * @return void
     */
    public function add($loc, $lastmod = null, $priority = null, $freq = null, $images = array(), $title = null, $translations = array(), $videos = array(), $googlenews = array())
    {
        if ($this->getEscaping())
        {
            $loc = htmlentities($loc, ENT_XML1);

            if ($title != null) htmlentities($title, ENT_XML1);

            if ($images)
            {
                foreach ($images as $k => $image)
                {
                    foreach ($image as $key => $value)
                    {
                        $images[$k][$key] = htmlentities($value, ENT_XML1);
                    }
                }
            }

            if ($translations)
            {
                foreach ($translations as $k => $translation)
                {
                    foreach ($translation as $key => $value)
                    {
                        $translations[$k][$key] = htmlentities($value, ENT_XML1);
                    }
                }
            }

            if ($videos)
            {
                foreach ($videos as $k => $video)
                {
                    if ($video['title']) $videos[$k]['title'] = htmlentities($video['title'], ENT_XML1);
                    if ($video['description']) $videos[$k]['description'] = htmlentities($video['description'], ENT_XML1);
                }
            }

            if ($googlenews)
            {
                if (isset($googlenews['sitename'])) $googlenews['sitename'] = htmlentities($googlenews['sitename'], ENT_XML1);
            }

        }

        $googlenews['sitename'] = isset($googlenews['sitename']) ? $googlenews['sitename'] : '';
        $googlenews['language'] = isset($googlenews['language']) ? $googlenews['language'] : 'en';
        $googlenews['publication_date'] = isset($googlenews['publication_date']) ? $googlenews['publication_date'] : date('Y-m-d H:i:s');

        $this->setItems([
            'loc' => $loc,
            'lastmod' => $lastmod,
            'priority' => $priority,
            'freq' => $freq,
            'images' => $images,
            'title' => $title,
            'translations' => $translations,
            'videos' => $videos,
            'googlenews' => $googlenews
        ]);
    }


    /**
     * Add new sitemap to $sitemaps array
     *
     * @param string $loc
     * @param string $lastmod
     *
     * @return void
     */
    public function addSitemap($loc, $lastmod = null)
    {
        $this->setSitemaps([
            'loc' => $loc,
            'lastmod' => $lastmod,
        ]);
    }


    /**
     * Returns document with all sitemap items from $items array
     *
     * @param string $format (options: xml, html, txt, ror-rss, ror-rdf, google-news)
     *
     * @return View
     */
    public function render($format = 'xml')
    {

        $data = $this->generate($format);

        if ($format == 'html')
        {
            return $data['content'];
        }

        $CI =& get_instance();

        $CI->load->view('sitemap/'.$format, $data);
    }


    /**
     * Generates document with all sitemap items from $items array
     *
     * @param string $format (options: xml, html, txt, ror-rss, ror-rdf, sitemapindex, google-news)
     *
     * @return array
     */
    public function generate($format = 'xml')
    {

        $CI =& get_instance();

        if (!$this->getLink())
        {
            $this->setLink($CI->config->item('base_url'));
        }

        if (!$this->getTitle())
        {
            $this->setTitle('Sitemap for ' . $this->getLink());
        }

        $channel = [
            'title' => $this->getTitle(),
            'link' => $this->getLink(),
        ];

        if ($format == 'sitemapindex')
        {
            // don't render more than 50000 elements in a single sitemapindex
            (count($this->getSitemaps()) > 50000) ? $items = array_slice($this->getSitemaps(), 0, 50000) : $items = $this->getSitemaps();
        }
        else
        {
            // don't render more than 50000 elements in a single sitemap (or 1000 for google-news sitemap)
            ($format == 'google-news' && count($this->getItems()) > 1000) ? $items = array_slice($this->getItems(), 0, 1000) : $items = $this->getItems();
            ($format != 'google-news' && count($this->getItems()) > 50000) ? $items = array_slice($this->getItems(), 0, 50000) : $items = $this->getItems();
        }

        return $CI->load->view('sitemap/'.$format, array('items' => $items, 'channel' => $channel));
    }


    /**
     * Generate sitemap and store it to a file
     *
     * @param string $format (options: xml, html, txt, ror-rss, ror-rdf, sitemapindex, google-news)
     * @param string $filename (without file extension, may be a path like 'sitemaps/sitemap1' but must exist)
     *
     * @return void
     */
    public function store($format = 'xml', $filename = 'sitemap')
    {
        // use correct file extension
        ($format == 'txt' || $format == 'html') ? $fe = $format : $fe = 'xml';

        // use correct limit
        ($format != "google-news") ? $max = 50000 : $max = 1000;

        // check if this sitemap have more than 50000 elements
        if (count($this->getItems()) > $max)
        {
            foreach (array_chunk($this->getItems(), $max) as $key => $item)
            {
                $this->items = $item;
                $this->store('xml', $filename . '-' . $key);
                $this->addSitemap(url($filename . '-' . $key . '.' . $fe));
            }

            $data = $this->generate('sitemapindex');
        }
        else
        {
            $data = $this->generate($format);
        }

        $file = FCPATH . DIRECTORY_SEPARATOR . $filename . '.' . $fe;

        // must return something
        if (write_file($file, $data['content'])
        {
            return "Success! Your sitemap file is created.";
        }
        else
        {
            return "Error! Your sitemap file is NOT created.";
        }

        // clear memory
        if ($format == 'sitemapindex')
        {
            $this->sitemaps = array();
            $this->items = array();
        }
        else
        {
            $this->items = array();
        }
    }


}
