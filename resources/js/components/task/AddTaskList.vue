<template>
    <div v-if="selected == task.t_id">
        <loading
            :active.sync="loading"
            :opacity="0.7"
            color="blue"
            blur="5px"
        />

        <ValidationObserver v-slot="{ handleSubmit }">
            <form
                class="mb-3 w-full bg-white rounded-md shadow"
                @submit.prevent="handleSubmit(create)"
            >
                <div class="p-1">
                    <div class="p-2">
                        <label class="block uppercase font-bold">Title</label>

                        <ValidationProvider
                            name="Title"
                            rules="required"
                            mode="eager"
                            v-slot="{ errors }"
                            :customMessages="{
                                required: 'Title is required'
                            }"
                        >
                            <span
                                v-if="errors[0]"
                                class="mt-1 text-xs text-red-600 font-bold"
                            >
                                {{ errors[0] }}
                            </span>

                            <input
                                v-model.trim="taskList.tl_title"
                                class="w-full mt-1 p-2 border-2 border-gray-300 rounded-md"
                                type="text"
                                name="tl_title"
                                placeholder="Title"
                            />
                        </ValidationProvider>
                    </div>
                    <div class="p-2">
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
                                v-model="taskList.tl_description"
                                class="w-full mt-1 p-2 border-2 border-gray-300 rounded-md"
                                rows="3"
                                name="tl_description"
                                placeholder="Description"
                            ></textarea>
                        </ValidationProvider>
                    </div>
                </div>
                <div class="p-3 flex justify-between items-end bg-gray-100">
                    <button
                        v-if="selected == task.t_id"
                        @click.prevent="$emit('tasklist-cancelled')"
                        class="px-2 py-2 text-white text-xs bg-red-500 rounded-md shadow hover:bg-red-600 transition duration-300 ease-in-out"
                    >
                        <i class="fas fa-times" /> Cancel
                    </button>

                    <button
                        type="submit"
                        class="px-3 py-2 text-white text-xs bg-green-500 rounded shadow hover:bg-green-600 transition duration-300 ease-in-out"
                    >
                        <i class="fas fa-plus" /> Add
                    </button>
                </div>
            </form>
        </ValidationObserver>
    </div>
</template>

<script>
export default {
    props: ["selected", "task"],
    data() {
        return {
            taskList: {
                t_id: this.task.t_id,
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
    mounted() {},
    methods: {
        create() {
            this.loading = true;

            axios
                .post("api/task_list/store", this.taskList)
                .then(response => {
                    this.loading = false;

                    this.$emit("tasklist-created", response.data.task_list);
                })
                .catch(error => {
                    console.log(error);
                });
        }
    }
};
</script>
