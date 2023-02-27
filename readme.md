# MoveFilesAutomatically

With this script you can move files from a given directory automatically into destination folders.
You have to specify a mappings config where you can set keywords and the destination folder.

## Run
Just run `run.php`. It will ask you for all findings and if the file should be moved or not.

**There are some options:**

`--dry` or short `-d` will show you all planned moves, but will do nothing.

`--verbose` or short `-v` will show you much information.

`--non-interactive` or short `-y` will proceed all planned moves.

`--include-hidden` or short `-h` will include hidden files (beginning with .) from the source dir.

## Settings
First you have to set up some settings. There is a `settings.example.php` file. Please adjust it to your context and use case. And rename or better copy it as `settings.php`.

## Help
You can open issues right here at GitHub or send me a mail to `flost-dev@mailbox.org`.