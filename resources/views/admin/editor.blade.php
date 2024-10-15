<style>
    .ck-editor__editable_inline {
        min-height: 150px;
    }
</style>
<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
<script>
    // Configuration object with the desired height
    const editorConfig = {
        height: 100
    };

    // Initialize CKEditor for each textarea with the height configuration
    ClassicEditor.create(document.querySelector('#editor_uz'), editorConfig)
        .then(editor => {
            console.log(editor);

            // Update the original textarea with CKEditor data before form submission
            editor.model.document.on('change', () => {
                const data = editor.getData();
                document.querySelector('textarea[name="description_uz"]').value = data;
            });
        }).catch(error => {
        console.error(error);
    });

    ClassicEditor.create(document.querySelector('#editor_ru'), editorConfig)
        .then(editor => {
            console.log(editor);

            editor.model.document.on('change', () => {
                const data = editor.getData();
                document.querySelector('textarea[name="description_ru"]').value = data;
            });
        }).catch(error => {
        console.error(error);
    });

    ClassicEditor.create(document.querySelector('#editor_en'), editorConfig)
        .then(editor => {
            console.log(editor);

            editor.model.document.on('change', () => {
                const data = editor.getData();
                document.querySelector('textarea[name="description_en"]').value = data;
            });
        }).catch(error => {
        console.error(error);
    });
</script>
