# D8-Exercises

<strong>Given that the following exercise has been done</strong>
Create a Paragraph type - “Social Media” with the following fields - 1)
Embed Code (Text field that accepts any long text and is rendered
without any filters (Hint: Create a text format called “Raw”) and 2)
Link
On the Article Content type - Add a new field referring to the above
paragraph type created (Multiple values allowed).
Configure display of the paragraph type and the article content type
such that the embed code and link are displayed as on the screengrab
attached.

<strong>Bonus Exercise</strong>
Theme the paragraph type such that the 2 fields (Embed code and link,
wherever they are shown on any content type, are rendered in 2 columns
as below:
<table><tr><td>Embed Code</td><td>Link</td></tr></table>


Steps:
1. Create a custom theme - with info file etc. 
2. Create a .theme file - eg: suchi.theme
  This file is similar to the template.php file that we had earlier.
Please check the file - there is a preprocess_paragraph function where
we are defining our variables to be used in the twig template.
3. Create a paragraph template - paragraph--social_media.html.twig
Use the variable defined in #2 - as per the table structure we need. 


