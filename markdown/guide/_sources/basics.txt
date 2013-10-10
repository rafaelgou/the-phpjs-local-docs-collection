================
Markdown Basics
================

This should cover 99% of your Markdown needs.
    
Blockquotes
============

To enclose a segment of text in blockquotes, one must prefix each written line
with a less-than sign.

Markdown::

    > ## Blockquoted header
    >
    > This is blockquoted text.
    >
    > This is a second paragraph within the blockquoted text.
    
Output:

.. code-block:: html

    <blockquote>
        <h2>Blockquoted header</h2>
    
        <p>This is blockquoted text.</p>

        <p>This is a second paragraph within the blockquoted text.</p>

    </blockquote>

Code: Block
=============

To specify an entire block of pre-formatted code, indent every line of the block by 1 tab or 4 spaces. Ampersands and angle brackets will automatically be translated into HTML entities.

Markdown::

    If you want to mark something as code, indent it by 4 spaces.

        <p>This has been indented 4 spaces.</p>

.. code-block:: html

    <p>If you want to mark something as code, indent it by 4 spaces.</p>
    
        &lt;p&gt;This has been indented 4 spaces.&lt;/p&gt;

Code: Inline
===============

Inline code descriptions can be done via the use of the backtick quotes. Any ampersands and angle brackets will automatically be translated into HTML entities.

Markdown::

    Markdown is a `<em>text-to-html</em>` conversion tool for writers.

Output:

.. code-block:: html

    <p>Markdown is a `&lt;em&gt;text-to-html&lt;/em&gt;` conversion tool for writers.</p>

    
Emphasis: Italics
==================

To emphasize text wrap it with either a asterisk or underscore.

Markdown::

    This is *emphasized* _text_.

Output:

.. code-block:: html

    <p>This is <em>emphasized</em> <em>text</em>.</p>

Emphasis: Strong
================

To boldly emphasize text, wrap it with either double asterisks or double underscores.

Markdown::

    This is very heavily **emphasized** __text__.

Output:

.. code-block:: html

    <p>This is very heavily <strong>emphasized</strong> <strong>text</strong>.</p>

    
Headers
========

HTML headings are produced by placing a number of hashes before the header
text corresponding to the level of heading desired (HTML offers six levels of
headings).

Markdown::

    # First-level heading

    #### Fourth-level heading

Output:

.. code-block:: html

    <h1>First-level heading</h1>

    <h4>Fourth-level heading</h4>


Horizontal rules
=================

You can create a horizontal rule (``<hr />``) by placing 3 or more phens, asterisks, or underscores on a single line. You can also place spaces between them.

Markdown::

    * * *

    ***

    *****

    - - -

    ---------------------------------------

Output:

.. code-block:: html

    <hr />

    <hr />

    <hr />

    <hr />

    <hr />

Images: Inline
===============

Image syntax is very similar to Link syntax, but prefixed with an exclamation point.

Markdown::

    ![alt text](http://path/to/img.jpg "Title")

Output:

.. code-block:: html

    <img src="http://path/to/img.jpg" alt="alt text" title="Title" />

Line Return
============

To force a line return, place two empty spaces at the end of a line.

Markdown::

    Forcing a line-break\s\s
    Next line in the list

Output:

.. code-block:: html

    Forcing a line-break<br>
    Next line in the list

Links: Inline
===============

Inline-style links use parentheses immediately after the link text.

Markdown::

    This is an [example link](http://example.com/).

Output:

.. code-block:: html

    <p>This is an <a href="http://example.com/">example link</a>.</p>
    
Links: Inline with title
========================

Markdown::

    This is an [example link](http://example.com/ "With a Title").

Output:
    
.. code-block:: html

    <p>This is an <a href="http://example.com/" 
        title="With a Title">example link</a>.</p>

Links: Reference
================

Reference-style links allow you to refer to your links by names, which you define elsewhere.

Markdown::

    This is a guide on Markdown [Markdown][1].

    [1]: http://en.wikipedia.org/wiki/Markdown        "Markdown"
    
Output:

.. code-block:: html

    <p>This is a guide on <a href="http://en.wikipedia.org/wiki/Markdown">Markdown</a>.</p>
    
Lists: Simple
=============

Creating simple links is done by using plus, hyphens or asterisks as list markers. These list markers are interchangeable.

Markdown::

    + One
    - Two
    * Three
    
Output:

.. code-block:: html
    
    <ul>
        <li>One</li>
        <li>Two</li>
        <li>Three</li>
    </ul>
    
Lists: Nested
=============

Nest a list requires you to indent by **exactly** four spaces.

Markdown::

    + One
    + Two
    + Three
        - Nested One
        - Nested Two

Output:

.. code-block:: html

    <ul>
        <li>One</li>
        <li>Two</li>
        <li>Three
            <ul>
                <li>Nested One</li>
                <li>Nested Two</li>
            </ul>
        </li>
    </ul>


Paragraphs
===========

A paragraph is one or more consecutive lines of text separated by one or more
blank lines. Normal paragraphs should not be indented with spaces or tabs.

Markdown::

    This is a paragraph. It has two sentences.

    This is another paragraph. It also has two sentences.

Output:

.. code-block:: html

    <p>This is a paragraph. It has two sentences.</p>

    <p>This is another paragraph. It also has two sentences.</p>

----


Images: Reference
=================

TODO