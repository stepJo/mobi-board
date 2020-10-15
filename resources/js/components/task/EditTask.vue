<template>
    <div>
        <loading
            :active.sync="loading"
            :opacity="0.7"
            color="blue"
            blur="5px"
        />

        <modal
            name="edit-task-modal"
            :draggable="false"
            :resizable="true"
            :adaptive="true"
            :scrollable="true"
            :height="400"
        >
            <div class="flex p-3 bg-orange-300">
                <h2 class="text-md text-white font-bold">
                    Edit Task
                </h2>
            </div>
            <div class="p-3">
                <ValidationObserver v-slot="{ handleSubmit }">
                    <form
                        class="w-full bg-white rounded-md shadow"
                        @submit.prevent="handleSubmit(update)"
                    >
                        <div class="p-3">
                            <label class="block uppercase font-bold"
                                >Title</label
                            >

                            <ValidationProvider
                                name="Title"
                                rules="required"
                                mode="eager"
                                :customMessages="{
                                    required: 'Title is required'
                                }"
                                v-slot="{ errors }"
                            >
                                <span
                                    v-if="errors[0]"
                                    class="mt-1 text-xs text-red-600 font-bold"
                                >
                                    {{ errors[0] }}
                                </span>

                                <input
                                    v-model.trim="task.t_title"
                                    class="w-full mt-1 p-2 border-2 border-gray-300 rounded-md"
                                    type="text"
                                    name="t_title"
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
                                mode="eager"
                                :customMessages="{
                                    required: 'Description is required'
                                }"
                                v-slot="{ errors }"
                            >
                                <span
                                    v-if="errors[0]"
                                    class="mt-1 text-xs text-red-600 font-bold"
                                >
                                    {{ errors[0] }}
                                </span>

                                <textarea
                                    v-model="task.t_description"
                                    class="w-full mt-1 p-2 border-2 border-gray-300 rounded-md"
                                    rows="3"
                                    name="t_description"
                                    placeholder="Description"
                                ></textarea>
                            </ValidationProvider>
                        </div>

                        <div class="w-full p-3 bg-gray-100">
                            <button
                                @click.prevent="closeModal('edit-task-modal')"
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
    props: ["t_id", "t_title", "t_description"],
    data() {
        return {
            task: {
                t_id: "",
                t_title: "",
                t_description: "",
                loading: false
            }
        };
    },
    methods: {
        update() {
            this.loading = true;

            axios
                .patch(`/api/task/${this.task.t_id}/update`, {
                    t_id: this.task.t_id,
                    t_title: this.task.t_title,
                    t_description: this.task.t_description
                })
                .then(response => {
                    this.loading = false;

                    this.$emit("task-updated", response.data.task);
                })
                .catch(error => {
                    console.log(error);
                });
        }
    },
    watch: {
        t_id() {
            this.task.t_id = this.t_id;
        },
        t_title() {
            this.task.t_title = this.t_title;
        },
        t_description() {
            this.task.t_description = this.t_description;
        }
    }
};
</script>

<style></style>
