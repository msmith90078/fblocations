README
======

FB Locations
------------

This was just a weekend project after I started looking at the my FB archive dump and noticed
how much data there is that I did not know about or had long forgotten. I encourage everyone to create
an archive dump of their account and have a close look this data.


Instructions
------------

Appologies in advance for the messy code and manual process

* You first need to create an archive of your FB data. Visit https://www.facebook.com/settings?tab=account

* Once you have created your archive and extracted it, place the file 'security.htm' in this directory

* Since we need to translate these IP addresses to their long/lat coordinates, we need some sort of web
  service, I used ipinfodb.com because it just works. (Seems like they're getting a lot of DDoS attacks
  so be nice with their free service)

* Once you have an API key, edit convert.php and place the key there

* Get composer by running "curl -sS https://getcomposer.org/installer | php"

* Run "php composer.phar install" to install some dependencies

* Now just run convert.php. This will generate a file called locations.json which in turn be loaded by
  the index.html page

* That's it, now go to index.html and find out which locations FB knows that you've logged in from!


