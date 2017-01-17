## Notes:

The following files should have the same content:

- partials/content-home.php
- partials/content-series.php
- partials/content-archive.php

The reason for this is that the same layout is desired in each location, which is not possible without overriding the content-archive, content-home and content-series partials. Largo doesn't have a content-home partial, so we define one using the same code as the other two partials here.
