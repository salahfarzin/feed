####
# Feed Reader (Currently Atom Reader)

This bundle is a simple feed reader that currently supports Atom feeds.


## Setup

```bash
$ composer require ahoraian/feed
```

# Usage
This package support some Http Client Driver internally, but it's completely exensible, and you free to use any
Http Driver, also support local Atom.xml files (use FileDriver instead of CurlDriver).

### Remote Feed
```php
// example url
$feedUrl = 'https://rss.dw.com/atom/rss-en-all'; 

$reader = new \Ahoraian\Feed\Reader(new \Ahoraian\Feed\Reader\Driver\CurlDriver);
$feeds = $reader->load($feedUrl);

foreach($feeds as $feed) {
     $id = $feed->getId();
     $title = $feed->getTitle();
     $authors = $feed->getAuthors();
     $links = $feed->getLinks();
     $summary = $feed->getSubtitle();
     $categories = $feed->get('category');
     $contributors = $feed->getContributors();
     $generators = $feed->getGenerator();
     $icon = $feed->getIcon();
     $logo = $feed->getLogo();
     $copyRight = $feed->getCopyright();
     $lastModificationDate = $feed->getLastModification();

    foreach ($feed->getItems() as $entry) {
        $entryId = $entry->getId();
        $entryTitle = $entry->getTitle();
        $entryAuthors = $entry->getAuthors();
        $entryContent = $entry->getContent();
        $entrySummary = $entry->getSummary();
        $entryLinks = $entry->getLinks();
        $entrySubtitle = $entry->getSubtitle();
        $entryCategories = $entry->get('category');
        $entryContributors = $entry->getContributors();
        $entryCopyright = $entry->getCopyright();
        $entrySource = $entry->getSource();
        $entryLastModification = $entry->getLastModification();
    }
}
```
### Local
```php
// example url
$atom = file_get_contents('feed.xml');

$reader = new \Ahoraian\Feed\Reader(new \Ahoraian\Feed\Reader\Driver\FileDriver);
$feeds = $reader->load($atom);

//...
```