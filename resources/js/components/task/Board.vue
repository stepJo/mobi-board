<template>
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="page-header">
                    <h1 class="font-bold text-xl">TASK BOARD</h1>
                </div>

                <div
                    v-if="tasks.length > 0"
                    class="grid lg:grid-cols-4 md:grid-cols-2 gap-6"
                >
                    <div v-for="task in tasks" :key="task.t_id">
                        <div class="py-3">
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

                            <div class="bg-white p-2">
                                <div class="grid grid-cols-1 gap-4">
                                    <draggable
                                        v-bind="taskListDragOptions"
                                        :list="task.lists"
                                        @end="syncTaskList"
                                    >
                                        <div
                                            v-for="list in task.lists"
                                            :key="list.tl_id"
                                            class="p-2 my-2 rounded-md shadow-xs border-2 border-grey-100 hover:shadow cursor-move"
                                        >
                                            <!-- TaskList -->
                                            <tasklist
                                                :list="list"
                                                v-on:show-edit-modal="
                                                    setSelectedTaskList
                                                "
                                                v-on:show-delete-modal="
                                                    setSelectedTaskList
                                                "
                                            />
                                        </div>
                                    </draggable>

                                    <div
                                        :key="task.t_id"
                                        v-if="show && selected == task.t_id"
                                    >
                                        <!-- Add TaskList -->
                                        <add-tasklist
                                            :selected="selected"
                                            :task="task"
                                            v-on:tasklist-added="taskListAdded"
                                            v-on:tasklist-cancelled="
                                                cancelSelectTaskToAddList
                                            "
                                        />
                                    </div>

                                    <div
                                        v-if="!task.lists.length"
                                        class="flex justify-center"
                                    >
                                        <span
                                            v-if="
                                                !show || selected != task.t_id
                                            "
                                            class="text-gray-500 font-bold"
                                            >Task list empty...</span
                                        >
                                    </div>

                                    <button
                                        v-if="selected != task.t_id"
                                        @click.prevent="
                                            selectTaskToAddList(task.t_id)
                                        "
                                        class="mt-1 text-green-600 hover:underline"
                                    >
                                        Add More
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Tasklist Modal -->
                    <edit-tasklist
                        :tl_id="tasklist.tl_id"
                        :tl_title="tasklist.tl_title"
                        :tl_description="tasklist.tl_description"
                        v-on:tasklist-updated="taskListUpdated"
                    />

                    <!-- Delete Tasklist Modal -->
                    <delete-tasklist
                        :tl_id="tasklist.tl_id"
                        :tl_title="tasklist.tl_title"
                        :tl_description="tasklist.tl_description"
                        v-on:tasklist-deleted="taskListDeleted"
                    />
                </div>

                <div v-else class="row">
                    <div class="grid lg:grid-cols-1 ml-5 gap-3">
                        <h1>No tasks at the moment...</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import draggable from "vuedraggable";
import TaskList from "./TaskList.vue";
import AddTaskList from "./AddTaskList.vue";
import EditTaskList from "./EditTaskList.vue";
import DeleteTaskList from "./DeleteTaskList.vue";

export default {
    components: {
        draggable,
        tasklist: TaskList,
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
        syncTaskList() {
            axios
                .patch("/api/task/sync", {
                    tasks: this.tasks
                })
                .then(response => {
                    this.$toasted.global.successNotification({
                        message: "Tasklist synchronized"
                    });
                })
                .catch(error => {
                    console.log(error);
                });
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
        }
    },
    computed: {
        taskListDragOptions() {
            return {
                animation: 200,
                emptyInsertThreshold: 60,
                group: "task"
            };
        }
    }
};
</script>
