<template>
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="page-header my-3">
                    <h1 class="font-bold text-xl">TASK BOARD</h1>
                </div>

                <!-- Add Task -->
                <add-task v-on:task-created="taskCreated" />

                <div
                    v-if="tasks.length > 0"
                    class="grid xl:grid-cols-4 md:grid-cols-2 gap-6"
                >
                    <div v-for="task in tasks" :key="task.t_id">
                        <div class="py-3">
                            <!-- Task -->
                            <task
                                :task="task"
                                v-on:show-edit-modal="setSelectedTask"
                                v-on:show-delete-modal="setSelectedTask"
                            />

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
                                        v-show="show && selected == task.t_id"
                                    >
                                        <!-- Add TaskList -->
                                        <add-tasklist
                                            :selected="selected"
                                            :task="task"
                                            v-on:tasklist-created="
                                                taskListCreated
                                            "
                                            v-on:tasklist-cancelled="
                                                cancelSelectTask
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
                                        v-show="selected != task.t_id"
                                        @click.prevent="selectTask(task.t_id)"
                                        class="mt-1 text-green-600 hover:underline"
                                    >
                                        Add More
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Task Modal -->
                    <delete-task
                        :t_id="modified.id"
                        :t_title="modified.title"
                        :t_description="modified.description"
                        v-on:task-deleted="taskDeleted"
                    />

                    <!-- Edit Task Modal -->
                    <edit-task
                        :t_id="modified.id"
                        :t_title="modified.title"
                        :t_description="modified.description"
                        v-on:task-updated="taskUpdated"
                    />

                    <!-- Edit Tasklist Modal -->
                    <edit-tasklist
                        :tl_id="modified.id"
                        :tl_title="modified.title"
                        :tl_description="modified.description"
                        v-on:tasklist-updated="taskListUpdated"
                    />

                    <!-- Delete Tasklist Modal -->
                    <delete-tasklist
                        :tl_id="modified.id"
                        :tl_title="modified.title"
                        :tl_description="modified.description"
                        v-on:tasklist-deleted="taskListDeleted"
                    />
                </div>

                <div v-else class="flex my-3">
                    <h1>No tasks at the moment...</h1>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import draggable from "vuedraggable";
import Task from "./Task.vue";
import AddTask from "./AddTask.vue";
import EditTask from "./EditTask.vue";
import DeleteTask from "./DeleteTask.vue";
import TaskList from "./TaskList.vue";
import AddTaskList from "./AddTaskList.vue";
import EditTaskList from "./EditTaskList.vue";
import DeleteTaskList from "./DeleteTaskList.vue";

export default {
    components: {
        draggable,
        task: Task,
        "add-task": AddTask,
        "edit-task": EditTask,
        "delete-task": DeleteTask,
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
            open: false,
            openedId: "",
            modified: {
                id: "",
                title: "",
                description: ""
            }
        };
    },
    created() {
        setTimeout(() => {
            this.getTasks();
        }, 200);
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
        selectTask(id) {
            if (this.selected != id) {
                this.selected = id;
            } else {
                this.show = !this.show;
                this.selected = id;
            }
        },
        setSelectedTask(task) {
            this.modified.id = task.t_id;
            this.modified.title = task.t_title;
            this.modified.description = task.t_description;
        },
        cancelSelectTask() {
            this.selected = "";
        },
        taskCreated(task) {
            this.tasks.push({
                t_id: task.t_id,
                t_title: task.t_title,
                t_description: task.t_description,
                lists: []
            });

            this.$toasted.global.successNotification({
                message: "Task created"
            });

            this.closeModal("add-task-modal");
        },
        taskUpdated(task) {
            let index = this.tasks.map(t => t.t_id).indexOf(task.t_id);

            this.tasks[index].t_title = task.t_title;
            this.tasks[index].t_description = task.t_description;

            this.$toasted.global.successNotification({
                message: `Task updated to <span class="font-bold ml-1"> ${task.t_title} </span>`
            });

            this.closeModal("edit-task-modal");
        },
        taskDeleted(task) {
            let index = this.tasks.map(t => t.t_id).indexOf(task.t_id);

            this.tasks.splice(index, 1);

            this.$toasted.global.successNotification({
                message: `Task <span class="font-bold mx-1"> ${task.t_title} </span> deleted`
            });

            this.closeModal("delete-task-modal");
        },
        setSelectedTaskList(list) {
            this.modified.id = list.tl_id;
            this.modified.title = list.tl_title;
            this.modified.description = list.tl_description;
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
        taskListCreated(list) {
            let task = this.tasks.find(task => task.t_id === list.t_id);

            task.lists.push({
                tl_id: list.tl_id,
                tl_title: list.tl_title,
                tl_description: list.tl_description
            });

            this.selected = "";

            this.$toasted.global.successNotification({
                message: "Tasklist created"
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
