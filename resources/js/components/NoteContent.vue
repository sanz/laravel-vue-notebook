<template>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title border-bottom title">
                    <span class="edit" v-if="titleEdit">
                        <input
                            type="text"
                            id="note-content-title"
                            v-model="newTitle"
                            v-on:keyup.enter="updateNoteTitle"
                        />

                        <div class="actions">
                            <i class="ti-close text-danger mr-2" @click="closeTitleEdit"></i>
                            <i class="ti-check text-success" @click="updateNoteTitle"></i>
                        </div>
                    </span>

                    <span class="text" v-else>
                        {{ note.title }}
                        <i
                            class="ti-pencil text-primary float-right"
                            @click="editTitle"
                        ></i>
                    </span>
                </h1>

                <ul class="list-inline">
                    <li class="list-inline-item text-muted">{{ note.date }}</li>
                    <li class="list-inline-item text-muted">{{ note.time }}</li>

                    <li class="list-inline-item float-right" v-if="contentEdit">
                        <a href="#!" @click="updateNoteContent" class="mr-2">
                            <i class="ti-save"></i> Save Edited Content
                        </a>

                        <a href="#!" @click="destroyContentEditor" class="text-danger">
                            <i class="ti-eraser"></i> Cancel Editing
                        </a>
                    </li>

                    <li class="list-inline-item float-right" v-else>
                        <a href="#!" class="text-primary" @click="createContentEditor">
                            <i class="ti-eraser"></i> Edit note
                        </a>
                    </li>
                </ul>

                <div v-html="note.content" id="editor" ref="content" class="ck-content"></div>

                <div class="mt-4">
                    <a href="#!" @click="deleteNote" class="text-danger">
                        <i class="ti-trash"></i> I confirm to delete this note!
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

require("../ckeditor5-build-balloon-block/build/ckeditor");

export default {
    props: ["note"],
    data() {
        return {
            titleEdit: false,
            contentEdit: false,
            contentEditor: null,
            newTitle: null,
            editorOptions: {
                placeholder: 'Start Writing Content...',
                // toolbar: [
                //     'heading', '|', 'bold', 'italic', 'link', '|', 'bulletedList', 'numberedList', 
                //     '|', 'blockQuote', 'imageUpload', 'insertTable', 'mediaEmbed'
                // ],
                // table: {
                //     contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
                // },
                image: {
                    toolbar: ['imageTextAlternative', '|', 'imageStyle:alignLeft', 'imageStyle:full', 'imageStyle:alignRight'],
                    styles: ['full', 'alignLeft', 'alignRight']
                },
                mediaEmbed: { 
                    previewsInData: true 
                },
                simpleUpload: {
                    // The URL that the images are uploaded to.
                    uploadUrl: '/upload',

                    // Headers sent along with the XMLHttpRequest to the upload server.
                    headers: {
                        'X-CSRF-TOKEN': window.csrf
                    }
                }
            }
        };
    },
    watch: {
        note: {
            handler: function(note) {
                this.newTitle = this.note ? this.note.title : null;
                this.closeTitleEdit();
                this.destroyContentEditor();
            }
        }
    },
    methods: {
        editTitle() {
            this.titleEdit = true;
            this.$nextTick(() =>
                document.getElementById("note-content-title").focus()
            );
        },
        createContentEditor() {
            if (!this.contentEditor) {
                this.contentEdit = true;

                BalloonEditor.create(document.querySelector("#editor"), this.editorOptions)
                    .then(editor => {
                        this.contentEditor = editor;
                    })
                    .catch(error => {
                        console.error(error);
                    })
                    .finally(() => {
                        this.contentEditor.editing.view.focus();
                    });
            }
        },
        destroyContentEditor() {
            if (this.contentEditor) {
                this.contentEditor
                    .destroy()
                    .catch(error => {
                        console.log(error);
                    })
                    .finally(() => {
                        this.contentEdit = false;
                        this.contentEditor = null;
                        this.$refs["content"].innerHTML = this.note ? this.note.content : null;
                    });
            }
        },
        closeTitleEdit() {
            this.titleEdit = false;
            this.newTitle = this.note ? this.note.title : null;
        },
        updateNoteTitle() {
            if (this.newTitle == this.note.title) return this.closeTitleEdit();

            axios
                .patch(`/note/${this.note.id}`, { title: this.newTitle })
                .then(response => {
                    this.note.title = this.newTitle;
                })
                .catch(error => {
                    console.log(error);
                })
                .finally(() => {
                    this.closeTitleEdit();
                });
        },
        updateNoteContent(e) {
            let contentData = this.contentEditor.getData();

            if (contentData == this.note.content)
                return this.destroyContentEditor();

            axios
                .patch(`/note/${this.note.id}`, { content: contentData })
                .then(response => {
                    if(contentData) this.note.content = contentData;
                })
                .catch(error => {
                    console.log(error);
                })
                .finally(() => {
                    this.destroyContentEditor();
                });
        },
        deleteNote() {
            axios
                .delete(`/note/${this.note.id}`)
                .then(response => {
                    this.$emit("deleted");
                })
                .catch(error => {
                    console.log(error);
                });
        }
    }
};
</script>
