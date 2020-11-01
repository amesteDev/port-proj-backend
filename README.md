# This repo is part of bundle of things made for the course Webbutveckling III at Mittuniversitet.

The repo contains the backend for my portfolio, all calls will return some form of JSON.

***

Calls can be made to the following endpoints:

index.php

Calls are made with a GET-variable as such: ?table=***

Where *** must be a valid table-name from the database, change the $allowedTables to control this.

***

admlogin.php

Calls here are made with a body containing:

meth: LOGIN or CHECK,

username: username,

password: password

LOGIN or CHECK is depending on if the call is made to login or check if the user is authenticated.

***

admin.php

Calls here can be made with POST, PUT and DELETE

All the calls must contain a body where a key: value must be set as such:

table: ***

Following the same logic as the GET-variable above. The call must also contain the right amount of data that is to be stored in the table, since a check is made before storing.

***

imgupl.php

Send a file wrapped in formdata and get a return with the path to the stored image.

***

contact.php

The only purpose for this endpoint is to send emails to me, change to your own e-mail. The body is constructed in the same way as calls to for example admin.php
