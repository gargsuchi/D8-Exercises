# D8-Exercises

<strong>Given that the following exercise has been done</strong>
<br>
Create a Paragraph type - “Social Media” with the following fields - 
<ol>
<li>Embed Code (Text field that accepts any long text and is rendered
without any filters (Hint: Create a text format called “Raw”) and </li>
<li>Link</li>
</ol>
<br>
On the Article Content type - Add a new field referring to the above
paragraph type created (Multiple values allowed).
<br>
Configure display of the paragraph type and the article content type
such that the embed code and link are displayed as on the screengrab
attached.
<br>

<strong>Bonus Exercise</strong>
<br>
Theme the paragraph type such that the 2 fields (Embed code and link,
wherever they are shown on any content type, are rendered in 2 columns
as below:
<table><tr><td>Embed Code</td><td>Link</td></tr></table>


Steps:
<ol>
<li>Create a custom theme - with info file etc. </li>
<li>Create a .theme file - eg: suchi.theme</li>
  This file is similar to the template.php file that we had earlier.
Please check the file - there is a preprocess_paragraph function where
we are defining our variables to be used in the twig template.
<li>Create a paragraph template - paragraph--social_media.html.twig
Use the variable defined in #2 - as per the table structure we
need.</li> 
</ol>


