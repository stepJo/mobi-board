<template>
    <div class="row">
        <loading
            :active.sync="loading"
            :opacity="0.7"
            color="blue"
            blur="5px"
        />

        <modal
            name="edit-tasklist-modal"
            :draggable="false"
            :resizable="true"
            :adaptive="true"
            :scrollable="true"
            :height="400"
        >
            <div class="flex p-3 bg-orange-300">
                <h2 class="text-md text-white font-bold">
                    Edit Task List
                </h2>
            </div>
            <div class="p-3">
                <ValidationObserver v-slot="{ handleSubmit }">
                    <form
                        class="w-full bg-white rounded-md shadow"
                        @submit.prevent="handleSubmit(updateTaskList)"
                    >
                        <div class="p-3">
                            <label class="block uppercase font-bold"
                                >Title</label
                            >

                            <ValidationProvider
                                name="Title"
                                rules="required"
                                v-slot="{ errors }"
                            >
                                <span
                                    class="mt-1 text-xs text-red-600 font-bold"
                                >
                                    {{ errors[0] }}
                                </span>

                                <input
                                    v-model.trim="tasklist.tl_title"
                                    class="w-full mt-1 p-2 border-2 border-gray-300 rounded-md"
                                    type="text"
                                    name="tl_title"
                                    placeholder="Title"
                                />
                            </ValidationProvider>
                        </div>
                        <div class="p-3">
                            <label class="block uppercase font-bold"
                                >Description</label
                            >

                            <ValidationProvider
                                name="Description"
                                rules="required"
                                v-slot="{ errors }"
                            >
                                <span
                                    class="mt-1 text-xs text-red-600 font-bold"
                                >
                                    {{ errors[0] }}
                                </span>

                                <textarea
                                    v-model.trim="tasklist.tl_description"
                                    class="w-full mt-1 p-2 border-2 border-gray-300 rounded-md"
                                    rows="3"
                                    name="tl_description"
                                    placeholder="Description"
                                ></textarea>
                            </ValidationProvider>
                        </div>

                        <div class="w-full p-3 bg-gray-100">
                            <button
                                @click.prevent="
                                    closeModal('edit-tasklist-modal')
                                "
                                class="px-2 py-2 mr-2 text-white text-xs bg-red-500 rounded-md shadow hover:bg-red-600 transition duration-300 ease-in-out"
                            >
                                <i class="fas fa-times" /> Cancel
                            </button>

                            <button
                                type="submit"
                                class="px-3 py-2 text-white text-xs bg-orange-300 rounded shadow hover:bg-orange-500 transition duration-300 ease-in-out"
                            >
                                <i class="fas fa-edit" /> Update
                            </button>
                        </div>
                    </form>
                </ValidationObserver>
            </div>
        </modal>
    </div>
</template>

<script>
export default {
    props: ["tl_id", "tl_title", "tl_description"],
    data() {
        return {
            tasklist: {
                tl_id: "",
                tl_title: "",
                tl_description: ""
            },
            error: {
                tl_title: "",
                tl_description: ""
            },
            loading: false
        };
    },
    methods: {
        updateTaskList() {
            this.loading = true;

            axios
                .patch(`/api/task_list/${this.tasklist.tl_id}/update`, {
                    tl_id: this.tasklist.tl_id,
                    tl_title: this.tasklist.tl_title,
                    tl_description: this.tasklist.tl_description
                })
                .then(response => {
                    this.loading = false;

                    this.$emit("tasklist-updated", response.data.task_list);
                })
                .catch(error => {
                    console.log(error);
                });
        }
    },
    watch: {
        tl_id() {
            this.tasklist.tl_id = this.tl_id;
        },
        tl_title() {
            this.tasklist.tl_title = this.tl_title;
        },
        tl_description() {
            this.tasklist.tl_description = this.tl_description;
        }
    }
};
</script>

<style></style>
