# Largo child theme for Chicago Reporter #

This repository is for the Largo child theme used by Chicago Reporter on INN's shared hosting.

- [Creating new issues for Chicago reporter and Catalyst Chicago](docs/creating-new-issues.md)

## Compiling LESS

### Setup

run `npm install` to install Grunt and all the dependencies.

### Development

If you want the `css/` files to update every time you save changes, run `grunt watch`. Then edit the LESS source files in `less/` and refresh your browser as normal.

If you want to just build the CSS from the LESS files once, simply run `grunt less`.

## Migration notes for version 0.4, May 2016

1. In Theme Options > Layout, set the footer to the four-column layout.
2. In Theme Options > Basic Settings, set the Copyright message to:

	```html
	Copyright Â©%d Community Renewal Society
	```
3. In Appearances > Widgets, create a Text Widget in Footer 4 with the following HTML.

	```html
		<p class="footer-credit">
			<b>The Chicago Reporter</b> is a publication of the <a target="_blank" href="http://www.communityrenewalsociety.org/">Community Renewal Society</a>, a faith-based organization founded in 1882. Visit our sister publication <a href="http://catalyst-chicago.org/">Catalyst Chicago</a>.
		</p>
		<p class="footer-credit">
			The Chicago Reporter 111 W. Jackson Blvd., Suite 820 | Chicago, IL 60604 | (312) 427-4830 | <a target="_blank" href="mailto:tcr@chicagoreporter.com">tcr@chicagoreporter.com</a>
		</p>
	```

4. Also in Appearances > Widgets, add `class="btn btn-submit"` to the submit button in the newsletter signup text widget:

	```html
	<input class="btn btn-submit" type="Submit" value="Join" />
	```

5. In Appearance > Menus, add "terms and conditions of use" and "Privacy Policy" to the "Footer Navigation" menu.

