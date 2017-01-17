# Creating new issues

The process of creating a new issue falls into three general parts:

1. Creating the new issue term
2. Assigning posts to the issue
3. Creating a landing page for the term

Instructions in this tutorial will presume you're creating a new issue in the 'reporter-issues' taxonomy, but they are equally applicable to the 'catalyst-issues' taxonomy.

## Creating the new issue term

1. In the Dashboard, go to Posts > Reporter Issues
2. Under "Add New Reporter Issue", fill out the following blanks:
	- Name: This is the display name of the new issue.
	- Slug: This is what shows up in URLs
	- Parent: If an issue has a parent issue, set this. Otherwise, leave it at "None"
	- Description: This should include the issue's date and a brief description of what it focuses upon.
3. Press the "Add New Reporter Issue" button
4. Find your new issue in the list of issues, and click the "edit" link that appears when you hover over it with a mouse.
5. Set the term banner image by uploading an image of the cover of the magazine.
6. Set the sidebar that should display on this issue from the drop-down.
7. Press the "Update" button.

## Assigning posts to the issue

### Assigning posts in bulk

1. In the list of posts in the Dashboard, choose multiple posts by checking the checkbox next to their title.
2. At the top of the list, click on the "Bulk Actions" dropdown and choose "Edit". Press the "Apply" button next to the drop-down.
3. In the new dialog that appears, check the box next to the issue that these posts should be in.
4. Press the "Update" button.


### Assigning posts one-by-one
For every post that you want to assign to a given issue:

1. Open the post editor
2. In the right-hand column, look for a box titled "Reporter Issues"
3. Check the box next to the issue that this post should be in.
4. Save the post.

## Creating a landing page for the issue

This process is much like the old way of creating landing pages, when issues were series.

If you do not create a landing page for a given issue, it will not show up in the list of issues on at `/reporter-issues/`, because without a landing page, the shortcode used on `/reporter-issues/` does not know what year the issue was published in, and does not know where to put it in the order of issues.

1. In the Dashboard, go to Landing Pages > Add New
2. Fill out the following fields:
	- Title: This should be the same as the name you set for the issue when you created the issue term.
	- Description: This should be the same as the descripton you set for the issue when you created the issue term.
	- Layout Style: Set it to "Custom HTML"
	- Custom HTML: Use this for whatever you would like to set for the term. At the beginning of the text, place `[featured_image size="medium"]`.
	- Featured Media (in the right-hand sidebar): Set this to the cover image for the issue.
	- Reporter Issues (in the right-hand sidebar): Set this to the issue you are creating.
	- Publish (in the right-hand sidebar): Set the publish date to the date the issue was/will-have-been published.
3. All other options will be ignored by the issue's archive template.

## Conclusion

When you've done all of the above, go back to the listing of issues at Dashboard > Posts > Reporter Issues. Find your new issue, and click "View". 
