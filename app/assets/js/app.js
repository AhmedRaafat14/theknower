/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.css';

// Need jQuery? then uncomment to import it.
import $ from 'jquery';
import 'bootstrap';
import EasyMDE from 'easymde';
import hljs from 'highlight.js';
import 'highlight.js/styles/github.css';
import 'highlight.js/styles/default.css';

hljs.initHighlightingOnLoad();

window.EasyMDE = EasyMDE;
window.hljs = hljs;

// We add an event `load` when the whole DOM is loaded do whatever required
window.addEventListener('load', function () {

    // Make the contribution description textarea as markdown editor, only if it s exist for sure
    if (!!document.getElementById('contribution_description')) {
        new EasyMDE({
            element: document.getElementById('contribution_description'),
            forceSync: true,
            spellChecker: true,
        });
    }

    // If the remove contribution button exist, disable it is default and perform a form submit
    if (!!document.getElementById('remove_contribution')) {
        $('#remove_contribution').click(function (e) {
            e.preventDefault();
            var form = document.getElementById('delete-contribution-form');

            if (window.confirm('Are you sure you want to delete this contribution?')) {
                form.submit();
            }
        });
    }

});
