

import './livewire-helpers';

import tinymce from 'tinymce/tinymce';
import 'tinymce/icons/default';
import 'tinymce/themes/silver';
import 'tinymce/models/dom';

import 'tinymce/plugins/link';
import 'tinymce/plugins/image';
import 'tinymce/plugins/code';
import 'tinymce/plugins/lists';

import 'tinymce/skins/ui/oxide/skin.min.css';

window.initTinyEditor = function (elementId, livewireComponentId, modelName) {
    if (tinymce.get(elementId)) {
        tinymce.get(elementId).remove();
    }

    tinymce.init({
        selector: `#${elementId}`,
        height: 500,
        menubar: false,
        plugins: [
            'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
            'checklist', 'mediaembed', 'casechange', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'ai', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown','importword', 'exportword', 'exportpdf'
        ],
        toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright | bullist numlist | link image | code',
        setup: function (editor) {
            editor.on('change input undo redo', function () {
                window.Livewire.find(livewireComponentId).set(modelName, editor.getContent());
            });
        }
    });
};
