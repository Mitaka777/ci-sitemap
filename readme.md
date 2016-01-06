# [ci-sitemap](https://roumen.it/projects/ci-sitemap) library

A simple sitemap generator for CodeIgniter.

## Installation

To install just copy/paste the content of ci-sitemap in your application folder.

## Example

```php
public function sitemap()
{
    // first load the library
    $this->load->library('sitemap');

    // create new instance
    $sitemap = new Sitemap();

    // add items to your sitemap (url, date, priority, freq)
    $sitemap->add('http://mysite.tld/', '2012-08-25T20:10:00+02:00', '1.0', 'daily');
    $sitemap->add('http://mysite.tld/page1', '2012-08-26T22:30:00+02:00', '0.6', 'monthly');
    $sitemap->add('http://mysite.tld/page2', '2012-08-26T23:45:00+02:00', '0.9', 'weekly');

    // add multiple items with a loop
    foreach ($posts as $post)
    {
        $sitemap->add($post->slug, $post->date, $post->priority, $post->freq);
    }

    // show your sitemap (options: 'xml', 'google-news', 'sitemapindex' 'html', 'txt', 'ror-rss', 'ror-rdf')
    $sitemap->render('xml');
}
```