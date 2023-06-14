# ScorrPHP

A simple scoring system for mobile games, mostly PHP, with some Python for testing.

# Installation

Download the software from github and place in a directory accessible by your server software. It should work as-is with Apache or NGinx. 

From a command line, change directory to get to the ScorrPHP directory.

From a command line, type `composer update` to download the correct versions of PHP software.

From a command line, type `npm update` to download the correct versions of javascript software.

You may need SQLite on your system. Installation is system-dependent and left as an exercise for the reader.

From a command line, type `sqlite3 writable/scorr.db < rsc/scorr.sqlite` to create the SQLite database.

If instead, you opt to use mysql for storage, a mysql script is included in the rsc directory. SQLite should be more than adequate for most purposes.