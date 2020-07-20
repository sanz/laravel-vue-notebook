<template>
    <div class="container-fluid">
        <div class="row" v-if="notebooks.length">
            <div class="col-md-3">
                <div class="list-group sticky-top">
                    <button
                        class="list-group-item list-group-item-action notebook"
                        :class="activeNotebook.id == notebook.id ? 'active' : ''"
                        v-for="notebook in notebooks"
                        :key="notebook.id"
                        @click="change(notebook)"
                    >
                        <span class="edit" v-if="isActiveEdit(notebook)">
                            <input
                                type="text"
                                :id="activeNoteBookEditId"
                                v-model="activeNoteBookEditTitle"
                                v-on:keyup.enter="updateActiveEdit"
                            />

                            <div class="actions">
                                <i class="ti-close mr-2" @click="closeActiveEdit"></i>
                                <i class="ti-check" @click="updateActiveEdit"></i>
                            </div>
                        </span>

                        <span class="text" v-else>
                            <i class="ti-notepad mr-2"></i>{{ notebook.title }}
                            
                            <ul class="list-inline m-0 float-right hidden">
                                <li class="list-inline-item">
                                    <i class="ti-pencil" @click="edit(notebook)"></i>
                                </li>
                                <li class="list-inline-item text-danger">
                                    <i class="ti-trash" @click="destroy(notebook)"></i>
                                </li>
                            </ul>
                        </span>
                    </button>
                </div>
            </div>

            <notes v-if="activeNotebook" :notebook="activeNotebook"></notes>
        </div>

        <div class="row" v-else>
            <div class="col-12 d-flex justify-content-center flex-column mt-5" >
                <h1 class="text-center">
                    <i class="ti-pencil-alt d-block"></i> 
                    Welcome to Laravel Notebook! <br>
                </h1>
                <p class="text-center text-muted">Lets get started with a new Notebook.</p>
            </div>
        </div>
    </div>
</template>

<script>
import Note from "./Notes";

export default {
    data() {
        return {
            notebooks: [],
            activeNotebook: null,
            activeNoteBookEdit: null,
            activeNoteBookEditTitle: null
        };
    },
    components: {
        notes: Note
    },
    methods: {
        get() {
            axios
                .get("/notebook")
                .then(response => {
                    this.notebooks = response.data;
                    this.activeNotebook = this.notebooks[0];
                })
                .catch(error => {
                    console.log(error);
                });
        },
        edit(notebook) {
            this.activeNoteBookEdit = notebook;
            this.activeNoteBookEditTitle = notebook.title;
            this.$nextTick(() =>
                document.getElementById(this.activeNoteBookEditId).focus()
            );
        },
        destroy(notebook) {
            axios
                .delete(`/notebook/${notebook.id}`)
                .then(response => {
                    this.notebooks = this.notebooks.filter(
                        el => el.id !== notebook.id
                    );
                    this.activeNotebook = this.notebooks[0];
                })
                .catch(error => {
                    console.log(error);
                });
        },
        change(notebook) {
            this.activeNotebook = notebook;

            if(this.activeNoteBookEdit && this.activeNotebook.id !== this.activeNoteBookEdit.id) {
                this.closeActiveEdit();
            }
        },
        isActiveEdit(notebook) {
            return (
                this.activeNoteBookEdit &&
                notebook.id == this.activeNoteBookEdit.id
            );
        },
        updateActiveEdit() {
            if (!this.activeNoteBookEditTitle) return;

            if (this.activeNoteBookEdit.title == this.activeNoteBookEditTitle)
                return this.closeActiveEdit();

            let index = this.notebooks.findIndex(
                notebook => notebook.id == this.activeNoteBookEdit.id
            );

            axios
                .patch(`/notebook/${this.activeNoteBookEdit.id}`, {
                    title: this.activeNoteBookEditTitle
                })
                .then(response => {
                    this.notebooks[index].title = this.activeNoteBookEditTitle;
                })
                .catch(error => {
                    console.log(error);
                })
                .finally(() => {
                    this.closeActiveEdit();
                });
        },
        closeActiveEdit() {
            this.activeNoteBookEdit = null;
            this.activeNoteBookEditTitle = null;
        }
    },
    computed: {
        activeNoteBookEditId() {
            return `notebook-input-${this.activeNoteBookEdit.id}`;
        }
    },
    mounted() {
        this.get();
    }
};
</script>
