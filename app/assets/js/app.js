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
import bootbox from 'bootbox';

hljs.initHighlightingOnLoad();

window.EasyMDE = EasyMDE;
window.hljs = hljs;
window.bootbox = bootbox;

// We add an event `load` when the whole DOM is loaded do whatever required
window.addEventListener('load', function () {

    // Make the contribution description textarea as markdown editor, only if it is exist for sure
    if (!!document.getElementById('contribution_description')) {
        new EasyMDE({
            element: document.getElementById('contribution_description'),
            forceSync: true,
            spellChecker: true,
            hideIcons: ["fullscreen"],
        });
    }

    // If the remove contribution button exist, disable it is default and perform a form submit
    if (!!document.getElementById('remove_contribution')) {
        $('#remove_contribution').click(function (e) {
            e.preventDefault();
            var form = document.getElementById('delete-contribution-form');

            // Confirm the delete action
            bootbox.confirm({
                message: "Are you sure you want to delete this contribution?",
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'No',
                        className: 'btn-danger'
                    }
                },
                callback: function (result) {
                    if (result) {
                        form.submit();
                    }
                }
            });
        });
    }

    // Like/Dislike action
    if (!!document.getElementById('toggle_likes')) {
        $('#toggle_likes').on('click', function (e) {
            e.preventDefault();
            $('#toggle_likes').blur(); // Deselect the button after the click

            $.ajax({
                url: this.dataset.href,
                dataType: 'json',
                async: true,

                success: function (data, status) {
                    $('#toggle_likes').toggleClass('btn-outline-dark').toggleClass('btn-outline-primary');
                    $('#likes_counter').text(data.new_likes);
                },
                error: function (xhr, textStatus, errorThrown) {
                    console.debug(xhr.responseJSON.detail);
                    bootbox.alert(xhr.responseJSON.title + ". Please, try again later or contact platform team!");
                }
            });
        });
    }

    // Make the comments description textarea as markdown editor, only if it is exist for sure
    if (!!document.getElementById('comment_body')) {
        enableMarkdownOnCommentEditor();
    }

    // Add comment form is exist
    if (!!document.getElementById('add_comment')) {
        $('#add_comment').submit(function (event) {
            event.preventDefault();
            var form = $(this);

            $.ajax({
                type: 'POST',
                url: form.prop('action'),
                data: form.serialize(),
                dataType: 'json',
                async: true,

                success: function (data, status) {
                    $('#comments-section').html(data.template);
                    enableMarkdownOnCommentEditor();
                    bootbox.alert("Your comment added successfully!");
                },
                error: function (xhr, textStatus, errorThrown) {
                    console.debug(xhr.responseJSON.detail);
                    bootbox.alert(xhr.responseJSON.title + ". Please, try again later or contact platform team!");
                }
            });
        });
    }
});

function enableMarkdownOnCommentEditor() {
    new EasyMDE({
        element: document.getElementById('comment_body'),
        forceSync: true,
        spellChecker: true,
        minHeight: "150px",
        hideIcons: ["fullscreen"],
    });
}
