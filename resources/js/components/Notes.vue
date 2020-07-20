<template>
    <div class="col-md-9">
        <div class="row">
            <note-content v-if="activeNote" :note="activeNote" @deleted="deleted"></note-content>

            <div class="col-md-4">
                <div class="card sticky-top">
                    <div class="card-header">
                        <a href="#!" @click="add">
                            <i class="ti-plus"></i> Add Note
                        </a>
                    </div>

                    <div class="card-body">
                        <ul class="list-group list-group-flush" v-if="notes.length">
                            <button
                                class="list-group-item text-left"
                                v-for="note in notes"
                                :key="note.id"
                                :class="activeNote.id == note.id ? 'active' : ''"
                                @click="change(note)"
                            >{{ note.title }}</button>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import NoteContent from "./NoteContent";

export default {
    props: ["notebook"],
    data() {
        return {
            notes: [],
            activeNote: null,
            defaultNoteTitle: "Untitled Note"
        };
    },
    components: {
        "note-content": NoteContent
    },
    watch: {
        notebook: {
            handler: function(notebook) {
                this.get();
            }
        }
    },
    methods: {
        get() {
            axios
                .get(`/notebook/${this.notebook.id}`)
                .then(response => {
                    this.notes = response.data;
                    this.activeNote = this.notes[0];
                })
                .catch(error => {
                    console.log(error);
                });
        },
        add() {
            axios
                .post("/note", {
                    title: this.defaultNoteTitle,
                    note_book_id: this.notebook.id
                })
                .then(response => {
                    let note = response.data;

                    this.activeNote = note;
                    this.notes.push(note);
                })
                .catch(error => {
                    console.log(error);
                });
        },
        change(note) {
            this.activeNote = note;
        },
        deleted() {
            this.notes = this.notes.filter(
                note => note.id !== this.activeNote.id
            );
            this.activeNote = this.notes[0];
        }
    },
    mounted() {
        if(this.notebook) this.get();
    }
};
</script>
