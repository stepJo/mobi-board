<template>
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="page-header">
                    <h1 class="font-bold text-xl">TASKS BOARD</h1>
                </div>
                <div v-if="tasks.length > 0" class="grid lg:grid-cols-4 gap-3">
                    <div v-for="task in tasks" :key="task.t_id">
                        <div class="m-2">
                            <div class="p-3 bg-blue-500 rounded-md">
                                <p class="font-bold text-base text-white">
                                    {{ task.t_title }}
                                </p>
                                <p
                                    class="badge bg-indigo-600 border-none text-white mt-2"
                                >
                                    {{ task.t_description }}
                                </p>
                            </div>

                            <div class="bg-white p-3">
                                <div v-if="task.lists.length > 0">
                                    <div class="grid grid-cols-1">
                                        <div
                                            v-for="list in task.lists"
                                            :key="list.tl_id"
                                            class="mb-3 p-3 h-24 flex flex-col bg-white rounded-md shadow transform hover:shadow-md cursor-pointer"
                                        >
                                            <span
                                                class="block mb-2 text-xl text-gray-900"
                                            >
                                                {{ list.tl_title }}
                                            </span>
                                            <p class="text-gray-700">
                                                {{ list.tl_description }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div v-else>
                                    <div
                                        :key="task.t_id"
                                        v-if="show && selected == task.t_id"
                                    >
                                        <add-task
                                            :selected="selected"
                                            :task="task"
                                            v-on:cancel-task="
                                                cancelSelectTaskToAddList()
                                            "
                                        />
                                    </div>

                                    <span
                                        v-if="!show || selected != task.t_id"
                                        class="text-gray-600 font-bold"
                                        >No task at the moment...</span
                                    >

                                    <br />

                                    <button
                                        v-if="selected != task.t_id"
                                        @click="selectTaskToAddList(task.t_id)"
                                        class="mt-2 text-red-600 hover:underline"
                                    >
                                        Add One
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-else class="row">
                    <div class="col-md-12">
                        <h1>No tasks available...</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import AddTask from "./AddTask.vue";

export default {
    components: {
        AddTask
    },
    data() {
        return {
            tasks: [],
            show: true,
            selected: ""
        };
    },
    created() {
        this.getTasks();
    },
    methods: {
        getTasks() {
            axios
                .get("/api/tasks")
                .then(response => {
                    this.tasks = response.data.tasks;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        selectTaskToAddList(id) {
            if (this.selected != id) {
                this.selected = id;
            } else {
                this.show = !this.show;
                this.selected = id;
            }
        },
        cancelSelectTaskToAddList() {
            this.show = true;
            this.selected = "";
        }
    }
};
</script>
