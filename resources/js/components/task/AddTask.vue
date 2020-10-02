<template>
    <div>
        <ValidationObserver v-slot="{ handleSubmit }">
            <form
                class="mb-3 w-full bg-white rounded-md shadow"
                @submit.prevent="handleSubmit(addNewTaskList())"
            >
                <div class="p-1">
                    <div class="p-2">
                        <label class="block uppercase font-bold">Name</label>

                        <ValidationProvider
                            name="tl_title"
                            rules="required"
                            v-slot="{ errors }"
                        >
                            <span class="mt-1 text-xs text-red-500 font-bold">
                                {{ errors[0] }}
                            </span>

                            <input
                                v-model.trim="newTaskList.tl_title"
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

                        <span class="mt-1 text-xs text-red-500 font-bold">
                            {{ error.tl_description }}
                        </span>

                        <textarea
                            v-model.trim="newTaskList.tl_description"
                            class="w-full mt-1 p-2 border-2 border-gray-300 rounded-md"
                            rows="3"
                            name="tl_description"
                            placeholder="Description"
                        ></textarea>
                    </div>
                </div>
                <div
                    class="p-3 flex justify-between items-end text-sm bg-gray-100"
                >
                    <button
                        v-if="selected == task.t_id"
                        @click="$emit('cancel-task')"
                        class="px-2 py-1 text-white bg-red-400 rounded-md shadow hover:bg-red-600 transition duration-300 ease-in-out"
                    >
                        <i class="fas fa-times" /> Cancel
                    </button>

                    <button
                        type="submit"
                        class="px-3 py-1 text-white bg-green-400 rounded shadow hover:bg-green-600 transition duration-300 ease-in-out"
                    >
                        Add
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
            newTaskList: {
                t_id: this.task.t_id,
                tl_title: "",
                tl_description: ""
            },
            error: {
                tl_title: "",
                tl_description: ""
            }
        };
    },
    mounted() {},
    methods: {
        addNewTaskList() {
            this.validateTitle();
            this.validateDescription();
        }
        // validateTitle(value) {
        //     if (!value) {
        //         this.error.tl_title = "Title is required";
        //         return false;
        //     }
        //     this.error.tl_title = "";
        //     return true;
        // },
        // validateDescription(value) {
        //     if (!value) {
        //         this.error.tl_description = "Description is required";
        //         return false;
        //     }
        //     this.error.tl_description = "";
        //     return true;
        // }
    }
    // watch: {
    //     "newTaskList.tl_title": function(value) {
    //         this.newTaskList.tl_title = value;
    //         this.validateTitle(value);
    //     },
    //     "newTaskList.tl_description": function(value) {
    //         this.newTaskList.tl_description = value;
    //         this.validateDescription(value);
    //     }
    // }
};
</script>
