<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.5.10/ckeditor.js"></script>
{{-- CKEDITOR --}}
<script data-sample="1">
    CKEDITOR.addCss('.cke_editable { font-size: 15px; padding: 0.5em; }');

    CKEDITOR.replace('ck_editor', {
        toolbar: [
            {name: 'colors', items: ['TextColor', 'BGColor']},
            {name: 'align', items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']},
            {name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat', 'CopyFormatting']},
            {name: 'styles', items: ['Format', 'Font', 'FontSize']},
            {name: 'links', items: ['Link', 'Unlink']},
            {name: 'document', items: ['Print']},
            {name: 'clipboard', items: ['Undo', 'Redo']},
            {name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote']},
            {name: 'insert', items: ['Table']},
            {name: 'tools', items: ['Maximize']},
            {name: 'editing', items: ['Scayt']}
        ],

        extraAllowedContent: 'h3{clear};h2{line-height};h2 h3{margin-left,margin-top}',

        extraPlugins: 'print,format,font,colorbutton,justify,uploadimage',
        uploadUrl: '/apps/ckfinder/3.4.4/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json',

        // Configure your file manager integration. This example uses CKFinder 3 for PHP.
        filebrowserBrowseUrl: '/apps/ckfinder/3.4.4/ckfinder.html',
        filebrowserImageBrowseUrl: '/apps/ckfinder/3.4.4/ckfinder.html?type=Images',
        filebrowserUploadUrl: '/apps/ckfinder/3.4.4/core/connector/php/connector.php?command=QuickUpload&type=Files',
        filebrowserImageUploadUrl: '/apps/ckfinder/3.4.4/core/connector/php/connector.php?command=QuickUpload&type=Images',

        height: 360,

        removeDialogTabs: 'image:advanced;link:advanced'
    });
</script>