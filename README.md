#tumblr setup

- put the files on your server (duh)
- go to customize -> edit html, and paste this where you want the counter to show up:
```html
<div id="counter"></div>
<script src="http://your.domain/counter.php"></script>
```
- add a new page (at the bottom of the "edit theme" sidebar), it must be called "map" unless you edit counter.php
- paste this 
```html
<img src="http://your.domain/map.php"/></p>
<script src="http://your.domain/userlist.php" type="text/javascript"></script>
```

#non-tumblr setup
- change the "output_as_script" flag to false in counter.php and userlist.php
- same thing as the tumblr setup
