# [ci-sitemap](http://roumen.me/projects/ci-sitemap) library

A simple sitemap generator for CodeIgniter.

## Installation

To install just copy/paste the content of ci-sitemap in your application folder.

## Example (xml)

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

    // show your sitemap (options: 'xml' (default), 'html', 'txt', 'ror-rss', 'ror-rdf')
    $sitemap->render('xml');
}
```

## Example (ror-rdf)

```php
public function ror-sitemap()
{
    // first load the library
    $this->load->library('sitemap');

    // create new instance
    $sitemap = new Sitemap();

    // set sitemap's title and url (only for html, ror-rss and ror-rdf)
    $sitemap->title = 'ROR sitemap';
    $sitemap->link = 'http://domain.tld';

    // add items to your sitemap (url, date, sortOrder, updatePeriod, title)
    $sitemap->add('http://mysite.tld/', '2012-08-25T20:10:00+02:00', '0', 'daily', 'Some Title');
    $sitemap->add('http://mysite.tld/page1', '2012-08-26T22:30:00+02:00', '1', 'monthly', 'Some Title');
    $sitemap->add('http://mysite.tld/page2', '2012-08-26T23:45:00+02:00', '2', 'weekly', 'Some Title');

    // add multiple items with a loop
    foreach ($posts as $post)
    {
        $sitemap->add($post->slug, $post->date, $post->priority, $post->freq);
    }

    // show your sitemap (options: 'xml' (default), 'html', 'txt', 'ror-rss', 'ror-rdf')
    $sitemap->render('ror-rdf');
}
```