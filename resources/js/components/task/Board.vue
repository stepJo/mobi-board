<template>
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="page-header">
                    <h1 class="font-bold text-xl">TASK BOARD</h1>
                </div>
                <div v-if="tasks.length > 0" class="grid lg:grid-cols-4 gap-5">
                    <div v-for="task in tasks" :key="task.t_id">
                        <div class="py-2">
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

                            <div class="bg-white pl-0 p-3">
                                <div v-if="task.lists.length > 0">
                                    <div class="grid grid-cols-1 gap-4">
                                        <div
                                            v-for="list in task.lists"
                                            :key="list.tl_id"
                                            class="py-1 px-3 h-full bg-white rounded-md shadow-xs border-2 border-blue-300 hover:shadow-md cursor-pointer"
                                        >
                                            <span
                                                class="py-2 text-md font-bold text-indigo-400"
                                            >
                                                {{ list.tl_title }}
                                            </span>
                                            <p class="text-xs text-gray-500">
                                                {{ list.tl_description }}
                                            </p>

                                            <div class="flex justify-end">
                                                <i
                                                    @click.prevent="
                                                        showEditTaskListModal(
                                                            list
                                                        )
                                                    "
                                                    class="fas fa-edit mt-2 text-lg text-orange-300 block"
                                                ></i>

                                                <i
                                                    @click.prevent="
                                                        showDeleteTaskListModal(
                                                            list
                                                        )
                                                    "
                                                    class="fas fa-eraser mt-2 ml-2 text-lg text-red-500 block"
                                                ></i>
                                            </div>
                                        </div>

                                        <div
                                            :key="task.t_id"
                                            v-if="show && selected == task.t_id"
                                            class="mt-2"
                                        >
                                            <add-tasklist
                                                :selected="selected"
                                                :task="task"
                                                v-on:tasklist-added="
                                                    taskListAdded
                                                "
                                                v-on:tasklist-cancelled="
                                                    cancelSelectTaskToAddList
                                                "
                                            />
                                        </div>

                                        <button
                                            v-if="selected != task.t_id"
                                            @click.prevent="
                                                selectTaskToAddList(task.t_id)
                                            "
                                            class="mt-2 text-green-600 hover:underline"
                                        >
                                            Add Task List
                                        </button>
                                    </div>
                                </div>

                                <div v-else>
                                    <div
                                        :key="task.t_id"
                                        v-if="show && selected == task.t_id"
                                    >
                                        <add-tasklist
                                            :selected="selected"
                                            :task="task"
                                            v-on:tasklist-added="taskListAdded"
                                            v-on:tasklist-cancelled="
                                                cancelSelectTaskToAddList
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
                                        @click.prevent="
                                            selectTaskToAddList(task.t_id)
                                        "
                                        class="mt-2 text-green-600 hover:underline"
                                    >
                                        Add One
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <edit-tasklist
                        :tl_id="tasklist.tl_id"
                        :tl_title="tasklist.tl_title"
                        :tl_description="tasklist.tl_description"
                        v-on:tasklist-updated="taskListUpdated"
                    />

                    <delete-tasklist
                        :tl_id="tasklist.tl_id"
                        :tl_title="tasklist.tl_title"
                        :tl_description="tasklist.tl_description"
                        v-on:tasklist-deleted="taskListDeleted"
                    />
                </div>

                <div v-else class="row">
                    <div class="grid lg:grid-cols-1 ml-5 gap-3">
                        <h1>No tasks available...</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import AddTaskList from "./AddTaskList.vue";
import EditTaskList from "./EditTaskList.vue";
import DeleteTaskList from "./DeleteTaskList.vue";

export default {
    components: {
        "add-tasklist": AddTaskList,
        "edit-tasklist": EditTaskList,
        "delete-tasklist": DeleteTaskList
    },
    data() {
        return {
            tasks: [],
            show: true,
            selected: "",
            tasklist: {
                tl_id: "",
                tl_title: "",
                tl_description: ""
            }
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
        setSelectedTaskList(list) {
            this.tasklist.tl_id = list.tl_id;
            this.tasklist.tl_title = list.tl_title;
            this.tasklist.tl_description = list.tl_description;
        },
        cancelSelectTaskToAddList() {
            this.show = true;
            this.selected = "";
        },
        taskListAdded(list) {
            let task = this.tasks.find(task => task.t_id === list.t_id);

            task.lists.push({
                tl_id: list.tl_id,
                tl_title: list.tl_title,
                tl_description: list.tl_description
            });

            this.selected = "";

            this.$toasted.global.successNotification({
                message: "Tasklist added"
            });
        },
        taskListUpdated(list) {
            let task = this.tasks.find(task => task.t_id === list.t_id);
            let index = task.lists.map(tl => tl.tl_id).indexOf(list.tl_id);
            task.lists[index].tl_title = list.tl_title;
            task.lists[index].tl_description = list.tl_description;

            this.$toasted.global.successNotification({
                message: `Tasklist updated to <span class="font-bold ml-1"> ${list.tl_title} </span>`
            });

            this.closeModal("edit-tasklist-modal");
        },
        taskListDeleted(list) {
            let task = this.tasks.find(task => task.t_id === list.t_id);
            let index = task.lists.map(tl => tl.tl_id).indexOf(list.tl_id);
            task.lists.splice(index, 1);

            this.$toasted.global.successNotification({
                message: `Tasklist <span class="font-bold mx-1"> ${list.tl_title} </span> deleted`
            });

            this.closeModal("delete-tasklist-modal");
        },
        showEditTaskListModal(list) {
            this.setSelectedTaskList(list);

            this.showModal("edit-tasklist-modal");
        },
        showDeleteTaskListModal(list) {
            this.setSelectedTaskList(list);

            this.showModal("delete-tasklist-modal");
        }
    }
};
</script>
